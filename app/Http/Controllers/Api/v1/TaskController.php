<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        Task::create(array_merge(['user_id' => auth()->user()->getAuthIdentifier()], $request->validated()));

        return response()->json('', 201);
    }

    /**
     * Mark a Task as finished.
     */
    public function finish(Task $task): JsonResponse
    {
        if ($task->isFinished()) {
            abort(422, 'This task is already finished.');
        }

        $task->finish();

        $cacheKey = Task::getCacheKey(auth()->user()->getAuthIdentifier(), Task::STATUS_FINISHED);

        Cache::tags([Task::STATUS_FINISHED_CACHE_TAG])->forget($cacheKey);

        return response()->json('', 204);
    }

    /**
     * Mark a Task as failed.
     */
    public function fail(Task $task): JsonResponse
    {
        if ($task->isFailed()) {
            abort(422, 'This task is already failed.');
        }

        $task->fail();

        return response()->json('', 204);
    }

    /**
     * Return user finished tasks
     */
    public function finished(User $user): JsonResponse
    {
        $cacheKey = Task::getCacheKey($user->getAuthIdentifier(), Task::STATUS_FINISHED);

        $tasks = Cache::tags([Task::STATUS_FINISHED_CACHE_TAG])->remember($cacheKey, now()->addMinutes(30), function () use ($user) {
            return $user->tasks
                ->where('status', 'finished')
                ->groupBy(function ($task) {
                    return $task->merchant->name;
                })
                ->map(function ($tasks) {
                    return $tasks->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'card_id' => $task->card_id,
                            'created_at' => $task->created_at->toDateTimeString(),
                        ];
                    });
                });
        });

        return response()->json($tasks);
    }
}
