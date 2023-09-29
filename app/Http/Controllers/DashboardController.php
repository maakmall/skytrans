<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\CompanyMaterial;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\Material;
use App\Models\Notification;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin')->only('index');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [
                'material' => Auth::user()->is_admin
                    ? Material::count()
                    : CompanyMaterial::of(Auth::user()->company_id)->count(),
                'delivery' => Auth::user()->is_admin
                    ? Delivery::count()
                    : Delivery::of(Auth::user()->company_id)->count(),
                'vehicle' => Auth::user()->is_admin
                    ? Vehicle::count()
                    : Vehicle::of(Auth::user()->company_id)->count(),
                'company' => Company::count(),
                'driver' => Driver::of(Auth::user()->company_id)->count(),
                'deliveriesHasNotBeenReceived' => Auth::user()->is_admin
                    ? Delivery::sent()->get()
                    : Delivery::of(Auth::user()->company_id)->sent()->get()
            ];

            if (Auth::user()->is_admin) {
                unset($data['driver']);
            } else {
                unset($data['company']);
            }

            return response()->json($data);
        }

        return view('dashboard.index');
    }

    public function registration(Request $request)
    {
        if ($request->query('notif')) {
            Notification::where('id', $request->query('notif'))
                ->update(['is_read' => true]);
        }

        return view('dashboard.registration', ['materials' => Material::all()]);
    }

    public function register(RegistrationRequest $request)
    {
        DB::transaction(function () use ($request) {

            $company = Company::firstOrCreate(
                ['name' => $request->input('company_name')],
                ['address' => $request->input('company_address')]
            );

            if ($company->wasRecentlyCreated) {
                if (!Auth::user()->company_id && !Auth::user()->is_admin) {
                    User::where('id', Auth::user()->id)->update([
                        'company_id' => $company->id,
                    ]);
                }
            }

            $materials = $request->input('materials');
            foreach ($materials as $material) {
                CompanyMaterial::firstOrCreate([
                    'company_id' => $company->id,
                    'material_id' => $material['name'],
                ]);
            }

            $vehicles = $request->input('vehicles');
            foreach ($vehicles as $i => $vehicle) {
                $vehicle['stnk'] = $request->file('vehicles')[$i]['stnk']->store('stnk');
                $result = Vehicle::firstOrCreate(
                    ['plat_number' => $vehicle['plat_number'], 'company_id' => $company->id],
                    $vehicle
                );

                !$result->wasRecentlyCreated && Storage::delete($vehicle['stnk']);
            }

            $drivers = $request->input('drivers');
            foreach ($drivers as $driver) {
                Driver::firstOrCreate(
                    ['name' => $driver['name'], 'company_id' => $company->id],
                    $driver
                );
            }

        });

        return response()->json(['message' => 'Registrasi Data Berhasil']);
    }

    public function setting()
    {
        return view('dashboard.setting', ['user' => Auth::user()]);
    }

    public function updateProfile(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['password'] = $data['password'] ?? $user->password;

        $user->update($data);

        return back()->with('message', 'Profil Berhasil Diubah');
    }
}
