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
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.dataTables.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/dataTables.dataTables.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/select.dataTables.min.css">')}}">
    <link href="{{asset('backend/dist/css/select2.min.css')}}" rel="stylesheet" />
    <!-- End Datatables -->
    <!-- Toster and Sweet Alert -->
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('backend/css/toastr.css')}}"> -->
    <!-- End Toaster and Sweet Alert-->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
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
            @yield('content')
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <!-- Main Footer -->
      @include('backend.layouts.footer')

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.dataTables.js')}}"></script>
    <script src="{{asset('backend/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('backend/dist/js/app.js')}}"></script>
    <!-- <script src="{{ asset('backend/js/toastr.min.js')}}"></script> -->
    <script src="{{ asset('backend/js/sweetalert.min.js') }}"></script>
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <!-- End  Sweet Alert and Toaster notifications -->
</body>
</html>
