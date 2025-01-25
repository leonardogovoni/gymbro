// Importazione dei moduli
import Chart from 'chart.js/auto';

document.addEventListener('livewire:init', function () {
	const ctx = document.getElementById('exerciseChart').getContext('2d');
	let chart = null;

	// Eventi Livewire
	Livewire.on('updateChartKgs', (exerciseData) => {
		const data = getDataForChart(exerciseData, 'used_weights');
		createChart('used_weights', data[0], data[1]);
	});

	Livewire.on('updateChartReps', (exerciseData) => {
		const data = getDataForChart(exerciseData, 'reps');
		createChart('reps', data[0], data[1]);
	});

	// ==================================================
	// Creazione e aggiornamento grafico

	function getDataForChart (exerciseData, type) {
		const dataArray = exerciseData[0];
		const labels = [...new Set(dataArray.map(data => {			
			return getFormattedDate(data.created_at);
		}))];

		const datasets = [];
		const sets = [...new Set(dataArray.map(data => data.set))];

		sets.forEach(set => {
			const dataForSet = labels.map(created_at => {
				const entry = dataArray.find(data => {
					return getFormattedDate(data.created_at) === created_at && data.set === set;
				});

				// Filtra i dati richiesti in base allo switch, accedere a entry[type] significa accedere a un attributo di valore 'type' di 'entry'
				// E' equivalente a 'entry.uses_weights' oppure 'entry.reps'
				const dataType = entry ? Number(entry[type]) : 0;
				return dataType;
			});

			const gradient = ctx.createLinearGradient(0, 0, 0, 400);
			gradient.addColorStop(0, `rgba(${getColorForSet(set)}, 0.4)`);
			gradient.addColorStop(1, `rgba(${getColorForSet(set)}, 0)`);

			datasets.push({
				label: `Serie ${set}`,
				data: dataForSet,
				borderColor: `rgb(${getColorForSet(set)}, 1)`,
				backgroundColor: gradient,
				fill: true,
				tension: 0.4,
				borderWidth: 2,
				pointRadius: 3,
				pointHoverRadius: 7,
				pointBackgroundColor: `rgb(${getColorForSet(set)}, 1)`
			});
		});

		return [labels, datasets];
	}

	function createChart (type, labels, datasets) {
		// Se il grafico e' gia' esistente, lo aggiorna, altrimenti lo crea!
		// Questo previene il glitch grafico della pagina
		if (chart !== null) {
			updateChart([labels, datasets], type);
			return;
		}

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
					x: getCoordinateObject('Data'),
					y: {
						beginAtZero: true,
						...getCoordinateObject(type === 'used_weights' ? 'Kg' : 'Ripetizioni')
					},
				},
				plugins: {
					tooltip: {
						callbacks: {
							label: function(tooltipItem) {
								// Questo sistema e' poco scalabile perche' accetta solo due opzioni,
								// per il momento rimane cosi'
								return type === 'used_weights' ? `Kg: ${tooltipItem.raw}` : `Rip.: ${tooltipItem.raw}`;
							}
						}
					},
					legend: {
						position: 'top',
						labels: {
							font: {
								family: 'Arial',
								size: 14,
								weight: 'bold'
							}
						}
					}
				},
				animation: {
					duration: 1000,
					easing: 'easeInOutQuart'
				}
			}
		});
	};

	function updateChart (data, type) {
		chart.data.labels = data[0];
		chart.data.datasets = data[1];

		// Aggiorna la barra Y
		chart.options.scales.y = {
			beginAtZero: true,
			...getCoordinateObject(type === 'used_weights' ? 'Kg' : 'Ripetizioni')
		}

		// Importante il resize(), senza appare
		// zoomato e completamente rotto
		chart.resize();
		chart.update();
	}

	// ==================================================
	// Riscritte come funzioni per evitare duplicazioni

	function getColorForSet (set) {
		const colors = [
			'59, 130, 246',	// Blu
			'34, 197, 94',	// Verde
			'255, 165, 0',	// Arancione
			'255, 99, 132',	// Rosso
			'75, 85, 99'	// Grigio
		];
		return colors[set - 1] || '59, 130, 246';
	}

	// Formattazione della data
	function getFormattedDate (date) {
		return new Date(date).toLocaleDateString('it-IT', {
			day: '2-digit',
			month: '2-digit',
			year: 'numeric'
		});
	}

	// Creazione oggetto per le coordinate
	function getCoordinateObject (text) {
		return {
			title: {
				display: true,
				text: text,
				font: {
					size: 16,
					family: 'Arial',
					weight: 'bold'
				}
			},
			grid: {
				color: 'rgba(0, 0, 0, 0.1)'
			}
		}
	}
});