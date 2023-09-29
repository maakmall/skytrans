<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Models\Company;
use App\Models\Driver;
use App\Models\DriverChange;
use App\Models\Notification;
use App\Models\RequestChange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
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
            $drivers = Auth::user()->is_admin
                ? Driver::all()
                : Driver::of(Auth::user()->company_id)->get();

            return response()->json($drivers);
        }

        if ($request->query('notif')) {
            Notification::where('id', $request->query('notif'))
                ->update(['is_read' => true]);
        }

        return view('driver.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['companies'] = Auth::user()->is_admin ? Company::all() : null;

        return view('driver.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = $data['company_id'] ?? Auth::user()->company_id;

        Driver::create($data);

        return response()->json(['message' => 'Driver Berhasil Ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Driver $driver)
    {
        return view('driver.edit', [
            'driver' => $driver,
            'companies' => Auth::user()->is_admin ? Company::all() : null
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DriverRequest $request, Driver $driver)
    {
        $data = $request->validated();

        if (!Auth::user()->is_admin) {
            DB::transaction(function () use ($driver, $data) {

                $driverBeforeChange = DriverChange::create([
                    'name' => $driver->name,
                    'contact' => $driver->contact,
                ]);

                $driverChange = DriverChange::create([
                    'name' => $data['name'],
                    'contact' => $data['contact'],
                ]);

                $requestChange = RequestChange::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Update',
                    'data' => 'Driver',
                    'data_id' => $driver->id,
                    'data_before_id' => $driverBeforeChange->id,
                    'data_change_id' => $driverChange->id,
                ]);

                Notification::create([
                    'user_id' => Auth::user()->id,
                    'title' => 'Pengajuan Update',
                    'description' => "Perubahan data memerlukan izin admin. Silahkan tunggu konfirmasi dari admin",
                    'icon' => 'fa-pencil-alt',
                    'color' => 'warning',
                    'link' => "/requests/$requestChange->id",
                ]);

                $admin = User::where('is_admin', true)->first();

                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pengajuan Update',
                    'description' => Auth::user()->username . ' mengajukan perubahan data driver',
                    'icon' => 'fa-pencil-alt',
                    'color' => 'warning',
                    'link' => "/requests/$requestChange->id",
                ]);
            });

            return response()->json(['message' => 'Menunggu Konfirmasi Admin']);
        }

        $data['company_id'] = $data['company_id'] ?? Auth::user()->company_id;

        $driver->update($data);

        return response()->json(['message' => 'Driver Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        if (!Auth::user()->is_admin) {
            DB::transaction(function () use ($driver) {

                $driverChange = DriverChange::create([
                    'name' => $driver->name,
                    'contact' => $driver->contact,
                ]);

                $requestChange = RequestChange::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus',
                    'data' => 'Driver',
                    'data_id' => $driver->id,
                    'data_before_id' => $driverChange->id,
                ]);

                Notification::create([
                    'user_id' => Auth::user()->id,
                    'title' => 'Pengajuan Hapus',
                    'description' => "Penghapusan data memerlukan izin admin. Silahkan tunggu konfirmasi dari admin",
                    'icon' => 'fa-trash-alt',
                    'color' => 'danger',
                    'link' => "/requests/$requestChange->id",
                ]);

                $admin = User::where('is_admin', true)->first();

                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pengajuan Hapus',
                    'description' => Auth::user()->username . ' mengajukan penghapusan data driver',
                    'icon' => 'fa-trash-alt',
                    'color' => 'danger',
                    'link' => "/requests/$requestChange->id",
                ]);
            });

            return response()->json(['message' => 'Menunggu Konfirmasi Admin']);
        }

        $driver->delete();

        return response()->json(['message' => 'Driver Berhasil Dihapus']);
    }
}
