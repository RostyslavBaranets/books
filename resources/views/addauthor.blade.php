@extends('layouts.app')

@section('title')
add author
@endsection

@section('content')
<h1>Add author</h1>
@if($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach($errors ->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
<form action="{{route('author-save')}}" method="post">
  @csrf
  <div class="form-group">
    <div class="form-floating">
      <input type="text" class="form-control" name="name" id="name" placeholder="name">
      <label for="name">Name</label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control" name="surname" id="surname " placeholder="surname ">
      <label for="surname">Surname </label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control" name="patronymic" id="patronymic" placeholder="patronymic">
      <label for="patronymic">Patronymic</label>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
@endsection
