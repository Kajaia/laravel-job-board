<?php

namespace App\Actions\JobVacancy;

use App\Models\SentEmail;

class CheckJobVacancySentEmailsForLastHourAction
{
    public function __construct(
        protected SentEmail $model
    ) {
    }

    public function __invoke(int $vacancyId): ?int
    {
        return $this->model->where('vacancy_id', $vacancyId)
            ->where('created_at', '<', now()->subHour())
            ->count();
    }
}
