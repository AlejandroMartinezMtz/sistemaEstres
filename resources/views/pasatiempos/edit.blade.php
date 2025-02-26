@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Editar pasatiempo</h2>

    <form action="{{ route('pasatiempos.update', $pasatiempo->idPasatiempo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Cambia el método a PUT para actualizar -->
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $pasatiempo->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ $pasatiempo->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagenUrl" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagenUrl" name="imagenUrl">
            <!-- Mostrar la imagen actual si existe -->
            @if($pasatiempo->imagenUrl)
                <img src="{{ asset($pasatiempo->imagenUrl) }}" alt="{{ $pasatiempo->nombre }}" style="width: 100px; height: auto;">
            @endif
        </div>


        <div class="mb-3">
            <label for="videoUrl" class="form-label">Video</label>
            <input type="file" class="form-control" id="videoUrl" name="videoUrl">
            <!-- Mostrar la imagen actual si existe -->
            @if($pasatiempo->videoUrl)
                <video src="{{ asset($pasatiempo->videoUrl) }}" alt="{{ $pasatiempo->nombre }}" style="width: 100px; height: auto;">
            @endif
        </div>

        <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo" required>
            <option value="Artístico" {{ $pasatiempo->tipo == 'Artístico' ? 'selected' : '' }}>Artístico</option>
            <option value="Deportivo" {{ $pasatiempo->tipo == 'Deportivo' ? 'selected' : '' }}>Deportivo</option>
            <option value="Intelectual" {{ $pasatiempo->tipo == 'Intelectual' ? 'selected' : '' }}>Intelectual</option>
            <option value="Social" {{ $pasatiempo->tipo == 'Social' ? 'selected' : '' }}>Social</option>
            <option value="Personal" {{ $pasatiempo->tipo == 'Personal' ? 'selected' : '' }}>Personal</option>
        </select>
        </div>

        <div class="mb-3">
            <label for="requerimientos" class="form-label">Requerimientos</label>
            <textarea class="form-control" id="requerimientos" name="requerimientos" rows="4" required>{{ $pasatiempo->requerimientos }}</textarea>
        </div>
    
        <div class="mb-3">
            <label for="duracionRecomendada" class="form-label">Duración recomendada</label>
            <input type="text" class="form-control" id="duracionRecomendada" name="duracionRecomendada" value="{{ $pasatiempo->duracionRecomendada }}" required>
        </div>


        <button type="submit" class="btn btn-success">Actualizar pasatiempo</button>
        <a href="{{ route('pasatiempos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
