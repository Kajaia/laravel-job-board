<?php

namespace App\Actions\Auth;

use App\Models\Like;

class CheckUserLikedAnotherUserAction
{
    public function __construct(
        protected Like $model
    ) {
    }

    public function __invoke(int $userId): ?int
    {
        $like = $this->model->where([
                'likeable_type' => 'App\\Models\\User',
                'likeable_id' => $userId,
                'user_id' => auth()->user()->id
            ])->count();

        return $like;
    }
}
