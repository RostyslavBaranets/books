@extends('layouts.app')

@section('title')
books
@endsection

@section('content')
<div class="modal fade" id="AddBookModal" tabindex="-1" aria-labelledby="AddBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddBookModalLabel">Add book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul id="save_msgList"></ul>

        <div class="form-group mb-3">
          <label for="">Name</label>
          <input type="text" required class="name form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">description</label>
          <input type="text" required class="description form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">image</label>
          <input type="text" class="image form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">author_id</label>
          <select class="author_id form-control">
            @foreach ($books->authors as $data)
              <option>{{ $data->name  }}</option>
            @endforeach
          </select>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_book">Save</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit & Update book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <ul id="update_msgList"></ul>

        <input type="hidden" id="book_id" />

        <div class="form-group mb-3">
          <label for="">Name</label>
          <input type="text" id="name" required class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">Surname</label>
          <input type="text" id="surname" required class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">Patronymic</label>
          <input type="text" id="patronymic" class="form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update_book">Update</button>
      </div>

    </div>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    <div class="col-md-12">

      <div id="success_message"></div>

      <div class="card">
        <div class="card-header">
          <h4>
            books
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AddBookModal">Add book</button>
          </h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>description</th>
                <th>image</th>
                <th>authors_id</th>
                <th>date</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($books as $data)
              <tr id="uid{{ $data->id  }}">
                <td>{{ $data->id  }}</td>
                <td>{{ $data->name  }}</td>
                <td>{{ $data->description  }}</td>
                <td>{{ $data->image  }}</td>
                <td>{{ $data->authors_id  }}</td>
                <td>{{ $data->date  }}</td>
                <td><button type="button" value=" {{ $data->id  }} " class="btn btn-primary editbtn btn-sm">Edit</button></td>\
                <td><button type="button" value=" {{ $data->id  }} " class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
              </tr>
              @endforeach
            </tbody>
          </table>

          {{ $books->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>Confirm to Delete ?</h4>
        <input type="hidden" id="deleteing_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_book">Yes Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){
  //fetchauthors();

  $(document).on('click', '.add_book', function (e) {
    e.preventDefault();

    $(this).text('Sending..');

    var data = {
      'name': $('.name').val(),
      'surname': $('.surname').val(),
      'patronymic': $('.patronymic').val(),
    }

    $.ajax({
      type: "POST",
      url: "/store-books",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == 400) {
          $('#save_msgList').html("");
          $('#save_msgList').addClass('alert alert-danger');
          $.each(response.errors, function (key, err_value) {
            $('#save_msgList').append('<li>' + err_value + '</li>');
          });
          $('.add_book').text('Save');
        } else {
          $('#save_msgList').html("");
          $('#success_message').addClass('alert alert-success');
          $('#success_message').text(response.message);
          $('#AddBookModal').find('input').val('');
          $('.add_book').text('Save');
          $('#AddBookModal').modal('hide');
        //  fetchbooks();
        }
      }
    });
  });

@endsection
