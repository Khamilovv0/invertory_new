@extends('backend.layouts.app')
@section('content')

    @php

        use Illuminate\Support\Facades\DB;

        $product_lists= DB::table('in_product_lists')->get();

    @endphp

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Генерация QR-кодов для инвентаря</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="myform" role="form" action="{{route('qr_generate_auditory')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="auditory">Аудитория</label>
                                            <select id="auditory" name="auditoryID" class="form-control">
                                                <option value="">Выберите аудиторию</option>
                                                @foreach($for_qr as $auditory)
                                                    <option value="{{$auditory->auditoryID}}">{{$auditory->auditoryName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Генерация</button>
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
@endsection

<style>
    .select2-container--default{
        width: 100%;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding: 1px 7px !important;
        padding-left: 30px !important;
    }
    .select2-selection__choice__remove{
        padding: 1px 7px !important;
        margin: 0 !important;
    }
    .select2-selection__choice__remove:hover{
        background-color: #0e5b44; !important;
    }
</style>

