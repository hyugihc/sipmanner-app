<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pia;
use App\ProgressIntervensiNasional;

class IntervensiNasional extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'uraian_kegiatan', 'output', 'timeline', 'ukuran_keberhasilan', 'outcome', 'keterangan'
    ];

    // public function pias()
    // {
    //     return $this->belongsToMany(Pia::class);
    // }

    public function progress_intervensi_nasionals()
    {
        return $this->hasMany(ProgressIntervensiNasional::class);
    }
}
