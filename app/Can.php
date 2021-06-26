<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Can extends Model
{
    //

    const STATUS_DRAFT    = 0;
    const STATUS_SUBMIT   = 1;
    const STATUS_APPROVE  = 2;
    const STATUS_DECLINE  = 3;
    const STATUS_INACTIVE = 4;
    const CHANGE_LEADER = 2;
    const CHANGE_CHAMPION = 3;
    const CHANGE_AGENT = 4;
    const TOP_LEADER = 5;

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


    public static function attachChangeAgents(Can $can, $userArray)
    {
        foreach ($userArray as $user) {
            $can->changeAgents()->attach($user, ['role_id' => Can::CHANGE_AGENT]);
        }
        return $can;
    }

    public static function attachChangeChampions(Can $can, $userArray)
    {
        foreach ($userArray as $user) {
            $can->changeChampions()->attach($user, ['role_id' => Can::CHANGE_CHAMPION]);
        }
        return $can;
    }

    public static function attachChangeLeaders(Can $can, $userArray)
    {
        foreach ($userArray as $user) {
            $can->changeLeaders()->attach($user, ['role_id' => Can::CHANGE_LEADER]);
        }
        return $can;
    }
}
