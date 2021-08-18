@extends('layouts.app')

@section('title')
authors
@endsection

@section('content')

<div class="modal fade" id="AddAuthorModal" tabindex="-1" aria-labelledby="AddAuthorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddAuthorModalLabel">Add Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul id="save_msgList"></ul>

        <div class="form-group mb-3">
          <label for="">Name</label>
          <input type="text" required class="name form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">Surname</label>
          <input type="text" required class="surname form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">Patronymic</label>
          <input type="text" class="patronymic form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_author">Save</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit & Update Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <ul id="update_msgList"></ul>

        <input type="hidden" id="author_id" />

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
        <button type="submit" class="btn btn-primary update_author">Update</button>
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
            Authors
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AddAuthorModal">Add Author</button>
          </h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Patronymic</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($authors as $data)
              <tr id="uid{{ $data->id  }}">
                <td>{{ $data->id  }}</td>
                <td>{{ $data->name  }}</td>
                <td>{{ $data->surname  }}</td>
                <td>{{ $data->patronymic  }}</td>
                <td><button type="button" value=" {{ $data->id  }} " class="btn btn-primary editbtn btn-sm">Edit</button></td>\
                <td><button type="button" value=" {{ $data->id  }} " class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
              </tr>
              @endforeach
            </tbody>
          </table>

          {{ $authors->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>Confirm to Delete ?</h4>
        <input type="hidden" id="deleteing_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_author">Yes Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){
  //fetchauthors();

  function fetchauthors() {
    $.ajax({
      type: "GET",
      url: "/fetch-authors",
      dataType: "json",
      success: function (response) {
        $('tbody').html("");
        $.each(response.authors, function (key, item) {
          $('tbody').append('<tr>\
          <td>' + item.id + '</td>\
          <td>' + item.name + '</td>\
          <td>' + item.surname + '</td>\
          <td>' + item.patronymic + '</td>\
          <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</button></td>\
          <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
          \</tr>');
        });
      }
    });
  }

  $(document).on('click', '.add_author', function (e) {
    e.preventDefault();

    $(this).text('Sending..');

    var data = {
      'name': $('.name').val(),
      'surname': $('.surname').val(),
      'patronymic': $('.patronymic').val(),
    }

    $.ajax({
      type: "POST",
      url: "/store-authors",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == 400) {
          $('#save_msgList').html("");
          $('#save_msgList').addClass('alert alert-danger');
          $.each(response.errors, function (key, err_value) {
            $('#save_msgList').append('<li>' + err_value + '</li>');
          });
          $('.add_author').text('Save');
        } else {
          $('#save_msgList').html("");
          $('#success_message').addClass('alert alert-success');
          $('#success_message').text(response.message);
          $('#AddAuthorModal').find('input').val('');
          $('.add_author').text('Save');
          $('#AddAuthorModal').modal('hide');
          fetchauthors();
        }
      }
    });
  });

  $(document).on('click', '.editbtn', function (e) {
    e.preventDefault();
    var author_id = $(this).val();
    $('#editModal').modal('show');
    $.ajax({
      type: "GET",
      url: "/edit-author/" + author_id,
      success: function (response) {
        if (response.status == 404) {
          $('#success_message').addClass('alert alert-success');
          $('#success_message').text(response.message);
          $('#editModal').modal('hide');
        } else {
          $('#name').val(response.author.name);
          $('#surname').val(response.author.surname);
          $('#patronymic').val(response.author.patronymic);
          $('#author_id').val(author_id);
        }
      }
    });
    $('.btn-close').find('input').val('');

  });

  $(document).on('click', '.update_author', function (e) {
    e.preventDefault();

    $(this).text('Updating..');
    var id = $('#author_id').val();

    var data = {
      'name': $('#name').val(),
      'surname': $('#surname').val(),
      'patronymic': $('#patronymic').val(),
    }

    $.ajax({
      type: "PUT",
      url: "/update-author/" + id,
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == 400) {
          $('#update_msgList').html("");
          $('#update_msgList').addClass('alert alert-danger');
          $.each(response.errors, function (key, err_value) {
            $('#update_msgList').append('<li>' + err_value +
            '</li>');
          });
          $('.update_author').text('Update');
        } else {
          $('#update_msgList').html("");

          $('#success_message').addClass('alert alert-success');
          $('#success_message').text(response.message);
          $('#editModal').find('input').val('');
          $('.update_author').text('Update');
          $('#editModal').modal('hide');
          fetchauthors();
        }
      }
    });
  });

  $(document).on('click', '.deletebtn', function () {
    var author_id = $(this).val();
    $('#DeleteModal').modal('show');
    $('#deleteing_id').val(author_id);
  });

  $(document).on('click', '.delete_author', function (e) {
    e.preventDefault();

    $(this).text('Deleting..');
    var id = $('#deleteing_id').val();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: "DELETE",
      url: "/delete-author/" + id,
      dataType: "json",
      success: function (response) {
        if (response.status == 404) {
          $('#success_message').addClass('alert alert-success');
          $('#success_message').text(response.message);
          $('.delete_author').text('Yes Delete');
        } else {
          $('#success_message').html("");
          $('#success_message').addClass('alert alert-success');
          $('#success_message').text(response.message);
          $('.delete_author').text('Yes Delete');
          $('#DeleteModal').modal('hide');
          fetchauthors();
        }
      }
    });
  });

});

</script>


@endsection
