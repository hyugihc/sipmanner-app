<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgramIntervensi;
use App\Provinsi;

class ProgressProgram extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_intervensi_id', 'nama', 'provinsi_id', 'tanggal_kegiatan', 'progress_kegiatan', 'progress_output', 'outcome', 'upload_dokumentasi', 'upload_bukti_dukung', 'keterangan'
    ];

    public function program_intervensi()
    {
        return $this->belongsTo(ProgramIntervensi::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
