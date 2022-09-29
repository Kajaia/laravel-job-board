<?php

namespace Tests\Feature;

use App\Models\JobVacancy;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobVacancyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_post_new_job_vacancy()
    {
        $user = User::findOrFail(1);

        // We can't post new job if user has no coins, so let's give some
        $service = app(TransactionService::class);
        $service->addOrSubtractCoins(2, 'add', $user->id);

        $title = fake()->word();
        $desc = fake()->text(150);

        $details = [
            'title' => $title,
            'description' => $desc,
            'author_id' => $user->id
        ];

        $response = $this->actingAs($user)
            ->post('/vacancy', $details);

        $this->assertDatabaseHas('job_vacancies', $details);

        $response->assertStatus(302);
    }

    public function test_user_can_send_response_to_job_vacancy()
    {
        $vacancy = JobVacancy::create([
            'title' => fake()->word(),
            'description' => fake()->word(),
            'author_id' => 1
        ]);

        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@mail.com',
            'password' => bcrypt('Passw@rd123')
        ]);

        // User can't send response without coins, let's give some
        $service = app(TransactionService::class);
        $service->addOrSubtractCoins(1, 'add', $user->id);

        $response = $this->actingAs($user)
            ->post("/vacancy/{$vacancy->id}/response", [
                'vacancy_id' => $vacancy->id,
                'user_id' => $user->id
            ]);

        $this->assertDatabaseHas('job_vacancy_responses', [
            'vacancy_id' => $vacancy->id,
            'user_id' => $user->id
        ]);

        $response->assertStatus(302);
    }
}
