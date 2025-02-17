<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookController;

Route::group([
    'prefix' => 'v1',
], function () {
    Route::get('/books', [BookController::class, 'getBooks'])->name('books');
    Route::group([
        'prefix' => 'authors',
    ], function () {
        Route::get('/', [BookController::class, 'getAuthors'])->name('authors');
        Route::get('/{author}/books', [BookController::class, 'getAuthorBooks'])->name('author-books');
    });
});
