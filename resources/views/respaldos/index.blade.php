@extends('panelVista.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
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

    <div class="container mt-5">
        <h3>Respaldo y Restauración de Base de Datos</h3>
        <br>

        <div class="row mb-4">
            <!-- Card para crear respaldo -->
            <div class="col-md-6">
                <div class="card shadow respaldo" style="">
                    <div class="card-body">
                        <h4 class="card-title">Crear Respaldo</h4>
                        <form action="{{ route('respaldos.respaldo') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Crear Respaldo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Card para restaurar respaldo -->
            <div class="col-md-6 mb-4">
                <div class="card shadow respaldo">
                    <div class="card-body">
                        <h4 class="card-title">Restaurar Respaldo</h4>
                        <form id="restore-form" action="{{ route('respaldos.restaurar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="backup_file" class="form-label">Seleccionar archivo de respaldo (.sql)</label>
                                <input type="file" class="form-control" id="backup_file" name="backup_file" required>
                            </div>
                            <button type="button" class="btn btn-danger" onclick="validateAndShowModal()">Restaurar Base de Datos</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación de Contraseña -->
        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">Confirmar Restauración</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="password" class="form-label">Ingresa tu contraseña para confirmar:</label>
                        <input type="password" class="form-control" id="password" required>
                        <small id="error-message" class="text-danger d-none">Contraseña incorrecta</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="verifyPassword()">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateAndShowModal() {
            const fileInput = document.getElementById('backup_file');
            const filePath = fileInput.value;

            // Verificar si el archivo tiene la extensión .sql
            if (filePath) {
                const allowedExtensions = /(\.sql)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    alert('Por favor, selecciona un archivo con extensión .sql');
                    fileInput.value = ''; // Limpiar el campo
                    return false; // Evitar que el formulario se envíe
                }
                // Si la validación es exitosa, mostrar el modal
                showPasswordModal();
            } else {
                alert('Por favor, selecciona un archivo antes de continuar.');
            }
        }

        function showPasswordModal() {
            var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            passwordModal.show();
        }

        function verifyPassword() {
            const passwordInput = document.getElementById('password').value;

            fetch("{{ route('respaldos.verificarPassword') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ password: passwordInput })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('restore-form').submit();
                } else {
                    document.getElementById('error-message').classList.remove('d-none');
                }
            });
        }
    </script>
@endsection
