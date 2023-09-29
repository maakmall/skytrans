<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            'username' => [
                'required',
                Rule::unique('users')->ignore($this->user)
            ],
            'phone' => 'required',
            'password' => [
                Rule::requiredIf($this->isMethod('POST')),
                'confirmed',
            ],
            'company_id' => [
                Rule::unique('users')->ignore($this->user),
                Rule::requiredIf($this->is('users*'))
            ]
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
            'username.required' => 'Username Tidak Boleh Kosong',
            'username.unique' => 'Username Sudah Digunakan',
            'phone.required' => 'No. Telepon Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.confirmed' => 'Konfirmasi Password Tidak Sesuai',
            'company_id.required' => 'Perusahaan Belum Dipilih',
            'company_id.unique' => 'Perusahaan Sudah Memiliki User',
        ];
    }
}
