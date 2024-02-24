<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data): User
    {

        $data['password'] = Hash::make($data['password']);

        return $this->authRepository->register($data);
    }

    public function login(array $data): ?User
    {
        $email = $data['email'];
        $password = $data['password'];

        return $this->authRepository->login($email, $password);
    }

    public function logout($request): mixed
    {
        $user = $request->user();

        return $this->authRepository->logout($user);
    }
}
