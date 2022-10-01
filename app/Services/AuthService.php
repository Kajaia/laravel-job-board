<?php

namespace App\Services;

use App\Actions\Auth\CheckUserLikedAnotherUserAction;
use App\Actions\Auth\GetLastUserIdAction;
use App\Actions\Auth\GetLikedUsersAction;
use App\Actions\Auth\GetUsersIdsAction;
use App\Actions\Auth\LikeModelAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthService
{
    public function __construct(
        protected RegisterAction $registerAction,
        protected LoginAction $loginAction,
        protected GetUsersIdsAction $getUsersIdsAction,
        protected LikeModelAction $likeModelAction,
        protected CheckUserLikedAnotherUserAction $checkUserLikedAnotherUserAction,
        protected GetLikedUsersAction $getLikedUsersAction,
        protected GetLastUserIdAction $getLastUserIdAction
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return ($this->registerAction)($request);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return ($this->loginAction)($request);
    }

    public function getUsersIds(): array
    {
        return ($this->getUsersIdsAction)();
    }

    public function getLastUserId(): int
    {
        return ($this->getLastUserIdAction)();
    }

    public function like(LikeRequest $request, int $id): JsonResponse
    {
        return ($this->likeModelAction)($request, $id);
    }

    public function likedUsers(): JsonResponse
    {
        return ($this->getLikedUsersAction)();
    }

    public function checkUserLikedAnotherUser(int $userId): ?int
    {
        return ($this->checkUserLikedAnotherUserAction)($userId);
    }
}
