@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Crear nueva materia</h2>

    <form action="{{ route('materias.store') }}" method="POST">
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
            <label for="horaSemana" class="form-label">Horas por semana</label>
            <input type="number" class="form-control" id="horaSemana" name="horaSemana" value="{{ old('horaSemana') }}" required>
        </div>

        <div class="mb-3">
            <label for="cuatrimestre" class="form-label">Cuatrimestre</label>
            <input type="number" class="form-control" id="cuatrimestre" name="cuatrimestre" value="{{ old('cuatrimestre') }}" required>
        </div>

        <div class="mb-3">
            <label for="numeroCreditos" class="form-label">Total de creditos</label>
            <input type="number" class="form-control" id="numeroCreditos" name="numeroCreditos" value="{{ old('numeroCreditos') }}" required>
        </div>


        <div class="mb-3">
            <label for="programaEducativo" class="form-label">Programa Educativo</label>
            <select class="form-select" id="programaEducativo" name="programaEducativo" required>
                <option value="">Seleccionar programa</option>
                @foreach($programas as $programa)
                    <option value="{{ $programa->idProgramaEducativo }}">{{ $programa->nombre }} "{{ $programa->nivel }}"</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn colorButton">Crear materia</button>
        <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
