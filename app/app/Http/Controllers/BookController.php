<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Models\Book;
use App\Models\User;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookController
{
    private User $user;
    public function __construct()
    {
        $this->user = JWTAuth::user();
    }

    public function index()
    {
        return response()->json(
            Book::where('user_id', $this->user->id)
                ->get()
        );
    }

    public function create(CreateBookRequest $request)
    {
        try {
            Book::create(
                array_merge($request->toArray(), ['user_id' => $this->user->id])
            );
            return response()->json([
                'success' => true,
            ], 201);
        } catch (Throwable $ex) {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
