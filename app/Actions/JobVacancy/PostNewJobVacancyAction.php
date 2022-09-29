<?php

namespace App\Actions\JobVacancy;

use App\Http\Requests\JobVacancyRequest;
use App\Models\JobVacancy;
use Illuminate\Http\RedirectResponse;

class PostNewJobVacancyAction
{
    public function __construct(
        protected JobVacancy $model
    ) {
    }

    public function __invoke(JobVacancyRequest $request): RedirectResponse
    {
        $request->validate($request->rules());

        if ($this->userHasNoJobVacancies()) {
            $this->model->create([
                'title' => $request->title,
                'description' => $request->description,
                'author_id' => auth()->user()->id
            ]);

            return back();
        }

        return back()->with('message', 'You can\'t post more than two job vacancies per 24 hours');
    }

    public function userHasNoJobVacancies(): bool
    {
        $vacancies = $this->model->where('created_at', '>=', now()->subDay())
            ->where('author_id', auth()->user()->id)
            ->count();

        return $vacancies >= 0 && $vacancies < 2;
    }
}
