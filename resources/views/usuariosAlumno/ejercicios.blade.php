@extends('panelVistaAlumno.layout')

@section('content')
<div class="container mt-4">
    <h2 class="text-center" style="color: blue; background-color: #f0f0f0; padding: 10px; border-radius: 15px;">
        Ejercicios Asignados
    </h2>

    @foreach($ejerciciosPorCategoria as $categoria => $ejercicios)
        @if(count($ejercicios) > 0)
            <!-- Contenedor para cada categoría -->
            <div class="categoria-contenedor my-4 p-4" style="background-color: #f0f0f0; background-image: url('ruta/a/la/imagen.jpg'); background-size: cover; background-position: center;">
                
                <!-- Subtítulo para cada categoría -->
                <h3>{{ $categoria }}</h3>
                
                <div class="row">
                    @foreach($ejercicios as $ejercicio)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <!-- Imagen del ejercicio con tamaño fijo -->
                                <div class="image-container">
                                    <img src="{{ asset($ejercicio->imagenUrl) }}" class="card-img-top" alt="{{ $ejercicio->nombre }}">
                                </div>
                                
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <!-- Nombre del ejercicio centrado -->
                                    <h5 class="card-title text-center">{{ $ejercicio->nombre }}</h5>
                                    
                                    <!-- Botón centrado -->
                                    <div class="d-grid">
                                        <a href="{{ route('ejercicioDetalle.inicio', $ejercicio->idEjercicio) }}" class="btn btn-primary">Ver más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>
@endsection
