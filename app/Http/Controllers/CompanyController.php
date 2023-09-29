<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\CompanyMaterial;
use App\Models\Driver;
use App\Models\MaterialChange;
use App\Models\Notification;
use App\Models\RequestChange;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['addMaterial', 'deleteMaterial']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->ajax()
            ? response()->json(Company::all())
            : view('company.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        Company::create($request->validated());

        return response()->json([
            'message' => 'Perusahaan Berhasil Ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('company.show', ['company' => $company]);
    }

    /**
     * Search the specified resource by name.
     */
    public function search(Request $request)
    {
        $name = $request->query('name');

        return response()->json(
            Company::where('name', 'LIKE', "%$name%")->get()
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('company.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return response()->json([
            'message' => 'Perusahaan Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        CompanyMaterial::of($company->id)->delete();
        Driver::of($company->id)->delete();
        Vehicle::of($company->id)->delete();
        $company->user?->delete();
        $company->delete();

        return response()->json(['message' => 'Perusahaan Berhasil Dihapus']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteMaterial(CompanyMaterial $material)
    {
        if (!Auth::user()->is_admin) {
            DB::transaction(function () use ($material) {

                $materialChange = MaterialChange::create([
                    'material_id' => $material->material_id,
                ]);

                $requestChange = RequestChange::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus',
                    'data' => 'Material',
                    'data_id' => $material->id,
                    'data_before_id' => $materialChange->id,
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
                    'description' => Auth::user()->username . ' mengajukan penghapusan data material',
                    'icon' => 'fa-trash-alt',
                    'color' => 'danger',
                    'link' => "/requests/$requestChange->id",
                ]);
            });

            return response()->json(['message' => 'Menunggu Konfirmasi Admin']);
        }

        $material->delete();

        return redirect("companies/$material->company_id")
            ->with('message', 'Material Berhasil Dihapus');
    }

    public function addMaterial(Request $request, string $companyId)
    {
        $data = $request->validate(
            [
                'material_id' => [
                    'required',
                    Rule::unique('company_materials')
                        ->where('company_id', $companyId)
                ],
            ],
            [
                'material_id.required' => 'Material Belum Dipilih',
                'material_id.unique' => 'Material Sudah Ada',
            ]
        );

        CompanyMaterial::create([
            'company_id' => $companyId,
            'material_id' => $data['material_id'],
        ]);

        return response()->json([
            'message' => 'Material Berhasil Ditambahkan'
        ]);
    }
}
