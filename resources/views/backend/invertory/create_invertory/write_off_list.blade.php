@extends('backend.layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- /.card -->
            <div class="card card-primary">
                <div class="card-header info">
                    <h3 class="card-title">Список наименований</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped" style="font-size: 16px !important; table-layout: auto !important;">
                        <thead>
                        <tr>
                            <th>Название инвентаря</th>
                            <th>Инвентарный номер</th>
                            <th>Документ</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                @php
                                    $updated_at = \Carbon\Carbon::parse($result->date);

                                    $formattedDate = $updated_at->format('d.m.Y');
                                @endphp
                                <tr>
                                    <td>{{$result->name_product}}</td>
                                    <td>{{$result->inv_number}}</td>
                                    <td><a href="{{route('doc_view', $result->id)}}" target="_blank">{{$result->theme}} от {{$formattedDate}}, №{{$result->document_number}}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Название инвентаря</th>
                            <th>Инвентарный номер</th>
                            <th>Документ</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
@endsection
