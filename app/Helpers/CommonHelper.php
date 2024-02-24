<?php

namespace App\Helpers\CommonHelper;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommonHelper
{
    /**
     * Getting current controller.
     *
     * @return string
     */
    public static function getCurrentController(Request $request)
    {
        try {
            $action = $request->route()->getAction();

            return $action['controller'];
        } catch (Exception $e) {
            Log::error(__FUNCTION__.' error when getting current controller');

            return '';
        }
    }
}
