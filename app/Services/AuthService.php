<?php

namespace App\Services;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use Illuminate\Http\RedirectResponse;

class AuthService
{
    public function __construct(
        protected RegisterAction $registerAction,
        protected LoginAction $loginAction
    ) {
    }

    public function register(): RedirectResponse
    {
        return ($this->registerAction)();
    }

    public function login(): RedirectResponse
    {
        return ($this->loginAction)();
    }
}
