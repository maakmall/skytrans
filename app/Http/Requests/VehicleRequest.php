<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
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
            'plat_number' => [
                'required',
                Rule::unique('vehicles')
                    ->where('company_id', $this->input('company_id'))
                    ->ignore($this->vehicle)
            ],
            'type' => 'required',
            'max_capacity' => 'required|numeric',
            'stnk' => [
                Rule::requiredIf($this->isMethod('POST')),
                'image',
                'file',
                'max:1024',
            ],
            'company_id' => Rule::requiredIf((bool) Auth::user()->is_admin),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'plat_number.required' => 'Nomor Plat Tidak Boleh Kosong',
            'plat_number.unique' => 'Nomor Plat Sudah Terdaftar',
            'type.required' => 'Jenis Kendaraan Belum Dipilih',
            'max_capacity.required' => 'Kapasitas Maksimal Belum Dipilih',
            'stnk.required' => 'STNK Belum Diupload',
            'stnk.image' => 'Format Gambar Yang Didukung Hanya jpg, jpeg, png, bmp, gif, svg, dan webp. ',
            'stnk.max' => 'Gambar Tidak Boleh Lebih Besar Dari 1024KB. ',
            'company_id.required' => 'Perusahaan Belum Dipilih',
        ];
    }
}
