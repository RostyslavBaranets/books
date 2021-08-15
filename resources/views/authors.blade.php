@extends('layouts.app')

@section('title')
authors
@endsection

@section('content')
  <h1>All authors</h1>
  <a href="addauthor"><button type="button" class="btn btn-primary">add new author</button></a>
  @foreach($data as $el)
    <div class="alert alert-info">
      <h3> {{$el->surname}} {{$el->name}} {{$el->patronymic}} <button type="button" class="btn btn-danger">edit</button></h3>
    </div>
  @endforeach
@endsection
