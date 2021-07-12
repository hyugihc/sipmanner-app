<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Can;
use App\Provinsi;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
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
