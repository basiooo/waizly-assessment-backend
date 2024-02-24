<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper\ApiHelper;
use App\Helpers\CommonHelper\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->all());
        Log::info(CommonHelper::getCurrentController($request).' new user registered :'.$user->email);

        return ApiHelper::makeResponse(
            true,
            'Success register user',
            status_code: Response::HTTP_CREATED
        );
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->validated('email'), $request->validated('password'));
        $current_controller = CommonHelper::getCurrentController($request);

        if ($user) {
            Log::info($current_controller.' user login success :'.$user->email);

            return ApiHelper::makeResponse(
                true,
                'Success login',
                ['token' => $user->createToken('auth_token')->plainTextToken],
                Response::HTTP_OK,
            );
        } else {
            Log::info($current_controller.' user login failed invalid credential :'.$request->validated('email'));

            return ApiHelper::makeResponse(
                false,
                'Invalid credential',
                status_code: Response::HTTP_BAD_REQUEST,
            );
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $this->authService->logout($user);
        Log::info(CommonHelper::getCurrentController($request).' user logout :'.$user->email);

        return ApiHelper::makeResponse(
            true,
            'Success logout',
            status_code: Response::HTTP_OK
        );
    }
}
