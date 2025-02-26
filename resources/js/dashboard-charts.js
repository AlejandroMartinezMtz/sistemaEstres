function renderCharts(genderData, surveyData, forumData, stressData) {
    // Gráfica de Género
    var total = Object.values(genderData).reduce((a, b) => a + b, 0); // Suma el total de usuarios
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
                    formatter: function(value) {
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

    // Gráfica de Encuestas
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
    var ctxForum = document.getElementById('forumChart').getContext('2d');
    new Chart(ctxForum, {
        type: 'bar',
        data: {
            labels: Object.keys(forumData),
            datasets: [{
                label: 'Actividad en el Foro',
                data: Object.values(forumData),
                backgroundColor: ['#1cc88a', '#4AD1B3'],
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    formatter: function(value) {
                        return value;
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

    // Gráfica de Niveles de Estrés
    var stressLabels = Object.keys(stressData);
    var ctxStress = document.getElementById('stressChart').getContext('2d');
    new Chart(ctxStress, {
        type: 'pie',
        data: {
            labels: stressLabels,
            datasets: [{
                label: 'Niveles de Estrés',
                data: Object.values(stressData),
                backgroundColor: ['#1cc88a', '#4e73df', '#f6c23e', '#e74a3b']
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    formatter: function(value) {
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
}
