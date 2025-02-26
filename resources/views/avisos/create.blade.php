@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Crear nuevo aviso</h2>

    <form action="{{ route('avisos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Token de protección contra CSRF -->

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagenUrl" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagenUrl" name="imagenUrl" value="{{ old('imagenUrl') }}"srequired>
        </div>

        <div class="mb-3">
            <label for="fechaInicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="{{ old('fechaInicio') }}" required>
        </div>

        <div class="mb-3">
            <label for="fechaFin" class="form-label">Fecha Fin</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin" value="{{ old('fechaFin') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear aviso</button>
        <a href="{{ route('avisos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
