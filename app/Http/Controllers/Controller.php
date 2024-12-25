<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Determine if the provided instance is a JsonResponse.
     *
     * @param mixed $object The object to evaluate.
     * @return bool Returns true if the instance is a JsonResponse, otherwise false.
     */
    protected function isJsonResponse(mixed $object): bool
    {
        return $object instanceof JsonResponse;
    }

    /**
     * Return a JsonResponse based on the repository response
     *
     * If the repository response is a JsonResponse, it is returned as is.
     * Otherwise, a success response is created using JsonResponseHelper::success.
     * If a callable is provided, it is called with the repository response as an argument
     * to transform the response into the desired format.
     *
     * @param mixed $response The response from the repository
     * @param string $message The message to include in the success response
     * @param callable|null $transformer An optional callable to transform the repository response
     * @return JsonResponse The response to return
     */
    protected function repoResponse(mixed $response, string $message = 'success', callable|null $transformer = null): JsonResponse
    {
        if ($this->isJsonResponse($response)) {
            return $response;
        }

        return JsonResponseHelper::success(
            $transformer ? $transformer($response) : $response,
            $message
        );
    }

    protected function repoRedirect(mixed $response, string $message = 'success', string $redirectType = 'email_verified'): JsonResponse
    {
        if ($this->isJsonResponse($response)) {
            return $response;
        }

        return Response::redirectTo(config('misc.redirect')[$redirectType]);
    }
}
