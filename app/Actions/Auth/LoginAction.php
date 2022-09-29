<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class LoginAction
{
    public function __construct(
        protected User $model,
        protected LoginRequest $request,
    ) {
    }

    public function __invoke(): RedirectResponse
    {
        $user = $this->request->validate($this->request->rules());

        if (auth()->attempt($user, $this->request->boolean('remember'))) {
            $this->request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Wrong credentials provided.'
        ])->onlyInput('email');
    }
}
