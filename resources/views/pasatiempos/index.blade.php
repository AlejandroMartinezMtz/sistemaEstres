@extends('panelVista.layout')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-6">
            <h3>Pasatiempos</h3>
            <h6>Admin Panel / <spand>Pasatiempos</spand></h6>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('pasatiempos.create')}}" class="btn colorButton"><i class="bi bi-plus icon-large"></i> Agregar</a>
        </div>
    </div>

    <div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('pasatiempos.index') }}" method="GET" id="searchForm">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Buscar pasatiempo..." value="{{ request()->input('search') }}">
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

    <!-- Tabla de pasatiempos -->
    <div class="table-responsive">
        <table class="table tablePasatiempo table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Video</th>
                    <th>Tipo</th>
                    <th>Requerimientos</th>
                    <th>Duración</th>
                    <th>Fecha registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($pasatiempos->isEmpty())
                    <tr>
                        <td colspan="11" class="text-center">No se encontraron pasatiempos.</td>
                    </tr>
                @else
                    @foreach($pasatiempos as $pasatiempo)
                        <tr>
                            <td>{{ $pasatiempo->idPasatiempo }}</td>
                            <td>{{ $pasatiempo->nombre }}</td>
                            <td>{{ $pasatiempo->descripcion }}</td>

                            <td>
                            <!-- Mostrar la imagen -->
                            <img src="{{ asset($pasatiempo->imagenUrl) }}" alt="{{ $pasatiempo->nombre }}" style="width: 60px; height: 60px;">
                            </td>

                            <td>
                            <!-- Mostrar el video -->
                            <video src="{{ asset($pasatiempo->videoUrl) }}" alt="{{ $pasatiempo->nombre }}" style="width: 60px; height: 60px;" muted loop></video>
                            </td>


                            <td>{{ $pasatiempo->tipo }}</td>
                            <td>{{ $pasatiempo->requerimientos }}</td>
                            <td>{{ $pasatiempo->duracionRecomendada }}</td>
                            <td>{{ $pasatiempo->fechaRegistro }}</td>
                            
                            <td>
                                <a href="{{ route('pasatiempos.edit', $pasatiempo->idPasatiempo) }}" class="btn btn-sm btn-custom-edit"> <i class="bi bi-pencil"></i> Editar</a>
                                <form action="{{ route('pasatiempos.destroy', $pasatiempo->idPasatiempo) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este pasatiempo?');">
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
