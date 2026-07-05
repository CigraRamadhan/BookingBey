<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_account_sections(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('user.profile'));

        $response->assertOk();
        $response->assertSee('Foto Profil');
        $response->assertSee('Logout');
        $response->assertSee('Notifikasi');
    }
}
