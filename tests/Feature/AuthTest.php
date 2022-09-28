<?php

namespace Tests\Feature;

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
}
