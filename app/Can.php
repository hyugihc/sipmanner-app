<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Can extends Model
{
    //
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
