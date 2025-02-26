@extends('panelVistaProfesor.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h2>Cuestionarios</h2>
            <h5>Profesor / <spand>Cuestionarios</spand></h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('cuestionarioProfesor.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i> Agregar</a>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('cuestionarioProfesor.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar cuestionario..." value="{{ request()->input('search') }}">
        </form>

    </div>
    </div>




    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="error-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabla de cuestionarios -->
    <div class="table-responsive">
        <table class="table tableCuestionarios table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Descripción</th>
                    <th>Registro</th>
                    <th>Estado</th>
                    <th>Puntaje</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                    <th>Opciones</th>
                    <th>Enviar</th>
                </tr>
            </thead>
            <tbody>
                @if($cuestionarios->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">No se encontraron cuestionarios.</td>
                    </tr>
                @else
                    @foreach($cuestionarios as $cuestionario)
                        <tr>
                            <td>{{ $cuestionario->idCuestionario }}</td>
                            <td>{{ $cuestionario->titulo }}</td>
                            <td>{{ $cuestionario->descripcion }}</td>

                            <td>{{ $cuestionario->fechaRegistro }}</td>

                             <!-- Aquí validamos si el custionario está activo o inactivo -->
                             <td>{{ $cuestionario->estadoActivo == 1 ? 'Activo' : 'Inactivo' }}</td>
                            <td>{{ $cuestionario->puntajeMaximo }}</td>
                            <td>"{{ $cuestionario->autor->idUsuario }}" {{ $cuestionario->autor->nombre }}</td>
                            
                            <td>
                                <a href="{{ route('cuestionarioProfesor.edit', $cuestionario->idCuestionario) }}" class="btn btn-sm btn-custom-edit"><i class="bi bi-pencil"></i> Editar</a>

                                <form action="{{ route('cuestionarioProfesor.destroy', $cuestionario->idCuestionario) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cuestionario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-custom-delete"><i class="bi bi-trash"></i> Eliminar</button>
                                </form>
                            </td>

                            <td>
                                
                            <button type="button" class="btn btn-sm btn-custom-verCuestionario" data-bs-toggle="modal" data-bs-target="#modalCuestionario-{{ $cuestionario->idCuestionario }}">
                                    <i class="bi bi-eye"></i> Ver Preguntas
                                </button>

                            
                                    <button type="button" class="btn btn-sm btn-custom-verAlumnos" data-bs-toggle="modal" data-bs-target="#modalAlumnos-{{ $cuestionario->idCuestionario }}">
                                        <i class="bi bi-eye"></i> Ver Alumnos
                                    </button>
                                
                            </td>
                         
                            <td>
                                <button type="button" class="btn btn-sm btn-custom-asignar" data-id="{{ $cuestionario->idCuestionario }}" data-bs-toggle="modal" data-bs-target="#modalSeleccionarAlumnos">
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


@foreach($cuestionarios as $cuestionario)
    <!-- Modal -->
    <div class="modal fade" id="modalCuestionario-{{ $cuestionario->idCuestionario }}" tabindex="-1" aria-labelledby="modalCuestionarioLabel-{{ $cuestionario->idCuestionario }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCuestionarioLabel-{{ $cuestionario->idCuestionario }}">{{ $cuestionario->titulo }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Descripción: {{ $cuestionario->descripcion }}</h6>
                    <h6>Preguntas:</h6>
                    <ul>
                        @foreach($cuestionario->preguntas as $pregunta)
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


@foreach($cuestionarios as $cuestionario)
    <!-- Modal con las respuestas de cada alumno -->
    <div class="modal fade" id="modalAlumnos-{{ $cuestionario->idCuestionario }}" tabindex="-1" aria-labelledby="modalAlumnosLabel-{{ $cuestionario->idCuestionario }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlumnosLabel-{{ $cuestionario->idCuestionario }}">
                        Alumnos que respondieron el cuestionario: {{ $cuestionario->titulo }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($cuestionario->alumnos->isEmpty())
                        <p class="text-center text-muted">Ningún alumno ha respondido este cuestionario aún.</p>
                    @else
                        <ul>
                            @foreach($cuestionario->alumnos as $alumno)
                                <li>
                                    {{ $alumno->alumno->nombre }} {{ $alumno->alumno->apellidoP }} {{ $alumno->alumno->apellidoM }}
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalRespuestasAlumno-{{ $alumno->idCuestionarioAlumno }}">
                                        Ver Respuestas
                                    </button>
                                    <p></p>
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


@foreach($cuestionarios as $cuestionario)
    @foreach($cuestionario->alumnos as $alumno)
        <div class="modal fade" id="modalRespuestasAlumno-{{ $alumno->idCuestionarioAlumno }}" tabindex="-1" aria-labelledby="modalRespuestasAlumnoLabel-{{ $alumno->idCuestionarioAlumno }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRespuestasAlumnoLabel-{{ $alumno->idCuestionarioAlumno }}">
                            Respuestas del alumno: {{ $alumno->alumno->nombre }} {{ $alumno->alumno->apellidoP }} {{ $alumno->alumno->apellidoM }}
                            {{$alumno->idCuestionarioAlumno}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach($cuestionario->preguntas as $pregunta)
                            <div class="mb-3 border rounded p-3">
                                <label class="fw-bold">{{ $pregunta->textoPregunta }}</label>
                                <div class="mt-2">
                                    @php
                                        $respuesta = $pregunta->respuestas()->where('fk_usuario', $alumno->alumno->idUsuario)->first();
                                    @endphp
                                    <div>
                                        @if($respuesta)
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}][{{ $alumno->alumno->idUsuario }}]" value="1" {{ $respuesta->valor_respuesta == 1 ? 'checked' : '' }} disabled> Nunca
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}][{{ $alumno->alumno->idUsuario }}]" value="2" {{ $respuesta->valor_respuesta == 2 ? 'checked' : '' }} disabled> Alguna vez
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}][{{ $alumno->alumno->idUsuario }}]" value="3" {{ $respuesta->valor_respuesta == 3 ? 'checked' : '' }} disabled> Bastantes veces
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}][{{ $alumno->alumno->idUsuario }}]" value="4" {{ $respuesta->valor_respuesta == 4 ? 'checked' : '' }} disabled> Muchas veces
                                            <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}][{{ $alumno->alumno->idUsuario }}]" value="5" {{ $respuesta->valor_respuesta == 5 ? 'checked' : '' }} disabled> Siempre
                                        @else
                                            <p>No hay respuesta disponible.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach



