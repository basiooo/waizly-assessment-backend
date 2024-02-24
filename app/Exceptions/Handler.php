<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {

        $this->renderable(function (AuthenticationException $e, $request) {
            // handle unauth user
            if ($request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'unAuthenticated'], 401);
            }
        });

        $this->renderable(function (ModelNotFoundException|NotFoundHttpException $e, $request) {
            // handle request when not found
            if ($request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Not found'], 404);
            }
        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            // handle response when internal server error
            if ($request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Method not allowed'], 405);
            }
        });
        $this->renderable(function (\Error|\Exception $e, $request) {
            Log::error('Internal server error: '.$e->getMessage());
            // handle response when internal server error
            if ($request->is('api/*')) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        });
    }
}
