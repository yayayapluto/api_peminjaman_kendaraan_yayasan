<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function sendSuccess(string $msg = "Success", $data = null, $code = 200)
    {
        return response()->json([
            "success" => true,
            "msg" => $msg,
            "data" => $data
        ], $code);
    }

    public static function sendErrors(string $msg = "Errors", $errors = null, $code = 500)
    {
        return response()->json([
            "success" => false,
            "msg" => $msg,
            "errors" => $errors
        ], $code);
    }
}
