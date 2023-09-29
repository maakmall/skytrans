<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => [
                'required',
                Auth::user()->is_admin ? '' : Rule::unique('companies', 'name')->ignore(Auth::user()->company_id)
            ],
            'company_address' => 'required',
            'materials.*.name' => 'required',
            'materials.*.code' => 'required',
            'vehicles.*.plat_number' => 'required',
            'vehicles.*.type' => 'required',
            'vehicles.*.stnk' => 'required|image|max:1024',
            'vehicles.*.max_capacity' => 'required',
            'drivers.*.name' => 'required',
            'drivers.*.contact' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'company_name.required' => 'Nama Perusahaan Tidak Boleh Kosong',
            'company_name.unique' => 'Nama Perusahaan Sudah Terdaftar',
            'company_address.required' => 'Alamat Perusahaan Tidak Boleh Kosong',
            'materials.*.name.required' => 'Nama Material Tidak Boleh Kosong',
            'materials.*.code.required' => 'Kode Material Tidak Boleh Kosong',
            'vehicles.*.plat_number.required' => 'No Plat Tidak Boleh Kosong',
            'vehicles.*.type.required' => 'Jenis Kendaraan Belum Dipilih',
            'vehicles.*.stnk.required' => 'STNK Belum Diupload',
            'vehicles.*.stnk.image' => 'Format Gambar Yang Didukung Hanya jpg, jpeg, png, bmp, gif, svg, dan webp. ',
            'vehicles.*.stnk.max' => 'Gambar Tidak Boleh Lebih Besar Dari 1024KB. ',
            'vehicles.*.max_capacity.required' => 'Kapasitas Maksimal Belum Dipilih',
            'drivers.*.name.required' => 'Nama Supir Tidak Boleh Kosong',
            'drivers.*.contact.required' => 'Kontak Supir Tidak Boleh Kosong',
        ];
    }
}
