<?php

namespace App\Http\Controllers\Api;

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
        Log::info(CommonHelper::getCurrentController().' new user registered :'.$user->email);

        return CommonHelper::makeResponse(
            true,
            'Success register user',
            status_code: Response::HTTP_CREATED
        );
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->all());
        $current_controller = CommonHelper::getCurrentController();

        if ($user) {
            Log::info($current_controller.' user login success :'.$user->email);

            return CommonHelper::makeResponse(
                true,
                'Success login',
                ['token' => $user->createToken('auth_token')->plainTextToken],
                Response::HTTP_OK,
            );
        } else {
            Log::info($current_controller.' user login failed invalid credential :'.$request->validated('email'));

            return CommonHelper::makeResponse(
                false,
                'Invalid credential',
                status_code: Response::HTTP_BAD_REQUEST,
            );
        }
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $this->authService->logout($request);
        Log::info(CommonHelper::getCurrentController().' user logout :'.$user->email);

        return CommonHelper::makeResponse(
            true,
            'Success logout',
            status_code: Response::HTTP_OK
        );
    }
}
