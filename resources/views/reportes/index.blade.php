@extends('panelVista.layout')


@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="error-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-message">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="pad">
        <h3>Reportes</h3>
        <div class="mb-4">
            <label for="dateRange" class="form-label">Seleccionar Rango de Fechas:</label>
            <input type="text" class="form-control" id="dateRange" placeholder="Selecciona el rango de fechas" />
        </div>
    </div>


<div class="row pad">
    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/cuestionarioContestado.png" class="card-img-top" alt="Reporte 1">
            <div class="card-body text-center">
                <h6 class="card-title">Cuestionarios contestados</h6>
                <button id="generateCuestionario" class="btn btn-primary">Ver Reporte</button>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/encuestaContestada.png" class="card-img-top" alt="Reporte 2">
            <div class="card-body text-center">
                <h6 class="card-title">Encuestas contestadas</h6>
                <button id="generateEncuesta" class="btn btn-primary">Ver Reporte</button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/materiaEstresante.png" class="card-img-top" alt="Reporte 3">
            <div class="card-body text-center">
                <h6 class="card-title">Materias más estresantes</h6>
                <button id="generateMateria" class="btn btn-primary">Ver Reporte</button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/mejorEjercicio.png" class="card-img-top" alt="Reporte 4">
            <div class="card-body text-center">
                <h6 class="card-title">Top 5 ejercicios</h6>
                <button id="generateEjercicio" class="btn btn-primary">Ver Reporte</button>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/antesDespues.png" class="card-img-top" alt="Reporte 5">
            <div class="card-body text-center">
                <h6 class="card-title">Cuestionarios antes y después</h6>
                <button id="generateMomentosCuestionario" class="btn btn-primary">Ver Reporte</button>
            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/intervencionPer.png" class="card-img-top" alt="Reporte 6">
            <div class="card-body text-center">
                <h6 class="card-title">Intervenciones personalizadas</h6>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectAlumnoModal">
                    Ver Reporte
                </button>

            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/programaEducativo.png" class="card-img-top" alt="Reporte 7">
            <div class="card-body text-center">
                <h6 class="card-title progra">Programas educativos</h6>
                <button id="generateProgramas" class="btn btn-primary">Ver Reporte</button>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card mb-4">
            <img src="/images/reportes/mejorPasatiempo.png" class="card-img-top" alt="Reporte 8">
            <div class="card-body text-center">
                <h6 class="card-title progra">Top 5 pasatiempos</h6>
                <button id="generatePasatiempo" class="btn btn-primary">Ver Reporte</button>
            </div>
        </div>
    </div>
</div>






<!-- Modal de selección de alumno -->
<div class="modal" id="selectAlumnoModal" tabindex="-1" aria-labelledby="selectAlumnoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectAlumnoModalLabel">Seleccionar Alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select id="alumnoSelect" class="form-select">
                    @foreach ($alumnos as $alumno)
                        <option value="{{ $alumno->idUsuario }}">{{ $alumno->nombre }} {{ $alumno->apellidoP }} {{ $alumno->apellidoM }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="viewReporte">Ver Reporte</button>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/reportes.js') }}" defer></script>
@endsection