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

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@mail.com',
            'password' => 'Passw@rd123',
            'password_confirmation' => 'Passw@rd123'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@mail.com'
        ]);

        $response->assertStatus(302);
    }

    public function test_user_can_login()
    {
        $credentials = [
            'email' => 'johndoe@mail.com',
            'password' => 'Passw@rd123'
        ];

        $user = User::where('email', $credentials['email'])->first();

        $response = $this->post('login', $credentials);

        $response->assertStatus(302);

        $this->actingAs($user)->get('/');
    }
}
