<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Publicación</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: auto; padding: 20px; }
        .header { background-color: #f2f2f2; padding: 10px; text-align: center; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #666; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Nueva Publicación en el Foro!</h1>
        </div>

        <p>Hola {{ $nombre }} {{ $apellidoP }},</p>

        <p>Te informamos que {{ auth()->user()->nombre }} ha compartido una nueva publicación en el foro.</p>


        <p>No dudes en revisar el foro y participar en la conversación.</p>

        <p>Saludos,<br>
        EstresTest</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Tu Plataforma de Aprendizaje</p>
        </div>
    </div>
</body>
</html>
