@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Tareas</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <a href="{{route('task_create')}}" class="btn btn-success btn-icon-text text-white mb-2 mb-md-0"/>
                <i class="btn-icon-prepend" data-feather="plus"></i>
                    Nueva Tarea
                </a>
            </div>
        </div>

        @if (session('prohibido'))
            <div class="col-lg-12 mt-4">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Ouch!</strong> No tienes acceso a ver el registro de esta tarea.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            {{session(['prohibido' => false])}}
        @endif

        <div class="mt-4 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive mb-5">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre Tarea</th>
                                <th>Encargado Tarea</th>
                                <th>Fecha maxima de ejecución</th>
                                <th>Creada el</th>
                                <th>Ultima Actualización</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr class="{{ $task->expired() ? 'bg-renew text-white':'' }}">
                                    <td>{{ $task->id }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->encargado->name }}</td>
                                    <td>{{ $task->limit_date }}</td>
                                    <td>{{ $task->created_at }}</td>
                                    <td>{{ $task->updated_at }}</td>
                                    <td>
                                        @if(Auth::user()->id == $task->user_id)
                                            <a onclick="eliminarTarea(this)" url="{{ route('task_delete', $task) }}" type="button" class="btn btn-danger text-white btn-icon mb-2">
                                                <i data-feather="trash"></i>
                                            </a>

                                            <a href="{{route('task_update', $task)}}" type="button" class="btn btn-warning text-white btn-icon mb-2">
                                                <i data-feather="edit"></i>
                                            </a>

                                            <a href="{{route('log', $task)}}" type="button" class="btn btn-info text-white btn-icon mb-2">
                                                <i data-feather="file-text"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <form id="deleteForm" hidden action="" method="POST">
        @method('DELETE')
        @csrf
        <button type="submit" id="deleteButtonForm"></button>
    </form>
@endsection

@section('script')
    <script>
        function eliminarTarea(element) {
            Swal.fire({
                title: 'Estas seguro que deseas borrar esta tarea?',
                text: "No podrás revertir esta decisión",
                icon: 'warning',
                showCancelButton: true,
                customClass:{
                    confirmButton: 'mr-2',
                    cancelButton: ''
                },
                confirmButtonText: 'Si, Borrar!',
                cancelButtonText: 'No!'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Borrando',
                        'Borrando tarea!.',
                        'success'
                    );
                    var form = document.getElementById('deleteForm');
                    form.action = element.getAttribute('url');
                    document.getElementById('deleteButtonForm').click();
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Acción cancelada',
                        'La tarea esta intacta :)',
                        'error'
                    )
                }
            });
        }
    </script>
@endsection
