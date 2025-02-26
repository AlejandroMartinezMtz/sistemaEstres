// Función para mostrar/ocultar la barra lateral
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
  }
  
  // Envío automático del formulario cuando se borra el texto del input de búsqueda
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
      searchInput.addEventListener('input', function () {
        if (this.value === '') {
          document.getElementById('searchForm').submit();
        }
      });
    }
  
    // Ocultar el mensaje de error después de 5 segundos
    setTimeout(function () {
      const errorMessage = document.getElementById('error-message');
      if (errorMessage) {
        errorMessage.style.display = 'none';
      }
    }, 5000);
  
    // Ocultar el mensaje de éxito después de 5 segundos
    setTimeout(function () {
      const successMessage = document.getElementById('success-message');
      if (successMessage) {
        successMessage.style.display = 'none';
      }
    }, 5000);
  
    // Activar/desactivar modo oscuro
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
      const isDarkMode = localStorage.getItem('darkMode') === 'true';
  
      if (isDarkMode) {
        document.body.classList.add('dark-mode');
        darkModeToggle.checked = true;
      }
  
      darkModeToggle.addEventListener('change', () => {
        const isChecked = darkModeToggle.checked;
        document.body.classList.toggle('dark-mode', isChecked);
        localStorage.setItem('darkMode', isChecked);
      });
    }
  });
  

  document.addEventListener('DOMContentLoaded', () => {
    // Mostrar u ocultar el campo de programa educativo
    const estadoActivo = document.getElementById('estadoActivo');
    if (estadoActivo) {
        estadoActivo.addEventListener('change', function () {
            document.getElementById('programa_educativo').style.display = this.value == 1 ? 'block' : 'none';
        });
    }

    // Función para agregar una nueva pregunta
    window.agregarPregunta = function () {
        const container = document.getElementById('preguntas-container');
        if (container) {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'preguntas[]';
            input.placeholder = 'Escribe tu pregunta';
            container.appendChild(input);
        }
    };

    // Modo oscuro
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        const isDarkMode = localStorage.getItem('darkMode') === 'true';

        if (isDarkMode) {
            document.body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }

        darkModeToggle.addEventListener('change', () => {
            const isChecked = darkModeToggle.checked;
            document.body.classList.toggle('dark-mode', isChecked);
            localStorage.setItem('darkMode', isChecked);
        });
    }
});
