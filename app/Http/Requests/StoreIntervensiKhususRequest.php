<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntervensiKhususRequest extends FormRequest
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
            'nama' => 'required|min:3|max:100'
        ];
        if ($this->has('submit')) {
            $rules['uraian_kegiatan'] = 'required';
            $rules['isu_strategis'] = 'required';
            $rules['output'] = 'required|min:5';
            $rules['timeline'] = 'required|min:5';
            $rules['ukuran_keberhasilan'] = 'required|min:5';
            $rules['outcome'] = 'required|min:5';
        }
        return $rules;
    }
}
