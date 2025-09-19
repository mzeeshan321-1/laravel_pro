<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $table = 'payrolls';
    
    protected $fillable = [
        'user_id',
        'num_of_day_work',
        'bonus',
        'overtime',
        'gross_salary',
        'cash_advance',
        'late_hours',
        'absent_days',
        'total_deduction',
        'netpay',
        'payroll_month',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
