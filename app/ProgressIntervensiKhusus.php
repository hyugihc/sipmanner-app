<?php

namespace App;

use App\IntervensiKhusus;

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
        'uraian_program', 'bulan', 'realisasi_pelaksanaan_kegiatan', 'upload_dokumentasi', 'upload_bukti_dukung', 'keterangan'
    ];

    public function intervensi_khusus()
    {
        return $this->belongsTo(IntervensiKhusus::class);
    }

    public function getNamaFileDokumentasi()
    {
        return 'pikdok_' . $this->intervensi_khusus->provinsi->nama . '_' . $this->intervensi_khusus->nama . '_' . $this->id . '.pdf';
    }

    public function getNamaFileBuktiDukung()
    {
        return 'pikduk_' . $this->intervensi_khusus->provinsi->nama . '_' . $this->intervensi_khusus->nama . '_' . $this->id . '.pdf';
    }
}
