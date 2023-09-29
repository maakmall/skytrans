<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DeliveryRequest extends FormRequest
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
            'no' => 'required',
            'company_id' => 'required',
            'company_name' => Rule::requiredIf((bool) Auth::user()->is_admin),
            'material_id' => 'required',
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'date' => 'required',
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
            'no.required' => 'Nomor Surat Jalan Tidak Boleh Kosong',
            'company_id.required' => 'Pengirim Tidak Valid',
            'company_name.required' => 'Pengirim Tidak Boleh Kosong',
            'material_id.required' => 'Material Belum Dipilih',
            'vehicle_id.required' => 'Kendaraan Belum Dipilih',
            'driver_id.required' => 'Driver Belum Dipilih',
            'date.required' => 'Tanggal Kirim Tidak Boleh Kosong',
        ];
    }
}
