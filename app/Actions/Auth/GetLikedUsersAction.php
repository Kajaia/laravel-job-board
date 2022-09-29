<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class GetLikedUsersAction
{
    public function __construct(
        protected User $model
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $users = $this->model::with('likes')
            ->whereHas('likes', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->paginate();

        return response()->json([
            'data' => $users
        ], 200);
    }
}
