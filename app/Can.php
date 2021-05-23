<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Can extends Model
{
    //
    protected $fillable = [
        'nomor_sk', 'tanggal_sk', 'perihal_sk', 'file_sk', 'approval', 'provinsi_id', 'alasan'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
