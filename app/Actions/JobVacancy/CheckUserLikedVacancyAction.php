<?php

namespace App\Actions\JobVacancy;

use App\Models\Like;

class CheckUserLikedVacancyAction
{
    public function __construct(
        protected Like $model
    ) {
    }

    public function __invoke(int $vacancyId): ?int
    {
        $like = $this->model->where([
                'likeable_type' => 'App\\Models\\JobVacancy',
                'likeable_id' => $vacancyId,
                'user_id' => auth()->user()->id
            ])->count();

        return $like;
    }
}
