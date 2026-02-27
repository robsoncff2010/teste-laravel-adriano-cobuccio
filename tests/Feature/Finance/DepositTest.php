<?php

namespace Tests\Finance\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class DepositTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_consegue_depositar()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('finance.deposit.store'), [
            'amount' => 500,
        ]);

        $response->assertRedirect(route('finance.deposit.create'));
        $response->assertSessionHas('success', __('messages.deposit_success'));

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'amount'  => 500,
            'type'    => 'deposit',
        ]);
    }
}
