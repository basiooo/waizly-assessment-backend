<?php

namespace App\Helpers\CommonHelper;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CommonHelper
{
    /**
     * Getting current controller.
     *
     * @return string
     */
    public static function getCurrentController()
    {
        try {
            $action = request()->route()->getAction();

            return $action['controller'];
        } catch (Exception $e) {
            Log::error(__FUNCTION__.' error when getting current controller');

            return '';
        }
    }

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
