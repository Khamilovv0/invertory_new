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

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
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
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('backend/dist/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#tutor').select2();
        });

          $(function () {
            $("#example1").DataTable({
              "responsive": true,
              "autoWidth": false,
            });
            $('#example2').DataTable({
              "paging": true,
              "lengthChange": false,
              "searching": false,
              "ordering": true,
              "info": true,
              "autoWidth": false,
              "responsive": true,
            });
          });
        </script>
    <!-- End Datatables -->
         <script>
             $(document).on("click", "#delete", function(e){
                 e.preventDefault();
                 var link = $(this).attr("href");
                    swal({
                      title: "Are you Want to delete?",
                      text: "Once Delete, This will be Permanently Delete!",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                           window.location.href = link;
                      } else {
                        swal("Safe Data!");
                      }
                    });
                });

             function readURL(input) {
                 if (input.files && input.files[0]) {
                     var reader = new FileReader();
                     reader.onload = function (e) {
                         $('#image')
                             .attr('src', e.target.result)
                             .width(80)
                             .height(80);
                     };
                     reader.readAsDataURL(input.files[0]);
                 }
             }
             document.addEventListener('DOMContentLoaded', function() {
                 var id_name = document.getElementById('id_name');
                 id_name.addEventListener('change', function() {
                     var selectedProductId = this.value;
                     fetchForm(selectedProductId);
                 });
             });
             function fetchForm(id_name) {
                 fetch('/get-product-form/' + id_name)
                     .then(response => response.json())
                     .then(data => {
                         const container = document.getElementById('product-form-container');
                         container.innerHTML = ''; // Очищаем контейнер перед добавлением нового содержимого

                         // Создаем массив для хранения id_characteristic
                         let idCharacteristics = [];

                         // Добавляем каждый id_characteristic в массив
                         data.forms.forEach(form => {
                             const formContainer = document.createElement('div');
                             formContainer.innerHTML = form.input_characteristic;
                             container.appendChild(formContainer);

                             const hiddenInput = document.createElement('input');
                             hiddenInput.type = 'hidden';
                             hiddenInput.name = 'id_characteristic[]'; // Обратите внимание на квадратные скобки []
                             hiddenInput.value = form.id_characteristic;
                             formContainer.appendChild(hiddenInput);

                             // Добавляем id_characteristic в массив
                             idCharacteristics.push(form.id_characteristic);
                         });
                         // Отправляем массив id_characteristic на сервер
                         fetch('/save-data', {
                             method: 'POST',
                             headers: {
                                 'Content-Type': 'application/json',
                             },
                             body: JSON.stringify({ id_characteristics: idCharacteristics }),
                         })
                             .then(response => response.json())
                             .then(data => console.log(data))
                             .catch(error => console.error('Ошибка:', error));
                     })
                     .catch(error => console.error('Ошибка:', error));
             }
             document.getElementById('myForm').addEventListener('submit', function(e) {
                 e.preventDefault();

                 const formData = new FormData(this);
                 const values = formData.getAll('values[]');

                 fetch('/dit_create/addAll', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': csrfToken // CSRF токен Laravel
                     },
                     body: JSON.stringify({ values })
                 })
                     .then(response => response.json())
                     .then(data => console.log(data))
                     .catch(error => console.error('Ошибка:', error));
             });
             document.getElementById('searchInput').addEventListener('input', function() {
                 var searchQuery = this.value.toLowerCase();
                 var selectElement = document.getElementById('mySelect');
                 var options = selectElement.options;

                 for (var i = 0; i < options.length; i++) {
                     var option = options[i];
                     var optionText = option.text.toLowerCase();
                     var isMatch = optionText.indexOf(searchQuery) >= 0;
                     option.style.display = isMatch ? '' : 'none';
                 }
             });
             $(document).ready(function() {
                 $('#tutor').select2();
             });
        </script>
    <!-- <script src="{{ asset('backend/js/toastr.min.js')}}"></script> -->
    <script src="{{ asset('backend/js/sweetalert.min.js') }}"></script>
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <!-- End  Sweet Alert and Toaster notifications -->
</body>
</html>
