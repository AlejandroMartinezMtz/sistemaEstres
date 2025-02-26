document.addEventListener('DOMContentLoaded', function () {
    const notificationsList = document.getElementById('notificationsList');
    const notificationCount = document.getElementById('notificationCount');


    if (typeof routeNotificaciones === 'undefined' || typeof routeForo === 'undefined') {
        console.error("Las rutas de notificaciones o foro no están definidas.");
        return;
    }

    // Función para cargar las notificaciones
    function cargarNotificaciones() {
        fetch(routeNotificaciones)
            .then(response => response.json())
            .then(data => {
                notificationsList.innerHTML = '';
                notificationCount.textContent = '';

                const { publicaciones, comentarios } = data;
                let totalNotificaciones = publicaciones.length + comentarios.length;

                if (totalNotificaciones > 0) {
                    notificationCount.textContent = totalNotificaciones;

                    publicaciones.forEach(pub => {
                        const item = document.createElement('li');
                        item.innerHTML = `<a class="dropdown-item" href="${routeForo}#publicacion-${pub.id}">
                            Nueva publicación: ${pub.texto.substring(0, 30)}...
                        </a>`;
                        notificationsList.appendChild(item);
                    });

                    comentarios.forEach(com => {
                        const item = document.createElement('li');
                        item.innerHTML = `<a class="dropdown-item" href="${routeForo}#comentario-${com.id}">
                            Nuevo comentario: ${com.comentario.substring(0, 30)}...
                        </a>`;
                        notificationsList.appendChild(item);
                    });
                } else {
                    notificationsList.innerHTML = '<li><a class="dropdown-item" href="#">Sin notificaciones</a></li>';
                }
            })
            .catch(error => console.error('Error al cargar notificaciones:', error));
    }

    cargarNotificaciones();
});
