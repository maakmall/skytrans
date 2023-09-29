<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\CompanyMaterial;
use App\Models\Material;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
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
            $materials = Auth::user()->is_admin
                ? Material::all()
                : mapMaterialForUser(CompanyMaterial::of(Auth::user()->company_id)->with('material')->get());

            return response()->json($materials);
        }

        if ($request->query('notif')) {
            Notification::where('id', $request->query('notif'))
                ->update(['is_read' => true]);
        }

        return view('material.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['materials'] = !Auth::user()->is_admin ? Material::all() : null;
        return view('material.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        Material::create($request->validated());

        return response()->json([
            'message' => 'Material Berhasil Ditambahkan'
        ]);
    }

    /**
     * Display the specified resource by id.
     */
    public function show(Material $material)
    {
        return response()->json($material);
    }

    /**
     * Display the specified resource by code.
     */
    public function showByCode(string $code)
    {
        return response()->json(
            Material::where('code', $code)->first()
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('material.edit', ['material' => $material]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return response()->json([
            'message' => 'Material Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return response()->json(['message' => 'Material Berhasil Dihapus']);
    }
}
