<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->creditCardNumber,
            'expiry_date' => fake()->creditCardExpirationDate->format('m/y'),
            'cvv' => rand(100, 9999),
        ];
    }
}
