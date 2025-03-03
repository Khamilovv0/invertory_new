@extends('backend.layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header info">
                    <h3 class="card-title">История перемещения</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <section class="content">
                        <div class="container-fluid">

                            <!-- Timelime example  -->
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- The time line -->
                                    <div class="timeline">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-green">Перемещения</span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        @foreach($results as $result)
                                            <div>
                                                @php
                                                    $updated_at = \Carbon\Carbon::parse($result->updated_at);

                                                    $formattedDate = $updated_at->format('d.m.Y H:m');
                                                @endphp
                                                <i class="fas fa-arrow-down bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> {{$formattedDate}}</span>
                                                    <h3 class="timeline-header"><a href="#">Местоположение: {{$result->auditoryName}}</a><br>
                                                        <strong>Ответственное лицо:</strong> &nbsp {{$result->tutor_fullname}}
                                                        <br>
                                                        <strong>Редактор:</strong> &nbsp {{$result->redactor_fullname}}
                                                    </h3>
                                                    @if(!empty($result->id)) <!-- Проверка на наличие id -->
                                                    <p style="font-weight: 800; padding: 5px;"><a href="{{route('move_view', $result->id)}}" target="_blank">Акт приема и передачи</a></p>
                                                    @else
                                                        <p style="font-weight: 800; padding: 5px; color: #0d6efd">Документ отсутствует</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- END timeline item -->
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.timeline -->
                    </section>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
