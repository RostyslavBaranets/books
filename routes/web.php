<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddauthorController;

Route::get('/', function () {
  return view('home');
})->name('home');

Route::get('/books', function () {
  return view('books');
})->name('books');

Route::get('/authors',[AddauthorController::class, 'index'])->name('authors');

Route::get('fetch-authors', [AddauthorController::class, 'fetchauthors']);
Route::post('store-authors', [AddauthorController::class, 'store']);
Route::get('edit-author/{id}', [AddauthorController::class, 'edit']);
Route::put('update-author/{id}', [AddauthorController::class, 'update']);
Route::delete('delete-author/{id}', [AddauthorController::class, 'destroy']);
