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
        $sortBy = request('sortBy');
        $sortDirection = request('sortDirection');

        $vacancies = $this->model->with('author')
            ->withCount('responses')
            ->when($sortBy && $sortDirection, function ($query) use ($sortBy, $sortDirection) {
                $query->orderBy($sortBy, $sortDirection);
            })->paginate();

        return response()->json([
            'data' => $vacancies
        ], 200);
    }
}
