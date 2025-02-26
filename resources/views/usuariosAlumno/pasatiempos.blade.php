@extends('panelVistaAlumno.layout')


@section('content')
<div class="container mt-4">
    <h2 class="text-center" style="color: blue; background-color: #f0f0f0; padding: 10px; border-radius: 15px;">
        Pasatiempos Asignados
    </h2>

    @foreach($pasatiemposPorCategoria as $categoria => $pasatiempos)
        @if(count($pasatiempos) > 0)
            <!-- Contenedor para cada categoría -->
            <div class="categoria-contenedor my-4 p-4" style="background-color: #f0f0f0; background-image: url('ruta/a/la/imagen.jpg'); background-size: cover; background-position: center;">
                
                <!-- Subtítulo para cada categoría -->
                <h3>{{ $categoria }}</h3>
                
                <div class="row">
                    @foreach($pasatiempos as $pasatiempo)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <!-- Imagen del pasatiempo -->
                                <div class="image-container">
                                    <img src="{{ asset($pasatiempo->imagenUrl) }}" class="card-img-top" alt="{{ $pasatiempo->nombre }}">
                                </div>
                                
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <!-- Nombre del pasatiempo centrado -->
                                    <h5 class="card-title text-center">{{ $pasatiempo->nombre }}</h5>
                                    
                                    <!-- Botón centrado -->
                                    <div class="d-grid">
                                        <a href="{{ route('pasatiempoDetalle.inicio', $pasatiempo->idPasatiempo) }}" class="btn btn-primary">Ver más</a>
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