@extends('backend.layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header info">
                    <h3 class="card-title">Список наименований</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px !important">
                        @php

                            $adminTutorID = [646, 359];

                        @endphp
                        <thead>
                        <tr>
                            <th>Название инвертаря</th>
                            <th>Учебный корпус</th>
                            <th>Аудитория</th>
                            <th>Ответственное лицо</th>
                            <th>Инвертарный номер</th>
                            <th>Назначение</th>
                            <th>Характеристика</th>
                            <th>Дата редактирования</th>
                            <th>Редактирование</th>
                            <th>Статус</th>
                            @if (in_array(Auth::user()->TutorID, $adminTutorID))
                                <th>Подтверждение</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            @php
                                $updated_at = \Carbon\Carbon::parse($item->updated_at);

                                $formattedDate = $updated_at->format('d.m.Y');
                            @endphp
                            <tr>
                                <td>{{ $item->name_product }}</td>
                                <td>{{ $item->buildingName }}</td>
                                <td>{{ $item->auditoryName }}</td>
                                <td>{{ $item->tutor_fullname }}</td>
                                <td>{{ $item->inv_number }}</td>
                                <td>
                                    @if($item->type == 1)
                                        Личный
                                    @elseif($item->type == 2)
                                        Аудиторный
                                    @endif
                                </td>
                                <td>@foreach($item->characteristics as $characteristic)
                                        <strong>{{ $characteristic->characteristic->name_characteristic }}:</strong> {{ $characteristic->characteristic_value }};
                                        <br>
                                    @endforeach
                                </td>
                                <td align="center"><p >{{$formattedDate}}</p></td>
                                <td align="center"><a href="{{route('editAll', $item->id_product)}}" class="btn-sm  btn-danger">Редактировать</a></td>
                                <td>

                                    @if($item->status == 1)
                                        <span class="badge bg-warning">На проверке</span>
                                    @elseif($item->status == 2)
                                        <span class="badge bg-success">Подтверждено</span>
                                    @elseif($item->status == 3)
                                        <span class="badge bg-danger">Отказано</span>
                                    @endif

                                </td>
                                @if (in_array(Auth::user()->TutorID, $adminTutorID))
                                    <td>
                                        <form action="{{ route('confirmStatus', ['id' => $item->id_product]) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-block btn-info" type="submit">Подтвердить</button>
                                        </form>
                                        <br>
                                        <form action="{{ route('refuseStatus', ['id' => $item->id_product]) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-block btn-danger" type="submit">Отказать</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Название инвертаря</th>
                            <th>Учебный корпус</th>
                            <th>Аудитория</th>
                            <th>Ответственное лицо</th>
                            <th>Инвертарный номер</th>
                            <th>Назначение</th>
                            <th>Характеристика</th>
                            <th>Дата редактирования</th>
                            <th>Редактирование</th>
                            <th>Статус</th>
                            @if (in_array(Auth::user()->TutorID, $adminTutorID))
                                <th>Подтверждение</th>
                            @endif
                        </tr>
                        </tfoot>
                    </table>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
