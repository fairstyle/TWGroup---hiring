@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Registros</h4>
            </div>
        </div>

        <div class="mt-4 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="mb-5">
                        <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{route('logs_created', $task)}}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Comentario</label>
                                <div class="col-10">
                                    <input class="form-control" name="coment" id="coment" type="textarea" placeholder="Nombre" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 col-6 mx-auto mt-4">
                                <button type="submit" class="btn btn-success btn-block btn-icon-text">
                                    <i class="btn-icon-prepend" data-feather="save"></i>
                                    Crear Registro
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
