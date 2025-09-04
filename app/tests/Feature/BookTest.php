<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

class BookTest extends TestCase
{
    protected User $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = auth()->login($this->user);
    }
    /**
     * A basic feature test example.
     */
    public function test_book_index(): void
    {
        $countElements = 5;
        Book::factory()
            ->count($countElements)
            ->create([
                'user_id' => $this->user->id
            ]);
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/books');

        $response->assertStatus(200);
        $response->assertJsonCount($countElements);
        $responseData = $response->json();
        $this->assertIsArray($responseData);
        $response->assertJsonStructure([
            '*' => ['id', 'title', 'description', 'user_id', 'created_at', 'updated_at']
        ]);
    }

    public function test_create_book_success(): void
    {
        $requestData = ['title' => 'Руслан и Людмила', 'description' => 'Сказка'];
        $response = $this
            ->withHeader('Authorization', 'Bearer' . $this->token)
            ->post('/api/books/create', $requestData);
        $response->assertStatus(201);
        $responseData = $response->json();
        $this->assertEquals(true, $responseData['success']);
    }

    public function test_create_book_failed(): void
    {
        $requestData = ['description' => 'рассказ'];
        $response = $this
            ->withHeader('Authorization', 'Bearer' . $this->token)
            ->post('/api/books/create', $requestData);
        $response->assertStatus(422);
    }

    public function test_book_show_success(): void
    {
        $book = Book::factory()
            ->create([
                'user_id' => $this->user->id
            ]);

        $response = $this
            ->withHeader('Authorization', 'Bearer' . $this->token)
            ->get('/api/books/' . $book->id);
        $response->assertStatus(200);
        $responseBook = $response->json();
        $this->assertEquals($book->id, $responseBook['id']);
    }

   public function test_book_show_forbidden(): void
{
    $otherUser = User::factory()->create();
    $book = Book::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this
        ->withHeader('Authorization', 'Bearer ' . $this->token)
        ->get('/api/books/' . $book->id);

    $response->assertStatus(403);
}

   public function test_book_show_not_found(): void
{
    $nonExistingId = 999999;

    $response = $this
        ->withHeader('Authorization', 'Bearer ' . $this->token)
        ->get('/api/books/' . $nonExistingId);

    $response->assertStatus(404);
}
}
