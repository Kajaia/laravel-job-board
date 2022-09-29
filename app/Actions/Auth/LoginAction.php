<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class LoginAction
{
    public function __construct(
        protected User $model
    ) {
    }

    public function __invoke(LoginRequest $request): RedirectResponse
    {
        $user = $request->validate($request->rules());

        if (auth()->attempt($user, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Wrong credentials provided.'
        ])->onlyInput('email');
    }
}
