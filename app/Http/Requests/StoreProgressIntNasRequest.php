<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgressIntNasRequest extends FormRequest
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
        $rules = [
            'uraian_program' => 'required|max:500',
            'bulan' => 'required',
            'presentase_program' => 'required',
            'keterangan' => 'nullable',
        ];
        if ($this->getMethod() == 'POST') {
            $rules['upload_dokumentasi'] = 'required|mimes:pdf|max:2000';
            $rules['upload_bukti_dukung'] = 'required|mimes:pdf|max:2000';
        } else {
            $rules['upload_dokumentasi'] = 'nullable|mimes:pdf|max:2000';
            $rules['upload_bukti_dukung'] = 'nullable|mimes:pdf|max:2000';
        }
        return $rules;
    }
}
