<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    //
    const CHANGE_LEADER = 2;
    const CHANGE_CHAMPION = 3;
    const CHANGE_AGENT = 4;
    const TOP_LEADER = 5;
}
