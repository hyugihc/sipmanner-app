<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntervensiNasionalRequest extends FormRequest
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
            'nama' => 'required|min:3|max:1500',
            'uraian_kegiatan' => 'required|max:1500',
            'isu_strategis' => 'required|max:1500',
            'output' => 'required',
            'timeline' => 'required',
            'ukuran_keberhasilan' => 'required',
            'outcome' => 'required'
        ];
    }
}
