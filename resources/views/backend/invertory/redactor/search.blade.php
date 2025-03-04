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
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
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
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Результаты поиска</h3>
                    </div>
                    <div class="card-body">
                        @if ($product->isEmpty())
                            <p>Ничего не найдено.</p>
                        @else
                            <table id="example1" class="table table-bordered table-striped" style="font-size: 15px !important">
                                @php

                                    $adminTutorID = [646, 359];

                                @endphp
                                <thead>
                                <tr>
                                    <th>Название инвентаря</th>
                                    <th>Учебный корпус</th>
                                    <th>Аудитория</th>
                                    <th>Ответственное лицо</th>
                                    <th>Инвентарный номер</th>
                                    <th>Назначение</th>
                                    <th>Характеристика</th>
                                    <th>Дата редактирования</th>
                                    <th>Редактирование</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product as $products)
                                    @php
                                        $updated_at = \Carbon\Carbon::parse($products->updated_at);

                                        $formattedDate = $updated_at->format('d.m.Y');
                                    @endphp
                                    <tr>
                                        <td>{{ $products->name_product }}</td>
                                        <td>{{ $products->buildingName }}</td>
                                        <td>{{ $products->auditoryName }}</td>
                                        <td>{{ $products->tutor_fullname }}</td>
                                        <td>{{ $products->inv_number }}</td>
                                        <td>
                                            @if($products->type == 1)
                                                Личный
                                            @elseif($products->type == 2)
                                                Аудиторный
                                            @endif
                                        </td>
                                        <td>@foreach($products->characteristics as $characteristic)
                                                <strong>{{ $characteristic->characteristic->name_characteristic }}:</strong> {{ $characteristic->characteristic_value }};
                                                <br>
                                            @endforeach
                                        </td>
                                        <td align="center"><p >{{$formattedDate}}</p></td>
                                        <td align="center">

                                            <a href="{{route('editChange', $products->id_product)}}" class="btn-sm btn-danger btn-animated d-flex align-items-center">
                                                <i class="bi bi-pencil-square"></i>
                                                <span class="d-none d-md-inline">Редактировать</span>
                                            </a>
                                            <br>
                                            <a href="{{route('story', $products->id_product)}}" class="btn-sm btn-success btn-animated d-flex align-items-center">
                                                <i class="bi bi-clock-history"></i>
                                                <span class="d-none d-md-inline">История</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Название инвентаря</th>
                                    <th>Учебный корпус</th>
                                    <th>Аудитория</th>
                                    <th>Ответственное лицо</th>
                                    <th>Инвентарный номер</th>
                                    <th>Назначение</th>
                                    <th>Характеристика</th>
                                    <th>Дата редактирования</th>
                                    <th>Редактирование</th>
                                </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
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
    .btn-animated {
        width: 30px;
        overflow: hidden;
        transition: width 0.3s ease-in-out;
        white-space: nowrap;
    }

    .btn-animated:hover {
        width: 130px;
    }

    .btn-animated i {
        margin-right: 7px;
    }
</style>
