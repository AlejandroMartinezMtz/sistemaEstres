@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Crear nuevo pasatiempo</h2>

    <form action="{{ route('pasatiempos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Token de protección contra CSRF -->

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagenUrl" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagenUrl" name="imagenUrl" value="{{ old('imagenUrl') }}" required>
        </div>

        <div class="mb-3">
            <label for="videoUrl" class="form-label">Video</label>
            <input type="file" class="form-control" id="videoUrl" name="videoUrl" value="{{ old('videoUrl') }}" required>
        </div>


        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" name="tipo" value="{{ old('tipo') }}" required>
                <option value="Artístico" selected>Artístico</option>
                <option value="Deportivo">Deportivo</option>
                <option value="Intelectual">Intelectual</option>
                <option value="Social">Social</option>
                <option value="Personal">Personal</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="requerimientos" class="form-label">Requerimientos</label>
            <textarea class="form-control" id="requerimientos" name="requerimientos" rows="4" required>{{ old('requerimientos') }}</textarea>
        </div>


        <div class="mb-3">
            <label for="duracionRecomendada" class="form-label">Duración recomendada</label>
            <input type="text" class="form-control" id="duracionRecomendada" name="duracionRecomendada" value="{{ old('duracionRecomendada') }}" required>
        </div>


        <button type="submit" class="btn btn-primary">Crear pasatiempo</button>
        <a href="{{ route('pasatiempos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
