<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JsonResponseHelper
{
  public static function success(string $message = "success", mixed $data): JsonResponse
  {
    return response()->json([
      'status_code' => Response::HTTP_OK,
      'data' => [
        'message'=> $message,
        'data'=> $data
      ],
      'error' => null,
    ], Response::HTTP_OK);
  }

  public static function error(mixed $data, string $message = 'error', int $errorCode = Response::HTTP_BAD_REQUEST): JsonResponse
  {
    return response()->json([
      'status_code' => $errorCode,
      'data' => null,
      'error' => [
        'message'=> $message,
        'data' => $data,
      ],
    ], Response::HTTP_BAD_REQUEST);
  }

  public static function unauthorized(string $message = 'Unauthorized', mixed $data = null): JsonResponse
  {
    return response()->json([
      'status_code' => Response::HTTP_UNAUTHORIZED,
      'data' => null,
      'error' => [
        'message'=> $message,
        'data' => $data,
      ],
    ], Response::HTTP_UNAUTHORIZED);
  }

  public static function forbidden(string $message = 'Forbidden', mixed $data = null): JsonResponse
  {
    return response()->json([
      'status_code' => Response::HTTP_FORBIDDEN,
      'data' => null,
      'error' => [
        'message'=> $message,
        'data' => $data,
      ],
    ], Response::HTTP_FORBIDDEN);
  }

  public static function notFound(string $message = 'Not Found', mixed $data = null): JsonResponse
  {
    return response()->json([
      'status_code' => Response::HTTP_NOT_FOUND,
      'data' => null,
      'error' => [
        'message'=> $message,
        'data' => $data,
      ],
    ], Response::HTTP_NOT_FOUND);
  }

  public static function notAcceptable(string $message = 'Unacceptable', mixed $data = null): JsonResponse
  {
    return response()->json([
      'status_code' => Response::HTTP_NOT_ACCEPTABLE,
      'data' => null,
      'error' => [
        'message'=> $message,
        'data' => $data,
      ],
    ], Response::HTTP_NOT_ACCEPTABLE);
  }
}