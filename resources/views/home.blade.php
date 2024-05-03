@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>{{ __('Информация о пользователе') }}</h4></div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            @php

                                $updated_at = \Carbon\Carbon::parse(Illuminate\Support\Facades\Auth::user()->BirthDate);

                                $formattedDate = $updated_at->format('d.m.Y');
                            @endphp
                            <div class="col-md-8">
                                <h5>ФИО пользователя: <b> {{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</b></h5>
                                <hr>
                                <h6>Логин: <b>{{ Auth::user()->Login }}</b></h6>
                                <hr>
                                <h6>Дата рождения: <b>{{ $formattedDate }}</b></h6>
                            </div>
                            <div class="col-sm">
                                <img src="{{asset('backend/dist/img/metu.png')}}" alt="" style="width: 40%; margin: 10px auto 20px; display: block;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
