@extends('backend.layouts.app')
@section('content')

    @php

        use Illuminate\Support\Facades\DB;

        $product_lists= DB::table('in_product_lists')->get();

    @endphp

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Списание инвентаря</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="myform" role="form" action="{{route('write_off_save')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="tutor">Номер документа</label>
                                            <input type="number" class="form-control" placeholder="Введите номер" name="document_number">
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Тема</label>
                                            <select id="type" name="theme" class="form-control">
                                                <option value="">Выберите тему</option>
                                                <option value="Акт списания">Акт списания</option>
                                                <option value="Утилизация">Утилизация</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Введите дату документа</label>
                                            <input class="form-control" id="date" type="date" name="date">
                                        </div>
                                        <div class="form-group">
                                            <label for="recordSelect">Выберите инвентарные номера</label>
                                            <select id="recordSelect" multiple class="form-control" name="inv_numbers[]">
                                                @foreach($product_lists->where('write_off', 1) as $inv)
                                                    <option value="{{$inv->inv_number}}">{{$inv->inv_number}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fileInput">Загрузите скан-копию документа</label>
                                            <!-- Поле для загрузки файлов -->
                                            <div class="file-upload" id="fileUpload">
                                                <input type="file" id="fileInput" multiple accept=".pdf, .doc, .docx" name="file">
                                                <i style=" font-size: 100px; color: gray; padding-right: 80px" class="fa fa-upload" aria-hidden="true"></i>
                                                <p>Перетащите файлы сюда или нажмите для загрузки</p>
                                            </div>

                                            <!-- Отображение выбранных файлов -->
                                            <div id="fileList" class="file-list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
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
        width: 7rem !important;
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
        height: 200px;
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
        font-size: 30px;
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
