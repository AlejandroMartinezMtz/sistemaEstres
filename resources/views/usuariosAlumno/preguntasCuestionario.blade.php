@extends('panelVistaAlumno.layout')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">{{ $cuestionario->titulo }}</h1>
            <p class="text-center">{{ $cuestionario->descripcion }}</p>

            @if($cuestionario->preguntas->isEmpty())
                <p>No hay preguntas asociadas a este cuestionario.</p>
            @else
                <form action="{{ route('guardarRespuestas') }}" method="POST">
                     <input type="hidden" name="idCuestionario" value="{{ $cuestionario->idCuestionario }}">
                    @csrf
                    @foreach($cuestionario->preguntas as $pregunta)
                        <div class="mb-3 border rounded p-3">
                            <label class="fw-bold">{{ $pregunta->textoPregunta }}</label>
                            <div class="mt-2">
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}]" value="1" required> Nunca
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}]" value="2"> Alguna vez
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}]" value="3"> Bastantes veces
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}]" value="4"> Muchas veces
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaInstrumento }}]" value="5"> Siempre
                            </div>
                        </div>
                    @endforeach
                    @csrf
                    <div class="mb-3 border rounded p-3">
                        <label class="fw-bold">Selecciona tus ejercicios favoritos: </label>
                        @foreach($ejercicios as $ejercicio)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ejercicios[]" value="{{ $ejercicio->idEjercicio }}">
                                <label class="form-check-label" for="{{ $ejercicio->idEjercicio }}">
                                    {{ $ejercicio->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @csrf
                    <div class="mb-3 border rounded p-3">
                        <label class="fw-bold">Selecciona tus pasatiempos favoritos: </label>
                        @foreach($pasatiempos as $pasatiempo)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pasatiempos[]" value="{{ $pasatiempo->idPasatiempo }}">
                                <label class="form-check-label" for="{{ $pasatiempo->idPasatiempo }}">
                                    {{ $pasatiempo->nombre }}
                                </label>
                        </div>
                        @endforeach
                    </div>

                    @csrf
                    <div class="mb-3 border rounded p-3"> 
                        <label class="fw-bold">Selecciona las materias que consideres que son mas estresantes: </label>
                        @foreach($materias as $materia)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="materias[]" value="{{ $materia->idMateria }}">
                            <label class="form-check-label" for="{{ $materia->idMateria }}">
                                {{ $materia->nombre }} "{{ $materia->cuatrimestre }}"
                            </label>
                        </div>
                        @endforeach
                    </div>


                    <input type="hidden" name="idCuestionarioAlumno" value="{{ $cuestionarioAsignado->idCuestionarioAlumno }}">
                    <button type="submit" class="btn btn-primary">Enviar Respuestas</button>

                </form>
            @endif
        </div>
    </div>
</div>

@endsection