<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    protected $table = 'positions';

    public function userInfos() {
        return $this->hasMany(UsersInfo::class);
    }
}
