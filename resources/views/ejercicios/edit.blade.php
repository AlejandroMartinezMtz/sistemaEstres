@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Editar ejercicio</h2>

    <form action="{{ route('ejercicios.update', $ejercicio->idEjercicio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Cambia el método a PUT para actualizar -->
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $ejercicio->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ $ejercicio->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagenUrl" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagenUrl" name="imagenUrl">
            <!-- Mostrar la imagen actual si existe -->
            @if($ejercicio->imagenUrl)
                <img src="{{ asset($ejercicio->imagenUrl) }}" alt="{{ $ejercicio->nombre }}" style="width: 100px; height: auto;">
            @endif
        </div>


        
        <div class="mb-3">
            <label for="videoUrl" class="form-label">Video</label>
            <input type="file" class="form-control" id="videoUrl" name="videoUrl">
            <!-- Mostrar la imagen actual si existe -->
            @if($ejercicio->videoUrl)
                <video src="{{ asset($ejercicio->videoUrl) }}" alt="{{ $ejercicio->nombre }}" style="width: 100px; height: auto;">
            @endif
        </div>

        <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo" required>
            <option value="Relajación" {{ $ejercicio->tipo == 'Relajación' ? 'selected' : '' }}>Relajación</option>
            <option value="Ejercitación" {{ $ejercicio->tipo == 'Ejercitación' ? 'selected' : '' }}>Ejercitación</option>
            <option value="Estiramiento" {{ $ejercicio->tipo == 'Estiramiento' ? 'selected' : '' }}>Estiramiento</option>
            <option value="Cardio" {{ $ejercicio->tipo == 'Cardio' ? 'selected' : '' }}>Cardio</option>
            <option value="Baile" {{ $ejercicio->tipo == 'Baile' ? 'selected' : '' }}>Baile</option>
        </select>
        </div>

        <div class="mb-3">
            <label for="nivelDificultad" class="form-label">Nivel de dificultad</label>
            <select class="form-select" id="nivelDificultad" name="nivelDificultad" required>
                <option value="Principiante" {{ $ejercicio->nivelDificultad == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                <option value="Intermedio" {{ $ejercicio->nivelDificultad == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                <option value="Avanzado" {{ $ejercicio->nivelDificultad == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="duracionRecomendada" class="form-label">Duración</label>
            <input type="text" class="form-control" id="duracionRecomendada" name="duracionRecomendada" value="{{ $ejercicio->duracionRecomendada }}" required>
        </div>

        <div class="mb-3">
            <label for="frecuenciaRecomendada" class="form-label">Frecuencia</label>
            <input type="text" class="form-control" id="frecuenciaRecomendada" name="frecuenciaRecomendada" value="{{ $ejercicio->frecuenciaRecomendada }}" required>
        </div>

        <div class="mb-3">
            <label for="beneficios" class="form-label">Beneficios</label>
            <textarea class="form-control" id="beneficios" name="beneficios" rows="4" required>{{ $ejercicio->beneficios }}</textarea>
        </div>


        <button type="submit" class="btn btn-success">Actualizar ejercicio</button>
        <a href="{{ route('ejercicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
