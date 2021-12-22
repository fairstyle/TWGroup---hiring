@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Tareas</h4>
            </div>
        </div>

        <div class="mt-4 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="mb-5">
                        <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('task_created') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nombre</label>
                                <div class="col-10">
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Nombre" required>
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <label class="col-2 col-form-label">Encargado</label>
                                <div class="col-10">
                                    <input class="form-control" disabled value="{{Auth::user()->email}}" type="text" placeholder="Nombre">
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <label class="col-2 col-form-label">Fecha limite</label>
                                <div class="col-10">
                                    <input class="form-control" name="limit_date" id="limit_date" type="date" placeholder="Fecha limite" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 col-6 mx-auto mt-4">
                                <button type="submit" class="btn btn-success btn-block btn-icon-text">
                                    <i class="btn-icon-prepend" data-feather="save"></i>
                                    Crear tarea
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
