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
                                                <i class="fas fa-arrow-down bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> {{$result->updated_at}}</span>
                                                    <h3 class="timeline-header"><a href="#">Местоположение: {{$result->auditoryName}}</a><br>
                                                        <strong>Ответственное лицо:</strong> &nbsp {{$result->tutor_fullname}}
                                                        <br>
                                                        <strong>Редактор:</strong> &nbsp {{$result->redactor_fullname}}
                                                    </h3>
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
