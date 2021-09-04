<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => '{v1}'], function () {
Route::get('books', [BooksController::class, 'getAllBooks']);
Route::get('books/{id}', [BooksController::class, 'getBook']);
Route::post('books', [BooksController::class, 'createBook']);
Route::put('books/{id}', [BooksController::class, 'updateBook']);
Route::delete('books/{id}', [BooksController::class, 'deleteBook']);
});
