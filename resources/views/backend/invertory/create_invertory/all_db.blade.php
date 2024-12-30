@extends('backend.layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-cyan collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Импорт инвентаря</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Выберите Excel файл для импорта. Перед этим посмотрите <a href="/backend/assets/шаблон_импорта.xlsx">Шаблон</a> импорта.</label>
                            <br>
                            <input type="file" name="excel_file" class="form" id="file" accept=".xls, .xlsx">
                        </div>
                        <button class="btn btn-primary btn-sm">Загрузить</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-primary">
                <div class="card-header info">
                    <h3 class="card-title">Список наименований</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped" style="font-size: 13px !important">
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
                            <th>Последний редактор</th>
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
                                <td>
                                    @foreach($item->characteristics->where('current_status', 0) as $characteristic)
                                        <strong>{{ $characteristic->characteristic->name_characteristic }}:</strong> {{ $characteristic->characteristic_value }};
                                        <br>
                                    @endforeach
                                </td>
                                <td align="center"><p >{{$formattedDate}}</p></td>
                                <td>
                                    @if($item->redactor_fullname)
                                        {{ $item->redactor_fullname }}
                                    @else
                                        <h6 style="color: #7f8c8d">Нет данных</h6>
                                    @endif
                                </td>
                                <td align="center">
                                    <br>
                                    <a href="{{route('editAll', $item->id_product)}}" class="btn-sm  btn-danger">Редактировать</a>
                                </td>
                                <td>

                                    @if($item->verification_status == 1)
                                        <span class="badge bg-warning">Отправлено.<br>На проверке</span>
                                    @elseif($item->verification_status == 2)
                                        <span class="badge bg-success">Подтверждено</span>
                                    @elseif($item->verification_status == 3)
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
                                        <button class="btn btn-block btn-danger" data-toggle="modal" data-target="#modal-lg"
                                                onclick="fillModal('{{ $item->inv_number }}',
                                                                   '{{ $item->redactor_id }}',
                                                                   '{{ $item->id_name }}',
                                                                   '{{ $item->id_product }}')">
                                            Отказать
                                        </button>
                                        <!-- Модальное окно -->

                                        <!-- /.modal -->
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Название инвентаря</th>
                            <th>Учебный корпус</th>
                            <th>Аудитория</th>
                            <th>Ответственное лицо</th>
                            <th>Инвертанный номер</th>
                            <th>Назначение</th>
                            <th>Характеристика</th>
                            <th>Дата редактирования</th>
                            <th>Последний редактор</th>
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
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Причина</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('refuseStatus', ['id' => $item->id_product]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="message">Укажите причину отказа</label>
                        <textarea class="form-control" type="text" name="message" id="message" placeholder="Напишите причину..."></textarea>
                    </div>
                    <!-- Скрытые поля для передачи данных строки -->
                    <input style="margin: 5px; width: 70%" class="form-control" readonly name="inv_number" id="inv_number">
                    <input style="margin: 5px; width: 70%" class="form-control" readonly name="redactor_id" id="redactor_id">
                    <input style="margin: 5px; width: 70%" class="form-control" readonly name="id_product" id="id_product">
                    <input style="margin: 5px; width: 70%" class="form-control" readonly name="id_name" id="id_name">
                    <div class="card-body">
                        <button class="btn btn-primary" type="submit">Отправить</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>

        function fillModal(invNumber, redactorId, id_name, id_product) {
            // Находим скрытые поля в модальном окне и устанавливаем им значения
            document.getElementById('inv_number').value = invNumber;
            document.getElementById('redactor_id').value = redactorId;
            document.getElementById('id_name').value = id_name;
            document.getElementById('id_product').value = id_product;
        }
    </script>
@endsection
