<?php

namespace App\Actions\Auth;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;

class LikeModelAction
{
    public function __construct(
        protected Like $model
    ) {
    }

    public function __invoke(LikeRequest $request): RedirectResponse
    {
        $request->validate($request->rules());

        $this->model->create([
            'likeable_type' => $request->likeable_type,
            'likeable_id' => $request->likeable_id,
            'user_id' => auth()->user()->id
        ]);

        return back();
    }
}
