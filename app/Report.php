<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Report extends Model
{
    //
    protected $fillable = [
        'tahun', 'status', 'semester', 'user_id', 'provinsi_id', 'bab_i', 'bab_ii', 'bab_ii', 'bab_iii', 'bab_iv', 'bab_v', 'bab_vi', 'bab_vii', 'bab_viii',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
