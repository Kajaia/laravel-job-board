<?php

namespace App\Actions\JobVacancy;

use App\Http\Requests\JobVacancyResponseRequest;
use App\Models\JobVacancyResponse;

class SendResponseToJobVacancyAction
{
    public function __construct(
        protected JobVacancyResponse $model
    ) {}

    public function __invoke(JobVacancyResponseRequest $request, int $vacancyId): JobVacancyResponse
    {
        $request->validate($request->rules());
        
        return $this->model->create([
                'vacancy_id' => $vacancyId,
                'user_id' => auth()->user()->id
            ]);
    }
}