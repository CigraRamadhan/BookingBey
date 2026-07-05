<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_is_redirected_from_login_page_to_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('login'));

        $response->assertRedirect(route('user.dashboard'));
    }

    public function test_authenticated_user_is_redirected_from_register_page_to_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('register'));

        $response->assertRedirect(route('user.dashboard'));
    }
}
