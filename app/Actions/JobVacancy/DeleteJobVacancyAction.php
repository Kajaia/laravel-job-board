<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;

class DeleteJobVacancyAction
{
    public function __construct(
        protected JobVacancy $model
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        $this->model->destroy($id);

        return response()->json(null, 200);
    }
}
