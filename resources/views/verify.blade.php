

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href= "{{asset('css/app.css')}}" rel="stylesheet">
    
</head>
<body>
    <div class="login-container">

        <div class="login-left">
            <h1>BIENVENIDO</h1>
            <p>"Los retos de la vida no están ahí para paralizarte, sino para ayudarte a descubrir quién eres".<br><strong>Bernice Johnson Reagon</strong></p>
        </div>

        <div class="login-right">
          

            @if (session('success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify_code') }}">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    <input type="text" name="code" placeholder="Ingresar código" required>
                    <button type="submit" class="btn-login">Verificar código</button>
                </div>

                <div class="btnCancelar">
                    <button type="button" class="btn-login" onclick="window.location='{{ route('login') }}'">Cancelar</button>
                </div>
                
            </form>
           
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>