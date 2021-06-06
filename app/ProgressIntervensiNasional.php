<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgressIntervensiNasional extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intervensi_nasional_id', 'provinsi_id', 'uraian_program', 'bulan', 'presentase_program', 'upload_dokumentasi', 'upload_bukti_dukung', 'keterangan'
    ];
}
