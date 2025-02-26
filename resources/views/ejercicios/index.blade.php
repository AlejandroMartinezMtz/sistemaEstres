@extends('panelVista.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h3>Ejercicios</h3>
            <h6>Admin Panel / <spand>Ejercicios</spand></h6>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('ejercicios.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i> Agregar</a>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('ejercicios.index') }}" method="GET" id="searchForm">
        <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar ejercicio..." value="{{ request()->input('search') }}">

        </form>
    </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="error-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabla de Ejercicios -->
    <div class="table-responsive">
        <table class="table tableEjercicio table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Video</th>
                    <th>Tipo</th>
                    <th>Dificultad</th>
                    <th>Duración</th>
                    <th>Frecuencia</th>
                    <th>Beneficios</th>
                    <th>Fecha creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($ejercicios->isEmpty())
                    <tr>
                        <td colspan="12" class="text-center">No se encontraron ejercicios.</td>
                    </tr>
                @else
                    @foreach($ejercicios as $ejercicio)
                        <tr>
                            <td>{{ $ejercicio->idEjercicio }}</td>
                            <td>{{ $ejercicio->nombre }}</td>
                            <td>{{ Str::limit($ejercicio->descripcion, 40, '...') }}</td>
                            <td>
                            <!-- Mostrar la imagen -->
                            <img src="{{ asset($ejercicio->imagenUrl) }}" alt="{{ $ejercicio->nombre }}" style="width: 60px; height: 60px;">
                            </td>

                            <td>
                            <!-- Mostrar el video -->
                            <video src="{{ asset($ejercicio->videoUrl) }}" alt="{{ $ejercicio->nombre }}" style="width: 60px; height: 60px;" muted loop></video>
                            </td>

                            <td>{{ $ejercicio->tipo }}</td>
                            <td>{{ $ejercicio->nivelDificultad }}</td>
                            <td>{{ $ejercicio->duracionRecomendada }}</td>
                            <td>{{ $ejercicio->frecuenciaRecomendada }}</td>
                            <td>{{ Str::limit($ejercicio->beneficios, 50, '...') }}</td>
                            <td>{{ $ejercicio->fechaRegistro }}</td>
                            
                            <td>
                                <a href="{{ route('ejercicios.edit', $ejercicio->idEjercicio) }}" class="btn btn-sm btn-custom-edit"> <i class="bi bi-pencil"></i> Editar</a>
                                <form action="{{ route('ejercicios.destroy', $ejercicio->idEjercicio) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ejercicio?');">
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
