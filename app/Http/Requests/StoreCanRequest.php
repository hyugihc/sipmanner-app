<?php

namespace App\Http\Requests;

use App\User;
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
        $rules = [];
        if ($this->getMethod() == 'POST') {
            $rules['nomor_sk'] = 'required|unique:cans|min:3|max:255';
            $rules['file_sk'] = 'required|mimes:pdf|max:3000';
        } else {
            $rules['nomor_sk'] = 'required|min:3|max:255|unique:cans,nomor_sk,' . $this->can->id;
            $rules['file_sk'] = 'nullable|mimes:pdf|max:3000';
        }
        if ($this->has('submit')) {
            $changeLeaders = User::where('role_id', 2)->where('provinsi_id', $this->user()->provinsi_id)->get();
            $changeChampions = User::where('role_id', 3)->where('provinsi_id', $this->user()->provinsi_id)->get();
            $jumlahCa = $this->jumlah_can - $changeLeaders->count() - $changeChampions->count();
            $rules['tanggal_sk'] = 'required';
            $rules['perihal_sk'] = 'required';
            $rules['jumlah_can'] = 'required';
            $rules['change_agents'] = 'required|array|size:' . $jumlahCa;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'change_agents.required'  => 'Minimal 1 orang untuk ditambahkan',
            'change_agents.size'=>'Jumlah Change Agent Network harus sebanyak '.$this->jumlah_can
        ];
    }
}
