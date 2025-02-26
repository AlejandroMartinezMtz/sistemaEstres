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
            <h3>INICIA SESIÓN</h3>

           @if (session('status'))
             <div class="alert alert-success" id="success-message">
                {{ session('status') }}
            </div>
           @endif

            @if ($errors->any())
                <div class="alert alert-danger" id="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <img src="/images/userLogin.png" alt="Icono de inicio" class="login-icon">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="correo" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <input type="password" name="contrasenia" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn-login">Ingresar</button>
            </form>
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
         
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Oculta el mensaje de error después de 5 segundos
        setTimeout(function() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000); 
    </script>

    <script>
        // Oculta el mensaje de éxito después de 5 segundos
        setTimeout(function() {
            var sucessMessage = document.getElementById('success-message');
            if (sucessMessage) {
                sucessMessage.style.display = 'none';
            }
        }, 5000); 
    </script>
</body>
</html>
