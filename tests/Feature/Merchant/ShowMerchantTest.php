<?php

namespace Tests\Feature\Merchant;

use App\Models\Merchant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class ShowMerchantTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function merchants_can_be_shown()
    {
        $merchant =  Merchant::factory()->create();

        $this->get(route('v1.merchants.show', $merchant->id))
            ->assertSuccessful()
            ->assertSee($merchant->name)
            ->assertSee(str_replace('/', '\/', $merchant->website));
    }

    /** @test */
    public function merchants_can_not_be_shown_for_guests()
    {
        Auth::logout();

        $merchant = Merchant::factory()->create();

        $this->get(route('v1.merchants.show', $merchant->id))
            ->assertUnauthorized();
    }

    /** @test */
    public function not_found_merchant_returns_404()
    {
        $this->get(route('v1.merchants.show', 1))
            ->assertNotFound();
    }
}
