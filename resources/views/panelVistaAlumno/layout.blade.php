<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome Icons (CDN) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  
  <link href= "{{asset('css/estiloInicio.css')}}" rel="stylesheet">
  <!-- Custom styles (optional) -->
 
</head>
<body>



 <!-- Navbar (Topbar) -->
 <nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class='bx bxs-wink-smile' ></i>Estrés<span class="admin-text">Test</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto">

       <!-- Dark Mode Toggle -->
       <li class="nav-item d-flex align-items-center">
              <i class="fas fa-moon me-2"></i>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle">  </label>
              </div>
          </li>
        <!-- Opción de inicio -->
        <li class="nav-item menuInicio">
          <a class="nav-link text-white" href="{{ route('alumno.inicio') }}">Inicio</a>
        </li>

        <li class="nav-item menuInicio">
          <a class="nav-link text-white" href="{{ route('alumno.foro') }}">Foro</a>
        </li>

        <!-- Opción de cuestionarios -->
        <li class="nav-item menuInicio">
          <a class="nav-link text-white" href="{{ route('alumnoCuestionario.inicio') }}">Cuestionarios</a>
        </li>

        <!-- Opción de cuestionarios -->
        <li class="nav-item menuInicio">
          <a class="nav-link text-white" href="{{ route('alumnoEncuesta.inicio') }}">Encuestas</a>
        </li>

        <!-- Opción de ejercicios -->
        <li class="nav-item menuInicio">
          <a class="nav-link text-white" href="{{ route('alumnoEjercicio.inicio') }}">Ejercicios</a>
        </li>

        <!-- Opción de ejercicios -->
        <li class="nav-item menuInicio">
          <a class="nav-link text-white" href="{{ route('alumnoPasatiempo.inicio') }}">Pasatiempos</a>
        </li>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto">
          <!-- Notification Icon -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-bell"></i> <span id="notificationCount" class="badge bg-danger"></span>
            </a>
            <ul id="notificationsList" class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
            <!-- Aquí se cargan las notificaciones dinámicamente -->


            </ul>
          </li>
          
          <!-- User Profile Icon -->
          <li class="nav-item dropdown ms-3">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/adminLogin.png') }}" class="rounded-circle" alt="User Profile">
              <Strong><span class="ms-2 text-white" >{{ Auth::user()->nombre }}</span></Strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <!--<li><a class="dropdown-item" href="#">Perfil</a></li>
              <li><a class="dropdown-item" href="#">Configuraciones</a></li>-->
              <li><hr class="dropdown-divider"></li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
               @csrf
              </form>
              <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a></li>
              <!--li><a class="dropdown-item" href="#">Logout</a></li-->
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>


   <!-- Content -->
   <div class="col-md-11 col-lg-11 content p-3">

        @yield('content')
    </div>

     <!-- Footer -->
  <footer class="footer mt-auto">
    <div class="alumno">
      <span class="text-muted">© 2024 EstresTest</span>
    </div>
  </footer>

  <!-- Bootstrap 5 JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="{{ asset('js/funciones.js') }}" defer></script>

<script>
    var routeNotificaciones = "{{ route('notificaciones.obtener') }}";
    var routeForo = "{{ route('alumno.foro') }}";
</script>
<script src="{{ asset('js/notificaciones.js') }}" defer></script>


</body>
</html>