<?php

namespace App\Actions\JobVacancy;

use App\Http\Requests\JobVacancyResponseRequest;
use App\Models\JobVacancyResponse;

class SendResponseToJobVacancyAction
{
    public function __construct(
        protected JobVacancyResponse $model
    ) {
    }

    public function __invoke(JobVacancyResponseRequest $request): JobVacancyResponse
    {
        $request->validate($request->rules());

        return $this->model->create([
                'vacancy_id' => $request->vacancy_id,
                'user_id' => auth()->user()->id
            ]);
    }
}
