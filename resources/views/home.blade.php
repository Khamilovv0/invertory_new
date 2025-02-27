@extends('backend.layouts.app')

@section('content')
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Информация о пользователе') }}</h4></div>
                    <div class="card-body">
                        <div class="">
                            <div class="row">
                                @foreach($info as $data)
                                    <div class="col-md-4">
                                        <img class="profile-user-img img-responsive img-circle" src="https://ais.kazetu.kz/dist/users/{{$data->avatar_url}}" alt="User profile picture">
                                        <br>
                                        <h6 style="text-align: center">{{ $data->fio_rus }}</h6>
                                        <h6 style="text-align: center; color: #777">{{ $data->name_job_rus }}</h6>
                                        <h6 style="text-align: center; color: #777">{{ $data->division_name_rus }}</h6>
                                    </div>
                                @endforeach
                                <div class="col">
                                    @foreach($info as $data)
                                        <h6>Логин: <b>{{ Auth::user()->Login }}</b></h6>
                                        <hr>
                                        <h6>Почта: <b>{{ $data->email }}</b></h6>
                                        <hr>
                                        <h6>Моб-тел.: <b>{{ $data->mobile_phone }}</b></h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    @foreach($messages as $message)
                                        <div class="col-md-12">
                                            <div class="card card-info collapsed-card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Ошибка при редактировании ({{$message->inv_number}})</h3>

                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.card-tools -->
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <p><b>Инвентарный номер: </b> {{$message->inv_number}}</p>
                                                    <p><b>Название инвертаря: </b> {{$message->name_product}}</p>
                                                    <p><b>Данные редактора: </b> {{$message->tutor_fullname}}</p>
                                                    <p style="color: red;"><b>Сообщение об ошибке: </b> {{$message->message}}</p>
                                                    <p style="color: #0d6efd">Для исправления ошибки пройдите на страницу базы и в поле поиска введите инвентарный номер(<b style="color: #00a8c6">{{$message->inv_number}}</b>)</p>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .profile-user-img {
        display: block;
        margin: 0 auto;
    }
</style>
