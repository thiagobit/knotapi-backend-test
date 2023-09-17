<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        Task::create($request->validated());

        return response()->json('', 201);
    }
}
