// Elementi HTML
const infoButton = document.getElementById('infoButton');
const infoDiv = document.getElementById('infoModal');
const closeInfo = document.getElementById('closeInfo');

infoButton.addEventListener('click', () => {
	infoDiv.classList.remove('hidden');
});

closeInfo.addEventListener('click', () => {
	infoDiv.classList.add('hidden');
});
