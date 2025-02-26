document.addEventListener('DOMContentLoaded', function () {
    const stressData = JSON.parse(document.getElementById('stressData').value);
    const ctx = document.getElementById('stressChart').getContext('2d');
    
    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(stressData),
            datasets: [{
                label: 'Niveles de Estrés',
                data: Object.values(stressData),
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b'],
            }]
        }
    });

    // Convertir el gráfico a imagen base64
    document.getElementById('chartImage').value = ctx.canvas.toDataURL();
});
