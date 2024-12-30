@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>{{ __('Информация о пользователе') }}</h4></div>
                <div class="card-body">
                    <div class="">
                        <div class="row">
                            @php

                                $updated_at = \Carbon\Carbon::parse(Illuminate\Support\Facades\Auth::user()->BirthDate);

                                $formattedDate = $updated_at->format('d.m.Y');

                            @endphp
                            <div class="col">
                                <img src="{{asset('backend/dist/img/metu.png')}}" alt="" style="width: 40%; margin: 10px auto 20px; display: block;">
                            </div>
                            <div class="col">
                                <h5>ФИО пользователя: <b> {{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</b></h5>
                                <hr>
                                <h6>Логин: <b>{{ Auth::user()->Login }}</b></h6>
                                <hr>
                                <h6>Дата рождения: <b>{{ $formattedDate }}</b></h6>
                            </div>
                            <div class="col">
                                @foreach($messages as $message)
                                    <div class="col-md-12">
                                        <div class="card card-info collapsed-card">
                                            <div class="card-header">
                                                <h3 class="card-title">Ошибка при редактировании</h3>

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
                                                <p style="color: #0d6efd">Для исправления ошибки пройдите на страницу базы и в поле поиска введитинвентарный номер(<b style="color: #00a8c6">{{$message->inv_number}}</b>)</p>
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
