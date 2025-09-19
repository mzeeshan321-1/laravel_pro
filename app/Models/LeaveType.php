<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    protected $fillable = [
        'name',
        'max_days',
        'year_leave',
        'carry_forward',
        'paid',
    ];
}
