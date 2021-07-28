<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pia;
use App\ProgressIntervensiKhusus;
use App\Provinsi;
use App\User;

class IntervensiKhusus extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'uraian_kegiatan', 'volume', 'output', 'outcome', 'keterangan'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
