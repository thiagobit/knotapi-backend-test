<?php

namespace Task;

use App\Models\Card;
use App\Models\Merchant;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class ListTaskTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_finished_tasks_can_be_listed()
    {
        $tasks = Task::factory()->count(2)->create([
            'user_id' => $this->user->getAuthIdentifier(),
            'status' => Task::STATUS_FINISHED,
        ]);

        $this->get(route('v1.users.tasks.finished', $this->user))
            ->assertSuccessful()
            ->assertSee($tasks[0]->merchant->name)
            ->assertSee($tasks[0]->id)
            ->assertSee($tasks[0]->card_id)
            ->assertSee($tasks[0]->created_at)
            ->assertSee($tasks[1]->merchant->name)
            ->assertSee($tasks[1]->id)
            ->assertSee($tasks[1]->card_id)
            ->assertSee($tasks[1]->created_at);
    }

    /** @test */
    public function user_finished_tasks_can_not_be_listed_for_guests()
    {
        Auth::logout();

        Task::factory()->count(2)->create([
            'user_id' => $this->user->getAuthIdentifier(),
            'status' => Task::STATUS_FINISHED,
        ]);

        $this->get(route('v1.users.tasks.finished', $this->user))
            ->assertUnauthorized();
    }
}
