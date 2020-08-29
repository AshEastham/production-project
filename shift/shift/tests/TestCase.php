<?php

namespace Tests;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    // Allows for authorization token to be gained, to test the authenticated user.
    public function jsonAs(JWTSubject $user, $method, $endpoint, $data = [], $headers = [])
    {
        // Retrieve token by user id
        $token = auth()->tokenById($user->id);
        
        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => 'Bearer ' . $token
        ]));
    }
}
