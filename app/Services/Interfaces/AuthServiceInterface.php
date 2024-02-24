<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(array $data): User;

    public function login(array $data): ?User;

    public function logout(Request $request): mixed;
}
