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
        $add = $this->model->where([
                'type' => 'add',
                'user_id' => $userId ? $userId : auth()->user()->id
            ])->sum('coins');

        $subtract = $this->model->where([
                'type' => 'subtract',
                'user_id' => $userId ? $userId : auth()->user()->id
            ])->sum('coins');

        return $add - $subtract;
    }
}
