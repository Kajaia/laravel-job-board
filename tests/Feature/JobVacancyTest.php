<?php

namespace Tests\Feature;

use App\Models\User;
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

        $details = [
            'title' => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor, sit amet...',
            'author_id' => $user->id
        ];

        $response = $this->actingAs($user)
            ->put('/vacancy', $details);

        $this->assertDatabaseHas('job_vacancies', $details);

        $response->assertStatus(302);
    }
}
