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
        return 'sk_' . $this->tahun_sk . '_' . $this->provinsi->kode_provinsi . '_' . $this->id . '.pdf';
    }

    public function getCanStatus()
    {
        switch ($this->status_sk) {
            case 0:
                return "draft";
                break;
            case 1:
                return "submitted";
                break;
            case 2:
                return "approved (Aktif)";
                break;
            case 3:
                return "rejected";
                break;
            case 4:
                return "approved (Tidak Aktif)";
                break;

            default:
                # code...
                break;
        }
    }
}
