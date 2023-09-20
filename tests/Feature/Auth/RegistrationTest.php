<?php

namespace Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_be_registered()
    {
        $user = [
            'name' => 'Example',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->post(route('v1.register', $user))
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email'],
            'email_verified_at' => null,
        ]);
    }
}
