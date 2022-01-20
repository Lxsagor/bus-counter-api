<?php

if (!function_exists('serverError')) {
    function serverError($exception)
    {
        return response([
            'status'     => 'server_error',
            'statusCode' => 500,
            'message'    => $exception->getMessage(),
        ], 500);
    }
}

if (!function_exists('validateError')) {
    function validateError($validate)
    {
        return response([
            'status'     => 'validate_error',
            'statusCode' => 422,
            'data'       => $validate,
        ], 422);
    }
}

if (!function_exists('itemNotFound')) {
    function itemNotFound($message = 'There is no item', $statusCode = 404)
    {
        return response([
            'status'     => 'error',
            'statusCode' => $statusCode,
            'message'    => $message,
        ], $statusCode);
    }
}
