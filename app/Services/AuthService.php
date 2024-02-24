<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function login(string $email, string $password): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        auth()->attempt($credentials);

        return auth()->user();

    }

    public function logout($user)
    {
        return $user->currentAccessToken()->delete();
    }
}
