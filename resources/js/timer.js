document.addEventListener('DOMContentLoaded', function() {
	let timer;

	// Converti il tempo iniziale in secondi
	let rest = parseTime(document.getElementById('timerDisplay').textContent);
	// Per verificare se il timer è in esecuzione
	let isRunning = false;
	// Tempo rimanente in secondi
	let timeRemaining = rest;

	const progressBar = document.getElementById('progressBar');
	const modalTimer = document.getElementById('modalTimer');
	const startButton = document.getElementById('startTimerButton');
	const modal = document.getElementById('timerModal');
	const reduceButton = document.getElementById('reduceButton');
	const closeButton = document.getElementById('closeButton');

	// Funzione per convertire il formato minuti:secondi in secondi totali
	function parseTime(timeStr) {
		let parts = timeStr.split(':');
		let minutes = parseInt(parts[0], 10);
		let seconds = parseInt(parts[1], 10);
		return minutes * 60 + seconds;
	}

	// Funzione per avviare il timer
	function startTimer() {
		if (isRunning)
			return;

		isRunning = true;

		timer = setInterval(function() {
			if (timeRemaining <= 0) {
				clearInterval(timer);
				isRunning = false;
				return;
			}

			timeRemaining--;
			updateTimerDisplay();
			updateProgressBar();
		}, 1000);
	}

	// Funzione per aggiornare la visualizzazione del timer (in formato minuti:secondi)
	function updateTimerDisplay() {
		let minutes = Math.floor(timeRemaining / 60); // Ottieni i minuti
		let seconds = timeRemaining % 60; // Ottieni i secondi
		seconds = seconds < 10 ? '0' + seconds : seconds; // Aggiungi uno zero davanti ai secondi se è inferiore a 10
		modalTimer.textContent = `${minutes}:${seconds}`;
		document.getElementById('timerDisplay').textContent = `${minutes}:${seconds}`;
	}

	// Funzione per aggiornare la barra di progresso
	function updateProgressBar() {
		const percentage = (timeRemaining / rest) * 100;
		progressBar.style.width = `${percentage}%`;
	}

	// Funzione per aprire il modale
	startButton.addEventListener('click', function(event) {
		event.preventDefault();

		// Rimuove la classe 'hidden' per mostrare il modale e aggiunge la classe 'flex' per mantenerlo centrato. La classe non viene inserita
		// direttamente nel Blade altrimenti VS Code restituisce un warning, se trovate un modo di sopprimerlo, potete eliminare l'add di 'flex'
		modal.classList.add('flex');
		modal.classList.remove('hidden');

		if (!isRunning) {
			// Mostra il tempo iniziale nel modale
			updateTimerDisplay();
			// Mostra la barra di progresso iniziale
			updateProgressBar();

			if (timeRemaining === rest)
				// Inizializza solo se il timer non è stato ancora avviato
				startTimer();
		}
	});

	// Funzione per ridurre il modale
	reduceButton.addEventListener('click', function() {
		// Nasconde il modale
		modal.classList.add('hidden');
	});

	// Funzione per chiudere il modale e fermare il timer
	closeButton.addEventListener('click', function() {
		// Ferma il timer
		clearInterval(timer);

		// Resetta il timer ai valori di default
		isRunning = false;
		timeRemaining = rest;
		updateTimerDisplay();
		updateProgressBar();

		// Nasconde il modale
		modal.classList.add('hidden');
	});
});