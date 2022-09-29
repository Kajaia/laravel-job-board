<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function __construct(
        protected User $model
    ) {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $request->validate($request->rules());

        $user = $this->model::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong credentials provided.'
            ], 403);
        }

        $token = $user->createToken($request->ip())->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
