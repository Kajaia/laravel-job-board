<?php

namespace App\Http\Controllers\JobVacancy;

use App\Http\Controllers\Controller;
use App\Services\JobVacancyService;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;

class JobVacancyController extends Controller
{
    public function __construct(
        protected JobVacancyService $jobVacancyService,
        protected TransactionService $transactionService
    ) {}

    public function addVacancy(): RedirectResponse
    {
        if($this->transactionService->coinsCount() >= 2)
        {
            $this->jobVacancyService->addVacancy();

            $this->transactionService->addOrSubtractCoins(2, 'subtract');

            return back();
        }

        return back()->with('message', 'Insufficient amount of coins.');
    }
}
