<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancyResponse;
use Illuminate\Http\JsonResponse;

class DeleteJobVacancyResponseAction
{
    public function __construct(
        protected JobVacancyResponse $model
    ) {
    }

    public function __invoke(int $vacancyId): JsonResponse
    {
        $response = $this->model->where([
                'vacancy_id' => $vacancyId,
                'user_id' => auth()->user()->id
            ])->first();

        if ($response) {
            $response->delete();

            return response()->json(null, 200);
        }

        return response()->json([
            'message' => 'You can\'t delete other users responses.'
        ], 403);
    }
}
