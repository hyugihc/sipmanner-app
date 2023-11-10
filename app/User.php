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
use Illuminate\Support\Facades\Auth;

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

    //mempunyai banyak intervensi khusus pada tahun setting
    public function intervensi_khususes_by_year()
    {
        $user = Auth::user();
        $currentYear = $user->getSetting('tahun');
        return $this->hasMany(IntervensiKhusus::class)->where('tahun', $currentYear);
    }



    public function isAdmin()
    {
        return $this->role->id == 1;
    }

    public function isChangeChampion()
    {
        return $this->role->id == 3;
    }

    //apakah changechampion dari provinsi ini
    public function isChangeChampionOf($provinsi_id)
    {
        return $this->role->id == 3 && $this->provinsi_id == $provinsi_id;
    }



    public function isChangeLeader()
    {
        return $this->role->id == 2;
    }

    //set as ChangeLeader
    public function setChangeLeader($simpeg_kdorg, $simpeg_kdprop)
    {
        $this->role_id = 2;
        //ubah satker sesuai kdorg dan kdprop yang ada di table provinsi
        $this->provinsi_id = Provinsi::where('simpeg_kdorg', $simpeg_kdorg)->where('simpeg_kdprop', $simpeg_kdprop)->first()->id;
        $this->save();
    }

    public function isTopLeader()
    {
        return $this->role->id == 5;
    }

    public function isAdminOrTopLeader()
    {
        return $this->role->id == 5 || $this->role->id == 1;
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
