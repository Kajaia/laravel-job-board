<?php

namespace App\Actions\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterAction
{
    public function __construct(
        protected User $model
    ) {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $request->validate($request->rules());

        $user = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken($request->ip())->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
