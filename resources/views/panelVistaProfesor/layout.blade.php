<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profesor Dashboard</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome Icons (CDN) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

  
  
  <link href= "{{asset('css/styleDashboard.css')}}" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

 
</head>
<body>

 <button class="btn btn-dark toggle-sidebar-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </button>
  <nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class='bx bxs-wink-smile' ></i>Estrés<span class="admin-text">Test</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto">

         <!-- Dark Mode Toggle-->
         <li class="nav-item d-flex align-items-center">
              <i class="fas fa-moon me-2"></i>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle">  </label>
              </div>
          </li>

        <li class="nav-item menuInicio">
          <a class="nav-link" href="{{ route('profesor.foro') }}">Foro</a>
        </li>


          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-bell"></i> <!--<span class="badge bg-danger">3</span>-->
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
              <li><a class="dropdown-item" href="#">Sin notificaciones</a></li>

            </ul>
          </li>
          
          <li class="nav-item dropdown ms-3">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/adminLogin.png') }}" class="rounded-circle" alt="User Profile">
              <Strong><span class="ms-2 text-white" >{{ Auth::user()->nombre }}</span></Strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">

              <li><hr class="dropdown-divider"></li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
               @csrf
              </form>
              <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 sidebar p-3" id="sidebar">
        <ul class="nav flex-column">
        <li class="nav-item">
                    <a class="nav-link" href="{{ route('usuarios.profesorDashboard') }}">
                    <i class='bx bx-bar-chart-alt'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('usuarioProfesor.index') }}">
                    <i class='bx bx-group'></i> Alumnos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cuestionarioProfesor.index') }}">
                    <i class='bx bx-receipt'></i> Cuestionarios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('encuestaProfesor.index') }}">
                    <i class='bx bx-file'></i> Encuestas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('envioEncuesta.index') }}">
                    <i class='bx bx-file'></i> Seguimiento
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('envioRecomendacion.index') }}">
                    <i class='bx bx-file'></i> Asignación
                    </a>
                </li>

                
        </ul>
      </div>
      <div class="col-md-9 col-lg-10 content p-4">

        @yield('content')
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer mt-auto">

  </footer>

  <!-- Bootstrap 5 JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  
  <script src="{{ asset('js/funciones.js') }}" defer></script>

</body>
</html>
