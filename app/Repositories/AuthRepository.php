<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data): User
    {
        return User::create($data);
    }

    public function login(string $email, string $password): ?User
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        return auth()->attempt($credentials) ? auth()->user() : null;

    }

    public function logout(User $user): mixed
    {
        return $user->currentAccessToken()->delete();
    }
}
