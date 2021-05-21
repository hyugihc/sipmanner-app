<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgressProgram;
use App\Pia;

class ProgramIntervensi extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'uraian_kegiatan', 'pias_id', 'vol_keg_tahun', 'output', 'outcome', 'awal_pelaksanaan', 'selesai_pelaksanaan', 'keterangan'
    ];

    public function progressProgram()
    {
        return $this->belongsTo(ProgressProgram::class);
    }

    public function pias()
    {
        return $this->belongsToMany(Pia::class);
    }
}
