<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('books', [BookController::class, 'index']);
    Route::post('books/create', [BookController::class, 'create']);
    Route::get('books/{book}', [BookController::class, 'show']);
    Route::delete('books/{book}', [BookController::class, 'delete']);
});
