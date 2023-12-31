<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Merchant;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'card_id' => Card::factory()->create(),
            'merchant_id' => Merchant::factory()->create(),
        ];
    }
}
