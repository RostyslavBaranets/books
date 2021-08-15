@extends('layouts.app')

@section('title')
authors
@endsection

@section('content')


  <div class="row" style="margin-top: 45px">
               <div class="col-md-8">
                 <input type="text" name="searchfor" id="" class="form-control">
                     <div class="card">
                         <div class="card-header">Authors</div>
                         <div class="card-body">
                             <table class="table table-hover table-condensed">
                                 <thead>
                                     <th>#</th>
                                     <th>Name</th>
                                     <th>Surname</th>
                                     <th>Patronymic</button></th>
                                 </thead>
                                 <tbody></tbody>
                             </table>
                         </div>
                     </div>
               </div>
               <div class="col-md-4">
                     <div class="card">
                         <div class="card-header">Add new Author</div>
                         <div class="card-body">
                             <form action="{{route('author-save')}}" method="post" id="addauthor-form">
                                 @csrf
                                 <div class="form-group">
                                     <label for="">Name</label>
                                     <input type="text" class="form-control" name="name" placeholder="Enter name">
                                     <span class="text-danger error-text name_error"></span>
                                 </div>
                                 <div class="form-group">
                                     <label for="">Surname</label>
                                     <input type="text" class="form-control" name="surname" placeholder="Enter surname">
                                     <span class="text-danger error-text surname_error"></span>
                                 </div>
                                 <div class="form-group">
                                     <label for="">Patronymic</label>
                                     <input type="text" class="form-control" name="patronymic" placeholder="Enter patronymic">
                                     <span class="text-danger error-text patronymic_error"></span>
                                 </div>
                                 <div class="form-group">
                                     <button type="submit" class="btn btn-block btn-success">SAVE</button>
                                 </div>
                             </form>
                         </div>
                     </div>
               </div>
           </div>

@endsection


@section('script')
<script>
  $('#addauthor-form').on('submit', function(e){
      e.preventDefault();
      var form = this;
      $.ajax({
         url:$(form).attr('action'),
         method:$(form).attr('method'),
         data:new FormData(form),
         processData:false,
         dataType:'json',
         contentType:false,
         beforeSend:function(){
              $(form).find('span.error-text').text('');
         },
         success:function(data){
              if(data.code == 0){
                    $.each(data.error, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                    });
              }else{
                  $(form)[0].reset();
                   alert(data.msg);
                   allauthors();
              }
         }
     });
 });

allauthors();

function allauthors(){
  $.ajax({
    type: 'GET',
    url:'allauthors',
    dataType:'json',
    success:function(response){
      $('tbody').html("");
      $.each(response.authors, function(key, item){
        $('tbody').append('<tr>\
          <td>'+item.id+'</td>\
          <td>'+item.name+'</td>\
          <td>'+item.surname+'</td>\
          <td>'+item.patronymic+'</td>\
          </tr>')
      })
    }
  })
}


</script>
@endsection
