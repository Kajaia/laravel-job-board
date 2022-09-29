<?php

namespace App\Services;

use App\Actions\JobVacancy\PostNewJobVacancyAction;
use App\Actions\JobVacancy\SendResponseToJobVacancyAction;
use App\Actions\JobVacancy\UserResponsesCountForJobVacancyAction;
use App\Http\Requests\JobVacancyRequest;
use App\Http\Requests\JobVacancyResponseRequest;
use App\Models\JobVacancyResponse;
use Illuminate\Http\RedirectResponse;

class JobVacancyService
{
    public function __construct(
        protected PostNewJobVacancyAction $postNewJobVacancyAction,
        protected SendResponseToJobVacancyAction $sendResponseToJobVacancyAction,
        protected UserResponsesCountForJobVacancyAction $userResponsesCountForJobVacancyAction
    ) {
    }

    public function addVacancy(JobVacancyRequest $request): RedirectResponse
    {
        return ($this->postNewJobVacancyAction)($request);
    }

    public function sendResponse(JobVacancyResponseRequest $request, int $vacancyId): JobVacancyResponse
    {
        return ($this->sendResponseToJobVacancyAction)($request, $vacancyId);
    }

    public function userResponsesCount(int $vacancyId): int
    {
        return ($this->userResponsesCountForJobVacancyAction)($vacancyId);
    }
}
