<?php

namespace App\Helpers\ApiHelper;

use Illuminate\Http\Response;

class ApiHelper
{
    /**
     * make api response instace of response()->json().
     */
    public static function makeResponse(bool $success = true, string $message = '', array $data = [], int $status_code = Response::HTTP_OK)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $status_code);
    }
}
