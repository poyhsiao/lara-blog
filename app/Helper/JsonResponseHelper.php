<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class JsonResponseHelper
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(mixed $data, string $message = 'success'): JsonResponse
    {
        if ($data instanceof JsonResponse) {
            return $data;
        }

        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => [
                'message' => $message,
                'data' => $data
            ],
            'error' => null,
        ], Response::HTTP_OK);
    }

    /**
     * Error response
     *
     * @param mixed $data
     * @param string $message
     * @param int $errorCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(mixed $data, string $message = 'error', int $errorCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        if ($data instanceof JsonResponse) {
            return $data;
        }

        return response()->json([
            'status_code' => $errorCode,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Unauthorized response
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unauthorized(string $message = 'Unauthorized', mixed $data = null): JsonResponse
    {
        if ($data instanceof JsonResponse) {
            return $data;
        }

        return response()->json([
            'status_code' => Response::HTTP_UNAUTHORIZED,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Forbidden response
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function forbidden(string $message = 'Forbidden', mixed $data = null): JsonResponse
    {
        if ($data instanceof JsonResponse) {
            return $data;
        }

        return response()->json([
            'status_code' => Response::HTTP_FORBIDDEN,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_FORBIDDEN);
    }

    /**
     * Not Found response
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function notFound(string $message = 'Not Found', mixed $data = null): JsonResponse
    {
        if ($data instanceof JsonResponse) {
            return $data;
        }

        return response()->json([
            'status_code' => Response::HTTP_NOT_FOUND,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Not Acceptable response
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function notAcceptable(string $message = 'Unacceptable', mixed $data = null): JsonResponse
    {
        if ($data instanceof JsonResponse) {
            return $data;
        }

        return response()->json([
            'status_code' => Response::HTTP_NOT_ACCEPTABLE,
            'data' => null,
            'error' => [
                'message' => $message,
                'data' => $data,
            ],
        ], Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * Redirect to a specified URL with an optional status code.
     *
     * @param string $url The target URL for redirection.
     * @param int $statusCode The HTTP status code to use for the redirect.
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function redirectTo(string $url, int $statusCode = 302): RedirectResponse
    {
        return Redirect::to($url, $statusCode);
    }
}
