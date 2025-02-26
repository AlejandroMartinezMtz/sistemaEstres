@extends('panelVista.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h3>Materias</h3>
            <h6>Admin Panel / <spand>Materias</spand></h6>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('materias.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i>
            Agregar</a>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('materias.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar materia..." value="{{ request()->input('search') }}">
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

    <!-- Tabla de materias -->
    <div class="table-responsive">
        <table class="table tableMateria table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Hora por semana</th>
                    <th>Cuatrimestre</th>
                    <th>Total de creditos</th>
                    <th>Programa</th>
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($materias->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center">No se encontraron materias.</td>
                    </tr>
                @else
                    @foreach($materias as $materia)
                        <tr>
                            <td>{{ $materia->idMateria }}</td>
                            <td>{{ $materia->nombre }}</td>
                            <td>{{ $materia->descripcion}}</td>
                            <td>{{ $materia->horaSemana}}</td>
                            <td>{{ $materia->cuatrimestre}}</td>
                            <td>{{ $materia->numeroCreditos}}</td>
                            <td>{{ $materia->programaEducativo->nombre }} "{{ $materia->programaEducativo->nivel }}"</td>
                            <td>{{ $materia->fechaCreacion }}</td>
        
                            <td>
                                <a href="{{ route('materias.edit', $materia->idMateria) }}" class="btn btn-sm btn-custom-edit"><i class="bi bi-pencil"></i> Editar</a>
                                <form action="{{ route('materias.destroy', $materia->idMateria) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Está seguro de eliminar esta materia?');">
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
