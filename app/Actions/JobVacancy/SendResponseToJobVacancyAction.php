<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancyResponse;
use Illuminate\Http\JsonResponse;

class SendResponseToJobVacancyAction
{
    public function __construct(
        protected JobVacancyResponse $model
    ) {
    }

    public function __invoke(int $vacancyId): JsonResponse
    {
        $response = $this->model->create([
                'vacancy_id' => $vacancyId,
                'user_id' => auth()->user()->id
            ]);

        return response()->json([
            'data' => $response
        ], 201);
    }
}
