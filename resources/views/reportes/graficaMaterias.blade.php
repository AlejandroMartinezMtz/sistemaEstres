@extends('panelVista.layout')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5>Gráfica de las Materias Más Seleccionadas (Del {{ $startDate }} al {{ $endDate }})</h5>
            </div>
            <div class="card-body">
                <h6><strong>Total de Materias Seleccionadas:</strong> {{ $topMaterias->sum('total') }}</h6>

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
                    <h6 class="modal-title" id="graficaModalLabel">Gráfica de Materias Más Estresantes</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor de la gráfica -->
                    <div class="contenidoGrafica">
                        <h6><strong>Total de votos:</strong> {{ $topMaterias->sum('total') }}</h6>
                    </div>

                    <!-- Canvas para la gráfica -->
                    <canvas id="materiasChart"></canvas>

                    <!-- Botón para descargar PDF desde el modal -->
                    <button class="btn btn-primary" id="downloadPdfModal">
                        <i class='bx bxs-file-pdf' style="font-size: 25px;"></i> Descargar PDF
                    </button>

                    <!-- Botón para volver -->
                    <a href="{{ route('reportes.index') }}" class="btn btn-primary">  
                        <i class='bx bx-arrow-back' style="font-size: 25px;"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
    
@endsection
