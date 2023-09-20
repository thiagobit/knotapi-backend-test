<?php

namespace Merchant;

use App\Models\Merchant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class StoreMerchantTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function merchant_can_be_stored()
    {
        $merchant = Merchant::factory()->make()->toArray();

        $this->post(route('v1.merchants.store', $merchant))
            ->assertSuccessful();
        $this->assertDatabaseHas('merchants', $merchant);
    }

    /** @test */
    public function merchant_can_not_be_stored_by_guests()
    {
        Auth::logout();

        $merchant = Merchant::factory()->make()->toArray();

        $this->post(route('v1.merchants.store', $merchant))
            ->assertUnauthorized();
    }

    /** @test */
    public function merchant_can_not_be_stored_with_invalid_name()
    {
        $card = Merchant::factory()->make()->toArray();

        $card['name'] = '';

        $this->post(route('v1.merchants.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.',
            ]);

        $card['name'] = ['a'];

        $this->post(route('v1.merchants.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field must be a string.',
            ]);

        $card['name'] = str_repeat('1', 256);

        $this->post(route('v1.merchants.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field must not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function merchant_can_not_be_stored_with_invalid_website()
    {
        $card = Merchant::factory()->make()->toArray();

        $card['website'] = '';

        $this->post(route('v1.merchants.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'website' => 'The website field is required.',
            ]);

        $card['website'] = ['a'];

        $this->post(route('v1.merchants.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'website' => 'The website field must be a string.',
            ]);

        $card['website'] = str_repeat('1', 256);

        $this->post(route('v1.merchants.store', $card))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'website' => 'The website field must not be greater than 255 characters.',
            ]);
    }
}
