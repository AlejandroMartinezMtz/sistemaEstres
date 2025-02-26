@extends('panelVista.layout')

@section('content')

<div class="container">
    <h1 class="h3 mb-4">Dashboard  /Administrador</h1>

    <div class="row">
        <!-- Card para Gráfica de Género -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Distribución por Género</h5>
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Card para Encuestas de Alumnos -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Resultados de Encuestas</h5>
                    <canvas id="surveyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Card para Actividad en el Foro -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Actividad en el Foro</h5>
                    <canvas id="forumChart"></canvas>
                </div>
            </div>
        </div>

         <!-- Card para Nivel de Estrés -->
         <div class="col-md-6">
            <div class="card mb-2 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Niveles de Estrés</h5>
                    <div class="pie-chart-container">
                        <div class="chart-area">
                            <canvas id="stressChart"></canvas>
                        </div>
                        <div class="chart-legend" id="stressChartLegend">
        
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</div>





<script>
var genderData = {!! json_encode($genderData) !!}; // Ejemplo de datos
var total = Object.values(genderData).reduce((a, b) => a + b, 0); // Suma total de usuarios

var ctxGender = document.getElementById('genderChart').getContext('2d');
new Chart(ctxGender, {
    type: 'bar',
    data: {
        labels: Object.keys(genderData),
        datasets: [{
            label: 'Distribución de Género',
            data: Object.values(genderData),
            backgroundColor: ['#4eb6df', '#f15cde'],
        }]
    },
    options: {
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'end',
                formatter: function(value, context) {
                    // Calcular el porcentaje
                    var percentage = ((value / total) * 100).toFixed(2) + '%';
                    return value + ' (' + percentage + ')';
                },
                color: '#000', 
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Gráfica de Encuestas de Alumnos
var surveyData = {!! json_encode($surveyData) !!};
var ctxSurvey = document.getElementById('surveyChart').getContext('2d');
new Chart(ctxSurvey, {
    type: 'bar',
    data: {
        datasets: [{
            label: 'Nivel de satisfacción',
            data: surveyData,
            backgroundColor: ['#f13f27','#f18227','#ecdb3b','#64b4c0','#19e623']
        }]
    }
});



// Gráfica de Actividad en el Foro
var forumData = {!! json_encode($forumData) !!}; 

var ctxForum = document.getElementById('forumChart').getContext('2d');
new Chart(ctxForum, {
    type: 'bar',
    data: {
        labels: Object.keys(forumData),
        datasets: [{
            label: 'Actividad en el Foro',
            data: Object.values(forumData),
            backgroundColor: ['#1cc88a', '#4AD1B3']
        }]
    },
    options: {
        plugins: {
            datalabels: {
                anchor: 'start', 
                align: 'top', 
                offset: -10, 
                formatter: function(value) {
                    return value;
                },
                color: '#000'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
    plugins: [ChartDataLabels]
});



var stressData = {!! json_encode(array_values($stressData)) !!};
    var stressLabels = {!! json_encode(array_keys($stressData)) !!};

    var ctxStress = document.getElementById('stressChart').getContext('2d');

    // Crear la gráfica de pastel
    new Chart(ctxStress, {
        type: 'pie',
        data: {
            labels: stressLabels, 
            datasets: [{
                label: 'Niveles de Estrés',
                data: stressData, 
                backgroundColor: ['#1cc88a', '#4e73df', '#f6c23e', '#e74a3b']
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false, // Ocultamos la leyenda predeterminada
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw;
                            let total = stressData.reduce((a, b) => a + b, 0);
                            let percentage = ((value / total) * 100).toFixed(2);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                },
                datalabels: {
                    formatter: function(value, context) {
                        return value > 0 ? `Total: ${value}` : ''; 
                    },
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: {
                        weight: 'bold',
                        size: 10,
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Generar etiquetas en el contenedor
    var legendContainer = document.getElementById('stressChartLegend');
    var colors = ['#1cc88a', '#4e73df', '#f6c23e', '#e74a3b']; // Colores de la gráfica

    stressLabels.forEach((label, index) => {
        var legendItem = document.createElement('div');
        legendItem.style.display = 'flex';
        legendItem.style.alignItems = 'center';
        legendItem.style.marginBottom = '5px';

        var colorBox = document.createElement('span');
        colorBox.style.display = 'inline-block';
        colorBox.style.width = '15px';
        colorBox.style.height = '15px';
        colorBox.style.backgroundColor = colors[index];
        colorBox.style.marginRight = '10px';

        var labelText = document.createElement('span');
        labelText.textContent = `${label}`;

        legendItem.appendChild(colorBox);
        legendItem.appendChild(labelText);

        legendContainer.appendChild(legendItem);
    });


</script>


@endsection
