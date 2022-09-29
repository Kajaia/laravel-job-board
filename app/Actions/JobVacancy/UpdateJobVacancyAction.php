<?php

namespace App\Actions\JobVacancy;

use App\Http\Requests\JobVacancyRequest;
use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;

class UpdateJobVacancyAction
{
    public function __construct(
        protected JobVacancy $model
    ) {
    }

    public function __invoke(JobVacancyRequest $request, int $id): JsonResponse
    {
        $request->validate($request->rules());

        $vacancy = $this->model->findOrFail($id);

        $vacancy->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'data' => $vacancy
        ], 200);
    }
}
