<?php

namespace Tests\Feature\Task;

use App\Models\Card;
use App\Models\Merchant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class StoreTaskTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function tasks_can_be_stored()
    {
        $card = Card::factory()->create();
        $merchant = Merchant::factory()->create();

        $this->post(route('v1.tasks.store', ['card_id' => $card->id, 'merchant_id' => $merchant->id]))
            ->assertSuccessful();

        $this->assertDatabaseHas('tasks', [
            'user_id' => $this->user->getAuthIdentifier(),
            'card_id' => $card->id,
            'merchant_id' => $merchant->id,
        ]);
    }

    /** @test */
    public function tasks_can_not_be_stored_stored_by_guests()
    {
        Auth::logout();

        $card = Card::factory()->create();
        $merchant = Merchant::factory()->create();

        $this->post(route('v1.tasks.store', ['card_id' => $card->id, 'merchant_id' => $merchant->id]))
            ->assertUnauthorized();
    }

    /** @test */
    public function tasks_cannot_be_stored_with_invalid_card_id()
    {
        $merchant = Merchant::factory()->create();

        $cardId = 999;

        $this->post(route('v1.tasks.store', ['card_id' => $cardId, 'merchant_id' => $merchant->id]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'card_id' => 'The selected card id is invalid.',
            ]);
    }

    /** @test */
    public function tasks_cannot_be_stored_with_invalid_merchant_id()
    {
        $card = Card::factory()->create();

        $merchantId = 999;

        $this->post(route('v1.tasks.store', ['card_id' => $card->id, 'merchant_id' => $merchantId]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'merchant_id' => 'The selected merchant id is invalid.',
            ]);
    }
}
