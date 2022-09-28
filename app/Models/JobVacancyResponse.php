<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id',
        'user_id'
    ];

    public function vacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'vacancy_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
