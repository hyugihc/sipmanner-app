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
