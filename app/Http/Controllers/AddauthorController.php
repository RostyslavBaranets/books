<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addauthorrequest;
use App\Models\author;

class AddauthorController extends Controller
{
    public function save(addauthorrequest $req){
      $author = new author;
      $author->name = $req->input('name');
      $author->surname = $req->input('surname');
      $author->patronymic = $req->input('patronymic');
      $author->save();
      return redirect()->route('authors');
    }

    public function allauthors(){
      return view('authors', ['data' => author::all()]);
    }

}
