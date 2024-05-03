@extends('backend.layouts.app')
@section('content')

    @php
    use Illuminate\Support\Facades\DB;

    $property_list = DB::table('in_list_characteristics')->get();
    $category_list = DB::table('in_product_name')->get();

     @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Синхронизация данных</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- form start -->
                            <form action="{{ route('synchronize_complete') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="category">Выберите товар</label>
                                    <select id="category" name="id_name" class="form-control">
                                        @foreach($category_list as $category)
                                            <option name="id_name" value="{{$category->id_name}}">{{$category->name_product}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label> Выберите свойства</label>
                                    @foreach($property_list as $property)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$property->id_characteristic}}" name="properties[]">
                                            <label class="form-check-label">{{$property->name_characteristic}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success">Синхронизировать</button>
                            </form>
                            <!-- /.card -->
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Свойства</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $row)
                                    <tr>
                                        <td>{{$row->id_product_characteristic}}</td>
                                        <td>{{ $row->in_product_name->name_product }}</td>
                                        <td>{{ $row->in_list_characteristics->name_characteristic }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Свойства</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

@endsection
