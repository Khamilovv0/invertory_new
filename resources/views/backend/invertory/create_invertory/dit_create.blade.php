@extends('backend.layouts.app')
@section('content')

    @php

        use Illuminate\Support\Facades\DB;

        $product_name= DB::table('in_product_name')->get();
        $tutor = DB::connection('mysql_platonus')->table('tutors')->get();

    @endphp
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Добавить инвертарь</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="myform" role="form" action="{{route('addAll')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="category">Выберите товар</label>
                                            <select id="id_name" name="id_name" class="form-control">
                                                <option value="">Выберите товар</option>
                                                @foreach($product_name as $name)
                                                    <option value="{{$name->id_name}}">{{$name->name_product}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <h5><strong>Местоположение</strong></h5>
                                            <label for="building">Корпус</label>
                                            <select id="building" name="buildingID" class="form-control">
                                                <option value="">Выберите корпус</option>
                                                @foreach($building as $buildingID)
                                                    <option value="{{$buildingID->buildingID}}">{{$buildingID->buildingName}}</option>
                                                @endforeach
                                            </select>
                                            <label for="auditory">Аудитория</label>
                                            <select id="auditory" name="auditoryID" class="form-control">
                                                <option value="">Выберите аудиторию</option>
                                                @foreach($auditories as $auditory)
                                                    <option value="{{$auditory->auditoryID}}">{{$auditory->auditoryName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="tutor">Выберите ответственное лицо</label>
                                            <select id="tutor" name="TutorID" class="form-control">
                                                <option value="">Выберите ответственное лицо</option>
                                                @foreach($tutor as $tutors)
                                                    <option value="{{$tutors->TutorID}}">{{$tutors->lastname}} {{$tutors->firstname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Назначение</label>
                                            <select id="type" name="type" class="form-control">
                                                <option value="">Выберите назначение</option>
                                                <option value="1">Личный</option>
                                                <option value="2">Аудиторный</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="inv_number">Инвертарный номер</label>
                                            <input type="text" name="inv_number"  class="form-control"
                                                   id="inv_number" placeholder="Введите номер" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card-body">
                                        <div id="product-form-container">
                                            <!-- Сюда будет загружена форма соответствующего продукта -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
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
