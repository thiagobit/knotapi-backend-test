<?php

namespace Merchant;

use App\Models\Merchant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class ListMerchantTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function merchants_can_be_listed()
    {
        $merchant =  Merchant::factory()->create();

        $this->get(route('v1.merchants.index'))
            ->assertSuccessful()
            ->assertSee($merchant->name);
    }

    /** @test */
    public function merchants_can_not_be_listed_for_guests()
    {
        Auth::logout();

        $this->get(route('v1.merchants.index'))
            ->assertUnauthorized();
    }
}
