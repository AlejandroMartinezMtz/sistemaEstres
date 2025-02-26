@extends('panelVistaProfesor.layout')

@section('content')
<div class="row justify-content-center mt-2">
    @if($foro->isEmpty())
        <div class="col-md-8">
            <div class="alert alert-info text-center" role="alert">
                No hay publicaciones aún.
            </div>
        </div>
    @else
        <div class="publicaciones-container">
            @foreach($foro as $publicacion)
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between">
                        <strong>{{ $publicacion->usuario->nombre }}</strong>
                        <span class="text-muted">{{ $publicacion->fechaPublicacion }}</span>
                        <!-- Botón para eliminar publicación -->
                        <button class="btn btn-danger btn-sm" onclick="eliminarPublicacion({{ $publicacion->idPublicacionForo }})">X</button>
                    </div>

                    <div class="card-body">
                        <p class="text-left text-justificado">{{ $publicacion->texto }}</p>
                        @if($publicacion->imagenUrl)
                        <div class="mb-3 imagen-publicacion">
                            <img src="{{ asset($publicacion->imagenUrl) }}" class="img-fluid" alt="Imagen de la publicación">
                        </div>
                        @endif

                        <!-- Comentarios -->
                        <div class="mt-4 text-right">
                            @if($publicacion->comentario->count() > 0)
                            <div class="media mb-3">
                                <i class='bx bxs-wink-smile' style="font-size: 30px; color: #14836b;"></i>
                                <div class="media-body">
                                    <h6 class="mt-0 text-left">{{ $publicacion->comentario[0]->usuario->nombre }} {{ $publicacion->comentario[0]->usuario->apellidoP }}
                                        <button class="btn btn-danger btn-sm" onclick="eliminarComentario({{ $publicacion->comentario[0]->idComentarioPublicacion }})">X</button>
                                    </h6>
                                    <p class="text-left">{{ $publicacion->comentario[0]->comentario }}</p>
                                    <small class="text-muted text-left">{{ $publicacion->comentario[0]->fechaComentario }}</small>
                                </div>
                            </div>
                            <!-- Más comentarios -->
                            @if($publicacion->comentario->count() > 1)
                            <div id="comentarios-{{ $publicacion->idPublicacionForo }}" class="collapse">
                                @foreach($publicacion->comentario->slice(1) as $comentario)
                                <div class="media mb-3">
                                    <i class='bx bxs-wink-smile' style="font-size: 30px; color: #14836b;"></i>
                                    <div class="media-body">
                                        <h6 class="mt-0 text-left">{{ $comentario->usuario->nombre }} {{ $comentario->usuario->apellidoP }}
                                            <button class="btn btn-danger btn-sm" onclick="eliminarComentario({{ $comentario->idComentarioPublicacion }})">X</button>
                                        </h6>
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
        </div>
    @endif
</div>








<script>
    function eliminarPublicacion(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta publicación?')) {
        fetch(`/foro/publicacion/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => response.json())
          .then(data => {
              alert(data.message);
              location.reload();
          }).catch(error => console.error('Error:', error));
    }
}

function eliminarComentario(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
        fetch(`/foro/comentario/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => response.json())
          .then(data => {
              alert(data.message);
              location.reload();
          }).catch(error => console.error('Error:', error));
    }
}

</script>
@endsection
