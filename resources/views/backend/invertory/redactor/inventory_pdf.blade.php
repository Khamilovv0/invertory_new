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
@php
    $info = \Illuminate\Support\Facades\DB::connection('mysql_ais')
            ->table('db_users_profiles')
            ->leftJoin('db_users', 'db_users_profiles.user_login', '=', 'db_users.user_login')
            ->leftJoin('db_jobs', 'db_users_profiles.id_job', '=', 'db_jobs.id_job')
            ->leftJoin('db_organigramme', 'db_users_profiles.division_id', '=', 'db_organigramme.division_id')
            ->whereIn('db_users_profiles.id_job', [20, 5, 36])
            ->get();
@endphp
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
    <div class="approved">
        «Утверждаю»:<br>
        Первый проректор – <br>
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
    @php
        // Группируем записи в зависимости от значения auditoryType
        $groupedItems = $items->groupBy(function($item) {
            if ($item->auditoryType == 2) {
                // Группируем по product_name, характеристикам и TutorID
                return $item->product_name . '|' .
                    $item->characteristics->where('current_status', 0)->map(function($characteristic) {
                        return $characteristic->characteristic->name_characteristic . ':' . $characteristic->characteristic_value;
                    })->join('; ') . '|' . $item->TutorID;
            } elseif ($item->auditoryType == 1) {
                // Группируем только по product_name и характеристикам
                return $item->product_name . '|' .
                    $item->characteristics->where('current_status', 0)->map(function($characteristic) {
                        return $characteristic->characteristic->name_characteristic . ':' . $characteristic->characteristic_value;
                    })->join('; ');
            }
        });
    @endphp

    <table class="table">
        <thead>
        <tr>
            <th>№ п/п</th>
            <th>Наименование</th>
            <th>Характеристика</th>
            <th>Количество</th>
            <th>Инвентарный номер</th>
            @php
                // Проверяем, есть ли записи с auditoryType == 2
                $hasResponsiblePerson = $items->filter(function($item) {
                    return $item->auditoryType == 2;
                })->isNotEmpty();
            @endphp
            @if ($hasResponsiblePerson)
                <th>Ответственное лицо</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach ($groupedItems as $key => $group)
            @php
                // Извлекаем название продукта
                $productName = $group->first()->name_product;

                // Разбиваем ключ для извлечения характеристик
                $keyParts = explode('|', $key);
                $characteristics = $keyParts[1]; // Характеристики
                $invNumbers = $group->pluck('inv_number')->unique()->join(', '); // Уникальные инвентарные номера
            @endphp
            <tr>
                <td>{{ $counter++ }}</td>
                <td>{{ $productName }}</td>
                <td>{{ $characteristics }}</td>
                <td>{{ $group->count() }}</td>
                <td>{{ $invNumbers }}</td>
                @if ($hasResponsiblePerson)
                    @php
                        // Для каждой записи ищем ответственного
                        $responsiblePerson = $group->firstWhere('auditoryType', 2);
                    @endphp
                    @if ($responsiblePerson)
                        @php
                            $nameParts = explode(' ', $responsiblePerson->firstname);
                            $shortName = mb_substr($nameParts[0] ?? '', 0, 1) . '.';
                        @endphp
                        <td>{{ $responsiblePerson->lastname }}&nbsp;{{ $shortName }}</td>
                    @else
                        <td></td>
                    @endif
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <div>
        <table>
            <tbody style="text-align: left !important; font-size: 14px !important;">
            <tr>
                <td>Директор департамента по административно-хозяйственной <br>деятельности:</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td> Кузанов Х.С.</td>
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
                @foreach($info->where('division_id', 3) as $dit)
                    @php
                        $nameParts = explode(' ', $dit->fio_rus);

                        $shortName = $nameParts[0] . ' ' . mb_substr($nameParts[1] ?? '', 0, 1) . '.' . mb_substr($nameParts[2] ?? '', 0, 1) . '.';
                    @endphp
                    <td>
                        {{ $shortName }}
                    </td>
                @endforeach

            </tr>
            <br>
            @php
                // Проверяем, есть ли записи с auditoryType == 1
                $hasResponsiblePerson = $items->where('auditoryType', 1)->isNotEmpty();
            @endphp
            @if ($hasResponsiblePerson)
                <tr>
                    <td>Ответственный за аудиторию:</td>
                    <td></td>
                    @foreach($items->unique('lastname') as $item)
                        @php
                            $nameParts = explode(' ', $item->firstname);

                            $shortName = mb_substr($nameParts[0] ?? '', 0, 1) . '.';
                        @endphp
                        <td>{{$item->lastname}}&nbsp;{{$shortName}}</td>
                    @endforeach
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
