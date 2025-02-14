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
                <a class="dropdown-item" href=""
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    &nbsp&nbsp Выйти &nbsp
                    <i class="nav-icon fa fa-sign-out-alt"></i>&nbsp&nbsp
                </a>
                <form id="logout-form" action="" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="{{asset('backend/dist/img/logo.png')}}" alt="{{config('app.name')}}" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{config('app.name')}}</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('backend/dist/img/user.png')}}" class="" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Не авторизован</a>
                </div>
            </div>
            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Поиск" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <style>
                    li{
                        font-size: 14px !important;
                    }
                    i{
                        margin-right: 5px;
                    }
                </style>

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="bi bi-box-arrow-in-left"></i>
                            <p>
                                {{ __('Войдите для редактирования') }}
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- End Main Sidebar Container -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-cyan collapsed-card">
                        </div>
                        <!-- /.card -->
                        <div class="card card-primary">
                            <div class="card-header info">
                                <h3 class="card-title">Список наименований</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div>
                                    @foreach($items as $item)
                                        @php
                                            $updated_at = \Carbon\Carbon::parse($item->updated_at);
                                            $formattedDate = $updated_at->format('d.m.Y');
                                        @endphp

                                        <div style="margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                            <p><strong>Название инвентаря:</strong> {{ $item->name_product }}</p>
                                            <p><strong>Учебный корпус:</strong> {{ $item->buildingName }}</p>
                                            <p><strong>Аудитория:</strong> {{ $item->auditoryName }}</p>
                                            <p><strong>Ответственное лицо:</strong> {{ $item->tutor_fullname }}</p>
                                            <p><strong>Инвентарный номер:</strong> {{ $item->inv_number }}</p>
                                            <p><strong>Назначение:</strong>
                                                @if($item->type == 1)
                                                    Личный
                                                @elseif($item->type == 2)
                                                    Аудиторный
                                                @endif
                                            </p>
                                            <p><strong>Характеристика:</strong>
                                                @foreach($item->characteristics->where('current_status', 0) as $characteristic)
                                                    <strong>{{ $characteristic->characteristic->name_characteristic }}:</strong> {{ $characteristic->characteristic_value }};
                                                    <br>
                                                @endforeach
                                            </p>
                                            <p><strong>Дата редактирования:</strong> {{ $formattedDate }}</p>
                                            <p><strong>Последний редактор:</strong>
                                                @if($item->redactor_fullname)
                                                    {{ $item->redactor_fullname }}
                                                @else
                                                    <span style="color: #7f8c8d">Нет данных</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>

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
