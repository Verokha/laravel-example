<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;

class DeliveryTest extends TestCase
{
    public function test_make_order(): void
    {
        $this
            ->post('api/register', ['name' => 'Иван', 'email' => 'ivan@mail.ru', 'password' => 'password']);
        $response = $this
            ->post('api/login', ['email' => 'ivan@mail.ru', 'password' => 'password']);
        $responseData = $response->json();
        $newBook = Book::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $responseData['token'])
            ->post('api/cart/' . $newBook->id, ['count' => 1]);
        $responseDataAddToCart = $response->json();
        $this->assertEquals(true, $responseDataAddToCart['success']);
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $responseData['token'])
            ->get('api/cart');
        $responseDataCart = $response->json();
        $this->assertEquals(1, $responseDataCart[0]['count']);
        $this->assertEquals($newBook->id, $responseDataCart[0]['book_id']);
    }
}
