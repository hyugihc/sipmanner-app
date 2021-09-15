<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Setting extends Model
{
    //
    protected $fillable = ['name', 'value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
