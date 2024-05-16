@extends('backend.layouts.app')
@section('content')

    @php

        use Illuminate\Support\Facades\DB;

        $product_name= DB::table('in_product_name')->get();
        /*$tutor = DB::connection('mysql_platonus')->table('tutors')->get();
        $building = DB::table('buildings')->get();
        $auditories = DB::table('auditories')->get();
        $sortedAuditories = $auditories->sortBy('auditoryName');*/

    @endphp
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Поиск по инвентарному номеру</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('search_item') }}" method="GET">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="search">Введите инвентарный номер</label>
                                            <input id="search" class="form-control" type="text" name="query" placeholder="Введите запрос..." value="">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <button class="btn btn-primary" type="submit">Искать</button>
                                    </div>
                                </div>
                            </div>
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
