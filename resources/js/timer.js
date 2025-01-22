// TIMER VARIABLES
let timer;
var rest;
var nextRest;
let isRunning = false;
let timeRemaining;

// ========================================

// DOM ELEMENTS
// Floating button elements
const openButton = document.getElementById('timerFloatingButton');
const floatingText = document.getElementById('timerFloatingText');
// Modal elements
const modal = document.getElementById('timerModal');
const text = document.getElementById('timerText');
const progressBar = document.getElementById('timerProgressBar');
const reduceButton = document.getElementById('timerReduce');
const stopButton = document.getElementById('timerStop');

// ========================================

// EVENT LISTENERS FOR LIVEWIRE
// Gets rest time from the form everytime the exercise changes
Livewire.on('newRestTime', (restTime) => {
	if(isRunning)
		nextRest = restTime[0];
	else {
		rest = restTime[0];
		timeRemaining = rest;
		updateText();
	}
});

// ========================================

// EVENT LISTENERS FOR BUTTONS
openButton.addEventListener('click', function(event) {
	modal.classList.remove('hidden');

	if(!isRunning)
		startTimer();
});

reduceButton.addEventListener('click', function() {
	modal.classList.add('hidden');
});

stopButton.addEventListener('click', stopTimer());

// ========================================

// FUNCTIONS
function startTimer() {
	if (isRunning)
		return;

	isRunning = true;

	timer = setInterval(function() {
		if (timeRemaining == 0) {
			stopTimer();
			return;
		}

		timeRemaining--;

		updateText();
		updateProgressBar();
	}, 1000);
}

function stopTimer() {
	clearInterval(timer);

	isRunning = false;
	rest = nextRest;
	timeRemaining = rest;
	
	updateText();
	updateProgressBar();

	modal.classList.add('hidden');
}

function updateText() {
	let minutes = Math.floor(timeRemaining / 60);
	let seconds = timeRemaining % 60;
	// Adds a zero in front of seconds if lower than 10
	seconds = seconds < 10 ? '0' + seconds : seconds;

	text.textContent = `${minutes}:${seconds}`;
	floatingText.textContent = `${minutes}:${seconds}`;
}

function updateProgressBar() {
	const percentage = (timeRemaining / rest) * 100;
	progressBar.style.width = `${percentage}%`;
}