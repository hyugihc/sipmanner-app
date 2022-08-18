<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\IntervensiKhusus;
use Illuminate\Support\Facades\Auth;

class Provinsi extends Model
{

    public function isPusat()
    {
        return $this->pusat == 1;
    }

    public function isNotPusat()
    {
        return $this->pusat != 1;
    }

    public function changeLeader()
    {
        return $this->hasOne(User::class)->where('role_id', "2");
    }

    public function changeChampions()
    {
        return $this->hasMany(User::class)->where('role_id', "3");
    }

    //mempunyai banyak intervensi khusus sesuai dengan id provinsi
    public function intervensi_khususes()
    {
        return $this->hasMany(IntervensiKhusus::class);
    }

    //mempunyai banyak intervensi khusus pada tahun setting
    public function intervensi_khususes_by_year()
    {
        $user = Auth::user();
        $currentYear = $user->getSetting('tahun');
        return $this->hasMany(IntervensiKhusus::class)->where('tahun', $currentYear);
    }

    //mempunyai intervensi_nasional_provinsi sesuai setting tahun
    public function intervensi_nasional_provinsi_by_year()
    {
        $user = Auth::user();
        $currentYear = $user->getSetting('tahun');
        $intervensiNasionalAktif = IntervensiNasional::where('tahun', $currentYear)->where('status', 2);
        $intervensiNasionalAktifModelKeys = $intervensiNasionalAktif->get()->pluck('id')->toArray();
        return $this->hasMany(IntervensiNasionalProvinsi::class)->where('provinsi_id', $this->id)->where('status', 2)->whereIn('intervensi_nasional_id', $intervensiNasionalAktifModelKeys);
    }


    public function activeCan()
    {
        return $this->hasOne(Can::class)->where('status_sk', "2");
    }
}
