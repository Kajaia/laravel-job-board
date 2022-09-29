<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;

class GetVacanciesListAction
{
    public function __construct(
        protected JobVacancy $model
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $vacancies = $this->model->with('author')->paginate();

        return response()->json([
            'data' => $vacancies
        ], 200);
    }
}
