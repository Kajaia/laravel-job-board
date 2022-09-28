<?php

namespace App\Services;

use App\Actions\Auth\RegisterAction;
use Illuminate\Http\RedirectResponse;

class AuthService
{
    public function __construct(
        protected RegisterAction $registerAction
    ) {}

    public function register(): RedirectResponse
    {
        return ($this->registerAction)();
    }
}