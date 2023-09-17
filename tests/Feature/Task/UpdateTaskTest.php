<?php

namespace Task;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tasks_can_be_finished()
    {
        $task = Task::factory()->create();

        $this->patch(route('v1.tasks.finish', $task))
            ->assertSuccessful();

        $task->refresh();

        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
    }

    /** @test */
    public function tasks_already_finished_can_not_be_finished_again()
    {
        $task = Task::factory()->create();
        $task->finish();

        $this->patch(route('v1.tasks.finish', $task))
            ->assertUnprocessable();
    }

    /** @test */
    public function tasks_can_be_failed()
    {
        $task = Task::factory()->create();

        $this->patch(route('v1.tasks.fail', $task))
            ->assertSuccessful();

        $task->refresh();

        $this->assertEquals(Task::STATUS_FAILED, $task->status);
    }

    /** @test */
    public function tasks_already_failed_can_not_be_failed_again()
    {
        $task = Task::factory()->create();
        $task->fail();

        $this->patch(route('v1.tasks.fail', $task))
            ->assertUnprocessable();
    }
}
