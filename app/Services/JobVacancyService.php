<?php

namespace App\Services;

use App\Actions\JobVacancy\CheckUserLikedVacancyAction;
use App\Actions\JobVacancy\GetJobVacancyAuthorIdAction;
use App\Actions\JobVacancy\GetJobVacancyByIdAction;
use App\Actions\JobVacancy\PostNewJobVacancyAction;
use App\Actions\JobVacancy\SendResponseToJobVacancyAction;
use App\Actions\JobVacancy\UserResponsesCountForJobVacancyAction;
use App\Http\Requests\JobVacancyRequest;
use App\Http\Requests\JobVacancyResponseRequest;
use App\Mail\NewResponseAddedToJobVacancy;
use App\Models\JobVacancy;
use App\Models\JobVacancyResponse;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class JobVacancyService
{
    public function __construct(
        protected PostNewJobVacancyAction $postNewJobVacancyAction,
        protected SendResponseToJobVacancyAction $sendResponseToJobVacancyAction,
        protected UserResponsesCountForJobVacancyAction $userResponsesCountForJobVacancyAction,
        protected GetJobVacancyAuthorIdAction $getJobVacancyAuthorIdAction,
        protected CheckUserLikedVacancyAction $checkUserLikedVacancyAction,
        protected GetJobVacancyByIdAction $getJobVacancyByIdAction
    ) {
    }

    public function addVacancy(JobVacancyRequest $request): RedirectResponse
    {
        return ($this->postNewJobVacancyAction)($request);
    }

    public function sendResponse(JobVacancyResponseRequest $request): JobVacancyResponse
    {
        return ($this->sendResponseToJobVacancyAction)($request);
    }

    public function userResponsesCount(int $vacancyId): int
    {
        return ($this->userResponsesCountForJobVacancyAction)($vacancyId);
    }

    public function getJobVacancyAuthorId(int $vacancyId): int
    {
        return ($this->getJobVacancyAuthorIdAction)($vacancyId);
    }

    public function checkUserLikedVacancy(int $vacancyId): ?Like
    {
        return ($this->checkUserLikedVacancyAction)($vacancyId);
    }

    public function sendEmail(JobVacancy $vacancy): void
    {
        Mail::to($vacancy->author->email)->send(new NewResponseAddedToJobVacancy($vacancy));
    }

    public function getJobVacancyById(int $vacancyId): JobVacancy
    {
        return ($this->getJobVacancyByIdAction)($vacancyId);
    }
}
