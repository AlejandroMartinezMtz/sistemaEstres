@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Editar aviso</h2>

    <form action="{{ route('avisos.update', $aviso->idAviso) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Cambia el método a PUT para actualizar -->
        
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $aviso->titulo }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ $aviso->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagenUrl" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagenUrl" name="imagenUrl">
            <!-- Mostrar la imagen actual si existe -->
            @if($aviso->imagenUrl)
                <img src="{{ asset($aviso->imagenUrl) }}" alt="{{ $aviso->titulo }}" style="width: 100px; height: auto;">
            @endif
        </div>

        <div class="mb-3">
            <label for="fechaInicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="{{ $aviso->fechaInicio }}" required>
        </div>

        <div class="mb-3">
            <label for="fechaFin" class="form-label">Fecha Final</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin" value="{{ $aviso->fechaFin }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar aviso</button>
        <a href="{{ route('avisos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
