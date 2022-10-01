<?php

namespace App\Services;

use App\Actions\Transaction\AddOrSubtractUserCoinsAction;
use App\Actions\Transaction\GetUserCoinsAction;
use App\Models\UserCoin;

class TransactionService
{
    public function __construct(
        protected GetUserCoinsAction $getUserCoinsAction,
        protected AddOrSubtractUserCoinsAction $addOrSubtractUserCoinsAction,
        protected AuthService $authService
    ) {
    }

    public function coinsCount(?int $userId = null): int
    {
        return ($this->getUserCoinsAction)($userId);
    }

    public function addOrSubtractCoins(int $amount, ?int $userId = null): UserCoin
    {
        return ($this->addOrSubtractUserCoinsAction)($amount, $userId);
    }

    public function giveCoinsToUserDaily(): void
    {
        foreach ($this->authService->getUsersIds() as $userId) {
            $this->addOrSubtractCoins(1, $userId);
        }
    }
}
