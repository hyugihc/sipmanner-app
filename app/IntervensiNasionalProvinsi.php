<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provinsi;
use App\IntervensiNasional;

class IntervensiNasionalProvinsi extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kendala', 'solusi'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function intervensiNasional()
    {
        return $this->belongsTo(IntervensiNasional::class);
    }
}
