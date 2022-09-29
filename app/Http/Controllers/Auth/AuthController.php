<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        return $this->authService->register($request);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->authService->login($request);
    }
}
