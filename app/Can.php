<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use PhpParser\Node\Stmt\Switch_;

class Can extends Model
{
    //

    public const STATUS_DRAFT    = 0;
    public const STATUS_SUBMIT   = 1;
    public const STATUS_APPROVE  = 2;
    public const STATUS_DECLINE  = 3;
    public const STATUS_INACTIVE = 4;



    protected $fillable = [
        'nomor_sk', 'tanggal_sk', 'perihal_sk', 'jumlah_can'
    ];

    public function isCanPusat()
    {
        return $this->pusat == 1;
    }

    public function changeChampions()
    {
        return $this->belongsToMany(User::class)->wherePivot('role_id', 3);
    }

    public function changeLeaders()
    {
        return $this->belongsToMany(User::class)->wherePivot('role_id', 2);
    }

    public function changeAgents()
    {
        return $this->belongsToMany(User::class)->wherePivot('role_id', 4);
    }

    //jumlah change agent + change leader + change champion
    public function jumlahCAN()
    {
        return $this->changeAgents()->count() + $this->changeLeaders()->count() + $this->changeChampions()->count();
    }


    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }


    public function attachChangeAgents($userArray)
    {
        foreach ($userArray as $user) {
            $this->changeAgents()->attach($user, ['role_id' => Role::CHANGE_AGENT]);
        }
    }

    public function syncChangeAgents($userArray)
    {
        $this->detachChangeAgents();
        $this->attachChangeAgents($userArray);
    }

    public function detachChangeAgents()
    {
        $this->changeAgents()->detach();
    }


    public function attachChangeChampions($userArray)
    {
        foreach ($userArray as $user) {
            $this->changeChampions()->attach($user, ['role_id' => Role::CHANGE_CHAMPION]);
        }
    }

    public function attachChangeLeaders($userArray)
    {
        foreach ($userArray as $user) {
            $this->changeLeaders()->attach($user, ['role_id' => Role::CHANGE_LEADER]);
        }
    }


    public function getNameFileSK()
    {
        if ($this->isCanPusat()) {
            return 'sk_' . $this->tahun_sk . '_' . "pusat" . '_' . $this->id . '.pdf';
        } else {
            return 'sk_' . $this->tahun_sk . '_' . $this->provinsi->kode_provinsi . '_' . $this->provinsi->nama . '_' . $this->id . '.pdf';
        }
    }



    public function getCanStatus()
    {
        switch ($this->status_sk) {
            case 0:
                return "Draft";
                break;
            case 1:
                return "Diajukan ke Change Leader";
                break;
            case 2:
                return "Disetujui (Aktif)";
                break;
            case 3:
                return "Ditolak";
                break;
            case 4:
                return "Disetujui (Tidak Aktif)";
                break;

            default:
                # code...
                break;
        }
    }
}
