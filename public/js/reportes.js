document.addEventListener('DOMContentLoaded', function () {
    // Obtener datos del gráfico desde Laravel
    var stressData = JSON.parse(document.getElementById('stressChart').dataset.stressData);
    var stressLabels = JSON.parse(document.getElementById('stressChart').dataset.stressLabels);

    // Configurar el gráfico de estrés
    var ctxStress = document.getElementById('stressChart').getContext('2d');
    var stressChart = new Chart(ctxStress, {
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
                datalabels: {
                    formatter: function (value) {
                        return value > 0 ? 'Total de alumnos: ' + value : '';
                    },
                    color: '#fff',
                    anchor: 'center',
                    align: 'center'
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Capturar el gráfico como imagen y enviarlo al backend
    document.getElementById('generateCuestionario').addEventListener('click', function (e) {
        e.preventDefault();
        var selectedDates = document.getElementById('dateRange').value;
        if (selectedDates) {
            var chartImage = stressChart.toDataURL();

            fetch("{{ route('reporte.cuestionario') }}?dates=" + encodeURIComponent(selectedDates) + "&export=pdf", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ chartImage: chartImage })
            })
            .then(response => response.json())
            .then(data => {
                window.open(data.url, '_blank'); 
            })
            .catch(error => console.error('Error:', error));
        } else {
            alert('Por favor, selecciona un rango de fechas.');
        }
    });

    
});


