import Chart from 'chart.js/auto';  // Importa la libreria Chart.js

document.addEventListener('DOMContentLoaded', function () {
    const chartData = @json($chartData);  // I dati passati dal controller
    
    // Prepara i dati per il grafico
    const labels = chartData.map(data => data.date);
    const usedKg = chartData.map(data => data.used_kg);

    const ctx = document.getElementById('exerciseChart').getContext('2d');
    
    const exerciseChart = new Chart(ctx, {
        type: 'line', // Tipo di grafico (linea)
        data: {
            labels: labels,
            datasets: [{
                label: 'Kg usati',
                data: usedKg,
                borderColor: '#3b82f6', // Colore della linea
                backgroundColor: 'rgba(59, 130, 246, 0.1)', // Colore di sfondo
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'category', // Tipo di scala per l'asse X
                    title: {
                        display: true,
                        text: 'Data'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Kg'
                    }
                }
            }
        }
    });
});
