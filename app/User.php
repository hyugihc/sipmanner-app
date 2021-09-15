<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Can;
use App\Provinsi;
use App\Role;
use App\Setting;
use App\IntervensiKhusus;
use App\Traits\UserSettingsTrait;

class User extends Authenticatable
{

    public const ADMIN    = 1;
    public const CHANGE_LEADER = 2;
    public const CHANGE_CHAMPIONS    = 3;
    public const CHANGE_AGENT = 4;
    public const TOP_LEADER    = 5;

    use Notifiable;
    use UserSettingsTrait;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    //hanya change champion yang punya
    public function intervensi_khususes()
    {
        return $this->hasMany(IntervensiKhusus::class);
    }

    public function isAdmin()
    {
        return $this->role->id == 1;
    }

    public function isChangeChampion()
    {
        return $this->role->id == 3;
    }

    public function isChangeLeader()
    {
        return $this->role->id == 2;
    }

    public function isTopLeader()
    {
        return $this->role->id == 5;
    }

    public function setUserSatkerFromSSO($ssoOrg)
    {
    }

    public function getSatkerEs2()
    {
        return $this->provinsi_id;
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    // public function isActiveChangeAgent()
    // {
    //     $can = Can::where('provinsi_id', $this->provinsi_id)->where('status', 2)->where('tahun', date("y"))->first();
    //     return $can->changeAgents->where("user_id", $this->id)->first();
    // }




    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
