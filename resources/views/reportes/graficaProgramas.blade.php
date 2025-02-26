<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte por Programa Educativo</title>
    <link href="{{ public_path() . '/css/stylePDF.css' }}" rel="stylesheet">
</head>
<body>

    <div style="text-align:start;">
        <img src="{{ public_path() . '/images/reportes/logo.jpg' }}" alt="Logo" width="100" height="45">
    </div>

    <h3>Reporte por Programa Educativo</h3>
    <p><strong>Rango de Fechas:</strong> {{ $startDate }} - {{ $endDate }}</p>
    <p><strong>Total de Alumnos:</strong> {{ $totalUsuarios }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Programa Educativo</th>
                <th>Nivel</th>
                <th>Alumnos Registrados</th>
                <th>Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programas as $programa)
                <tr>
                    <td>{{ $programa->nombre }}</td>
                    <td>{{ $programa->nivel }}</td>
                    <td>{{ $programa->usuarios_count }}</td>
                    <td>{{ $programa->porcentaje }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
