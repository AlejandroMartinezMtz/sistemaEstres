@extends('panelVistaProfesor.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h2>Envío de recomendaciones</h2>
            <h5>Profesor / <spand>envío</spand></h5>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('envioRecomendacion.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar alumno..." value="{{ request()->input('search') }}">
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
        <table class="table tableMaterialAsignado table-bordered table-striped">
            <thead>
                <tr>
                <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Personal</th>
                    <th>Correo Institucional</th>
                    <th>Matrícula</th>
                    <th>Nivel de estres</th>
                    <th>Puntaje Total</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @if($alumnos->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No se encontraron alumnos.</td>
                    </tr>
                @else
                @foreach($alumnos as $usuario)
                <tr>
                    <td>{{ $usuario->idUsuario }}</td>
                    <td>{{ $usuario->nombre }} {{ $usuario->apellidoP }} {{ $usuario->apellidoM }}</td>
                    <td>{{ $usuario->correoPersonal }}</td>
                    <td>{{ $usuario->correoInstitucional }}</td>
                    <td>{{ $usuario->matricula }}</td>
                    <td>{{ optional($usuario->evaluacion->first())->nivelEstres }}</td>
                    <td>{{ optional($usuario->evaluacion->first())->puntajeTotal }}</td>
                    <td>
                    <button type="button" class="btn btn-custom-asignar" data-bs-toggle="modal" data-bs-target="#modalAsignar-{{ $usuario->idUsuario }}">
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



@foreach($alumnos as $alumno)
    <div class="modal fade" id="modalAsignar-{{ $alumno->idUsuario }}" tabindex="-1" aria-labelledby="modalAsignarLabel-{{ $alumno->idUsuario }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAsignarLabel-{{ $alumno->idUsuario }}">Asignar Ejercicios y Pasatiempos a {{ $alumno->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Mostrar ejercicios y pasatiempos asignados previamente -->
                    <h6>Ejercicios favoritos</h6>
                    @if($alumno->ejerciciosSeleccionados && !$alumno->ejerciciosSeleccionados->isEmpty())
                        @foreach($alumno->ejerciciosSeleccionados as $seleccion)
                            <div>{{ $seleccion->ejercicio->nombre }}</div>
                        @endforeach
                    @else
                        <div>No se ha seleccionado ningún ejercicio.</div>
                    @endif

                    <h6>Pasatiempos Favoritos</h6>
                    @if($alumno->pasatiemposSeleccionados && !$alumno->pasatiemposSeleccionados->isEmpty())
                        @foreach($alumno->pasatiemposSeleccionados as $seleccion)
                            <div>{{ $seleccion->pasatiempo->nombre }}</div>
                        @endforeach
                    @else
                        <div>No se ha seleccionado ningún pasatiempo.</div>
                    @endif

                    <!-- Formulario para asignar más recursos -->
                    <form action="{{ route('asignarMaterial.index') }}" method="POST">
                        @csrf
                        <input type="hidden" name="idUsuario_alumno" value="{{ $alumno->idUsuario }}">
                        <input type="hidden" name="idUsuario_profesor" value="{{ auth()->user()->idUsuario }}">

                        <!-- Seleccionar ejercicios -->
                        <div class="mb-3">
                            <br>
                            <label for="ejercicios-{{ $alumno->idUsuario }}" class="form-label">Seleccionar Ejercicios</label>
                            <select name="ejercicios[]" id="ejercicios-{{ $alumno->idUsuario }}" class="form-select" multiple>
                                @foreach($ejercicios as $ejercicio)
                                    @if($alumno->ejerciciosSeleccionados->contains('idEjercicio', $ejercicio->idEjercicio))
                                        <option value="{{ $ejercicio->idEjercicio }}" selected>{{ $ejercicio->nombre }}</option>
                                    @else
                                        <option value="{{ $ejercicio->idEjercicio }}">{{ $ejercicio->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Seleccionar pasatiempos -->
                        <div class="mb-3">
                            <label for="pasatiempos-{{ $alumno->idUsuario }}" class="form-label">Seleccionar Pasatiempos</label>
                            <select name="pasatiempos[]" id="pasatiempos-{{ $alumno->idUsuario }}" class="form-select" multiple>
                                @foreach($pasatiempos as $pasatiempo)
                                    @if($alumno->pasatiemposSeleccionados->contains('idPasatiempo', $pasatiempo->idPasatiempo))
                                        <option value="{{ $pasatiempo->idPasatiempo }}" selected>{{ $pasatiempo->nombre }}</option>
                                    @else
                                        <option value="{{ $pasatiempo->idPasatiempo }}">{{ $pasatiempo->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Asignar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach





@endsection
