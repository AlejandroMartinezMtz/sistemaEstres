@extends('panelVistaAlumno.layout')

@section('content')
<div class="container">
    <h1 class="text-center">Cuestionarios Asignados</h1>

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

    @if($cuestionariosAsignados->isEmpty())
        <p class="text-center">No tienes cuestionarios asignados o todos han sido contestados.</p>
    @else
        <ul class="list-group">
            @foreach($cuestionariosAsignados as $cuestionarioAlumno)
                <li class="list-group-item">
                    <h5>{{ $cuestionarioAlumno->cuestionario->titulo }}</h5>
                    <p>{{ $cuestionarioAlumno->cuestionario->descripcion }}</p>

                    @if($cuestionarioAlumno->estado == 'Contestado')
                        <button class="btn btn-secondary" disabled>Cuestionario respondido</button>
                    @else
                        <a href="{{ route('mostrarCuestionario', ['idCuestionario' => $cuestionarioAlumno->cuestionario->idCuestionario, 'idCuestionarioAlumno' => $cuestionarioAlumno->idCuestionarioAlumno]) }}" class="btn btn-primary">Responder cuestionario</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
