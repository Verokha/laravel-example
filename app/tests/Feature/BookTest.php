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
        //@todo
        $requestData = [];
        $this->token;
        //1. Проверить фабрику
        //2. Собрать валидацию
        //3. Удостовериться в авторизации
        //4. Вызвать апи
    }

    public function test_create_book_success(): void
    {
        //@todo
        $requestData = [];
        $this->token;
        //1. Проверить фабрику
        //2. Собрать валидацию
        //3. Удостовериться в авторизации
        //4. Вызвать апи
    }
}
