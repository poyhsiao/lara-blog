<?php

namespace App\Http\Controllers;

use App\Repositories\EmotionRepository;
use App\Validators\EmotionValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmotionController extends Controller
{
    protected $validator;

    protected $repo;

    protected $user;

    public function __construct(EmotionRepository $repo, EmotionValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
        $this->user = Auth::user();
    }

    /**
     * Get all emotions
     *
     * Get all emotions from the database.
     * The result is a JSON response containing all emotions or an error response
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing all emotions or an error response
     */
    public function index(): JsonResponse
    {
        $result = $this->repo->index();

        return $this->repoResponse($result, 'Get emotions successfully');
    }

    /**
     * Store a newly created emotion in storage.
     *
     * Validates the provided data using the EmotionValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to store the emotion using the EmotionRepository. If storing fails, returns an error response.
     * Otherwise, returns a success response with the created emotion.
     *
     * @param \Illuminate\Http\Request $request The request object containing emotion data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function store(Request $request)
    {
        $validated = $this->validator->store($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->store($validated, $this->user);

        return $this->repoResponse($result, 'Create emotion successfully');
    }

    /**
     * Retrieve an emotion by its ID.
     *
     * Validates the provided ID using the EmotionValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to retrieve the emotion using the EmotionRepository. If the emotion is not found, returns an error response.
     * Otherwise, returns a success response with the retrieved emotion.
     *
     * @param int $emotionId The ID of the emotion to retrieve.
     * @return JsonResponse A JSON response containing the retrieved emotion or an error response.
     */
    public function getById(int $emotionId)
    {
        $validated = $this->validator->getById($emotionId);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->getById($validated, $this->user);

        return $this->repoResponse($result, 'Get emotion successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $emotionId): JsonResponse
    {
        $validated = $this->validator->update($request, $emotionId);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->update($validated, $emotionId, $this->user);

        return $this->repoResponse($result, 'Update emotion successfully');
    }

    /**
     * Delete an emotion.
     *
     * Validates the provided ID using the EmotionValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to delete the emotion using the EmotionRepository. If deletion fails, returns an error response.
     * Otherwise, returns a success response with the deleted emotion.
     *
     * @param int $emotionId The ID of the emotion to delete.
     * @return JsonResponse A JSON response containing the result of the operation.
     */
    public function delete(int $emotionId): JsonResponse
    {
        $validated = $this->validator->delete($emotionId);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->delete($validated['id'], $this->user);

        return $this->repoResponse($result, 'Delete emotion successfully');
    }

    /**
     * Restore a soft-deleted emotion.
     *
     * Validates the provided ID using the EmotionValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to restore the emotion using the EmotionRepository. If restoration fails, returns an error response.
     * Otherwise, returns a success response with the restored emotion.
     *
     * @param int $emotionId The ID of the emotion to restore.
     * @return JsonResponse A JSON response containing the restored emotion or an error response.
     */
    public function restore(int $emotionId): JsonResponse
    {
        $validated = $this->validator->restore($emotionId);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->restore($validated['id'], $this->user);

        return $this->repoResponse($result, 'Restore emotion successfully');
    }

    /**
     * Force delete an emotion.
     *
     * Validates the provided ID using the EmotionValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to force delete the emotion using the EmotionRepository. If force deletion fails, returns an error response.
     * Otherwise, returns a success response with the result of the force deletion.
     *
     * @param int $emotionId The ID of the emotion to force delete.
     * @return JsonResponse A JSON response containing the result of the operation.
     */
    public function forceDelete(int $emotionId): JsonResponse
    {
        $validated = $this->validator->forceDelete($emotionId);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->forceDelete($validated['id'], $this->user);

        return $this->repoResponse($result, 'Force delete emotion successfully');
    }

    /**
     * Toggle an emotion on a source.
     *
     * Validates the provided data using the EmotionValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to toggle the emotion using the EmotionRepository. If toggling fails, returns an error response.
     * Otherwise, returns a success response with the toggled emotion.
     *
     * @param Request $request The request containing the source type and ID.
     * @param int $emotionId The ID of the emotion to toggle.
     * @return JsonResponse A JSON response containing the toggled emotion or an error response.
     */
    public function toggleEmotion(Request $request, int $emotionId): JsonResponse
    {
        $validated = $this->validator->toggleEmotion($request, $emotionId, $this->user);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->toggleEmotion($validated, $emotionId, $this->user);

        return $this->repoResponse($result, 'Toggle emotion successfully');
    }
}
