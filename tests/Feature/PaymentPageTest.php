<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\Lapangan;

class PaymentPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_payment_index_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get('/user/payment');

        $response->assertStatus(200);
        $response->assertSee('Riwayat Pembayaran');
    }
}
