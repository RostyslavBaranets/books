<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/books', function () {
    return view('books');
})->name('books');

Route::get('/authors','App\Http\Controllers\AddauthorController@allauthors')->name('authors');

Route::get('/addauthor', function () {
    return view('addauthor');
})->name('add-author');

Route::post('/addauthor/save', 'App\Http\Controllers\AddauthorController@save')->name('author-save');
