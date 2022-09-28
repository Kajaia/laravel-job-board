<?php

namespace App\Actions\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class RegisterAction
{
    public function __construct(
        protected User $model,
        protected RegisterRequest $request,
    ) {}

    public function __invoke(): RedirectResponse
    {
        $this->request->validate($this->request->rules());

        $user = $this->model->create([
            'name' => $this->request->name,
            'email' => $this->request->email,
            'password' => bcrypt($this->request->password)
        ]);

        auth()->login($user);

        return redirect()->route('home');
    }
}