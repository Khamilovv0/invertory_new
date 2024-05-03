@extends('backend.layouts.app')
@section('content')

<div class="card-body">
    <div class="row">
      <div class="col-md-2">
      </div>
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Редактировать Наименования</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('UpdateCategory', $edit->id_name)}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Название</label>
                            <input type="text" name="name" value="{{$edit->name_product}}"  class="form-control @error('title') is-invalid @enderror"
                                    id="exampleInputEmail1" placeholder="Enter Book Category Name">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Принадлежность</label>
                        <select id="type" name="type" class="form-control">
                            <option value="1">Личный</option>
                            <option value="2">Аудиторный</option>
                        </select>

                        @error('slug')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-2">
        </div>
    </div>
    <!-- /.row -->
</div>

<script type="text/javascript">
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#image')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
   }
</script>

@endsection
