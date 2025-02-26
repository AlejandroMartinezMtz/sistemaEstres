@extends('panelVistaProfesor.layout')

@section('content')
<div class="container">
    <h2>Crear nueva encuesta</h2>

    <form action="{{ route('encuestaProfesor.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Token de protección contra CSRF -->

        <div class="mb-3">
            <label for="objetivo" class="form-label">Objetivo</label>
            <textarea class="form-control" id="objetivo" name="objetivo" rows="4" required>{{ old('objetivo') }}</textarea>
        </div>



        <div class="mb-3">
    <label for="preguntas" class="form-label">Preguntas</label>
    <div id="preguntas-container">
        <div class="d-flex mb-2">
            <input type="text" class="form-control" name="preguntas[new_0][texto]" placeholder="Escribe tu pregunta" required>

            <button type="button" class="btn btn-danger ms-2" onclick="eliminarPreguntaEncuesta(0)">Eliminar</button>
        </div>
    </div>
    <button type="button" class="btn btn-primary" onclick="nuevaPreguntaEncuesta()">Agregar Pregunta</button>
</div>

    
        <div class="mb-3">
        <label for="estadoActivo" class="form-label">Estado</label>
            <select class="form-select" id="estadoActivo" name="estadoActivo" required>
                <option value="1">Activo</option>
                <option value="0" selected>Inactivo</option>
            </select>
        </div>

       
        <!-- Campo que solo aparece si es activo -->
        <div class="mb-3">
            <div id="programa_educativo" style="display: none;">
                <label for="alumnos" class="form-label">Seleccioná a los alumnos: </label>
            <div id="alumnos-list">
                @foreach($alumnosCreados as $alumnoCreado)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="alumnos[]" value="{{ $alumnoCreado->usuarioAlumno->idUsuario }}">
                        <label class="form-check-label" for="alumno{{ $alumnoCreado->usuarioAlumno->idUsuario }}">
                            {{ $alumnoCreado->usuarioAlumno->nombre }} {{ $alumnoCreado->usuarioAlumno->apellidoP }} {{ $alumnoCreado->usuarioAlumno->apellidoM }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>



        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Crear encuesta</button>
            <a href="{{ route('encuestaProfesor.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
       
    </form>
</div>



<script>
    let preguntaIndex = 0; // Mantén un contador para nuevas preguntas

function nuevaPreguntaEncuesta() {
    preguntaIndex++;
    const container = document.getElementById('preguntas-container');
    const nuevaPregunta = `
        <div class="d-flex mb-2" id="pregunta_${preguntaIndex}">
            <input type="text" class="form-control" name="preguntas[new_${preguntaIndex}][texto]" placeholder="Nueva pregunta" required>

            <button type="button" class="btn btn-danger ms-2" onclick="eliminarPreguntaEncuesta(${preguntaIndex})">Eliminar</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', nuevaPregunta);
}

function eliminarPreguntaEncuesta(index) {
    const preguntaDiv = document.getElementById(`pregunta_${index}`);
        if (preguntaDiv) {
            preguntaDiv.remove();
            // Comprobar si hay preguntas restantes, si no, permitir agregar una nueva
            if (document.querySelectorAll('#preguntas-container .d-flex').length === 0) {
                nuevaPreguntaEncuesta(); // Permite agregar una nueva pregunta si no quedan
            }
        }
}


</script>


@endsection
