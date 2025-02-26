@extends('panelVistaAlumno.layout')

@section('content')
    <!-- Carousel -->
<div id="avisosCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
  <div class="carousel-inner">
    @foreach ($avisos as $index => $aviso)
      <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
        <img src="{{ asset($aviso->imagenUrl) }}" class="d-block w-100 h-80" alt="Aviso">
      </div>
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#avisosCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#avisosCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>



<!-- Tips para reducir el estrés -->
<div class="row justify-content-center">
  <div class="col-md-11 mb-4">
    <div class="card h-100 d-flex flex-row custom-card">
      <!-- Imagen en el lado izquierdo -->
      <div class="card-img-left">
        <img src="/images/ejercicioFisicoInicio2.jpg" alt="Ejercicio Físico" class="img-fluid custom-img">
          <div class="text-center custom-footer">
            <a>Designed by </a>
            <a href="https://www.freepik.es/vector-gratis/fondo-pareja-confirmando-lista-comprobacion-gigante_4058677.htm#fromView=keyword&page=1&position=23&uuid=19d2fd78-21f7-4768-a9c8-c737b806b990" target="_blank">freepik</a>
         </div>
      </div>
      
     

      <!-- Texto en el lado derecho -->
      <div class="card-body custom-card-body">
        <h5 class="card-title">Ejercicio Físico</h5>
        <p class="card-text">
          El ejercicio físico es una de las maneras más efectivas de reducir el estrés. 
          Al realizar actividad física, el cuerpo libera endorfinas, conocidas como "hormonas 
          de la felicidad", que ayudan a mejorar el estado de ánimo y reducir la percepción del 
          estrés. Además, el ejercicio regular mejora la calidad del sueño, reduce la ansiedad y 
          proporciona una forma saludable de canalizar la tensión acumulada. Mantenerse activo no 
          solo fortalece el cuerpo, sino que también promueve el bienestar mental, creando un equilibrio 
          que resulta en una mente más relajada y enfocada.
        </p>
        

       

      </div>
    </div>
  </div>
</div>


@endsection
