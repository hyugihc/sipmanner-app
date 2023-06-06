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
        'nama', 'uraian_kegiatan', 'isu_strategis', 'output', 'timeline', 'ukuran_keberhasilan', 'outcome', 'keterangan'
    ];

    //has many rb2023
    public function rb2023s()
    {
        return $this->belongsToMany(rb2023::class);
    }


    // public function pias()
    // {
    //     return $this->belongsToMany(Pia::class);
    // }



    public function progress_intervensi_khususes()
    {
        return $this->hasMany(ProgressIntervensiKhusus::class);
    }

    //ambil progress bulan terakhir
    public function getRealisasiTerakhir()
    {
        if (ProgressIntervensiKhusus::where('intervensi_khusus_id', $this->id)->where('status', 2)->orderBy('tanggal', 'desc')->first() == null) {
            return null;
        } else {
            return ProgressIntervensiKhusus::where('intervensi_khusus_id', $this->id)->where('status', 2)->orderBy('tanggal', 'desc')->first()->realisasi_pelaksanaan_kegiatan;
        }
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //getChangeLeader
    public function getChangeLeader()
    {
        //ambli user yang punya role_id 2 dan mempunyai provinsi_id yang sama dengan provinsi_id dari user
        $user = User::where('role_id', 2)->where('provinsi_id', $this->user->provinsi_id)->first();
        return $user;
    }

    public function getStatus()
    {
        switch ($this->status) {
            case '0':
                return "Draft";
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
