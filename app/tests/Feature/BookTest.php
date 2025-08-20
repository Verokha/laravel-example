<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookTest extends TestCase
{
    //use DatabaseTransactions;
    use RefreshDatabase;


    protected User $user;
    protected ?string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаём пользователя через фабрику
        $this->user = User::factory()->create();

        // Генерируем токен через JWT
        $this->token = auth()->login($this->user);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Book::factory()
            ->count(5)
            ->create([
                'user_id' => $this->user->id
            ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/books');



        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $responseData = $response->json();
        $this->assertIsArray($responseData);
        $response->assertJsonStructure([
            '*' => ['id', 'title', 'description', 'user_id', 'created_at', 'updated_at']
        ]);
    }
}
