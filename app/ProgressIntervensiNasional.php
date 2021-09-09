<?php

namespace App;

use App\IntervensiNasionalProvinsi;

use Illuminate\Database\Eloquent\Model;

class ProgressIntervensiNasional extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uraian_program', 'bulan', 'realisasi_pelaksanaan_kegiatan','realisasi_capaian_keberhasilan', 'upload_dokumentasi', 'upload_bukti_dukung', 'keterangan'
    ];

    public function intervensiNasionalProvinsi()
    {
        return $this->belongsTo(IntervensiNasionalProvinsi::class);
    }

    public function getNamaFileDokumentasi()
    {
        return 'pindok_' . $this->intervensiNasionalProvinsi->provinsi->nama . '_' . $this->intervensiNasionalProvinsi->intervensiNasional->nama . '_' . $this->id . '.pdf';
    }

    public function getNamaFileBuktiDukung()
    {
        return 'pinduk_' . $this->intervensiNasionalProvinsi->provinsi->nama . '_' . $this->intervensiNasionalProvinsi->intervensiNasional->nama . '_' . $this->id . '.pdf';
    }
}
