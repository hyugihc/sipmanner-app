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
            'nama' => 'required|min:3|max:50'
        ];
        if ($this->has('submit')) {
            $rules['uraian_kegiatan'] = 'required|max:500';
            $rules['volume'] = 'required';
            $rules['output'] = 'required';
            $rules['outcome'] = 'required';
            $rules['pias'] = 'required';
        }
        return $rules;
    }
}
