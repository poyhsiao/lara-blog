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
     * Validates the provided data using the EmotionValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, checks if the user is an admin. If the user is not an admin, returns an unauthorized response.
     * Otherwise, returns a success response with the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing emotion data to create.
     * @param \App\Models\User|Authenticatable $user The user performing the action.
     * @return array|JsonResponse A JSON response containing the result of the operation.
     */
    public function store(Request $request, User|Authenticatable $user): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|between:2,255|unique:emotions,name',
            'description' => 'string|between:2,255',
            'avatar' => 'string|between:2,255|url',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Create emotion failed', $validated->errors());
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validated->validated();
    }

    /**
     * Validate get emotion by ID request.
     *
     * Validates the provided ID and checks if the user is authorized to get the emotion.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated data.
     *
     * @param int $emotionId The ID of the emotion to retrieve.
     * @param \App\Models\User|Authenticatable $user The user attempting to get the emotion.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors or unauthorized response.
     */
    public function getById(int $emotionId, User|Authenticatable $user): array|JsonResponse
    {
        $validated = Validator::make(['id' => $emotionId], [
            'id' => 'required|integer|exists:emotions,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get emotion failed', $validated->errors());
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validated->validated();
    }

    /**
     * Validate update emotion request.
     *
     * Validates the provided emotion update data to ensure the name is a string, between 2 and 255 characters, and unique among emotions,
     * the description is a string, between 2 and 255 characters, the avatar is a string, between 2 and 255 characters, and a valid URL.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it checks if the user is authorized to update the emotion.
     * If the user is not an admin, it returns an unauthorized response.
     * Otherwise, it returns the validated data as an array.
     * @param Request $request The request object containing emotion data to update.
     * @param int $emotionId The ID of the emotion to update.
     * @param \App\Models\User|Authenticatable $user The user attempting the update.
     * @return array|JsonResponse The validated data as an array or a JsonResponse with validation errors or unauthorized response.
     */
    public function update(Request $request, int $emotionId, User|Authenticatable $user): array|JsonResponse
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

        if (!$user->isAdmin()) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validated->validated();
    }

    /**
     * Validate and authorize deletion of an emotion.
     *
     * This method checks if the provided emotion ID is valid and exists in the emotions table.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * It also checks if the user performing the action is an admin.
     * If not, it returns a not authorized response.
     * If validation and authorization succeed, it returns the validated ID as an array.
     *
     * @param int $emotionId The ID of the emotion to delete.
     * @param \App\Models\User|Authenticatable $user The user attempting to delete the emotion.
     * @return array|JsonResponse The validated ID as an array or a JsonResponse with validation errors or unauthorized response.
     */
    public function delete(int $emotionId, User|Authenticatable $user): array|JsonResponse
    {
        $validated = Validator::make(['id'=> $emotionId], [
            'id'=> [
                'required',
                'integer',
                new IdAvailable('emotions', 'id', 'Emotion not found'),
            ]
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Delete emotion failed', $validated->errors());
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validated->validated();
    }

    /**
     * Validate and authorize restoration of an emotion.
     *
     * This method checks if the provided emotion ID is valid and exists in the emotions table with the trashed status.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * It also checks if the user performing the action is an admin.
     * If not, it returns a not authorized response.
     * If validation and authorization succeed, it returns the validated ID as an array.
     *
     * @param int $emotionId The ID of the emotion to restore.
     * @param \App\Models\User|Authenticatable $user The user attempting to restore the emotion.
     * @return array|JsonResponse The validated ID as an array or a JsonResponse with validation errors or unauthorized response.
     */
    public function restore(int $emotionId, User|Authenticatable $user): array|JsonResponse
    {
        $validated = Validator::make(['id'=> $emotionId], [
            'id' => [
                'required',
                'integer',
                new IdTrashedRule('emotions', 'id', 'Emotion not found'),
            ],
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Restore emotion failed', $validated->errors());
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validated->validated();
    }

    /**
     * Validate and authorize force deletion of an emotion.
     *
     * This method checks if the provided emotion ID is valid and exists in the emotions table.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * It also checks if the user performing the action is an admin.
     * If not, it returns a not authorized response.
     * If validation and authorization succeed, it returns the validated ID as an array.
     *
     * @param int $emotionId The ID of the emotion to force delete.
     * @param \App\Models\User|Authenticatable $user The user attempting to force delete the emotion.
     * @return array|JsonResponse The validated ID as an array or a JsonResponse with validation errors or unauthorized response.
     */
    public function forceDelete(int $emotionId, User|Authenticatable $user): array|JsonResponse
    {
        $validated = $this->validateId($emotionId);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
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
        $validated = Validator::make(['id'=> $emotionId], [
            'id'=> 'required|integer|exists:emotions,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get emotion failed', $validated->errors());
        }

        return $validated->validated();
    }
}
