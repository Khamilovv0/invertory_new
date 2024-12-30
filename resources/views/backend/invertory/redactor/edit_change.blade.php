@extends('backend.layouts.app')
@section('content')

    @php

        use Illuminate\Support\Facades\DB;

        $product_name= DB::table('in_product_name')->get();
        $tutor = DB::connection('mysql_platonus')->table('tutors')->get();
        $building = DB::table('buildings')->get();
        $auditories = DB::table('auditories')->get();
        $sortedAuditories = $auditories->sortBy('auditoryName');

    @endphp
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Редактирование</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="myform" role="form" action="{{route('insert', $edit->id_product)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <h5><strong>Местоположение</strong></h5>
                                            <label for="building">Корпус</label>
                                            <select id="building" name="buildingID" class="form-control">
                                                <option value="">Выберите корпус</option>
                                                @foreach($building as $buildingID)
                                                    <option value="{{$buildingID->buildingID}}">{{$buildingID->buildingName}}</option>
                                                @endforeach
                                            </select>
                                            <label for="auditory">Аудитория</label>
                                            <select id="auditory" name="auditoryID" class="form-control">
                                                <option value="">Выберите аудиторию</option>
                                                @foreach($sortedAuditories as $auditory)
                                                    <option value="{{$auditory->auditoryID}}">{{$auditory->auditoryName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="tutor">Ответственное лицо</label>
                                            <select id="tutor" name="TutorID" class="form-control">
                                                <option value="">Выберите ответственное лицо</option>
                                                @foreach($tutor as $tutors)
                                                    <option value="{{$tutors->TutorID}}">{{$tutors->lastname}} {{$tutors->firstname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fileInput">Загрузите скан-копию АКТа приема и передачи</label>
                                            <!-- Поле для загрузки файлов -->
                                            <div class="file-upload" id="fileUpload">
                                                <input type="file" id="fileInput" multiple accept=".pdf, .doc, .docx" name="file">
                                                <i style=" font-size: 20px; color: gray; padding-right: 10px" class="fa fa-upload" aria-hidden="true"></i>
                                                <p>Перетащите файлы сюда или нажмите для загрузки</p>
                                            </div>
                                            <!-- Отображение выбранных файлов -->
                                            <div id="fileList" class="file-list"></div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="inv_number"  class="form-control"
                                                   id="inv_number" placeholder="Введите номер" required readonly hidden value="{{$edit->inv_number}}">
                                        </div>
                                        <div class="form-group">
                                            <select id="id_name" name="id_name" class="form-control" readonly hidden>
                                                <option value="{{$edit->id_name}}">{{$edit->name_product}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select id="type" name="type" class="form-control" readonly hidden>
                                                <option value="{{$edit->type}}">
                                                @if($edit->type == 1)
                                                    Личный
                                                @elseif($edit->type == 2)
                                                    Аудиторный
                                                @endif
                                                </option>
                                            </select>
                                        </div>
                                        @foreach($edit->characteristics as $characteristic)
                                            <div class="form-group">
                                                <input type="text" name="id[]"  class="form-control"
                                                       id="characteristic" required readonly hidden value="{{ $characteristic->id_characteristic }}">
                                                <input type="text" name="names[]"  class="form-control"
                                                       id="characteristic" placeholder="Введите номер" required readonly hidden value="{{ $characteristic->characteristic_value }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
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
    textarea{
        width: 3rem !important;
        height: 1.5rem !important;
        margin-left: 5px !important;
    }
    .select2-container--default{
        width: 100%;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding: 1px 7px !important;
        padding-left: 30px !important;
    }
    .select2-selection__choice__remove{
        padding: 1px 7px !important;
        margin: 0 !important;
    }
    .select2-selection__choice__remove:hover{
        background-color: #0e5b44; !important;
    }
    .file-upload {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 50px;
        border: 2px dashed #aaa;
        border-radius: 8px;
        cursor: pointer;
        background-color: #f9f9f9;
        transition: background-color 0.3s;
        text-align: center;
        position: relative;
    }

    .file-upload:hover {
        background-color: #f0f0f0;
    }

    .file-upload p {
        font-size: 20px;
        color: #555;
        margin: 0;
        pointer-events: none;
    }

    .file-upload input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-list {
        margin-top: 20px;
        width: 100%;
        max-width: 500px;
        color: #333;
    }

    .file-list p {
        font-size: 16px;
        margin: 5px 0;
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 4px;
    }
</style>

<script>
    // script.js
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        const fileUpload = document.getElementById('fileUpload');

        // Обработчик выбора файлов
        fileInput.addEventListener('change', displayFiles);

        // Обработка события перетаскивания файлов
        fileUpload.addEventListener('dragover', function (e) {
            e.preventDefault();
            fileUpload.classList.add('dragging');
        });

        fileUpload.addEventListener('dragleave', function () {
            fileUpload.classList.remove('dragging');
        });

        fileUpload.addEventListener('drop', function (e) {
            e.preventDefault();
            fileUpload.classList.remove('dragging');
            const files = e.dataTransfer.files;
            displayFiles({ target: { files } });
        });

        // Функция для отображения списка загруженных файлов
        function displayFiles(event) {
            fileList.innerHTML = ''; // Очистка списка перед добавлением новых файлов
            const files = event.target.files;

            for (const file of files) {
                const fileItem = document.createElement('p');
                fileItem.textContent = `Имя файла: ${file.name}, Размер: ${(file.size / 1024).toFixed(2)} KB`;
                fileList.appendChild(fileItem);
            }
        }
    });

</script>
