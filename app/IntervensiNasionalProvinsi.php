<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provinsi;
use App\IntervensiNasional;

class IntervensiNasionalProvinsi extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kendala', 'solusi'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function intervensiNasional()
    {
        return $this->belongsTo(IntervensiNasional::class);
    }

    //ambil progres intervensi nasional bulan teraskhir
    public function getRealisasiTerakhir()
    {
        $status = [1, 2];
        $progress = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $this->id)->whereIn('status', $status)->orderBy('tanggal', 'desc')->first();

        if ($progress == null) {
            return null;
        } else {
            return $progress->realisasi_pelaksanaan_kegiatan;
        }
    }

    public function getStatus()
    {
        switch ($this->status) {
            case '0':
                return "Belum disesuaikan";
                break;

            case '1':
                return "Di ajukan ke Change leader";
                break;

            case '2':
                return "Disetujui";
                break;

            case '3':
                return "Ditolak";
                break;

            default:
                return "error";
                break;
        }
    }
}
