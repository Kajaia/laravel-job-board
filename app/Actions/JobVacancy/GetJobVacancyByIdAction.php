<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancy;

class GetJobVacancyByIdAction
{
    public function __construct(
        protected JobVacancy $model
    ) {
    }

    public function __invoke(int $vacancyId): JobVacancy
    {
        return $this->model::findOrFail($vacancyId);
    }
}
