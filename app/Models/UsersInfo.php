<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    protected $table = 'users_info';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(department::class);
    }

    public function position()
    {
        return $this->belongsTo(position::class);
    }
    
    public function country()
    {
        return $this->belongsTo(country::class);
    }

    protected $fillable = [
        'user_id',
        'designation',
        'joining_date',
        'phone',
        'address',
        'last_login',
        'image',
        'status',
        'department_id',
        'country_id',
        'position_id',
    ];    
}
