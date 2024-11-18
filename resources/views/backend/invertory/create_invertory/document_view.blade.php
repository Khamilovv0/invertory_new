@extends('backend.layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- /.card -->
            <div class="card card-primary">
                <iframe src="{{asset('storage/act/' . $view->file)}}" width="100%" height="800px"></iframe>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
