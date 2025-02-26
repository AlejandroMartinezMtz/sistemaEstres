

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href= "{{asset('css/app.css')}}" rel="stylesheet">
    
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <h1>BIENVENIDO</h1>
            <p>"Los retos de la vida no están ahí para paralizarte, sino para ayudarte a descubrir quién eres".<br><strong>Bernice Johnson Reagon</strong></p>
        </div>

        <div class="login-right">
            <div class="recuperarContra">
                <h2>¿Olvidaste tu contraseña?</h2>
                <p>Ingresa el correo de tu cuenta donde te enviaremos
                    un código de verificación para recuperar tu contraseña. Tu correo
                    debe ser el mismo correo con el que inicias sesión.
                </p>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.send_code') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <button type="submit" class="btn-login codigoBtn">Enviar código</button>
                </div>

            </form>
            <div class="botonCodigo">
                    <button type="button" class="btn-login" onclick="window.location='{{ route('login') }}'">Cancelar</button>
            </div>
           
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>