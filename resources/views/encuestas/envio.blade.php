@extends('panelVistaProfesor.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h2>Encuesta personalizada</h2>
            <h5>Profesor / <spand>Asignación</spand></h5>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('encuestaProfesor.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar encuesta..." value="{{ request()->input('search') }}">
        </form>
    </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="error-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
                <div class="alert alert-danger" id="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
    @endif

    <!-- Tabla de encuestas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Objetivo</th>
                    <th>Registro</th>
                    <th>Estado</th>
                    <th>Autor</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @if($encuestas->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron encuestas.</td>
                    </tr>
                @else
                    @foreach($encuestas as $encuesta)
                        <tr>
                            <td>{{ $encuesta->idencuesta }}</td>
                            <td>{{ $encuesta->objetivo }}</td>
                            <td>{{ $encuesta->fechaAplica }}  </td>
                            <!-- Aquí validamos si la encuesta está activa o inactiva -->
                            <td>{{ $encuesta->estadoActivo == 1 ? 'Activo' : 'Inactivo' }}</td>
                            <td>"{{ $encuesta->autor->idUsuario }}" {{ $encuesta->autor->nombre }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-custom-asignar" data-bs-toggle="modal" data-bs-target="#modalAlumnos-{{ $encuesta->idencuesta }}">
                                     Asignar
                                </button>
                            </td>

                        </tr>
                    @endforeach
                 @endif
            </tbody>
        </table>
    </div>
</div>



@foreach($encuestas as $encuesta)
    <div class="modal fade" id="modalAlumnos-{{ $encuesta->idencuesta }}" tabindex="-1" aria-labelledby="modalAlumnosLabel-{{ $encuesta->idencuesta }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlumnosLabel-{{ $encuesta->idencuesta }}">Selecciona a los alumnos:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('asignarEncuesta') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_encuesta" value="{{ $encuesta->idencuesta }}">

                        @foreach($alumnos as $alumno)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="alumnos[]" value="{{ $alumno->idUsuario }}" id="alumno-{{ $alumno->idUsuario }}">
                                <label class="form-check-label" for="alumno-{{ $alumno->idUsuario }}">
                                    {{ $alumno->nombre }} {{ $alumno->apellidoP }} {{ $alumno->apellidoM }}
                                    
                                    @if($alumno->evaluacion->isNotEmpty())
                                        @php
                                            $nivelEstres = $alumno->evaluacion->first()->nivelEstres;
                                            $puntajeTotal = $alumno->evaluacion->first()->puntajeTotal;
                                            $colorClase = '';
                                            if ($nivelEstres === 'Estrés alto') {
                                                $colorClase = 'text-danger';
                                            } elseif ($nivelEstres === 'Estrés medio') {
                                                $colorClase = 'text-warning'; 
                                            }
                                        @endphp
                                        <span class="{{ $colorClase }}"><strong>[{{ $nivelEstres }}, {{$puntajeTotal}}]</strong></span>
                                    @else
                                        <span>(No hay evaluación)</span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Asignar Encuesta</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach





@endsection
