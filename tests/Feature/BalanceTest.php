<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::create([
            'id' => 1,
            'name' => 'Bob',
            'email' => 'bob@mail.ru',
            'password' => '123',
        ]);
        User::create([
            'id' => 2,
            'name' => 'Piter',
            'email' => 'piter@mail.ru',
            'password' => '345',
        ]);
    }

    public function test_balance()
    {
        $response = $this->postJson('/api/deposit', [
              'user_id' => 2,
              'amount' => 230.75,
              'comment' => "Пополнение через карту"
        ]);
        $response->assertStatus(200);

        $response = $this->postJson('/api/withdraw', [
            'user_id' => 2,
            'amount' => 130.75,
            'comment' => "Покупка подписки"
        ]);
        $response->assertStatus(200);

        $response = $this->postJson('/api/withdraw', [
            'user_id' => 2,
            'amount' => 1130.75,
            'comment' => "Покупка подписки"
        ]);
        $response->assertStatus(409);

        $response = $this->postJson('/api/transfer', [
            'from_user_id' => 2,
            'to_user_id' => 1,
            'amount' => 50,
            'comment' => "Покупка подписки"
        ]);
        $response->assertStatus(200);

        $response = $this->get('/api/balance/1');

        $response->assertStatus(200);
    }

}
