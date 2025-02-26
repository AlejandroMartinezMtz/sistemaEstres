@extends('panelVistaAlumno.layout')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">{{ $encuesta->fechaAplica }}</h1>
            <p class="text-center">{{ $encuesta->objetivo}}</p>

            @if($encuesta->preguntas->isEmpty())
                <p>No hay preguntas asociadas a esta encuesta.</p>
            @else
                <form action="{{ route('guardarRespuestasEncuesta') }}" method="POST">
                    <input type="hidden" name="idencuesta" value="{{ $encuesta->idencuesta }}">
                    @csrf
                    @foreach($encuesta->preguntas as $pregunta)
                        <div class="mb-3 border rounded p-3">
                            <label class="fw-bold">{{ $pregunta->textoPregunta }}</label>
                            <div class="mt-2">
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta}}]" value="1" required> Totalmente en desacuerdo
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta}}]" value="2"> En desacuerdo
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta}}]" value="3"> Neutral
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta}}]" value="4"> De acuerdo
                                <input type="radio" name="respuestas[{{ $pregunta->idPreguntaEncuesta}}]" value="5"> Totalmente de acuerdo
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-4">
                    <label for="comentario" class="form-label"><strong>Tus comentarios:</strong> (Estos ayudaran a evaluarte mejor)</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4">{{ old('comentario') }}</textarea>
                    </div>


                    <input type="hidden" name="idEncuestaAlumno" value="{{ $encuestaAsignada->idEncuestaAlumno }}">
                    <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection