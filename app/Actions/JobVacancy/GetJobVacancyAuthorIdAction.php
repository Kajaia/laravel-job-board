<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancy;

class GetJobVacancyAuthorIdAction
{
    public function __construct(
        protected JobVacancy $model
    ) {
    }

    public function __invoke(int $vacancyId): int
    {
        return $this->model::findOrFail($vacancyId)->author_id;
    }
}
