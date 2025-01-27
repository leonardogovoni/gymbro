// TIMER VARIABLES
let timer;
let originalTime;
let isRunning = false;
let timeRemaining;

// ========================================
// DOM ELEMENTS

// Pulsanti
const openButton = document.getElementById('timerFloatingButton');
const floatingText = document.getElementById('timerFloatingText');

// Elementi modali
const modal = document.getElementById('timerModal');
const text = document.getElementById('timerText');
const progressBar = document.getElementById('timerProgressBar');
const reduceButton = document.getElementById('timerReduce');
const stopButton = document.getElementById('timerStop');

// ========================================
// EVENT LISTENERS FOR LIVEWIRE

// Eseguito una sola volta al caricamento della pagina
// o quando viene cambiato un esercizio
Livewire.on('newRestTime', (restTime) => {
	// originalTime e' una costante, dichiarata 'let' solo per questioni di scope, non viene mai sovrascritta
	// al di fuori di questa funzione, indica il tempo originale dell'esercizio
	originalTime = restTime[0];
	
	// Gestisce il cambio di esercizio in caso il timer stia ancora funzionando
	if (isRunning) return;

	// Aggiorna il tempo rimanente, questa variabile verra' modificata
	timeRemaining = restTime[0];
	updateText();
});

// ========================================
// EVENT LISTENERS FOR BUTTONS

openButton.addEventListener('click', () => {
	modal.classList.remove('hidden');

	// Avvia il timer solo se non gia' attivo
	!isRunning && startTimer();
});

reduceButton.addEventListener('click', () => modal.classList.add('hidden'));
stopButton.addEventListener('click', () => stopTimer());

// ========================================
// FUNCTIONS

function startTimer () {
	if (isRunning) return;
	isRunning = true;

	timer = setInterval( () => {
		if (timeRemaining-- === 0) {
			stopTimer();
			return;
		}

		updateText();
		updateProgressBar();
	}, 1000);
}

function stopTimer () {
	clearInterval(timer);

	isRunning = false;
	timeRemaining = originalTime;
	
	updateText();
	updateProgressBar();

	modal.classList.add('hidden');
}

function updateText () {
	let minutes = Math.floor(timeRemaining / 60);
	let seconds = timeRemaining % 60;

	// Aggiunge uno zero se il numero di secondi e' minore di 10,
	// serve ad allineare le scritte
	seconds = seconds < 10 ? '0' + seconds : seconds;

	text.textContent = `${minutes}:${seconds}`;
	floatingText.textContent = `${minutes}:${seconds}`;
}

function updateProgressBar () {
	const percentage = (timeRemaining / originalTime) * 100;
	progressBar.style.width = `${percentage}%`;
}