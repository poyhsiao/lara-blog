<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

abstract class Controller
{
    /**
     * Check if the given instance is a JsonResponse.
     *
     * @param mixed $instance The instance to evaluate.
     * @return bool Returns true if the instance is a JsonResponse, otherwise false.
     */
    protected function isJsonResponse(mixed $instance): bool
    {
        return $instance instanceof JsonResponse;
    }

    /**
     * Return a JsonResponse based on the repository response
     *
     * If the repository response is a JsonResponse, it is returned as is.
     * Otherwise, a success response is created using JsonResponseHelper::success.
     * If a callable is provided, it is called with the repository response as an argument
     * to transform the response into the desired format.
     *
     * @param mixed $repoResponse The response from the repository
     * @param string $message The message to include in the success response
     * @param callable|null $transformer An optional callable to transform the repository response
     * @return JsonResponse The response to return
     */
    protected function repoResponse(mixed $repoResponse, string $message = 'success', callable|null $transformer = null): JsonResponse
    {
        if ($this->isJsonResponse($repoResponse)) {
            return $repoResponse;
        }

        $data = $transformer ? $transformer($repoResponse) : $repoResponse;

        return JsonResponseHelper::success($data, $message);
    }

    /**
     * Return a RedirectResponse based on the repository response
     *
     * If the repository response is a JsonResponse, it is returned as is.
     * Otherwise, a redirect response is created using JsonResponseHelper::redirectTo.
     * The redirect URL is determined by the given redirectType, which is used to
     * look up the URL in the config.misc.redirect array.
     *
     * @param mixed $repoResponse The response from the repository
     * @param string $redirectType The type of redirect to perform
     * @return RedirectResponse The response to return
     */
    protected function repoRedirect(mixed $repoResponse, string $redirectType = 'email_verified'): RedirectResponse
    {
        if ($this->isJsonResponse($repoResponse)) {
            return $repoResponse;
        }

        return JsonResponseHelper::redirectTo(config('misc.redirect')[$redirectType]);
    }
}
