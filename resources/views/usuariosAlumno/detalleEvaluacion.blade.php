@extends('panelVistaAlumno.layout')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h3>Evaluación contestada</h3>
                    
                    <img src="{{ asset('images/evaluacionContestada.png') }}" class="img-fluid mb-3" style="max-height: 400px; object-fit: cover;">

                    <div class="text-center" style="font-size: 0.8em; margin-bottom: 15px;">
                        <a>Designed by </a>
                        <a href="https://www.freepik.es/vector-gratis/fondo-pareja-confirmando-lista-comprobacion-gigante_4058677.htm#fromView=keyword&page=1&position=23&uuid=19d2fd78-21f7-4768-a9c8-c737b806b990" target="_blank">freepik</a>
                    </div>
                    

                    <div>
                        <a href="{{ route('alumno.inicio') }}" class="btn btn-primary mt-3">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
