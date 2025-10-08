<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CartController
{
    public function addToCard(Book $book)
    {
        if (!request()->has('count')) {
            return response()->json([
                'success' => false
            ], 403);
        }
        return response()->json([
            'success' => true
        ]);
    }
}
