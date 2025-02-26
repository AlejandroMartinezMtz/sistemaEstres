<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Intervenciones Personalizadas</title>
    <link href= "{{public_path() . '/css/stylePDF.css'}}" rel="stylesheet">
    
</head>
<body>

    <div style="text-align:start;">
        <img src="{{ public_path() . '/images/reportes/logo.jpg' }}" alt="Logo" width="100" height="45" class="me-3">
    </div>

    <h3>Reporte de Intervenciones Personalizadas</h3>
    
    <p><strong>Alumno:</strong> {{ $alumno->nombre }} {{ $alumno->apellidoP }} {{ $alumno->apellidoM }}</p>
    <p><strong>Fecha del reporte:</strong> {{ $startDate }} - {{ $endDate }}</p>

    @if ($intervenciones->isEmpty())
        <p class="error">No hay información de este alumno en el rango de fechas seleccionado.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha de Asignación</th>
                    <th>Encuesta Asignada</th>
                    <th>Comentario</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($intervenciones as $intervencion)
                    <tr>
                        <td>{{ $intervencion->fechaAsignacion }}</td>
                        <td>{{ $intervencion->encuesta->objetivo }}</td>
                        <td>{{ $intervencion->comentario }}</td>
                        <td>{{ $intervencion->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
