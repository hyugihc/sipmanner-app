<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pia extends Model
{
    //
    public function intervensi_khususes()
    {
        return $this->hasMany(IntervensiKhusus::class);
    }
}
