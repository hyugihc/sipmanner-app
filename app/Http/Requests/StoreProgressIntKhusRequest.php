<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgressIntKhusRequest extends FormRequest
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
        $rules = [];
        if ($this->has('submit')) {
            $rules['upload_bukti_dukung'] = 'required|mimes:pdf|max:5000';
            $rules['uraian_program'] = 'required|max:2000';
            $rules['tanggal'] = 'required';
            $rules['realisasi_pelaksanaan_kegiatan'] = 'required';
            $rules['realisasi_capaian_keberhasilan'] = 'required';
            $rules['keterangan'] = 'nullable';
        } else {
            $rules['upload_bukti_dukung'] = 'nullable|mimes:pdf|max:5000';
        }
        return $rules;
    }
}
