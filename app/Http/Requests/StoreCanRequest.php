<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCanRequest extends FormRequest
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
        if ($this->getMethod() == 'POST') {
            $rules = [
                'tahun_sk' => 'required|min:4|max:4',
                'nomor_sk' => 'required|unique:cans|min:3|max:255',
                'tanggal_sk' => 'required',
                'perihal_sk' => 'required',
                'file_sk' => 'required|mimes:pdf|max:3000',
                'jumlah_can' => 'required',
                'change_agents' => 'required'
            ];
        } else {
            $rules = [
                'tahun_sk' => 'required|min:4|max:4',
                'nomor_sk' => 'required|min:3|max:255|unique:cans,nomor_sk,' . $this->can->id,
                'tanggal_sk' => 'required',
                'perihal_sk' => 'required',
                'file_sk' => 'nullable|mimes:pdf|max:3000',
                'jumlah_can' => 'required',
                'change_agents' => 'required'
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'change_agents.required'  => 'Minimal 1 orang untuk ditambahkan'
        ];
    }
}
