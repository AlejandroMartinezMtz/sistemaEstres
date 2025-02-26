@extends('panelVista.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h3>Avisos</h3>
            <h6>Admin Panel / <spand>Avisos</spand></h6>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('avisos.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i> Agregar</a>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('avisos.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar aviso..." value="{{ request()->input('search') }}">
        </form>
    </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="error-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabla de avisos -->
    <div class="table-responsive">
        <table class="table tableAviso table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>
                    <th>Fecha de creación</th>
                    <th>Usuario creador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($avisos->isEmpty())
                    <tr>
                        <td colspan="11" class="text-center">No se encontraron avisos.</td>
                    </tr>
                @else
                    @foreach($avisos as $aviso)
                        <tr>
                            <td>{{ $aviso->idAviso }}</td>
                            <td>{{ $aviso->titulo }}</td>
                            <td>{{ $aviso->descripcion }}</td>
                            <td>
                            <!-- Mostrar la imagen -->
                            <img src="{{ asset($aviso->imagenUrl) }}" alt="{{ $aviso->nombre }}" style="width: 60px; height: 60px;">
                            </td>

                            <td>{{ $aviso->fechaInicio }}</td>
                            <td>{{ $aviso->fechaFin }}</td>
                            <td>{{ $aviso->fechaCreacion }}</td>
                            <td>"{{ $aviso->usuario->idUsuario }}" {{ $aviso->usuario->nombre }}</td>
                            
                            <td>
                                <a href="{{ route('avisos.edit', $aviso->idAviso) }}" class="btn btn-sm btn-custom-edit"> <i class="bi bi-pencil"></i> Editar</a>
                                <form action="{{ route('avisos.destroy', $aviso->idAviso) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este aviso?');">
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
