import Chart from 'chart.js/auto'; // Importa Chart.js

document.addEventListener('livewire:init', function () {
    console.log("Livewire caricato, in ascolto dell'evento 'updateChart'"); // Debug Biagio

    const ctx = document.getElementById('exerciseChart').getContext('2d');
    let chart;

    Livewire.on('updateChart', (exerciseData) => {
        console.log("Dati ricevuti:", exerciseData); // Controlla che i dati siano corretti
        const dataArray = exerciseData[0]; // Devo prendere l'array interno in indice 0 (vedi console)
        const labels = [...new Set(dataArray.map(data => data.date))];
        console.log("Labels:", labels); // Verifica le etichette
        const datasets = [];
        const sets = [...new Set(dataArray.map(data => data.sets))];
        console.log("Sets:", sets); // Verifica i set

        // Creo un dataset per ogni set
        sets.forEach(set => {
            const dataForSet = labels.map(date => {
                // Cerco i dati per la data e il set specificato :P
                const entry = dataArray.find(data => data.date === date && data
                    .sets === set);
                return entry ? entry.used_kg : 0;
            });

            datasets.push({
                label: `Set ${set}`,
                data: dataForSet,
                borderColor: `rgb(${getColorForSet(set)}, 0.1)`,
                backgroundColor: `rgba(${getColorForSet(set)}, 0.1)`,
                fill: true,
                tension: 0.1
            });
        });

        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // BIAGIO, TEST
                scales: {
                    x: {
                        type: 'category', // Tipo di scala per l'asse X
                        title: {
                            display: true,
                            text: 'Data'
                        }
                    },
                    y: {
                        beginAtZero: true, // Inizio da zero sull'asse Y
                        title: {
                            display: true,
                            text: 'Kg'
                        }
                    }
                }
            }
        });
    });

    // Funzione per ottenere un colore differente per ogni set
    function getColorForSet(set) {
        const colors = [
            '59, 130, 246', // blu
            '34, 197, 94', // verde
            '255, 165, 0', // arancione
            '255, 99, 132', // rosso
            '75, 85, 99' // grigio
        ];
        return colors[set - 1] || '59, 130, 246'; // Usa il blu come colore di default
    }
});