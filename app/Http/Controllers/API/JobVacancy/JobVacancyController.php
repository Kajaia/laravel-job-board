<?php

namespace App\Http\Controllers\API\JobVacancy;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobVacancyRequest;
use App\Http\Requests\LikeRequest;
use App\Services\AuthService;
use App\Services\JobVacancyService;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class JobVacancyController extends Controller
{
    public function __construct(
        protected JobVacancyService $jobVacancyService,
        protected TransactionService $transactionService,
        protected AuthService $authService
    ) {
    }

    public function vacancies(): JsonResponse
    {
        return $this->jobVacancyService->getVacanciesList();
    }

    public function vacancy(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->jobVacancyService->getJobVacancyById($id)
        ], 200);
    }

    public function updateVacancy(JobVacancyRequest $request, int $id): JsonResponse
    {
        if (!$this->vacancyAuthorIsNotAuthUser($id)) {
            return $this->jobVacancyService->updateVacancy($request, $id);
        }

        return response()->json([
            'message' => 'You can only update your vacancies.'
        ], 403);
    }

    public function deleteVacancy(int $id): JsonResponse
    {
        if (!$this->vacancyAuthorIsNotAuthUser($id)) {
            return $this->jobVacancyService->deleteVacancy($id);
        }

        return response()->json([
            'message' => 'You can only delete your vacancies.'
        ], 403);
    }

    public function addVacancy(JobVacancyRequest $request): JsonResponse
    {
        if ($this->transactionService->coinsCount() >= 2) {
            $this->transactionService->addOrSubtractCoins(2, 'subtract');

            return $this->jobVacancyService->addVacancy($request);
        }

        return response()->json([
            'message' => 'Insufficient amount of coins.'
        ], 403);
    }

    public function sendResponse(int $id): JsonResponse
    {
        if ($this->vacancyAuthorIsNotAuthUser($id)) {
            if ($this->jobVacancyService->userResponsesCount($id) < 1) {
                if ($this->transactionService->coinsCount() >= 1) {
                    $response = $this->jobVacancyService->sendResponse($id);

                    if ($this->jobVacancyService->vacancyEmailsForLastHour($id) < 1) {
                        $this->jobVacancyService->sendEmail(
                            $this->jobVacancyService->getJobVacancyById($id)
                        );

                        $this->jobVacancyService->logSentEmail($id);
                    }

                    $this->transactionService->addOrSubtractCoins(1, 'subtract');

                    return $response;
                } else {
                    return response()->json([
                        'message' => 'Insufficient amount of coins.'
                    ], 403);
                }
            } else {
                return response()->json([
                    'message' => 'You can\'t send two or more responses to the same job vacancy.'
                ], 403);
            }
        }

        return response()->json([
            'message' => 'You can\'t send response to your job vacancy.'
        ], 403);
    }

    public function deleteResponse(int $id): JsonResponse
    {
        return $this->jobVacancyService->deleteResponse($id);
    }

    public function likeVacancy(LikeRequest $request, int $id): JsonResponse
    {
        if ($this->vacancyAuthorIsNotAuthUser($id)) {
            if (!$this->jobVacancyService->checkUserLikedVacancy($id)) {
                return $this->authService->like($request, $id);
            } else {
                return response()->json([
                    'message' => 'You already liked this vacancy.'
                ], 403);
            }
        }

        return response()->json([
            'message' => 'You can\'t like your vacancy.'
        ], 403);
    }

    public function likedVacancies(): JsonResponse
    {
        return $this->jobVacancyService->likedVacancies();
    }

    public function vacancyAuthorIsNotAuthUser(int $vacancyId): bool
    {
        return $this->jobVacancyService->getJobVacancyAuthorId($vacancyId) !== auth()->user()->id;
    }
}
