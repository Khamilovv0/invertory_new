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
                                    <th>Название инвертаря</th>
                                    <th>Учебный корпус</th>
                                    <th>Аудитория</th>
                                    <th>Ответственное лицо</th>
                                    <th>Инвертарный номер</th>
                                    <th>Дата редактирования</th>
                                    <th>Редактирование</th>
                                    <th>Статус</th>
                                    @if (in_array(Auth::user()->TutorID, $adminTutorID))
                                        <th>Подтверждение</th>
                                    @endif
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
                                        <td align="center"><p >{{$formattedDate}}</p></td>
                                        <td align="center"><a href="{{route('editAll', $products->id_product)}}" class="btn-sm  btn-danger">Редактировать</a></td>
                                        <td>

                                            @if($products->status == 1)
                                                <span class="badge bg-warning">На проверке</span>
                                            @elseif($products->status == 2)
                                                <span class="badge bg-success">Подтверждено</span>
                                            @elseif($products->status == 3)
                                                <span class="badge bg-danger">Отказано</span>
                                            @endif

                                        </td>
                                        @if (in_array(Auth::user()->TutorID, $adminTutorID))
                                            <td>
                                                <form action="{{ route('confirmStatus', ['id' => $products->id_product]) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-block btn-info" type="submit">Подтвердить</button>
                                                </form>
                                                <br>
                                                <form action="{{ route('refuseStatus', ['id' => $products->id_product]) }}" method="POST">
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
                                    <th>Дата редактирования</th>
                                    <th>Редактирование</th>
                                    <th>Статус</th>
                                    @if (in_array(Auth::user()->TutorID, $adminTutorID))
                                        <th>Подтверждение</th>
                                    @endif
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
