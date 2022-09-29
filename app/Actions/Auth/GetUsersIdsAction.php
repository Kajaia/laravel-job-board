<?php

namespace App\Actions\Auth;

use App\Models\User;

class GetUsersIdsAction
{
    public function __construct(
        protected User $model
    ) {
    }

    public function __invoke(): array
    {
        return $this->model->pluck('id')->toArray();
    }
}
