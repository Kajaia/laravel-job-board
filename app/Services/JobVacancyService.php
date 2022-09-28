<?php

namespace App\Services;

use App\Actions\JobVacancy\PostNewJobVacancyAction;
use Illuminate\Http\RedirectResponse;

class JobVacancyService
{
    public function __construct(
        protected PostNewJobVacancyAction $postNewJobVacancyAction
    ) {}

    public function addVacancy(): RedirectResponse
    {
        return ($this->postNewJobVacancyAction)();
    }
}