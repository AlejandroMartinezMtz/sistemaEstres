@extends('panelVistaAlumno.layout')

@section('content')
<div class="container mt-2">
   

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('crearPublicacion') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2 d-flex justify-content-between align-items-center">
                        <i class='bx bxs-wink-smile' style="font-size: 30px; color: #14836b;"></i>
                        <textarea name="texto" class="form-control" id="textoPublicacion" rows="1" placeholder="¡Hola!, ¿Cómo te sientes hoy?" required style="border-radius: 20px;"></textarea>
                    </div>
                    
                    <!-- Alinear el icono de imagen y el botón de publicar en la misma fila -->
                    <div class="form-group mb-2 d-flex justify-content-between align-items-center">
                        <!-- Icono de imagen con color -->
                        <label for="imagenPublicacion" class="btn">
                            <i class='bx bx-image-add' style="font-size: 30px; color: #007bff;"></i>
                            <input type="file" name="imagenUrl" class="d-none" id="imagenPublicacion" accept="image/*">
                        </label>

                        <!-- Botón de publicar alineado a la derecha -->
                        <button type="submit" class="btn btn-primary">Compartir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Listado de publicaciones -->
<div class="row justify-content-center mt-5">
    @if($foro->isEmpty())
        <div class="col-md-8">
            <div class="alert alert-info text-center" role="alert">
                No hay publicaciones aún.
            </div>
        </div>
    @else
        @foreach($foro as $publicacion)
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                
                <div class="card-header d-flex justify-content-between">
                    <strong>{{ $publicacion->usuario->nombre }}</strong>
                    <span class="text-muted">{{ $publicacion->fechaPublicacion }}</span>
                </div>

                <div class="card-body">
                    <p class="text-left text-justificado">{{ $publicacion->texto }}</p>
                    
                    @if($publicacion->imagenUrl)
                    <div class="mb-3 imagen-publicacion">
                        <img src="{{ asset($publicacion->imagenUrl) }}" class="img-fluid" alt="Imagen de la publicación">
                    </div>
                    @endif

                    @if($publicacion->comentario->count() < 3)
                    <form action="{{ route('agregarComentario', $publicacion->idPublicacionForo) }}" method="POST">
                        @csrf
                        <div class="form-group text-right">
                            <input type="text" name="comentario" class="form-control" placeholder="Escribe tu comentario aquí..." required>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-secondary btn-sm mt-2">Comentar</button>
                        </div>
                    </form>
                    @endif

                    <div class="mt-4 text-right">
                        @if($publicacion->comentario->count() > 0)
                        <div class="media mb-3">
                            <i class='bx bxs-wink-smile' style="font-size: 30px; color: #14836b;"></i>
                            <div class="media-body">
                                <h6 class="mt-0 text-left">{{ $publicacion->comentario[0]->usuario->nombre }} {{ $publicacion->comentario[0]->usuario->apellidoP }}</h6>
                                <p class="text-left">{{ $publicacion->comentario[0]->comentario }}</p>
                                <small class="text-muted text-left">{{ $publicacion->comentario[0]->fechaComentario }}</small>
                            </div>
                        </div>

                        @if($publicacion->comentario->count() > 1)
                        <div id="comentarios-{{ $publicacion->idPublicacionForo }}" class="collapse">
                            @foreach($publicacion->comentario->slice(1) as $comentario)
                            <div class="media mb-3">
                                <i class='bx bxs-wink-smile' style="font-size: 30px; color: #14836b;"></i>
                                <div class="media-body">
                                    <h6 class="mt-0 text-left">{{ $comentario->usuario->nombre }} {{ $comentario->usuario->apellidoP }}</h6>
                                    <p class="text-left">{{ $comentario->comentario }}</p>
                                    <small class="text-muted text-left">{{ $comentario->fechaComentario }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="btn btn-link ver-mas" type="button" data-bs-toggle="collapse" data-bs-target="#comentarios-{{ $publicacion->idPublicacionForo }}" aria-expanded="false" aria-controls="comentarios-{{ $publicacion->idPublicacionForo }}">
                            Ver más comentarios
                        </button>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>





@endsection
