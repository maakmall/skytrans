<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest;
use App\Models\Company;
use App\Models\CompanyMaterial;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\Material;
use App\Models\Notification;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
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
            $deliveries = Auth::user()->is_admin
                ? Delivery::all()
                : Delivery::of(Auth::user()->company_id)->get();

            return response()->json($deliveries);
        }

        return view('delivery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyId = Auth::user()->company_id;
        $isAdmin = Auth::user()->is_admin;

        return view('delivery.create', [
            'drivers' => $isAdmin
                ? Driver::all()
                : Driver::of($companyId)->get(),
            'materials' => $isAdmin
                ? CompanyMaterial::all()
                : CompanyMaterial::of($companyId)->get(),
            'vehicles' => $isAdmin
                ? Vehicle::all()
                : Vehicle::of($companyId)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $company = Company::find($data['company_id']);
            $material = Material::find($data['material_id']);
            $vehicle = Vehicle::find($data['vehicle_id']);
            $driver = Driver::find($data['driver_id']);

            $delivery = Delivery::create([
                'no' => $data['no'],
                'company_id' => $company->id,
                'company_name' => $company->name,
                'material_code' => $material->code,
                'material_name' => $material->name,
                'vehicle_plat_number' => $vehicle->plat_number,
                'vehicle_type' => $vehicle->type,
                'vehicle_max_capacity' => $vehicle->max_capacity,
                'driver_name' => $driver->name,
                'driver_contact' => $driver->contact,
                'date' => $data['date'],
            ]);

            $delivery->update(['qr_code' => "QR$delivery->id"]);

            // Notification for admin
            Notification::create([
                'user_id' => User::where('is_admin', true)->first()->id,
                'title' => 'Pengiriman',
                'description' => "{$delivery->company_name} melalukan pengiriman material {$delivery->material_name}",
                'icon' => 'fa-truck',
                'color' => 'primary',
                'link' => "/deliveries/$delivery->id"
            ]);

            // Notification for user
            if (!Auth::user()->is_admin) {
                Notification::create([
                    'user_id' => Auth::user()->id,
                    'title' => 'Pengiriman',
                    'description' => "Material {$delivery->material_name} sedang dikirim",
                    'icon' => 'fa-truck',
                    'color' => 'primary',
                    'link' => "/deliveries/$delivery->id"
                ]);
            }
        });

        return response()->json([
            'message' => 'Pengiriman Berhasil Dibuat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Delivery $delivery)
    {
        if ($request->query('notif')) {
            Notification::where('id', $request->query('notif'))
                ->update(['is_read' => true]);
        }

        return view('delivery.show', [
            'delivery' => $delivery,
            'qrCode' => mapDeliveryForQrCode($delivery)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Delivery $delivery)
    {
        $delivery->update(['status' => 'Diterima']);

        Notification::create([
            'user_id' => $delivery->company->user->id,
            'title' => 'Pengiriman',
            'description' => "Pengiriman material $delivery->material_name telah diterima",
            'icon' => 'fa-check',
            'color' => 'success',
            'link' => "/deliveries/$delivery->id"
        ]);

        return response()->json(['message' => 'Pengiriman Diterima']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        // $delivery->delete();

        // return redirect('/deliveries')->with('message', 'Pengiriman Berhasil Dihapus');
    }

    /**
     * Download the specified resource QRCode from storage.
     */
    public function download(Delivery $delivery)
    {
        $data = mapDeliveryForQrCode($delivery);

        $qrCode = 'data:image/svg+xml;base64,' . base64_encode(QrCode::generate($data));

        $pdf = Pdf::loadView('delivery.scan', [
            'code' => $delivery->qr_code,
            'qrCode' => $qrCode
        ]);

        return $pdf->download('scanme.pdf');
    }
}
