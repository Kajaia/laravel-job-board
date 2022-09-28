<?php

namespace App\Http\Controllers\JobVacancy;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobVacancyRequest;
use App\Http\Requests\JobVacancyResponseRequest;
use App\Services\JobVacancyService;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;

class JobVacancyController extends Controller
{
    public function __construct(
        protected JobVacancyService $jobVacancyService,
        protected TransactionService $transactionService
    ) {}

    public function addVacancy(JobVacancyRequest $request): RedirectResponse
    {
        if($this->transactionService->coinsCount() >= 2)
        {
            $this->jobVacancyService->addVacancy($request);
            
            $this->transactionService->addOrSubtractCoins(2, 'subtract');
            
            return back();
        }

        return back()->with('message', 'Insufficient amount of coins.');
    }

    public function sendResponse(JobVacancyResponseRequest $request, int $id): RedirectResponse
    {
        if($this->jobVacancyService->userResponsesCount($id) < 1)
        {
            $this->jobVacancyService->sendResponse($request, $id);

            return back();
        }

        return back()->with('message', 'You can\'t send two or more responses to the same job vacancy.');
    }
}
