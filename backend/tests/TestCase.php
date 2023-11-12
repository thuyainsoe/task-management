<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function login($user = null)
    {
        if(!$user) {
            $user = User::factory()->create();
        }

        Auth::login($user);

        return $user;
    }

    public function getToken($email = 'mgmg@g.com', $password = 'password') {
        $response = $this->apiLogin($email, $password);
        return $response['token'];
    }

    public function apiLogin($email = 'mgmg@g.com', $password = 'password') {
        $param = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->post('/api/login', $param);

        return $response;
    }
}
