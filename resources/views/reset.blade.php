<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .input-error {
            border-color: red;
        }
        .error-message {
            color: white;
            font-size: 0.9em;
            margin-top: 1px;
            margin-bottom: 1.5px;
            background-color: #f04444;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <h1>BIENVENIDO</h1>
            <p>"Los retos de la vida no están ahí para paralizarte, sino para ayudarte a descubrir quién eres".<br><strong>Bernice Johnson Reagon</strong></p>
        </div>

        <div class="login-right">
            <div class="cambiarContra">
                <h2>Cambiar la contraseña</h2>
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

            <form method="POST" action="{{ route('password.update_password') }}" onsubmit="return validatePasswords()">
                @csrf
                <div class="instContra">
                    <p>Introduzca entre 8 y 16 caracteres, al menos 1 minúscula, 1 mayúscula, 1 número y 1 carácter especial.</p>
                </div>

                <div id="error-message" class="error-message" style="display: none;"></div>

                <div class="form-group">
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    <input type="password" id="password" name="password" placeholder="Nueva contraseña" required>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar nueva contraseña" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-login">Restablecer contraseña</button>
                    <div class="btnCancelar">
                        <button type="button" class="btn-login" onclick="window.location='{{ route('login') }}'">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
    <script>
    function validatePasswords() {
        const passwordField = document.getElementById("password");
        const passwordConfirmationField = document.getElementById("password_confirmation");
        const errorMessage = document.getElementById("error-message");


        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+~`|}{[\]:;?/><.,-])[A-Za-z\d!@#$%^&*()_+~`|}{[\]:;?/><.,-]{8,16}$/;

   
        errorMessage.style.display = "none";
        errorMessage.textContent = "";
        passwordField.classList.remove("input-error");
        passwordConfirmationField.classList.remove("input-error");


        const password = passwordField.value;
        const passwordConfirmation = passwordConfirmationField.value;

 
        if (!passwordRegex.test(password)) {
            errorMessage.textContent = "La contraseña debe tener entre 8 y 16 caracteres, al menos 1 minúscula, 1 mayúscula, 1 número y 1 carácter especial.";
            errorMessage.style.display = "block";
            passwordField.classList.add("input-error");
            return false; 
        }


        if (password !== passwordConfirmation) {
            errorMessage.textContent = "Las contraseñas no coinciden.";
            errorMessage.style.display = "block";
            passwordConfirmationField.classList.add("input-error");
            return false; 
        }


        return true;
    }
</script>




</body>
</html>
