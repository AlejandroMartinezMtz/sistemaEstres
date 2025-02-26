@extends('panelVista.layout')

@section('content')
<div class="container">
    <h2>Crear Nuevo Usuario</h2>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf <!-- Token de protección contra CSRF -->
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="apellidoP" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellidoP" name="apellidoP" value="{{ old('apellidoP') }}" required>
        </div>

        <div class="mb-3">
            <label for="apellidoM" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" id="apellidoM" name="apellidoM" value="{{ old('apellidoM') }}" required>
        </div>

        <div class="mb-3">
            <label for="fechaNac" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fechaNac" name="fechaNac" value="{{ old('fechaNac') }}" required>
        </div>

        <div class="mb-3">
        <label for="sexo" class="form-label">Sexo</label>
            <select class="form-select" id="sexo" name="sexo" required>
                <option value="Mujer" selected>Mujer</option>
                <option value="Hombre">Hombre</option>
            </select>
        </div>

        <div class="mb-3">
        <label for="estadoActivo" class="form-label">Estado</label>
            <select class="form-select" id="estadoActivo" name="estadoActivo" required>
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="correoPersonal" class="form-label">Correo Personal</label>
            <input type="email" class="form-control" id="correoPersonal" name="correoPersonal" value="{{ old('correoPersonal') }}" required>
        </div>

        <div class="mb-3">
            <label for="correoInstitucional" class="form-label">Correo Institucional</label>
            <input type="email" class="form-control" id="correoInstitucional" name="correoInstitucional" value="{{ old('correoInstitucional') }}" required>
        </div>


        <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="{{ old('matricula') }}" required>
        </div>

        <div class="mb-3">
            <label for="tipoUsuario" class="form-label">Tipo de usuario</label>
            <select class="form-select" id="tipoUsuario" name="tipoUsuario" required>
                <option value="">Seleccionar tipo de usuario</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->idTipo_usuario }}">{{ $tipo->tipo }}</option>
                @endforeach
            </select>
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

        <button type="submit" class="btn colorButton">Crear usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
