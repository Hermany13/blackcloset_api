<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;

final class Responses
{
    /**
     * Default template for successful response
     *
     * @param string $status Generic status message
     * @param string $message Descriptive message
     * @param mixed $data Response data if needed
     * @param int $code Http status code
     * @return JsonResponse
     */
    public static function Success(
        string $message = null,
        $data = null,
        string $status = 'success',
        int $code = 200
    ): JsonResponse {
        $defaultResponse = ['status' => $status];
        if ($message) $defaultResponse['message'] = $message;
        if ($data) $defaultResponse['data'] = $data;
        return response()->json($defaultResponse, $code);
    }

    /**
     * Default template for not successful response
     *
     * @param string $status Generic status message
     * @param int $code Http status code
     * @param string $message Descriptive message for users
     * @param string $devMessage Descriptive message for developers
     * @param \Throwable $exception Complete exception object
     * @return JsonResponse
     */
    public static function Error(
        \Throwable $exception,
        string $message = 'Unknown error, try again later.',
        string $devMessage = null,
        string $status = 'error',
        int $code = 500
    ): JsonResponse {
        $defaultResponse = [
            'status' => $status,
            'code' => $code,
            'userMessage' => $message,
            'exMessage' => $exception->getMessage(),
            'ex' => $exception->getTrace(),
        ];
        if ($devMessage) $defaultResponse['devMessage'] = $devMessage;
        return response()->json($defaultResponse, $code);
    }
}
