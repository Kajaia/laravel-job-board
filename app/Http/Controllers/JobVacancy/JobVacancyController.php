<?php

namespace App\Http\Controllers\JobVacancy;

use App\Http\Controllers\Controller;
use App\Services\JobVacancyService;

class JobVacancyController extends Controller
{
    public function __construct(
        protected JobVacancyService $jobVacancyService
    ) {}

    public function addVacancy()
    {
        return $this->jobVacancyService->addVacancy();
    }
}
