<?php

namespace Tests\Unit;

use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /** @test */
    public function getCacheKey_returns_correct_cache_key()
    {
        $userId = 1;

        $cacheKeyFinished = Task::getCacheKey($userId, Task::STATUS_FINISHED);
        $this->assertEquals("user_{$userId}_finished_tasks", $cacheKeyFinished);

        $cacheKeyFailed = Task::getCacheKey($userId, Task::STATUS_FAILED);
        $this->assertEquals("user_{$userId}_failed_tasks", $cacheKeyFailed);
    }
}
