@extends('panelVistaAlumno.layout')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-5 d-flex flex-column align-items-center">
                    <!-- Título centrado -->
                    <h2 class="card-title text-center">{{ $ejercicio->nombre }}</h2>
                    
                    <!-- Imagen centrada -->
                    <img src="{{ asset($ejercicio->imagenUrl) }}" alt="{{ $ejercicio->nombre }}" class="img-fluid mb-3" style="max-height: 250px; object-fit: cover;">

                    <!-- Descripción justificada -->
                    <p class="card-text text-justify" style="text-align: justify;">
                        {{ $ejercicio->descripcion }}
                    </p>

                    <!-- Beneficios -->
                    <p class="card-text text-justify" style="text-align: justify;"><strong>Beneficios:</strong> 
                        {{ $ejercicio->beneficios }}
                    </p>
                </div>

                <!-- Línea divisoria -->
                <div class="col-md-1 d-none d-md-block">
                    <div style="border-left: 1px solid #ddd; height: 100%;"></div>
                </div>

                <!-- Columna derecha -->
                <div class="col-md-5 d-flex flex-column align-items-center">
                    <!-- Nivel de dificultad -->
                    <h6 class="card-title text-center">Nivel de Dificultad: {{ $ejercicio->nivelDificultad }}</h6>
                    
                    <!-- Duración recomendada -->
                    <p class="card-text"><strong>Duración Recomendada:</strong> {{ $ejercicio->duracionRecomendada }}</p>
                    
                    <!-- Frecuencia recomendada -->
                    <p class="card-text"><strong>Frecuencia Recomendada:</strong> {{ $ejercicio->frecuenciaRecomendada }}</p>
                    
                    <!-- Video -->
                    <video src="{{ asset($ejercicio->videoUrl) }}" class="img-fluid mt-3" controls style="max-height: 250px; object-fit: cover;"></video>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
