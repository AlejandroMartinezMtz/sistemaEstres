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

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Resumen de Cuestionarios Contestados</h5>
        </div>
        <div class="card-body">
            <p><strong>Total de alumnos:</strong> {{ $totalAlumnos }} </p>
            <p><strong>Alumnos que contestaron:</strong> {{ $alumnosQueContestaron }}</p>
            <p><strong>Porcentaje que contestaron:</strong> {{ number_format($porcentajeContestaron, 2) }}%</p>
            
            <!-- Botón para abrir el modal de la gráfica -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#graficaModal">Ver Gráfica</button>

            <!-- Botón para descargar PDF -->
            <button class="btn btn-primary" id="downloadPdf">Generar PDF</button>
        </div>
    </div>
</div>

<!-- Modal para mostrar la gráfica -->
<div class="modal fade" id="graficaModal" tabindex="-1" aria-labelledby="graficaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="graficaModalLabel">Resumen de Cuestionarios Contestados</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenedor de la gráfica con clase personalizada -->
                 <div class="contenidoGrafica">
                    <h6><strong>Total de alumnos:</strong> {{ $totalAlumnos }}</h6>
                    <h6><strong>Alumnos que contestaron:</strong> {{ $alumnosQueContestaron }}</h6>
                    <h6><strong>Porcentaje que contestaron:</strong> {{ number_format($porcentajeContestaron, 2) }}%</h6>
                </div>
                
                <div class="mb-4">
                    <canvas id="resumenCuestionariosChart"></canvas>
                </div>
                <button class="btn btn-primary" id="downloadPdfModal">
                    <i class='bx bxs-file-pdf' style="font-size: 25px;"></i> Descargar PDF
                </button>

    
                <a href="{{ route('reportes.index') }}" class="btn btn-primary">  
                    <i class='bx bx-arrow-back'style="font-size: 25px;" ></i> Volver
                </a>

            </div>
        </div>
    </div>
</div>


@endsection

