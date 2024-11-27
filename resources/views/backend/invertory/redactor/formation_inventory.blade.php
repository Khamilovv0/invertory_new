@extends('backend.layouts.app')

@php
    use Illuminate\Support\Facades\DB;
@endphp

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Формирование описи</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{url('generate-pdf')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="auditory">Введите номер аудитории</label>
                                <select id="auditory" name="auditoryID" class="form-control" required>
                                    <option value="">Выберите аудиторию</option>
                                    @foreach($auditories as $auditory)
                                        <option value="{{$auditory->auditoryID}}">{{$auditory->auditoryName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                @php

                                $cafedra = DB::connection('mysql_ais')->table('db_users_profiles')
                                           ->leftJoin('db_users', 'db_users_profiles.user_login', '=', 'db_users.user_login')
                                           ->where('db_users_profiles.id_job', 5)
                                           ->where('db_users.user_access', '1')
                                           ->get();

                                @endphp
                                <label for="head">Выберите ФИО зав. кафедры</label>
                                <select id="head" name="head" class="form-control">
                                    <option value=""> </option>
                                    @foreach($cafedra as $head)
                                        <option value="{{$head->fio_rus}}">{{$head->fio_rus}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Сформировать
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection
