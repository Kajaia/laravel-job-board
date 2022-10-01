<?php

namespace App\Actions\Transaction;

use App\Models\UserCoin;

class AddOrSubtractUserCoinsAction
{
    public function __construct(
        protected UserCoin $model
    ) {
    }

    public function __invoke(int $amount, ?int $userId = null): UserCoin
    {
        return $this->model->create([
                'coins' => $amount,
                'user_id' => $userId ? $userId : auth()->user()->id
            ]);
    }
}
