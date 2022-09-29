<?php

namespace App\Actions\Auth;

use App\Models\Like;

class CheckUserLikedAnotherUserAction
{
    public function __construct(
        protected Like $model
    ) {
    }

    public function __invoke(int $userId): ?Like
    {
        $like = $this->model->where([
                'likeable_id' => $userId,
                'user_id' => auth()->user()->id
            ])->first();

        return $like;
    }
}
