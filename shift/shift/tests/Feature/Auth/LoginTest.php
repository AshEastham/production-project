<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    public function test_it_requires_an_email()
    {
        // No data passed through, so validation errors will appear if test is successful.
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        // No data passed through, so validation errors will appear if test is successful.
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_it_returns_a_validation_error_if_credentials_are_invalid()
    {
        $user = factory(User::class)->create();

        // No data passed through, so validation errors will appear if test is successful.
        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'wrongPass'
        ])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_returns_a_token_if_credentials_are_valid()
    {
        $user = factory(User::class)->create([
            'password' => 'dogs'
        ]);

        // No data passed through, so validation errors will appear if test is successful.
        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'dogs'
        ])
            ->assertJsonStructure([
                'meta' => [
                    'token'
                ]
            ]);
    }

    public function test_it_returns_a_user_if_credentials_are_valid()
    {
        $user = factory(User::class)->create([
            'password' => 'dogs'
        ]);

        // No data passed through, so validation errors will appear if test is successful.
        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'dogs'
        ])
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}
