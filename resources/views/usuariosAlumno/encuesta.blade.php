@extends('panelVistaAlumno.layout')


@section('content')
<div class="container">
    <h1 class="text-center">Encuestas Asignadas</h1>

    <!-- Mostrar mensajes de estado -->
    @if (session('status'))
        <div class="alert alert-success" id="success-message">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" id="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($encuestasAsignadas->isEmpty())
        <p class="text-center">No tienes encuestas asignadas.</p>
    @else
        <ul class="list-group">
            @foreach($encuestasAsignadas as $encuestaAlumno)
                <li class="list-group-item">
                    <h5>{{ $encuestaAlumno->encuesta->fechaAplica }}</h5>
                    <p>{{ $encuestaAlumno->encuesta->objetivo }}</p>
                    @if($encuestaAlumno->estado == 'Contestado')
                        <button class="btn btn-secondary" disabled>Encuesta respondida</button>
                    @else
                        <a href="{{ route('mostrarEncuesta', ['idEncuesta' => $encuestaAlumno->encuesta->idencuesta, 'idEncuestaAlumno' => $encuestaAlumno->idEncuestaAlumno]) }}" class="btn btn-primary">Responder encuesta</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection