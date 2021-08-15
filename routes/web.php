<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/books', function () {
    return view('books');
})->name('books');

Route::get('/authors', function () {
    return view('authors');
})->name('authors');

Route::get('/allauthors','App\Http\Controllers\AddauthorController@allauthors')->name('allauthors');

Route::post('/addauthor/save', 'App\Http\Controllers\AddauthorController@save')->name('author-save');
