<?php

namespace App\Services;

use App\Actions\Transaction\AddOrSubtractUserCoinsAction;
use App\Actions\Transaction\GetUserCoinsAction;
use App\Models\UserCoin;

class TransactionService
{
    public function __construct(
        protected GetUserCoinsAction $getUserCoinsAction,
        protected AddOrSubtractUserCoinsAction $addOrSubtractUserCoinsAction
    ) {}

    public function coinsCount(): int
    {
        return ($this->getUserCoinsAction)();
    }

    public function addOrSubtractCoins(int $amount, string $type): UserCoin
    {
        return ($this->addOrSubtractUserCoinsAction)($amount, $type);
    }
}