<!-- Modal con lista de alumnos -->
<div class="modal fade" id="modalSeleccionarAlumnos" tabindex="-1" aria-labelledby="modalSeleccionarAlumnos" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSeleccionarAlumnos">Seleccionar Alumnos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('profesor.asignarCuestionario') }}" method="POST">
                    @csrf

                    <input type="hidden" name="fk_idCuestionario" id="cuestionarioId">
                    
                    <div class="list-group">
                        <div class="list-group-item">
                            <input type="checkbox" id="selectAllAlumnos">
                            <label for="selectAllAlumnos">Seleccionar todos</label>
                        </div>

                        @foreach($alumnos as $programa => $niveles)
                            <h5>{{ $programa }}</h5> 

                            @foreach($niveles as $nivel => $grupoAlumnos)
                                <h6>Nivel: {{ $nivel }}</h6>

                                <div class="list-group-item">
                                    <input type="checkbox" class="selectAllNivel" id="selectAllNivel-{{ $nivel }}" data-nivel="{{ $nivel }}">
                                    <label for="selectAllNivel-{{ $nivel }}">Seleccionar todos en este nivel</label>
                                    <br>
                                </div>

                                @foreach($grupoAlumnos as $alumno)
                                    <div class="list-group-item">
                                        <input type="checkbox" name="alumnos[]" value="{{ $alumno->idUsuario }}" class="alumno-checkbox nivel-{{ $nivel }}" id="alumno-{{ $alumno->idUsuario }}">
                                        <label for="alumno-{{ $alumno->idUsuario }}">
                                            {{ $alumno->nombre }} {{ $alumno->apellidoP }} {{ $alumno->apellidoM }}
                                        </label>
                                    </div>
                                @endforeach

                            @endforeach

                        @endforeach
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Asignar Cuestionario</button>
            </div>
            </form>
        </div>
    </div>
</div>



<script>
     document.querySelectorAll('.btn-custom-asignar').forEach(function(button) {
        button.addEventListener('click', function() {
            var cuestionarioId = this.getAttribute('data-id');
            document.getElementById('cuestionarioId').value = cuestionarioId;
        });
    });

    document.getElementById('selectAllAlumnos').addEventListener('change', function() {
        let isChecked = this.checked;
        let alumnoCheckboxes = document.querySelectorAll('input[name="alumnos[]"]');
        alumnoCheckboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });


    document.querySelectorAll('.selectAllNivel').forEach(function(selectNivel) {
        selectNivel.addEventListener('change', function() {
            let nivel = this.getAttribute('data-nivel');
            let isChecked = this.checked;
            let alumnoCheckboxesNivel = document.querySelectorAll('.nivel-' + nivel);
            alumnoCheckboxesNivel.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
    });
</script>


@endsection
