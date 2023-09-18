<?php

namespace Tests\Feature\Card;

use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class StoreCardTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function cards_can_be_stored()
    {
        $card = Card::factory()->make()->toArray();

        $this->post(route('v1.cards.store', $card))
            ->assertSuccessful();
        $this->assertDatabaseHas('cards', $card);
    }

    /** @test */
    public function cards_can_not_be_stored_by_guests()
    {
        Auth::logout();

        $card = Card::factory()->make()->toArray();

        $this->post(route('v1.cards.store', $card))
            ->assertUnauthorized();
    }

    /** @test */
    public function cards_can_not_be_stored_with_invalid_number()
    {
        $card = Card::factory()->make()->toArray();

        $card['number'] = '';

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'number' => 'The number field is required.',
            ]);

        $card['number'] = 'a';

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'number' => 'The number field must be an integer.',
            ]);

        $card['number'] = str_repeat('1', 12);

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'number' => 'The number field must be between 13 and 19 digits.',
            ]);
    }

    /** @test */
    public function cards_can_not_be_stored_with_invalid_expiry_date()
    {
        $card = Card::factory()->make()->toArray();

        $card['expiry_date'] = '';

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'expiry_date' => 'The expiry date field is required.',
            ]);

        $card['expiry_date'] = '10/2023';

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'expiry_date' => 'The expiry date field format is invalid.',
            ]);
    }

    /** @test */
    public function cards_can_not_be_stored_with_invalid_cvv()
    {
        $card = Card::factory()->make()->toArray();

        $card['cvv'] = '';

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'cvv' => 'The cvv field is required.',
            ]);

        $card['cvv'] = 'a';

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'cvv' => 'The cvv field must be an integer.',
            ]);

        $card['cvv'] = '12';

        $this->post(route('v1.cards.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'cvv' => 'The cvv field must be between 3 and 4 digits.',
            ]);
    }
}
