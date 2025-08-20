<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    //use DatabaseTransactions;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        //$user = User::factory()->create();
        // $token = auth()->login($user);
        // $response = $this
        //     ->withHeader('Authorization', 'Bearer ' . $token)
        //     ->get('/api/user');

        // $response->assertStatus(200);
    }
}
