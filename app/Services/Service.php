<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Service
{
    public function success(string $message, mixed $data): JsonResponse
    {
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => [
                'message' => $message,
                'data' => $data
            ],
            'error' => null,
        ], Response::HTTP_OK);
    }

    public function error(string $message, mixed $data, int $errorCode = 400): JsonResponse
    {
        return response()->json([
            'status_code' => $errorCode,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data
            ],
        ], Response::HTTP_BAD_REQUEST);
    }

    public function unauthorized(string $message = 'Unauthorized', mixed $data = null): JsonResponse
    {
        return response()->json([
            'status_code' => Response::HTTP_UNAUTHORIZED,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function forbidden(string $message = 'Forbidden', mixed $data = null): JsonResponse
    {
        return response()->json([
            'status_code' => Response::HTTP_FORBIDDEN,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_FORBIDDEN);
    }

    public function notFound(string $message = 'Not Found', mixed $data = null): JsonResponse
    {
        return response()->json([
            'status_code' => Response::HTTP_NOT_FOUND,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_NOT_FOUND);
    }

    public function notAcceptable(string $message = 'Unacceptable', mixed $data = null): JsonResponse
    {
        return response()->json([
            'status_code' => Response::HTTP_NOT_ACCEPTABLE,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_NOT_ACCEPTABLE);
    }
}
