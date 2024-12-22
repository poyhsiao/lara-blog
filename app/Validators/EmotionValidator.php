<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\Emotion;
use App\Models\User;
use App\Rules\IdAvailable;
use App\Rules\IdTrashedRule;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmotionValidator extends BaseValidator
{
    protected $model;

    public function __construct(Emotion $model)
    {
        $this->model = $model;
    }

    /**
     * Validate create emotion request.
     *
     * Validates the request data for creating an emotion. It ensures:
     * - 'name' is required, a string, between 2 and 255 characters, and unique among emotions.
     * - 'description' is a string and between 2 and 255 characters.
     * - 'avatar' is a string and a valid URL.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing emotion data to create.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function store(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|between:2,255|unique:emotions,name',
            'description' => 'string|between:2,255',
            'avatar' => 'string|between:2,255|url',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Create emotion failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate retrieval of an emotion by ID.
     *
     * Validates the provided emotion ID to ensure that it is an integer and exists in the emotions table.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated data.
     *
     * @param int $emotionId The ID of the emotion to retrieve.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function getById(int $emotionId): array|JsonResponse
    {
        $validated = Validator::make(['id' => $emotionId], [
            'id' => 'required|integer|exists:emotions,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get emotion failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate update emotion request.
     *
     * Validates the request data for updating an emotion. It ensures:
     * - 'name' is a string, between 2 and 255 characters, and unique among emotions (ignoring the emotion being updated).
     * - 'description' is a string and between 2 and 255 characters.
     * - 'avatar' is a string and a valid URL.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing emotion data to update.
     * @param int $emotionId The ID of the emotion to update.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function update(Request $request, int $emotionId): array|JsonResponse
    {
        $theId = $this->validateId($emotionId);

        if ($theId instanceof JsonResponse) {
            return $theId;
        }

        $validated = Validator::make($request->all(), [
            'name' => [
                'string',
                'between:2,255',
                Rule::unique('emotions', 'name')->ignore($theId['id']),
            ],
            'description' => 'string|between:2,255',
            'avatar' => 'string|between:2,255|url',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update emotion failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate delete emotion request.
     *
     * Validates the emotion ID to delete. It ensures the ID is a valid emotion ID.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated ID.
     *
     * @param int $emotionId The ID of the emotion to delete.
     * @return array|JsonResponse The validated ID or a JsonResponse with validation errors.
     */
    public function delete(int $emotionId): array|JsonResponse
    {
        $validated = Validator::make(['id' => $emotionId], [
            'id' => [
                'required',
                'integer',
                new IdAvailable('emotions', 'id', 'Emotion not found'),
            ]
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Delete emotion failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate restore emotion request.
     *
     * Validates the emotion ID to restore. It ensures the ID is a valid emotion ID that is soft deleted.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated ID.
     *
     * @param int $emotionId The ID of the emotion to restore.
     * @return array|JsonResponse The validated ID or a JsonResponse with validation errors.
     */
    public function restore(int $emotionId): array|JsonResponse
    {
        $validated = Validator::make(['id' => $emotionId], [
            'id' => [
                'required',
                'integer',
                new IdTrashedRule('emotions', 'id', 'Emotion not found'),
            ],
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Restore emotion failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate force delete emotion request.
     *
     * Validates the emotion ID to force delete. It ensures the ID is a valid emotion ID.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated ID.
     *
     * @param int $emotionId The ID of the emotion to force delete.
     * @return array|JsonResponse The validated ID or a JsonResponse with validation errors.
     */
    public function forceDelete(int $emotionId): array|JsonResponse
    {
        $validated = $this->validateId($emotionId);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        return $validated;
    }

    public function toggleEmotion(Request $request, int $emotionId, User|Authenticatable $user): array|JsonResponse
    {
        $theId = $this->validateId($emotionId);

        if ($theId instanceof JsonResponse) {
            return $theId;
        }

        try {
            $validated = Validator::make($request->all(), [
                'type' => [
                    'required',
                    'string',
                    Rule::in(config('emotion.available_types', ['posts', 'comments'])),
                ],
                'id' => [
                    'required',
                    'integer',
                    new IdAvailable($request->input('type'), 'id', "The id is not found in {$request->input('type')}"),
                ],
            ]);

            if ($validated->fails()) {
                return JsonResponseHelper::notAcceptable('Toggle emotion failed', $validated->errors());
            }

            return $validated->validated();
        } catch (\Exception $e) {
            Log::error('Toggle emotion failed', [
                'user_id' => $user->id,
                'id' => $emotionId,
                'data' => $request->all(),
                'message' => $e->getMessage(),
                'date' => now(),
            ]);
            return JsonResponseHelper::notAcceptable('Toggle emotion failed', $e->getMessage());
        }
    }

    /**
     * Validate the emotion ID.
     *
     * This method checks if the provided ID is a valid numeric value and exists in the emotions table.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it returns the validated ID as an integer.
     *
     * @param int $emotionId The ID of the emotion to validate.
     * @return int|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    public function validateId(int $emotionId): array|JsonResponse
    {
        $validated = Validator::make(['id' => $emotionId], [
            'id' => 'required|integer|exists:emotions,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get emotion failed', $validated->errors());
        }

        return $validated->validated();
    }
}
