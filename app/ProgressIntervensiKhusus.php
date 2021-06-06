<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgressIntervensiKhusus extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intervensi_khusus_id', 'uraian_program', 'bulan', 'presentase_program', 'upload_dokumentasi', 'upload_bukti_dukung', 'keterangan'
    ];
}
