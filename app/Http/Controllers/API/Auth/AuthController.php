<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->authService->register($request);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function likeUser(LikeRequest $request, int $id): JsonResponse
    {
        if ($id !== auth()->user()->id) {
            if (!$this->authService->checkUserLikedAnotherUser($id)) {
                return $this->authService->like($request, $id);
            } else {
                return response()->json([
                    'message' => 'You already liked this user.'
                ], 403);
            }
        }

        return response()->json([
            'message' => 'You can\'t like yourself.'
        ], 403);
    }
}
