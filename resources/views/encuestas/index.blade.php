@extends('panelVistaProfesor.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h2>Encuestas</h2>
            <h5>Profesor / <spand>Encuestas</spand></h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('encuestaProfesor.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i> Agregar</a>
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
        <table class="table tableEncuestas table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Objetivo</th>
                    <th>Registro</th>
                    <th>Estado</th>
                    <th>Autor</th>
                    <th>Acciones</th>
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
                                <a href="{{ route('encuestaProfesor.edit', $encuesta->idencuesta) }}" class="btn btn-sm btn-custom-edit"><i class="bi bi-pencil"></i> Editar</a>

                                <form action="{{ route('encuestaProfesor.destroy', $encuesta->idencuesta) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta encuesta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-custom-delete"><i class="bi bi-trash"></i> Eliminar</button>
                                </form>

                                <td>
                                <button type="button" class="btn btn-sm btn-custom-verCuestionario" data-bs-toggle="modal" data-bs-target="#modalEncuesta-{{ $encuesta->idencuesta }}">
                                    <i class="bi bi-eye"></i> Ver Preguntas
                                </button>

                                
                                <button type="button" class="btn btn-sm btn-custom-verAlumnos" data-bs-toggle="modal" data-bs-target="#modalAlumnos-{{ $encuesta->idencuesta }}">
                                    <i class="bi bi-eye"></i> Ver Alumnos
                                </button>
                                </td>
                            </td>

                        </tr>
                    @endforeach
                 @endif
            </tbody>
        </table>
    </div>
</div>


@foreach($encuestas as $encuesta)
    <!-- Modal -->
    <div class="modal fade" id="modalEncuesta-{{ $encuesta->idencuesta }}" tabindex="-1" aria-labelledby="modalEncuestaLabel-{{ $encuesta->idencuesta }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEncuestaLabel-{{ $encuesta->idencuesta }}">{{ $encuesta->fechaAplica }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Descripción: {{ $encuesta->objetivo }}</h6>
                    <h6>Preguntas:</h6>
                    <ul>
                        @foreach($encuesta->preguntas as $pregunta)
                            @if($pregunta->estadoActivo !== 0)
                                <li>{{ $pregunta->textoPregunta }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach




@foreach($encuestas as $encuesta)
    <div class="modal fade" id="modalAlumnos-{{ $encuesta->idencuesta }}" tabindex="-1" aria-labelledby="modalAlumnosLabel-{{ $encuesta->idencuesta }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlumnosLabel-{{ $encuesta->idencuesta }}">Alumnos que respondieron la encuesta:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($encuesta->alumnos->isEmpty())
                        <p class="text-center text-muted">Ningún alumno ha respondido esta encuesta aún.</p>
                    @else
                        <ul>
                            @foreach($encuesta->alumnos as $alumno)
                                <li>
                                    {{ $alumno->alumno->nombre }}
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalRespuestasAlumno-{{ $alumno->idEncuestaAlumno }}" data-id="{{ $alumno->idEncuestaAlumno }}">
                                        Ver Respuestas
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach



@foreach($encuestas as $encuesta)
    @foreach($encuesta->alumnos as $alumno)
        <div class="modal fade" id="modalRespuestasAlumno-{{ $alumno->idEncuestaAlumno }}" tabindex="-1" aria-labelledby="modalRespuestasAlumnoLabel-{{ $alumno->idEncuestaAlumno }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRespuestasAlumnoLabel-{{ $alumno->idEncuestaAlumno }}">Respuestas del alumno: {{ $alumno->alumno->nombre }} {{ $alumno->alumno->apellidoP }} {{ $alumno->alumno->apellidoM }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach($encuesta->preguntas as $pregunta)
                            <div class="mb-3 border rounded p-3">
                                <label class="fw-bold">{{ $pregunta->textoPregunta }}</label>
                                <div class="mt-2">
                                    @php
                                        $respuesta = $pregunta->respuestas()->where('fk_idUsuario', $alumno->alumno->idUsuario)->first();
                                    @endphp
                                    <div>
                                        @if($respuesta)
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta }}][{{ $alumno->alumno->idUsuario }}]" value="1" {{ $respuesta->valor_respuesta == 1 ? 'checked' : '' }} disabled> Nunca
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta }}][{{ $alumno->alumno->idUsuario }}]" value="2" {{ $respuesta->valor_respuesta == 2 ? 'checked' : '' }} disabled> Alguna vez
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta }}][{{ $alumno->alumno->idUsuario }}]" value="3" {{ $respuesta->valor_respuesta == 3 ? 'checked' : '' }} disabled> Bastantes veces
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta }}][{{ $alumno->alumno->idUsuario }}]" value="4" {{ $respuesta->valor_respuesta == 4 ? 'checked' : '' }} disabled> Muchas veces
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta }}][{{ $alumno->alumno->idUsuario }}]" value="5" {{ $respuesta->valor_respuesta == 5 ? 'checked' : '' }} disabled> Siempre
                                        @else
                                            <p>No hay respuesta disponible.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="mt-4">
                            <strong>Comentario del Alumno:</strong>
                            <p>{{ $alumno->comentario }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach


@endsection
