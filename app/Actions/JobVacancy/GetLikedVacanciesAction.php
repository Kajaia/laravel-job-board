<?php

namespace App\Actions\JobVacancy;

use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;

class GetLikedVacanciesAction
{
    public function __construct(
        protected JobVacancy $model
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $vacancies = $this->model::with('likes')
            ->whereHas('likes', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->paginate();

        return response()->json([
            'data' => $vacancies
        ], 200);
    }
}
