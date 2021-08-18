<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\author;
use Illuminate\Support\Facades\Validator;

class AddauthorController extends Controller
{

  public function index()
  {
    $authors = author::all();
        return view('authors', compact('authors'));
  //  $authors = author::all();
  //  return view('authors');
  }

  public function fetchauthors()
  {
    $authors = author::all();
    return response()->json([
      'authors'=>$authors,
    ]);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'=> 'required',
      'surname'=>'required|min:3',
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
      $author = new author;
      $author->name = $request->input('name');
      $author->surname = $request->input('surname');
      $author->patronymic = $request->input('patronymic');
      $author->save();
      return response()->json([
        'status'=>200,
        'message'=>'Author Added Successfully.'
      ]);
    }
  }

  public function edit($id)
  {
    $author = author::find($id);
    if($author)
    {
      return response()->json([
        'status'=>200,
        'author'=> $author,
      ]);
    }
    else
    {
      return response()->json([
        'status'=>404,
        'message'=>'No Author Found.'
      ]);
    }

  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name'=> 'required',
      'surname'=>'required|min:3',
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
      $author = author::find($id);
      if($author)
      {
        $author->name = $request->input('name');
        $author->surname = $request->input('surname');
        $author->patronymic = $request->input('patronymic');
        $author->update();
        return response()->json([
          'status'=>200,
          'message'=>'Author Updated Successfully.'
        ]);
      }
      else
      {
        return response()->json([
          'status'=>404,
          'message'=>'No Author Found.'
        ]);
      }
    }
  }

  public function destroy($id)
  {
    $author = author::find($id);
    if($author)
    {
      $author->delete();
      return response()->json([
        'status'=>200,
        'message'=>'Author Deleted Successfully.'
      ]);
    }
    else
    {
      return response()->json([
        'status'=>404,
        'message'=>'No Author Found.'
      ]);
    }
  }

}
