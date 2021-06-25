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

    protected $fillable = [
        'nomor_sk', 'tanggal_sk', 'perihal_sk', 'provinsi_id', 'alasan', 'tahun_sk'
    ];

    // public function users()
    // {
    //     return $this->belongsToMany(User::class)->withPivot(['role_id']);
    // }

    public function change_champions()
    {
        return $this->belongsToMany(User::class)->wherePivot('role_id', 3);
    }

    public function change_leaders()
    {
        return $this->belongsToMany(User::class)->wherePivot('role_id', 2);
    }

    public function change_agents()
    {
        return $this->belongsToMany(User::class)->wherePivot('role_id', 4);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
