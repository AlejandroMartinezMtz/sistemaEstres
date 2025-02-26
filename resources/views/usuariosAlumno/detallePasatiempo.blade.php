@extends('panelVistaAlumno.layout')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-5 d-flex flex-column align-items-center">
                    <!-- Título centrado -->
                    <h2 class="card-title text-center">{{ $pasatiempo->nombre }}</h2>
                    
                    <!-- Imagen centrada -->
                    <img src="{{ asset($pasatiempo->imagenUrl) }}" alt="{{ $pasatiempo->nombre }}" class="img-fluid mb-3" style="max-height: 250px; object-fit: cover;">

                    <!-- Descripción justificada -->
                    <p class="card-text text-justify" style="text-align: justify;">
                        {{ $pasatiempo->descripcion }}
                    </p>

                </div>

                <!-- Línea divisoria -->
                <div class="col-md-1 d-none d-md-block">
                    <div style="border-left: 1px solid #ddd; height: 100%;"></div>
                </div>

                <!-- Columna derecha -->
                <div class="col-md-5 d-flex flex-column align-items-center">
                    <!-- Tipo de pasatiempo-->
                    <h6 class="card-title text-center">Tipo: {{ $pasatiempo->tipo }}</h6>
               
                    <!-- Beneficios -->
                    <p class="card-text text-justify" style="text-align: justify;"><strong>Duración Recomendada:</strong> 
                        {{ $pasatiempo->duracionRecomendada }}
                    </p>

                     <!--Requerimientos -->
                     <p class="card-text text-justify" style="text-align: justify;"><strong>Requerimientos:</strong> 
                        {{ $pasatiempo->requerimientos }}
                    </p>

                    <!-- Video -->
                    <video src="{{ asset($pasatiempo->videoUrl) }}" class="img-fluid mt-3" controls style="max-height: 250px; object-fit: cover;"></video>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
