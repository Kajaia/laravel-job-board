<?php

namespace App\Http\Controllers\JobVacancy;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobVacancyRequest;
use App\Http\Requests\JobVacancyResponseRequest;
use App\Http\Requests\LikeRequest;
use App\Services\AuthService;
use App\Services\JobVacancyService;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;

class JobVacancyController extends Controller
{
    public function __construct(
        protected JobVacancyService $jobVacancyService,
        protected TransactionService $transactionService,
        protected AuthService $authService
    ) {
    }

    public function addVacancy(JobVacancyRequest $request): RedirectResponse
    {
        if ($this->transactionService->coinsCount() >= 2) {
            $this->jobVacancyService->addVacancy($request);

            $this->transactionService->addOrSubtractCoins(2, 'subtract');

            return back();
        }

        return back()->with('message', 'Insufficient amount of coins.');
    }

    public function sendResponse(JobVacancyResponseRequest $request, int $id): RedirectResponse
    {
        if ($this->jobVacancyService->userResponsesCount($id) < 1) {
            if ($this->transactionService->coinsCount() >= 1) {
                $this->jobVacancyService->sendResponse($request, $id);

                $this->transactionService->addOrSubtractCoins(1, 'subtract');

                return back();
            } else {
                return back()->with('message', 'Insufficient amount of coins.');
            }
        }

        return back()->with('message', 'You can\'t send two or more responses to the same job vacancy.');
    }

    public function likeVacancy(LikeRequest $request): RedirectResponse
    {
        if ($this->vacancyAuthorIsNotAuthUser($request->likeable_id)) {
            return $this->authService->like($request);
        }

        return back()->with('message', 'You can\'t like your vacancy.');
    }

    public function vacancyAuthorIsNotAuthUser(int $vacancyId): bool
    {
        return $this->jobVacancyService->getJobVacancyAuthorId($vacancyId) !== auth()->user()->id;
    }
}
