document.addEventListener('DOMContentLoaded', function() {
    let timer;
    let rest = parseTime(document.getElementById('timerDisplay').textContent); // Converti il tempo iniziale in secondi
    let isRunning = false; // Per verificare se il timer è in esecuzione
    let timeRemaining = rest; // Tempo rimanente in secondi
    const progressBar = document.getElementById('progressBar');
    const modalTimer = document.getElementById('modalTimer');
    const startButton = document.getElementById('startTimerButton');
    const modal = document.getElementById('timerModal');
    const reduceButton = document.getElementById('reduceButton');
    const closeButton = document.getElementById('closeButton');

    // Funzione per convertire il formato minuti:secondi in secondi totali
    function parseTime(timeStr) {
        let parts = timeStr.split(':');
        let minutes = parseInt(parts[0], 10); // Ottieni i minuti
        let seconds = parseInt(parts[1], 10); // Ottieni i secondi
        return minutes * 60 + seconds; // Ritorna il totale in secondi
    }

    // Funzione per avviare il timer
    function startTimer() {
        if (!isRunning) {
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

        if (isRunning) {
            modal.classList.remove('hidden'); // Mostra il modale solo se il timer è già in esecuzione
        } else {
            modal.classList.remove('hidden'); // Mostra il modale
            if (timeRemaining === rest) {
                // Inizializza solo se il timer non è stato ancora avviato
                updateTimerDisplay(); // Mostra il tempo iniziale nel modale
                updateProgressBar(); // Mostra la barra di progresso iniziale
                startTimer(); // Avvia il timer
            } else {
                // Non reimpostiamo il tempo se il timer è già in esecuzione
                updateTimerDisplay(); // Mostra il tempo attuale nel modale
                updateProgressBar(); // Mostra la barra di progresso con il tempo rimanente
            }
        }
    });

    // Funzione per ridurre il modale
    reduceButton.addEventListener('click', function() {
        modal.classList.add('hidden'); // Nascondi il modale
    });

    // Funzione per chiudere il modale e fermare il timer
    closeButton.addEventListener('click', function() {
        clearInterval(timer); // Ferma il timer
        isRunning = false;
        timeRemaining = rest; // Reset del timer
        updateTimerDisplay(); // Mostra il tempo iniziale
        updateProgressBar(); // Reset della barra di progresso
        modal.classList.add('hidden'); // Nascondi il modale
    });
});