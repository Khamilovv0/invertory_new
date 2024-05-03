@extends('backend.layouts.app')
@section('content')

       <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header info">
                        <h3 class="card-title">Список наименований</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Управление</th>
                                </tr>
                            </thead>
                                <tbody>
                                @foreach($list as $row)
                                    <tr>
                                        <td>{{ $row->id_name }}</td>
                                        <td>{{ $row->name_product }}</td>
                                        <td>
                                            <a href="{{ route('EditCategory', $row->id_name) }}" class="btn btn-sm btn-info">Редактировать</a>
                                            <a href="{{ route('DeleteCategory', $row->id_name) }}" class="btn btn-sm btn-danger" id="delete" class="middle-align">Удалить</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Управление</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
@endsection
