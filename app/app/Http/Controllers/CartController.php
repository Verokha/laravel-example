<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;

class CartController
{
    public function addToCard(Book $book)
    {
        if (!request()->has('count')) {
            return response()->json([
                'success' => false
            ], 403);
        }
        $card = new Cart();
        $card->user_id = request()->user()->id;
        $card->book_id = $book->id;
        $card->count = request()->get('count');
        $card->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function cart()
    {
        $responseData = Cart::where('user_id', request()->user()->id)
            ->get();

        return response()->json($responseData);
    }
}
