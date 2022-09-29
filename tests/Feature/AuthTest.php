<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $this->artisan('migrate:fresh');

        $response = $this->postJson('/api/v1/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@mail.com',
            'password' => 'Passw@rd123',
            'password_confirmation' => 'Passw@rd123'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@mail.com'
        ]);

        $response->assertStatus(201);
    }

    public function test_user_can_login()
    {
        $credentials = [
            'email' => 'johndoe@mail.com',
            'password' => 'Passw@rd123'
        ];

        $user = User::where('email', $credentials['email'])->first();

        $response = $this->postJson('/api/v1/login', $credentials);

        $response->assertStatus(200);

        $this->actingAs($user)->get('/');
    }

    public function test_user_can_like_another_user()
    {
        $taylor = User::create([
            'name' => 'Taylor Otwell',
            'email' => 'taylor@laravel.com',
            'password' => bcrypt('Tayl@r123')
        ]);

        $user = User::findOrFail(1);

        $details = [
            'likeable_type' => 'App\\Models\\User',
            'likeable_id' => $taylor->id,
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)
            ->postJson("/api/v1/user/{$taylor->id}/like", $details);

        $this->assertDatabaseHas('likes', $details);

        $response->assertStatus(201);
    }

    public function test_user_can_get_liked_users()
    {
        $user = User::findOrFail(1);

        $response = $this->actingAs($user)
            ->getJson('/api/v1/liked/users');

        $response->assertStatus(200);
    }
}
