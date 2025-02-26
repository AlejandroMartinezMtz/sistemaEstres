@extends('vistaReporte.layout')

@section('content')

<div style="background-color: #78cfbc; border-radius: 3; color: white; text-align:center; padding-bottom: 0.5rem" class="d-flex align-items-center ">
    <div class="d-flex align-items-center">
        <h2 class="mb-0">Reporte de Cuestionarios Contestados</h2>
    </div>
    <p class="mb-0" style="color: black;">{{ $startDate ?? 'Sin fecha' }} - {{ $endDate ?? 'Sin fecha' }}</p>
</div>

<br>

<div class="container mt-4" style="margin: auto; max-width: 80%;">
    @if($cuestionarios->isEmpty())
        <p>No se encontraron cuestionarios en el rango de fechas seleccionado.</p>
    @else
        <!-- Gráficos -->
        <canvas id="stressChart" width="400" height="200"
        data-stress-data='@json(array_values($stressData))'
        data-stress-labels='@json(array_keys($stressData))'></canvas>
        

        <!-- Tabla de Cuestionarios -->
        <table class="table table-bordered text-center" style="border: 1px solid black; width: 100%; margin: auto;">
            <thead>
                <tr>
                    <th style="border: 1px solid black;">ID</th>
                    <th style="border: 1px solid black;">Usuario</th>
                    <th style="border: 1px solid black;">Puntaje Total</th>
                    <th style="border: 1px solid black;">Nivel de Estrés</th>
                    <th style="border: 1px solid black;">Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuestionarios as $cuestionario)
                    <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#f8f9fa' : '#e0f7fa' }};">
                        <td style="border: 1px solid black;">{{ $cuestionario->usuario->idUsuario }}</td>
                        <td style="border: 1px solid black;">{{ $cuestionario->usuario->nombre }}</td>
                        <td style="border: 1px solid black;">{{ $cuestionario->puntajeTotal }}</td>
                        <td style="border: 1px solid black;">{{ $cuestionario->nivelEstres }}</td>
                        <td style="border: 1px solid black;">{{ $cuestionario->fechaRegistro }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
