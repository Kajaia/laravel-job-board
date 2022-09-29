<?php

namespace App\Actions\JobVacancy;

use App\Models\Like;

class CheckUserLikedVacancyAction
{
    public function __construct(
        protected Like $model
    ) {
    }

    public function __invoke(int $vacancyId): ?Like
    {
        $like = $this->model->where([
                'likeable_type' => 'App\\Models\\JobVacancy',
                'likeable_id' => $vacancyId,
                'user_id' => auth()->user()->id
            ])->first();

        return $like;
    }
}
