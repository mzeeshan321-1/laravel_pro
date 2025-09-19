<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class holiday extends Model
{
    protected $fillable = [
        'name',
        'day_of_week',
        'date',
        'description',
        'type',
        'status',
    ];
}
