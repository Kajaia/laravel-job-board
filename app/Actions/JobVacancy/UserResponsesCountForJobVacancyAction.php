<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancyResponse;

class UserResponsesCountForJobVacancyAction
{
    public function __construct(
        protected JobVacancyResponse $model
    ) {}

    public function __invoke(int $vacancyId): int
    {
        return $this->model->where([
                'vacancy_id' => $vacancyId,
                'user_id' => auth()->user()->id
            ])->count();
    }
}