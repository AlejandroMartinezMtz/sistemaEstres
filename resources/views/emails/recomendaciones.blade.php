<p>Hola {{ $nombre }},</p>

<p>Se han asignado pasatiempos y ejercicios para ti:</p>

<ul>
    <li><strong>Objetivo:</strong> Reducir tu nivel de estrés</li>
    <li><strong>Ejercicios asignados:</strong></li>
    <ul>
        @foreach($ejercicios as $ejercicio)
            <li>{{ $ejercicio }}</li>
        @endforeach
    </ul>
    <li><strong>Pasatiempos asignados:</strong></li>
    <ul>
        @foreach($pasatiempos as $pasatiempo)
            <li>{{ $pasatiempo }}</li>
        @endforeach
    </ul>
</ul>

<p>Por favor, inicia sesión en EstresTest y lleva a cabo las recomendaciones.</p>

<p>Saludos</p>
