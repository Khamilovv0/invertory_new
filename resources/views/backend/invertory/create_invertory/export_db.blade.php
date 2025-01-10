<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <link rel="icon" type="image/png" href="{{asset('backend/dist/img/metu.png')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{asset('backend/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('backend/css/toastr.css')}}"> -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
    <!-- Яндекс метрика -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(99075707, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/99075707" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    &nbsp&nbsp Выйти &nbsp
                    <i class="nav-icon fa fa-sign-out-alt"></i>&nbsp&nbsp
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('backend.layouts.sidebar')
    <!-- End Main Sidebar Container -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @include('backend.flash-message')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header info">
                                    <h3 class="card-title">Список наименований</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="export" class="table table-bordered table-striped" style="font-size: 13px !important">
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
                                            <th>Статус</th>
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
                                                <td>
                                                    @if($item->verification_status == 1)
                                                        <span class="badge bg-warning">Отправлено.<br>На проверке</span>
                                                    @elseif($item->verification_status == 2)
                                                        <span class="badge bg-success">Подтверждено</span>
                                                    @elseif($item->verification_status == 3)
                                                        <span class="badge bg-danger">На доработке</span>
                                                    @endif
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
                                            <th>Инвертанный номер</th>
                                            <th>Назначение</th>
                                            <th>Характеристика</th>
                                            <th>Дата редактирования</th>
                                            <th>Последний редактор</th>
                                            <th>Статус</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    @include('backend.layouts.footer')
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <!-- End  Sweet Alert and Toaster notifications -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
</body>
</html>
<script>
    $('#export').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                customize: function(doc) {
                    // Дополнительная настройка PDF (например, шрифт, стили)
                    doc.styles.tableHeader.fontSize = 10; // Размер шрифта заголовков таблицы
                    doc.styles.tableBodyEven.alignment = 'center'; // Центрирование текста
                    doc.styles.tableBodyOdd.alignment = 'center';
                    // Настройка стилей таблицы
                },
                extend: 'excelHtml5',
                text: 'Экспорт в Excel',
                serverSide: true,
                exportOptions: {
                    columns: ':visible', // Экспортировать только видимые колонки
                    modifier: {
                        page: 'all' // Экспортировать все страницы
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: 'Экспорт в PDF',
                serverSide: true,
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':visible',
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'csvHtml5',
                text: 'Экспорт в CSV',
                serverSide: true,
                exportOptions: {
                    columns: ':visible',
                    modifier: {
                        page: 'all'
                    }
                }
            }
        ],
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        language: {
            lengthMenu: "Показать _MENU_ записей на странице",
            zeroRecords: "Записи не найдены",
            info: "Показаны записи с _START_ по _END_ из _TOTAL_",
            infoEmpty: "Нет данных",
            infoFiltered: "(отфильтровано из _MAX_ записей)"
        }
    });
</script>
