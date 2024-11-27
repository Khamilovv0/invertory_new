<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Опись</title>
    <style>
        body {
            font-family: "dejavu serif" !important;
        }
        .header {
            text-align: center;
            text-transform: uppercase;
        }
        .approved {
            text-align: right;
            font-style: italic;
            font-weight:bold
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .table th, .table td {
            border: 1px solid #000;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div>
    <div class="header">
        <p style="font-size: 13px">Министерство науки и высшего образования Республики Казахстан</p>
        <br>
        <table class="center">
            <tr>
                <th><img src="{{$imageBase64}}" style="width: 100px"></th>
                <th style="font-size: 15px; text-transform: uppercase; font-weight: normal;">Международный инженерно-<br>технологический университет</th>
            </tr>
        </table>
    </div>
    @php
        $info = \Illuminate\Support\Facades\DB::connection('mysql_ais')
                ->table('db_users_profiles')
                ->leftJoin('db_users', 'db_users_profiles.user_login', '=', 'db_users.user_login')
                ->leftJoin('db_jobs', 'db_users_profiles.id_job', '=', 'db_jobs.id_job')
                ->get();
    @endphp
    <div class="approved">
        «Утверждаю»:<br>
        Проректор по АРиМС<br>
        ___________
        @foreach($info->where('id_job', 36) as $prorector)
            @php
                // Разбиваем ФИО на части
                $nameParts = explode(' ', $prorector->fio_rus);

                // Формируем сокращенный формат
                $shortName = $nameParts[0] . ' ' . mb_substr($nameParts[1] ?? '', 0, 1) . '.' . mb_substr($nameParts[2] ?? '', 0, 1) . '.';
            @endphp
            {{$shortName}}
        @endforeach<br>
        «___» ________ {{ date('Y') }}.
    </div>

    <h3 style="text-align: center;">Опись</h3>
    <h4 style="text-align: center;">Аудитории №@foreach($items->unique('auditoryName') as $item) {{$item->auditoryName}} @endforeach</h4>
    <table class="table">
        <thead>
        <tr>
            <th>№ п/п</th>
            <th>Наименование</th>
            <th>Характеристика</th>
            <th>Количество</th>
            <th>Инвентарный номер</th>
        </tr>
        </thead>
        @php
            // Группируем записи по product_name и характеристикам
            $groupedItems = $items->groupBy(function($item) {
                return $item->product_name . $item->characteristics->where('current_status', 0)->map(function($characteristic) {
                    return $characteristic->characteristic->name_characteristic . ':' . $characteristic->characteristic_value;
                })->join('; ');
            });
        @endphp
        <tbody>
        @php $counter = 1; @endphp <!-- Счетчик для порядковых номеров -->
        @foreach ($groupedItems as $key => $group)
            @php
                // Получаем название продукта непосредственно из первой записи группы
                $productName = $group->first()->name_product;
                $characteristics = $key; // Сохраняем характеристику из ключа
                $invNumbers = $group->pluck('inv_number')->unique()->join(', '); // Собираем уникальные инвентарные номера
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Порядковый номер -->
                <td>{{ $productName }}</td> <!-- Просто выводим название продукта -->
                <td>{{ $characteristics }}</td> <!-- Характеристика -->
                <td>{{ $group->count() }}</td> <!-- Количество записей в группе -->
                <td>{{ $invNumbers }}</td> <!-- Инвентарные номера -->
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <div>
        <table>
            <tbody style="text-align: left !important; font-size: 14px !important;">
            <tr>
                <td>Директор департамента по административно-хозяйственным <br>работам:</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td> Кузанов Х.</td>
            </tr>
            <br>
            @foreach($info->where('fio_rus', $head) as $head_d)
                @php
                    // Разбиваем ФИО на части
                    $nameParts = explode(' ', $head_d->fio_rus);

                    // Формируем сокращенный формат
                    $shortName = $nameParts[0] . ' ' . mb_substr($nameParts[1] ?? '', 0, 1) . '.' . mb_substr($nameParts[2] ?? '', 0, 1) . '.';
                @endphp
                <tr>
                    <td>{{$head_d->name_job_rus}}:</td>
                    <td></td>
                    <td>{{$shortName }}</td>
                </tr>
                <br>
            @endforeach
            <tr>
                <td>Директор департамента информационных технологий:</td>
                <td></td>
                <td> Шындалы С.Б.</td>
            </tr>
            <br>
            <tr>
                <td>Ответственный за аудиторию:</td>
                <td></td>
                @foreach($items->unique('lastname') as $item)
                <td>{{$item->lastname}}&nbsp;{{ $item->firstname}}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>


