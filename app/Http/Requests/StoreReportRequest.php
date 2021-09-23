<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            $rules['bab_i'] = 'required|min:5|max:10000';
            $rules['bab_ii'] = 'required|min:5|max:10000';
            $rules['bab_iii'] = 'required|min:5|max:10000';
            $rules['bab_iv'] = 'required|min:5|max:10000';
            $rules['bab_v'] = 'required|min:5|max:10000';
            $rules['bab_vi'] = 'required|min:5|max:10000';
            $rules['bab_vii'] = 'required|min:5|max:10000';
        }
        return $rules;
    }
}
