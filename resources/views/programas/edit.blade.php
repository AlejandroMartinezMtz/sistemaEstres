@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Editar programa</h2>

    <form action="{{ route('programas.update', $programa->idProgramaEducativo) }}" method="POST">
        @csrf
        @method('PUT') <!-- Cambia el método a PUT para actualizar -->
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $programa->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ $programa->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="nivel" class="form-label">Nivel (1,3,6...)</label>
            <input type="number" class="form-control" id="nivel" name="nivel" value="{{ $programa->nivel}}" required>
        </div>

        <div class="mb-3">
            <label for="duracion" class="form-label">Total de meses</label>
            <input type="number" class="form-control" id="duracion" name="duracion" value="{{ $programa->duracion }}" required>
        </div>

    
        <div class="mb-3">
            <label for="facultad" class="form-label">Facultad</label>
            <input type="text" class="form-control" id="facultad" name="facultad" value="{{ $programa->facultad }}" required>
        </div>


        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="1" {{ $programa->estado == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $programa->estado == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        

        <button type="submit" class="btn colorButton">Actualizar programa</button>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
