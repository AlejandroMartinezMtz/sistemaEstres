@extends('panelVista.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h3>Usuarios</h3>
            <h6>Admin Panel / <spand>Usuarios</spand></h6>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('usuarios.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i>
            Agregar</a>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('usuarios.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar usuario..." value="{{ request()->input('search') }}">
        </form>
    </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="error-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-message">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabla de Usuarios -->
    <div class="table-responsive">
        <table class="table tableUsuario table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Correo Personal</th>
                    <th>Correo Institucional</th>
                    <th>Matrícula</th>
                    <th>Programa</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($usuarios->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">No se encontraron usuarios.</td>
                    </tr>
                @else
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->idUsuario }}</td>
                            <td>{{ $usuario->nombre }} {{ $usuario->apellidoP }} {{ $usuario->apellidoM }}</td>
                            <td>{{ $usuario->sexo }}</td>
                            <td>{{ $usuario->correoPersonal }}</td>
                            <td>{{ $usuario->correoInstitucional }}</td>
                            <td>{{ $usuario->matricula }}</td>
                            <td>{{ $usuario->programaEducativo->nombre }}</td>
                            <td>{{ $usuario->tipoUsuario->tipo }}</td>
                            
                             <!-- Aquí validamos si el usuario está activo o inactivo -->
                            <td>{{ $usuario->estadoActivo == 1 ? 'Activo' : 'Inactivo' }}</td>

                            <td>
                                <a href="{{ route('usuarios.edit', $usuario->idUsuario) }}" class="btn btn-sm btn-custom-edit">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario->idUsuario) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('“¿Está seguro de eliminar este registro? Nota: El estado del usuario cambia de activo a inactivo”.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-custom-delete">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                 @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
