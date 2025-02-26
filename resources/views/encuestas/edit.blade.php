@extends('panelVistaProfesor.layout')

@section('content')
<div class="container">
    <h2>Editar encuesta</h2>

   <form action="{{ route('encuestaProfesor.update', $encuestas->idencuesta) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Cambia el método a PUT para actualizar -->

        <div class="mb-3">
            <label for="objetivo" class="form-label">Objetivo</label>
            <textarea class="form-control" id="objetivo" name="objetivo" rows="4" required>{{ $encuestas->objetivo }}</textarea>
        </div>




        <div class="mb-3">
        <label for="preguntas" class="form-label">Preguntas</label>
        <div id="preguntas-container">
         @foreach($encuestas->preguntas as $pregunta)
            @if($pregunta->estadoActivo !== 0)
                <div class="d-flex mb-2">
                    <input type="text" class="form-control" name="preguntas[{{ $pregunta->idPreguntaEncuesta }}][texto]" value="{{ $pregunta->textoPregunta }}" required>
                        <label class="form-check-label ms-2">
                            <input type="checkbox" name="preguntas[{{ $pregunta->idPreguntaEncuesta }}][eliminar]" value="1"> Eliminar
                        </label>
                </div>
            @endif
        @endforeach
    </div>
    <button type="button" class="btn btn-primary" onclick="agregarPreguntaEncuesta()">Agregar Pregunta</button>
</div>




        <div class="mb-3">
            <label for="estadoActivo" class="form-label">Estado</label>
            <select class="form-select" id="estadoActivo" name="estadoActivo" required>
                <option value="1" {{ $encuestas->estadoActivo == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $encuestas->estadoActivo == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <!-- Mostrar la lista de alumnos -->
        <div id="programa_educativo" style="{{ $encuestas->estadoActivo == 1 ? '' : 'display: none;' }}">
            <label for="alumnos" class="form-label">Selecciona a los alumnos: </label>
            <div id="alumnos-list">
                @foreach($alumnosCreados as $alumnoCreado)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="alumnos[]" value="{{ $alumnoCreado->usuarioAlumno->idUsuario }}" 
                        {{ in_array($alumnoCreado->usuarioAlumno->idUsuario, $encuestas->alumnos->pluck('fk_idAlumno')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="alumno{{ $alumnoCreado->usuarioAlumno->idUsuario }}">
                            {{ $alumnoCreado->usuarioAlumno->nombre }} {{ $alumnoCreado->usuarioAlumno->apellidoP }} {{ $alumnoCreado->usuarioAlumno->apellidoM }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Actualizar encuesta</button>
        <a href="{{ route('encuestaProfesor.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>



<script>
    let preguntaIndex = 0; // Mantén un contador para nuevas preguntas
    function agregarPreguntaEncuesta() {
        preguntaIndex++;
        const container = document.getElementById('preguntas-container');
        const nuevaPregunta = `
            <div class="d-flex mb-2">
                <input type="text" class="form-control" name="preguntas[new_${preguntaIndex}][texto]" placeholder="Nueva pregunta" required>
                <label class="form-check-label ms-2">
                    <input type="checkbox" name="preguntas[new_${preguntaIndex}][eliminar]" value="1"> Eliminar
                </label>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', nuevaPregunta);
    }
</script>
@endsection
