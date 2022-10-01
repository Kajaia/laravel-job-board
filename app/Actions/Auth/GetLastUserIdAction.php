<?php

namespace App\Actions\Auth;

use App\Models\User;

class GetLastUserIdAction
{
    public function __construct(
        protected User $model
    ) {
    }

    public function __invoke(): int
    {
        return $this->model::all()->max('id');
    }
}
