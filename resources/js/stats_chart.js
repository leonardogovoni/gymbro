import Chart from 'chart.js/auto'; // Importa Chart.js

document.addEventListener('DOMContentLoaded', function () {
    const exerciseData = window.exerciseData; // Array di oggetti ExerciseData
    
    // Prepara le etichette per l'asse X (date)
    const labels = [...new Set(exerciseData.map(data => data.date))]; 
    
    // Raggruppa i dati per data e set
    const groupedData = labels.reduce((acc, label) => {
        acc[label] = exerciseData.filter(data => data.date === label);
        return acc;
    }, {});

    // Crea un array per i dataset dei diversi sets
    const datasets = [];
    const sets = [...new Set(exerciseData.map(data => data.sets))]; // Estrai tutti i set unici

    // Per ogni set, crea un dataset
    sets.forEach(set => {
        const dataForSet = labels.map(date => {
            // Cerca i dati per la data e il set specifico
            const dataForDate = groupedData[date].find(data => data.sets === set);
            return dataForDate ? dataForDate.used_kg : 0; // Usa 0 se non ci sono dati per quella data
        });

        datasets.push({
            label: `Set ${set}`, // Etichetta per la serie
            data: dataForSet,
            borderColor: `rgb(${getColorForSet(set)}, 0.1)`, // Colore della linea per il set
            backgroundColor: `rgba(${getColorForSet(set)}, 0.1)`, // Colore di sfondo
            fill: true, // Riempi l'area sotto la linea
            tension: 0.1 // Smussa la linea
        });
    });

    // Funzione per ottenere un colore differente per ogni set
    function getColorForSet(set) {
        const colors = [
            '59, 130, 246', // blu
            '34, 197, 94',  // verde
            '255, 165, 0',  // arancione
            '255, 99, 132', // rosso
            '75, 85, 99'    // grigio
        ];
        return colors[set - 1] || '59, 130, 246'; // Usa il blu come colore di default
    }

    // Crea il contesto del grafico
    const ctx = document.getElementById('exerciseChart').getContext('2d');

    // Crea il grafico
    new Chart(ctx, {
        type: 'line', // Tipo di grafico
        data: {
            labels: labels, // Dati dell'asse X (date)
            datasets: datasets // I datasets per ogni set
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
