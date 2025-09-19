<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'min_salary',
        'max_salary'
    ];

    /**
     * Job Grade is linked to multiple Job Positions.
     */
    public function jobPositions(): HasMany
    {
        return $this->hasMany(JobPosition::class, 'min_salary', 'min_salary')
                    ->whereColumn('max_salary', '>=', 'max_salary');
    }
}
