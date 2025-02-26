@extends('panelVista.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h3>Programas</h3>
            <h6>Admin Panel / <spand>Programas</spand></h6>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('programas.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i>
            Agregar</a>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('programas.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar programa..." value="{{ request()->input('search') }}">
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

    <!-- Tabla de programas -->
    <div class="table-responsive">
        <table class="table tablePrograma table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nivel</th>
                    <th>Duración</th>
                    <th>Facultad</th>
                    <th>Fecha de registro</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($programas->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No se encontraron programas.</td>
                    </tr>
                @else
                    @foreach($programas as $programa)
                        <tr>
                            <td>{{ $programa->idProgramaEducativo }}</td>
                            <td>{{ $programa->nombre }}</td>
                            <td>{{ $programa->descripcion}}</td>
                            <td>{{ $programa->nivel}}</td>
                            <td>{{ $programa->duracion}}</td>
                            <td>{{ $programa->facultad}}</td>
                            <td>{{ $programa->fechaRegistro }}</td>

                            <!-- Aquí validamos si el programa está activo o inactivo -->
                            <td>{{ $programa->estado == 1 ? 'Activo' : 'Inactivo' }}</td>

        
                            <td>
                                <a href="{{ route('programas.edit', $programa->idProgramaEducativo) }}" class="btn btn-sm btn-custom-edit"><i class="bi bi-pencil"></i> Editar</a>
                                <form action="{{ route('programas.destroy', $programa->idProgramaEducativo) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Está seguro de eliminar este programa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-custom-delete"><i class="bi bi-trash"></i> Eliminar</button>
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
