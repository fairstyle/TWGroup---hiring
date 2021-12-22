@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Registros</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <a class="btn btn-success btn-icon-text text-white mb-2 mb-md-0" href="{{route('logs_create', $task)}}"/>
                <i class="btn-icon-prepend" data-feather="plus"></i>
                    Nuevo Registro
                </a>
            </div>
        </div>

        @if (session('task_created'))
            <div class="col-lg-12 mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Genial!</strong> Generaste una tarea, ahora agrega un par de registros.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            {{session(['task_created' => false])}}
        @endif

        @if (session('log_created'))
            <div class="col-lg-12 mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Genial!</strong> Generaste un registro a la tarea.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            {{session(['log_created' => false])}}
        @endif

        <div class="mt-4 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive mb-5">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tarea id</th>
                                    <th>Comentario</th>
                                    <th>Creado el</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->task_id }}</td>
                                    <td>{{ $log->coment }}</td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
