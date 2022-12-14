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
