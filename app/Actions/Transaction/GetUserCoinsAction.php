<?php

namespace App\Actions\Transaction;

use App\Models\UserCoin;

class GetUserCoinsAction
{
    public function __construct(
        protected UserCoin $model
    ) {
    }

    public function __invoke(?int $userId = null): int
    {
        $coins = $this->model->where([
                'user_id' => $userId ? $userId : auth()->user()->id
            ])->sum('coins');

        return $coins;
    }
}
