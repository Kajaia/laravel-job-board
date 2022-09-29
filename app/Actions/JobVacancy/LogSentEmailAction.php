<?php

namespace App\Actions\JobVacancy;

use App\Models\SentEmail;

class LogSentEmailAction
{
    public function __construct(
        protected SentEmail $model
    ) {
    }

    public function __invoke(int $vacancyId): SentEmail
    {
        return $this->model->create(['vacancy_id' => $vacancyId]);
    }
}
