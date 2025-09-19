<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department_id',
        'position_id',
        'min_salary',
        'max_salary'
    ];

    /**
     * Job Position belongs to a department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Job Position belongs to a position.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Job Position has many job histories.
     */
    public function jobHistories(): HasMany
    {
        return $this->hasMany(JobHistory::class);
    }
}
