<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Report extends Model
{
    //
    protected $fillable = [
        'tahun', 'semester', 'user_id', 'provinsi_id', 'bab_i', 'bab_ii', 'bab_ii', 'bab_iii', 'bab_iv', 'bab_v', 'bab_vi', 'bab_vii', 'bab_viii',
    ];

    //last modified
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    //aporval cc
    public function changeChampions()
    {
        return $this->belongsToMany(User::class)->withPivot('status');;
    }

    //nama lampiran
    public function getNamaFileLampiran()
    {
        return $this->provinsi->nama . '_' . $this->tahun . "_" . $this->semester . ".pdf";
    }

    public function attachChangeChampions($userArray)
    {
        foreach ($userArray as $user) {
            $this->changeChampions()->attach($user, ['status' => 0]);
        }
    }

    public function intervensiKhususes()
    {
        return $this->belongsToMany(IntervensiKhusus::class)->withPivot(['kendala', 'solusi']);
    }

    public function intervensiNasionalProvinsis()
    {
        return $this->belongsToMany(IntervensiNasionalProvinsi::class)->withPivot(['kendala', 'solusi']);
    }



    public function getStatus()
    {

        switch ($this->status) {
            case null:
                return "draft";
                break;

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

            case '4':
                return "Disetujui";
                break;

            default:
                # code...
                break;
        }
    }
}
