<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobVacancyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id',
        'user_id'
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class, 'vacancy_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
