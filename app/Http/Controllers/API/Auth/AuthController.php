<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected TransactionService $transactionService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $registration = $this->authService->register($request);

        $this->transactionService->addOrSubtractCoins(
            3,
            $this->authService->getLastUserId()
        );

        return $registration;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function likeUser(LikeRequest $request, User $user): JsonResponse
    {
        if ($user->id !== auth()->user()->id) {
            if (!$this->authService->checkUserLikedAnotherUser($user->id)) {
                return $this->authService->like($request, $user->id);
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

    public function likedUsers(): JsonResponse
    {
        return $this->authService->likedUsers();
    }
}
