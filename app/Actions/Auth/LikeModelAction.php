<?php

namespace App\Actions\Auth;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Illuminate\Http\JsonResponse;

class LikeModelAction
{
    public function __construct(
        protected Like $model
    ) {
    }

    public function __invoke(LikeRequest $request, int $id): JsonResponse
    {
        $request->validate($request->rules());

        $like = $this->model->create([
            'likeable_type' => $request->likeable_type,
            'likeable_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        return response()->json([
            'data' => $like
        ], 201);
    }
}
