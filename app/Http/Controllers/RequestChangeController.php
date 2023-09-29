<?php

namespace App\Http\Controllers;

use App\Models\CompanyMaterial;
use App\Models\Driver;
use App\Models\DriverChange;
use App\Models\Material;
use App\Models\MaterialChange;
use App\Models\RequestChange;
use App\Models\Notification;
use App\Models\Vehicle;
use App\Models\VehicleChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestChangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only('confirm');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requestChange = Auth::user()->is_admin
                ? RequestChange::latest()->with('user')->get()
                : RequestChange::of(Auth::user()->id)->with('user')->get();

            return response()->json($requestChange);
        }

        return view('requestchange.index');
    }

    public function show(Request $request, RequestChange $requestChange)
    {
        if ($request->query('notif')) {
            Notification::where('id', $request->query('notif'))
                ->update(['is_read' => true]);
        }

        $data['request'] = $requestChange;
        $data['data'] = match($requestChange->data) {
            'Kendaraan' => VehicleChange::find($requestChange->data_before_id),
            'Driver' => DriverChange::find($requestChange->data_before_id),
            'Material' => Material::find(MaterialChange::find($requestChange->data_before_id)->material_id),
        };

        if ($requestChange->action == 'Update') {
            $data['data_change'] = match($requestChange->data) {
                'Kendaraan' => VehicleChange::find($requestChange->data_change_id),
                'Driver' => DriverChange::find($requestChange->data_change_id),
                'Material' => MaterialChange::find($requestChange->data_change_id),
            };
        }

        return view('requestchange.show', $data);
    }

    public function confirm(Request $request, RequestChange $requestChange)
    {
        $isApprove = (bool) $request->query('approve');

        if ($isApprove) {
            $requestChange->update(['status' => 'Disetujui']);

            $entity = match($requestChange->data) {
                'Kendaraan' => Vehicle::find($requestChange->data_id),
                'Driver' => Driver::find($requestChange->data_id),
                'Material' => CompanyMaterial::find($requestChange->data_id),
            };

            if ($requestChange->action == 'Hapus') {
                $requestChange['data'] == 'Kendaraan' && Storage::delete($entity->stnk);
                $entity->delete();

                Notification::create([
                    'user_id' => $requestChange->user_id,
                    'title' => 'Pengajuan Hapus',
                    'description' => "Penghapusan data {$requestChange['data']} disetujui oleh admin",
                    'icon' => 'fa-check',
                    'color' => 'danger',
                    'link' => "/requests/$requestChange->id",
                ]);

            } else {
                $entityChange = match($requestChange->data) {
                    'Kendaraan' => VehicleChange::find($requestChange->data_change_id),
                    'Driver' => DriverChange::find($requestChange->data_change_id),
                    'Material' => MaterialChange::find($requestChange->data_change_id),
                };

                if ($requestChange['data'] == 'Kendaraan' && ($entity->stnk != $entityChange->stnk)){
                   Storage::delete($entity->stnk);
                }

                $entity->update($entityChange->toArray());

                Notification::create([
                    'user_id' => $requestChange->user_id,
                    'title' => 'Pengajuan Update',
                    'description' => "Perubahan data {$requestChange['data']} disetujui oleh admin",
                    'icon' => 'fa-check',
                    'color' => 'warning',
                    'link' => "/requests/$requestChange->id",
                ]);
            }

            return response()->json(['message' => 'Pengajuan Berhasil Disetujui']);
        }

        $requestChange->update(['status' => 'Ditolak']);

        if ($requestChange->action == 'Hapus') {
            Notification::create([
                'user_id' => $requestChange->user_id,
                'title' => 'Pengajuan Hapus',
                'description' => "Penghapusan data {$requestChange['data']} ditolak oleh admin",
                'icon' => 'fa-times',
                'color' => 'danger',
                'link' => "/requests/$requestChange->id",
            ]);
        } else {
            Notification::create([
                'user_id' => $requestChange->user_id,
                'title' => 'Pengajuan Update',
                'description' => "Perubahan data {$requestChange['data']} ditolak oleh admin",
                'icon' => 'fa-times',
                'color' => 'warning',
                'link' => "/requests/$requestChange->id",
            ]);
        }

        return response()->json(['message' => 'Pengajuan Berhasil Ditolak']);
    }
}
