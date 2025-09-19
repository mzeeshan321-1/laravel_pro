<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'department_name',
        'department_head',
        'email',
        'location',
        'status',
        'total_employees',
        'contact_info',
    ];

    public function userInfos() {
        return $this->hasMany(UsersInfo::class);
    }
}
