@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Editar materia</h2>

    <form action="{{ route('materias.update', $materia->idMateria) }}" method="POST">
        @csrf
        @method('PUT') <!-- Cambia el método a PUT para actualizar -->
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $materia->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ $materia->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="horaSemana" class="form-label">Horas por semana</label>
            <input type="number" class="form-control" id="horaSemana" name="horaSemana" value="{{ $materia->horaSemana}}" required>
        </div>

        <div class="mb-3">
            <label for="cuatrimestre" class="form-label">Cuatrimestre</label>
            <input type="number" class="form-control" id="cuatrimestre" name="cuatrimestre" value="{{ $materia->cuatrimestre }}" required>
        </div>

    
        <div class="mb-3">
            <label for="numeroCreditos" class="form-label">Total de creditos</label>
            <input type="number" class="form-control" id="numeroCreditos" name="numeroCreditos" value="{{ $materia->numeroCreditos }}" required>
        </div>


        <div class="mb-3">
            <label for="programaEducativo" class="form-label">Programa educativo</label>
            <select class="form-select" id="programaEducativo" name="programaEducativo" required>
                <option value="">Seleccionar programa</option>
                    @foreach($programas as $programa)
                        <option value="{{ $programa->idProgramaEducativo }}" {{ $materia->fk_Programa == $programa->idProgramaEducativo ? 'selected' : '' }}>
                    {{ $programa->nombre }} "{{ $programa->nivel}}"
                </option>
                    @endforeach
            </select>
        </div>


        <button type="submit" class="btn colorButton">Actualizar materia</button>
        <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
