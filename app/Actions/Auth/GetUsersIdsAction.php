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
        return $this->model->query()
            ->withCount('coins')
            ->having('coins_count', '<', config('transactions.coins.max'))
            ->pluck('id')
            ->toArray();
    }
}
