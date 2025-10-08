<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CartController
{
    public function addToCard(Book $book)
    {
        return response()->json([
            'success' => true
        ]);
    }
}
