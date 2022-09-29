<?php

namespace App\Services;

use App\Actions\JobVacancy\CheckJobVacancySentEmailsForLastHourAction;
use App\Actions\JobVacancy\CheckUserLikedVacancyAction;
use App\Actions\JobVacancy\DeleteJobVacancyAction;
use App\Actions\JobVacancy\DeleteJobVacancyResponseAction;
use App\Actions\JobVacancy\GetJobVacancyAuthorIdAction;
use App\Actions\JobVacancy\GetJobVacancyByIdAction;
use App\Actions\JobVacancy\GetLikedVacanciesAction;
use App\Actions\JobVacancy\GetVacanciesListAction;
use App\Actions\JobVacancy\LogSentEmailAction;
use App\Actions\JobVacancy\PostNewJobVacancyAction;
use App\Actions\JobVacancy\SendResponseToJobVacancyAction;
use App\Actions\JobVacancy\UpdateJobVacancyAction;
use App\Actions\JobVacancy\UserResponsesCountForJobVacancyAction;
use App\Http\Requests\JobVacancyRequest;
use App\Mail\NewResponseAddedToJobVacancy;
use App\Models\JobVacancy;
use App\Models\SentEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class JobVacancyService
{
    public function __construct(
        protected PostNewJobVacancyAction $postNewJobVacancyAction,
        protected SendResponseToJobVacancyAction $sendResponseToJobVacancyAction,
        protected UserResponsesCountForJobVacancyAction $userResponsesCountForJobVacancyAction,
        protected GetJobVacancyAuthorIdAction $getJobVacancyAuthorIdAction,
        protected CheckUserLikedVacancyAction $checkUserLikedVacancyAction,
        protected GetJobVacancyByIdAction $getJobVacancyByIdAction,
        protected CheckJobVacancySentEmailsForLastHourAction $checkJobVacancySentEmailsForLastHourAction,
        protected LogSentEmailAction $logSentEmailAction,
        protected GetVacanciesListAction $getVacanciesListAction,
        protected UpdateJobVacancyAction $updateJobVacancyAction,
        protected DeleteJobVacancyAction $deleteJobVacancyAction,
        protected DeleteJobVacancyResponseAction $deleteJobVacancyResponseAction,
        protected GetLikedVacanciesAction $getLikedVacanciesAction
    ) {
    }

    public function getVacanciesList(): JsonResponse
    {
        return ($this->getVacanciesListAction)();
    }

    public function addVacancy(JobVacancyRequest $request): JsonResponse
    {
        return ($this->postNewJobVacancyAction)($request);
    }

    public function updateVacancy(JobVacancyRequest $request, int $id): JsonResponse
    {
        return ($this->updateJobVacancyAction)($request, $id);
    }

    public function deleteVacancy(int $id): JsonResponse
    {
        return ($this->deleteJobVacancyAction)($id);
    }

    public function sendResponse(int $vacancyId): JsonResponse
    {
        return ($this->sendResponseToJobVacancyAction)($vacancyId);
    }

    public function deleteResponse(int $vacancyId): JsonResponse
    {
        return ($this->deleteJobVacancyResponseAction)($vacancyId);
    }

    public function userResponsesCount(int $vacancyId): int
    {
        return ($this->userResponsesCountForJobVacancyAction)($vacancyId);
    }

    public function getJobVacancyAuthorId(int $vacancyId): int
    {
        return ($this->getJobVacancyAuthorIdAction)($vacancyId);
    }

    public function checkUserLikedVacancy(int $vacancyId): ?int
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

    public function vacancyEmailsForLastHour(int $vacancyId): ?int
    {
        return ($this->checkJobVacancySentEmailsForLastHourAction)($vacancyId);
    }

    public function logSentEmail(int $vacancyId): SentEmail
    {
        return ($this->logSentEmailAction)($vacancyId);
    }

    public function likedVacancies(): JsonResponse
    {
        return ($this->getLikedVacanciesAction)();
    }
}
