<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\author;
use App\Models\book;

class BookController extends Controller
{
  public function index()
  {
    $books = book::simplePaginate(5);
        return view('books', compact('books'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'=> 'required',
      'author_id'=>'required',
      'image'=>'required',
    ]);

    if($validator->fails())
    {
      return response()->json([
        'status'=>400,
        'errors'=>$validator->messages()
      ]);
    }
    else
    {
      $book = new book;
      $book->name = $request->input('name');
      $book->description = $request->input('description');
      $book->image = $request->input('image');
      $book->authors_id = $request->input('authors_id');
      $book->date = $request->input('date');
      $book->save();
      return response()->json([
        'status'=>200,
        'message'=>'book Added Successfully.'
      ]);
    }
  }
}
