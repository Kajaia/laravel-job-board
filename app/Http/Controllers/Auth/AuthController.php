<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function register(): RedirectResponse
    {
        return $this->authService->register();
    }

    public function login(): RedirectResponse
    {
        return $this->authService->login();
    }
}
