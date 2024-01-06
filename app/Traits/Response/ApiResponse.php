<?php

namespace App\Traits\Response;

use Illuminate\Http\JsonResponse;

use function response;

trait ApiResponse
{
    /**
     * Return a successful response.
     *
     * @param array $data The response data.
     * @param array $message Optional response messages.
     * @param int $code The HTTP status code.
     *
     * @return JsonResponse The JSON response.
     */
    public function successResponse(array $data = [], array $message = [], $code = 200): JsonResponse
    {
        return response()->json([
            "status" => true,
            "status_code" => $code,
            "message" => $message,
            "body" => $data,
        ], $code);
    }

    /**
     * Return a error response.
     *
     * @param array $message Optional response messages.
     * @param int $code The HTTP status code.
     *
     * @return JsonResponse The JSON response.
     */
    public function errorResponse(array $message = [], int $code = 500): JsonResponse
    {
        return response()->json([
            "status" => false,
            "status_code" => $code,
            "message" => $message,
            "body" => null,

        ], $code);
    }
}
