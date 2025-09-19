<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_position_id',
        'job_grade_id',
        'department_id',
        'start_date',
        'end_date'
    ];

    /**
     * Job History belongs to a User (Employee).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Job History belongs to a Job Position.
     */
    public function jobPosition(): BelongsTo
    {
        return $this->belongsTo(JobPosition::class);
    }

    /**
     * Job History belongs to a Department.
     */
    public function jobGrade(): BelongsTo
    {
        return $this->belongsTo(JobGrade::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(department::class);
    }
}
