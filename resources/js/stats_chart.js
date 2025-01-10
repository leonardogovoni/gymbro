import Chart from 'chart.js/auto'; // Importa Chart.js

// Assicurati che il documento sia pronto prima di iniziare a creare il grafico
document.addEventListener('DOMContentLoaded', function () {
    // Dati passati dalla vista
    const exerciseData = ($exerciseData); // Array di oggetti ExerciseData
    
    // Prepara i dati per il grafico
    const labels = exerciseData.map(data => data.date); // Etichette per l'asse X (date)
    const usedKg = exerciseData.map(data => data.used_kg); // Dati per l'asse Y (kg)

    // Crea il contesto del grafico
    const ctx = document.getElementById('exerciseChart').getContext('2d');

    // Crea il grafico
    new Chart(ctx, {
        type: 'line', // Tipo di grafico
        data: {
            labels: labels, // Dati dell'asse X (date)
            datasets: [{
                label: 'Kg usati', // Etichetta per la linea
                data: usedKg, // Dati dell'asse Y (kg)
                borderColor: '#3b82f6', // Colore della linea
                backgroundColor: 'rgba(59, 130, 246, 0.1)', // Colore di sfondo della linea
                fill: true, // Riempi l'area sotto la linea
                tension: 0.4 // Smussa la linea
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
                    beginAtZero: true, // Inizia da zero sull'asse Y
                    title: {
                        display: true,
                        text: 'Kg'
                    }
                }
            }
        }
    });
});
