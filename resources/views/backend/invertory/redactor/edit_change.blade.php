@extends('backend.layouts.app')
@section('content')

    @php

        use Illuminate\Support\Facades\DB;

        $product_name= DB::table('in_product_name')->get();
        $tutor = DB::connection('mysql_platonus')->table('tutors')->get();
        $building = DB::table('buildings')->get();
        $auditories = DB::table('auditories')->get();
        $sortedAuditories = $auditories->sortBy('auditoryName');

    @endphp
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Редактирование</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="myform" role="form" action="{{route('insert', $edit->id_product)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-body">
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
                                                @foreach($sortedAuditories as $auditory)
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
                                            <label for="inv_number">Инвентарный номер</label>
                                            <input type="text" name="inv_number"  class="form-control"
                                                   id="inv_number" placeholder="Введите номер" required readonly value="{{$edit->inv_number}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Инвентарь</label>
                                            <select id="id_name" name="id_name" class="form-control" readonly>
                                                <option value="{{$edit->id_name}}">{{$edit->name_product}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Назначение</label>
                                            <select id="type" name="type" class="form-control" readonly>
                                                <option value="{{$edit->type}}">
                                                @if($edit->type == 1)
                                                    Личный
                                                @elseif($edit->type == 2)
                                                    Аудиторный
                                                @endif
                                                </option>
                                            </select>
                                        </div>
                                        @foreach($edit->characteristics as $characteristic)
                                            <div class="form-group">
                                                <label for="characteristic">{{ $characteristic->characteristic->name_characteristic }}</label>
                                                <input type="text" name="id[]"  class="form-control"
                                                       id="characteristic" required readonly hidden value="{{ $characteristic->id_characteristic }}">
                                                <input type="text" name="names[]"  class="form-control"
                                                       id="characteristic" placeholder="Введите номер" required readonly value="{{ $characteristic->characteristic_value }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-body">
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
