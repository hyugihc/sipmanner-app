<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgressProgram;
use App\Pia;
use App\Provinsi;

class ProgramIntervensi extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'uraian_kegiatan', 'provinsi_id', 'vol_keg_tahun', 'output', 'outcome', 'awal_pelaksanaan', 'selesai_pelaksanaan', 'keterangan', 'jenis'
    ];



    public function pias()
    {
        return $this->belongsToMany(Pia::class);
    }

    public function progress_programs()
    {
        return $this->hasMany(ProgressProgram::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
