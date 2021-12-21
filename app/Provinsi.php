<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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

    public function isKabupaten()
    {
        return $this->pusat == 0;
    }


    public function changeLeader()
    {
        return $this->hasOne(User::class)->where('role_id', "2");
    }

    public function changeChampions()
    {
        return $this->hasMany(User::class)->where('role_id', "3");
    }

    public function activeCan()
    {
        return $this->hasOne(Can::class)->where('status_sk', "2");
    }
}
