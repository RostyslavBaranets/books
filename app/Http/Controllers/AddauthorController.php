<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\author;
use DataTables;

class AddauthorController extends Controller
{
    public function save(Request $req){
      $validator = \Validator::make($req->all(),[
        'name'=>'required',
        'surname'=>'required|min:3',
      ]);

      if(!$validator->passes()){
       return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
      }else{
        $author = new author;
        $author->name = $req->input('name');
        $author->surname = $req->input('surname');
        $author->patronymic = $req->input('patronymic');
        $query = $author->save();
        if(!$query){
          return response()->json(['code'=>0,'msg'=>'Something went wrong']);
        }else{
          return response()->json(['code'=>1,'msg'=>'New author has been successfully saved']);
        }
      }
    }

    public function allauthors(Request $req){
      $author = author::all();
      return response()->json(['authors'=>$author]);

    }

}
