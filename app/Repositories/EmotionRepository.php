<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\Comment;
use App\Models\Emotion;
use App\Models\Emotionable;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmotionRepository extends BaseRepository
{
    protected $model;

    public function __construct(Emotion $model)
    {
        $this->model = $model;
    }

    /**
     * Get all emotions
     *
     * This method retrieves all emotions from the database.
     * The result is a Collection of emotions or a JsonResponse in case of error.
     *
     * @return Collection|JsonResponse A Collection of emotions or a JsonResponse in case of error
     */
    public function index(): Collection|JsonResponse
    {
        try {
            return $this->model::get();
        } catch (\Exception $e) {
            Log::error('Fail to get emotions', ['message' => $e->getMessage()]);
            return JsonResponseHelper::error(null, 'Fail to get emotions');
        }
    }

    /**
     * Create a new emotion
     *
     * Attempts to create a new emotion in the database.
     * The result is an Emotion object or a JsonResponse in case of error.
     *
     * @param array $data The data to create the emotion with.
     * @param \App\Models\User|Authenticatable $user The user performing the action.
     * @return \App\Models\Emotion|JsonResponse An Emotion object or a JsonResponse in case of error.
     */
    public function store(array $data, User|Authenticatable $user): Emotion|JsonResponse
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->model::create($data);
            });
        } catch (\Exception $e) {
            Log::error('Fail to create emotion', [
                'user' => $user,
                'data' => $data,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Fail to create emotion');
        }
    }

    /**
     * Retrieve an emotion by its validated ID.
     *
     * This method attempts to find an emotion in the database using the provided validated ID.
     * If the emotion is found, it returns the emotion data as an array.
     * If an error occurs during retrieval, it logs the error and returns a JsonResponse with an error message.
     *
     * @param array $validated The validated data containing the emotion ID.
     * @param \App\Models\User|Authenticatable $user The user attempting to retrieve the emotion.
     * @return array|JsonResponse An array of emotion data on success, or a JsonResponse on error.
     */
    public function getById(array $validated, User|Authenticatable $user): array|JsonResponse
    {
        try {
            return $this->model::find($validated['id'])->toArray();
        } catch (\Exception $e) {
            Log::error('Fail to get emotion by ID', [
                'id' => $validated['id'],
                'user' => $user,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Fail to get emotion by ID');
        }
    }

    /**
     * Update an emotion.
     *
     * This method attempts to update an emotion in the database.
     * The result is an Emotion object or a JsonResponse in case of error.
     *
     * @param array $data The data to update the emotion with.
     * @param int $emotionId The ID of the emotion to update.
     * @param \App\Models\User|Authenticatable $user The user performing the action.
     * @return \App\Models\Emotion|JsonResponse An Emotion object or a JsonResponse in case of error.
     */
    public function update(array $data, int $emotionId, User|Authenticatable $user): Emotion|JsonResponse
    {
        try {
            return DB::transaction(function () use ($data, $emotionId) {
                return tap($this->model::find($emotionId))->update($data);
            });
        } catch (\Exception $e) {
            Log::error('Fail to update emotion', [
                'id' => $emotionId,
                'user' => $user,
                'data' => $data,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Fail to update emotion');
        }
    }

    /**
     * Delete an emotion.
     *
     * This method attempts to delete an emotion in the database.
     * The result is an Emotion object or a JsonResponse in case of error.
     *
     * @param int $emotionId The ID of the emotion to delete.
     * @param \App\Models\User|Authenticatable $user The user performing the action.
     * @return \App\Models\Emotion|JsonResponse An Emotion object or a JsonResponse in case of error.
     */
    public function delete(int $emotionId, User|Authenticatable $user): Emotion|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($emotionId, &$result) {
                $result = $this->model::find($emotionId);
                $result->delete();
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Fail to delete emotion', [
                'id' => $emotionId,
                'user' => $user,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Fail to delete emotion');
        }
    }

    /**
     * Restore a soft-deleted emotion.
     *
     * Attempts to restore a comment with the given ID from the database.
     * If the comment is successfully restored, it returns the restored comment.
     * If the comment is not found or an exception occurs, an error response is returned.
     *
     * @param int $emotionId The ID of the emotion to restore.
     * @return Emotion|JsonResponse The restored comment, or an error response if the comment is not found or if an error occurs.
     */
    public function restore(int $emotionId, User|Authenticatable $user): Emotion|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($emotionId, &$result) {
                $result = $this->model::onlyTrashed()->find($emotionId);
                $result->restore();
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Fail to restore emotion', [
                'id' => $emotionId,
                'user' => $user,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Fail to restore emotion');
        }
    }

    public function forceDelete(int $emotionId, User|Authenticatable $user): Emotion|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($emotionId, &$result) {
                $result = $this->model::withTrashed()->find($emotionId)
                ->makeVisible(['created_at', 'updated_at', 'deleted_at']);
                $result->forceDelete();
            });

            Log::info('Force delete emotion successfully', [
                'user_id' => $user->id,
                'emotion' => $result,
                'datetime' => now(),
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Fail to force delete emotion', [
                'id' => $emotionId,
                'user' => $user,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Fail to force delete emotion');
        }
    }

    /**
     * Toggle an emotion on a source.
     *
     * Checks whether the specified emotion exists for the given source type and ID.
     * If the emotion does not exist, creates a new emotion record.
     * If the emotion exists and the emotion ID is the same, deletes the emotion record.
     * If the emotion exists and the emotion ID is different, updates the emotion record.
     * Logs errors and returns a JsonResponse in case of failures.
     *
     * @param array $data An associative array containing 'type' and 'id' keys for the source.
     * @param int $emotionId The ID of the emotion to toggle.
     * @param \App\Models\User|Authenticatable $user The user performing the action.
     * @return \App\Models\Emotionable|JsonResponse The modified Emotionable object or a JsonResponse in case of error.
     */
    public function toggleEmotion(array $data, int $emotionId, User|Authenticatable $user): Emotionable|JsonResponse
    {
        $source_type = $data['type'];
        $source_id = $data['id'];

        if (!$theClass = $this->modelCheck($source_type, $source_id)) {
            Log::error('Fail to check emotion on checking model', [
                'source_id' => $source_id,
                'source_type' => $source_type,
                'user_id' => $user->id,
                'id' => $emotionId,
            ]);
            return JsonResponseHelper::error(null, 'Fail to check emotion');
        }

        try {
            $result = null;

            $existingEmotion = Emotionable::where('user_id', $user->id)
                ->where('emotionable_id', $source_id)
                ->where('emotionable_type', $theClass)
                ->first();

            /**
             * If the emotion does not exist, create a new one
             */
            if (!$existingEmotion) {
                DB::transaction(function () use ($emotionId, $source_id, $theClass, $user, &$result) {
                    $result = Emotionable::create([
                        'user_id' => $user->id,
                        'emotionable_id' => $source_id,
                        'emotionable_type' => $theClass,
                        'emotion_id' => $emotionId,
                    ]);
                });
                /**
                 * If the emotion exists, update the emotion_id
                 */
            } else {
                /**
                 * If the emotion exists and the emotion_id is the same, delete the emotion
                 */
                if ($existingEmotion->emotion_id == $emotionId) {
                    DB::transaction(function () use ($existingEmotion, &$result) {
                        $result = tap($existingEmotion)->delete();
                    });
                    /**
                     * If the emotion exists and the emotion_id is different, update the emotion
                     */
                } else {
                    DB::transaction(function () use ($emotionId, $existingEmotion, &$result) {
                        $existingEmotion->emotion_id = $emotionId;
                        $existingEmotion->save();
                        $result = $existingEmotion;
                    });
                }
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('Fail to check emotion', [
                'source_id' => $source_id,
                'source_type' => $source_type,
                'user_id' => $user->id,
                'id' => $emotionId,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Fail to check emotion');
        }
    }

    /**
     * Get the class name of a model based on the source type and source ID.
     * The supported source types are "posts", "comments", and "users".
     * If the source type is not supported, null is returned.
     *
     * @param string $source_type The source type.
     * @param int $source_id The ID of the source.
     * @return string|null The class name of the model, or null if the source type is not supported.
     */
    private function modelCheck(string $source_type, int $source_id): ?string
    {
        switch ($source_type) {
            case 'posts':
                $model = Post::findOrFail($source_id);
                break;
            case 'comments':
                $model = Comment::findOrFail($source_id);
                break;
            case 'users':
                $model = User::findOrFail($source_id);
                break;
            default:
                return null;
        }

        return get_class($model);
    }
}
