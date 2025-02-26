@extends('panelVistaProfesor.layout')

@section('content')
<div class="container">
    <h2>Editar Alumno</h2>

    <form action="{{ route('usuarioProfesor.update', $usuario->idUsuario) }}" method="POST">
        @csrf
        @method('PUT') <!-- Cambia el método a PUT para actualizar -->
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="apellidoP" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellidoP" name="apellidoP" value="{{ $usuario->apellidoP }}" required>
        </div>

        <div class="mb-3">
            <label for="apellidoM" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" id="apellidoM" name="apellidoM" value="{{ $usuario->apellidoM }}" required>
        </div>

        <div class="mb-3">
            <label for="fechaNac" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fechaNac" name="fechaNac" value="{{ $usuario->fechaNac }}" required>
        </div>


        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select class="form-select" id="sexo" name="sexo" required>
                <option value="Mujer" {{ $usuario->sexo == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                <option value="Hombre" {{ $usuario->sexo == 'Hombre' ? 'selected' : '' }}>Hombre</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="estadoActivo" class="form-label">Estado</label>
            <select class="form-select" id="estadoActivo" name="estadoActivo" required>
                <option value="1" {{ $usuario->estadoActivo == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $usuario->estadoActivo == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="correoPersonal" class="form-label">Correo Personal</label>
            <input type="email" class="form-control" id="correoPersonal" name="correoPersonal" value="{{ $usuario->correoPersonal }}" required>
        </div>

        <div class="mb-3">
            <label for="correoInstitucional" class="form-label">Correo Institucional</label>
            <input type="email" class="form-control" id="correoInstitucional" name="correoInstitucional" value="{{ $usuario->correoInstitucional }}" required>
        </div>

        <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="{{ $usuario->matricula }}" required>
        </div>


        <div class="mb-3">
        <label for="tipoUsuario" class="form-label">Tipo de usuario</label>
        <select class="form-select" id="tipoUsuario" name="tipoUsuario" required>
           <option value="{{ $tipoAlumno }}" selected>Alumno</option>
        </select>
        </div>

        <div class="mb-3">
            <label for="programaEducativo" class="form-label">Programa Educativo</label>
            <select class="form-select" id="programaEducativo" name="programaEducativo" required>
                <option value="">Seleccionar programa</option>
                    @foreach($programas as $programa)
                        <option value="{{ $programa->idProgramaEducativo }}" {{ $usuario->fk_programaEducativo == $programa->idProgramaEducativo ? 'selected' : '' }}>
                    {{ $programa->nombre }}, Nivel: "{{ $programa->nivel }}"
                </option>
                    @endforeach
            </select>
        </div>


        

        <button type="submit" class="btn colorButton">Actualizar alumno</button>
        <a href="{{ route('usuarioProfesor.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
