@extends('backend.layouts.app')
@section('content')

    @php

        use Illuminate\Support\Facades\DB;

        $product_name= DB::table('in_product_name')->get();
        $tutor = DB::connection('mysql_platonus')->table('tutors')->get();

    @endphp
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" data-card-widget="collapse" title="Collapse" style="cursor: pointer">Импорт преподавателей</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none;">

                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file">Выберите Excel файл для импорта. Перед этим посмотрите <a href="/assets/documents/template/шаблон_импорта.xlsx">Шаблон</a> импорта.</label>
                                    <br>
                                    <input type="file" name="file" class="form" id="file" accept=".xls, .xlsx">
                                </div>

                                <button class="btn btn-primary btn-sm">Загрузить</button>
                            </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection
