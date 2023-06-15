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
        'uraian_program', 'bulan', 'tanggal', 'realisasi_pelaksanaan_kegiatan', 'realisasi_capaian_keberhasilan', 'upload_dokumentasi', 'upload_bukti_dukung', 'keterangan'
    ];

    public function getStatus()
    {
        switch ($this->status) {
            case '0':
                return "draft";
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
                # code...
                break;
        }
    }

    public function getBulan()
    {
        if ($this->bulan == null || $this->bulan == 0) {
            // ambil bulan pada $thhis->tanggal
            $bulan = date('m', strtotime($this->tanggal));
            switch ($bulan) {
                case 1:
                    return "Januari";
                    break;

                case 2:
                    return "Februari";
                    break;

                case 3:
                    return "Maret";
                    break;

                case 4:
                    return "April";
                    break;

                case 5:
                    return "Mei";
                    break;

                case 6:
                    return "Juni";
                    break;
                case 7:
                    return "Juli";
                    break;
                case 8:
                    return "Agustus";
                    break;
                case 9:
                    return "September";
                    break;
                case 10:
                    return "Oktober";
                    break;
                case 11:
                    return "November";
                    break;
                case 12:
                    return "Desember";
                    break;
            }
        } else {
            switch ($this->bulan) {
                case 1:
                    return "Januari";
                    break;

                case 2:
                    return "Februari";
                    break;

                case 3:
                    return "Maret";
                    break;

                case 4:
                    return "April";
                    break;

                case 5:
                    return "Mei";
                    break;

                case 6:
                    return "Juni";
                    break;
                case 7:
                    return "Juli";
                    break;
                case 8:
                    return "Agustus";
                    break;
                case 9:
                    return "September";
                    break;
                case 10:
                    return "Oktober";
                    break;
                case 11:
                    return "November";
                    break;
                case 12:
                    return "Desember";
                    break;


                default:
                    # code...
                    break;
            }
        }
    }

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
