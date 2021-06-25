<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'email' => 'required|unique:users|email:rfc,dns',
            'nip_lama' => 'required|unique:users|size:9',
            'role_id' => 'required',
            'provinsi_id' => 'required'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'name.required'          => 'Nama wajib diisi.',
    //         'email.required'         => 'Email wajib diisi.',
    //         'email.email'            => 'Email tidak valid.',
    //         'email.unique'           => 'Email sudah terdaftar.',
    //         'nip_lama.required'      => 'NIP lama wajib diisi.'
    //     ];
    // }
}
