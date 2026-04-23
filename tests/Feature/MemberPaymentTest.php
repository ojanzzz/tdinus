<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_open_own_invoice_when_user_id_type_differs(): void
    {
        $user = User::create([
            'name' => 'Member Test',
            'email' => 'member@example.com',
            'password' => 'password',
            'role' => 'member',
        ]);

        $pelatihan = Pelatihan::create([
            'title' => 'Pelatihan Test',
            'slug' => 'pelatihan-test',
            'description' => 'Pelatihan test',
            'price' => 100000,
            'status' => 'active',
        ]);

        $payment = Payment::create([
            'user_id' => (string) $user->id,
            'pelatihan_id' => $pelatihan->id,
            'amount' => 100000,
            'status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get(route('member.payments.show', $payment))
            ->assertOk()
            ->assertViewIs('member.payments.show');
    }
}
