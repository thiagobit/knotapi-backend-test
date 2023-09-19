<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

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
}
