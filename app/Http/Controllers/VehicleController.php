<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use App\Models\Company;
use App\Models\Notification;
use App\Models\RequestChange;
use App\Models\User;
use App\Models\VehicleChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $vehicles = Auth::user()->is_admin
                ? Vehicle::all()
                : Vehicle::of(Auth::user()->company_id)->get();

            return response()->json($vehicles);
        }

        if ($request->query('notif')) {
            Notification::where('id', $request->query('notif'))
                ->update(['is_read' => true]);
        }

        return view('vehicle.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['companies'] = Auth::user()->is_admin ? Company::all() : null;

        return view('vehicle.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = $data['company_id'] ?? Auth::user()->company_id;
        $data['stnk'] = $request->file('stnk')->store('stnk');

        Vehicle::create($data);

        return response()->json(['message' => 'Kendaraan Berhasil Ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicle.edit', [
            'vehicle' => $vehicle,
            'companies' => Auth::user()->is_admin ? Company::all() : null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $data = $request->validated();
        $data['stnk'] = $request->file('stnk')?->store('stnk') ?? $vehicle->stnk;

        if (!Auth::user()->is_admin) {
            DB::transaction(function () use ($vehicle, $data) {

                $vehicleBeforeChange = VehicleChange::create([
                    'plat_number' => $vehicle->plat_number,
                    'type' => $vehicle->type,
                    'stnk' => $vehicle->stnk,
                    'max_capacity' => $vehicle->max_capacity,
                ]);

                $vehicleChange = VehicleChange::create([
                    'plat_number' => $data['plat_number'],
                    'type' => $data['type'],
                    'stnk' => $data['stnk'],
                    'max_capacity' => $data['max_capacity'],
                ]);

                $requestChange = RequestChange::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Update',
                    'data' => 'Kendaraan',
                    'data_id' => $vehicle->id,
                    'data_before_id' => $vehicleBeforeChange->id,
                    'data_change_id' => $vehicleChange->id,
                ]);

                Notification::create([
                    'user_id' => Auth::user()->id,
                    'title' => 'Pengajuan Update',
                    'description' => 'Perubahan data memerlukan izin admin. Silahkan tunggu konfirmasi dari admin',
                    'icon' => 'fa-pencil-alt',
                    'color' => 'warning',
                    'link' => "/requests/$requestChange->id",
                ]);

                $admin = User::where('is_admin', true)->first();

                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pengajuan Update',
                    'description' => Auth::user()->username . ' mengajukan perubahan data kendaraan',
                    'icon' => 'fa-pencil-alt',
                    'color' => 'warning',
                    'link' => "/requests/$requestChange->id",
                ]);
            });

            return response()->json(['message' => 'Menunggu Konfirmasi Admin']);
        }

        $data['company_id'] = $data['company_id'] ?? Auth::user()->company_id;
        $request->file('stnk') && Storage::delete($vehicle->stnk);
        $vehicle->update($data);

        return response()->json(['message' => 'Kendaraan Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        if (!Auth::user()->is_admin) {
            DB::transaction(function () use ($vehicle) {

                $vehicleChange = VehicleChange::create([
                    'plat_number' => $vehicle->plat_number,
                    'type' => $vehicle->type,
                    'stnk' => $vehicle->stnk,
                    'max_capacity' => $vehicle->max_capacity,
                ]);

                $requestChange = RequestChange::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus',
                    'data' => 'Kendaraan',
                    'data_id' => $vehicle->id,
                    'data_before_id' => $vehicleChange->id,
                ]);

                Notification::create([
                    'user_id' => Auth::user()->id,
                    'title' => 'Pengajuan Hapus',
                    'description' => 'Penghapusan data memerlukan izin admin. Silahkan tunggu konfirmasi dari admin',
                    'icon' => 'fa-trash-alt',
                    'color' => 'danger',
                    'link' => "/requests/$requestChange->id",
                ]);

                $admin = User::where('is_admin', true)->first();

                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pengajuan Hapus',
                    'description' => Auth::user()->username . ' mengajukan penghapusan data kendaraan',
                    'icon' => 'fa-trash-alt',
                    'color' => 'danger',
                    'link' => "/requests/$requestChange->id",
                ]);
            });

            return response()->json(['message' => 'Menunggu Konfirmasi Admin']);
        }

        Storage::delete($vehicle->stnk);
        $vehicle->delete();

        return response()->json(['message' => 'Kendaraan Berhasil Dihapus']);
    }
}
