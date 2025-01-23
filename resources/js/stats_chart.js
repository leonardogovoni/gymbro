import Chart from 'chart.js/auto'; // Importa Chart.js

document.addEventListener('livewire:init', function () {
    const ctx = document.getElementById('exerciseChart').getContext('2d');
    let chart;

    Livewire.on('updateChart', (exerciseData) => {
        const dataArray = exerciseData[0];
        const labels = [...new Set(dataArray.map(data => {
            const date = new Date(data.created_at);
            return date.toLocaleDateString('it-IT', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }))];

        const datasets = [];
        const sets = [...new Set(dataArray.map(data => data.set))];

        sets.forEach(set => {
            const dataForSet = labels.map(created_at => {
                const entry = dataArray.find(data => {
                    const entryDate = new Date(data.created_at).toLocaleDateString('it-IT', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                    return entryDate === created_at && data.set === set;
                });
                const usedWeight = entry ? Number(entry.used_weights) : 0;
                return usedWeight;
            });

            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, `rgba(${getColorForSet(set)}, 0.4)`);
            gradient.addColorStop(1, `rgba(${getColorForSet(set)}, 0)`);

            datasets.push({
                label: `Set ${set}`,
                data: dataForSet,
                borderColor: `rgb(${getColorForSet(set)}, 1)`,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: `rgb(${getColorForSet(set)}, 1)`,
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
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Data',
                            font: {
                                size: 16,
                                family: 'Arial',
                                weight: 'bold',
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kg',
                            font: {
                                size: 16,
                                family: 'Arial',
                                weight: 'bold',
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `Kg: ${tooltipItem.raw}`;
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Arial',
                                size: 14,
                                weight: 'bold',
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart',
                }
            }
        });
    });

    function getColorForSet(set) {
        const colors = [
            '59, 130, 246', // blu
            '34, 197, 94', // verde
            '255, 165, 0', // arancione
            '255, 99, 132', // rosso
            '75, 85, 99' // grigio
        ];
        return colors[set - 1] || '59, 130, 246';
    }
});
