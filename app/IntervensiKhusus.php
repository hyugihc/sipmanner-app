<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pia;
use App\ProgressIntervensiKhusus;
use App\Provinsi;

class IntervensiKhusus extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'uraian_kegiatan', 'volume', 'output', 'outcome', 'keterangan', 'provinsi_id'
    ];

    public function pias()
    {
        return $this->belongsToMany(Pia::class);
    }

    public function progress_intervensi_khususes()
    {
        return $this->hasMany(ProgressIntervensiKhusus::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
