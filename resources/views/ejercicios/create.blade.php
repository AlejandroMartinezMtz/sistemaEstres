@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Crear nuevo ejercicio</h2>

    <form action="{{ route('ejercicios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf<!-- Token de protección contra CSRF -->
        
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
                <option value="Relajación" selected>Relajación</option>
                <option value="Ejercitación">Ejercitación</option>
                <option value="Estiramiento">Estiramiento</option>
                <option value="Cardio">Cardio</option>
                <option value="Baile">Baile</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nivelDificultad" class="form-label">Nivel de dificultad</label>
            <select class="form-select" id="nivelDificultad" name="nivelDificultad" value="{{ old('nivelDificultad') }}"required>
                <option value="Principiante" selected>Principiante</option>
                <option value="Intermedio">Intermedio</option>
                <option value="Avanzado">Avanzado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="duracionRecomendada" class="form-label">Duración recomendada</label>
            <input type="text" class="form-control" id="duracionRecomendada" name="duracionRecomendada" value="{{ old('duracionRecomendada') }}" required>
        </div>

        <div class="mb-3">
            <label for="frecuenciaRecomendada" class="form-label">Frecuencia recomendada</label>
            <input type="text" class="form-control" id="frecuenciaRecomendada" name="frecuenciaRecomendada" value="{{ old('frecuenciaRecomendada') }}" required>
        </div>

        <div class="mb-3">
            <label for="beneficios" class="form-label">Beneficios</label>
            <input type="text" class="form-control" id="beneficios" name="beneficios" value="{{ old('beneficios') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear ejercicio</button>
        <a href="{{ route('ejercicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
