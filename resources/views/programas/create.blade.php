@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Crear nuevo programa</h2>

    <form action="{{ route('programas.store') }}" method="POST">
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
            <label for="nivel" class="form-label">Nivel (1,3,6...)</label>
            <input type="number" class="form-control" id="nivel" name="nivel" value="{{ old('nivel') }}" required>
        </div>

        <div class="mb-3">
            <label for="duracion" class="form-label">Total de meses</label>
            <input type="number" class="form-control" id="duracion" name="duracion" value="{{ old('duracion') }}" required>
        </div>

        <div class="mb-3">
            <label for="facultad" class="form-label">Facultad</label>
            <input type="text" class="form-control" id="facultad" name="facultad" value="{{ old('facultad') }}" required>
        </div>

        <button type="submit" class="btn colorButton">Crear programa</button>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
