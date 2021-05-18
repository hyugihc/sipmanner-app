<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Can extends Model
{
    //
    protected $fillable = [
        'nomor_sk', 'tanggal_sk', 'perihal_sk', 'file_sk', 'approval', 'kode_org', 'alasan'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
