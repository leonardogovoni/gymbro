@vite(['resources/js/timer.js'])

<div>
    <!-- Bottone principale del timer -->
    <a href="#" class="fixed bottom-16 left-6 bg-blue-500 text-white text-lg font-bold py-2 px-4 rounded-full shadow-lg hover:bg-blue-600 flex items-center space-x-2" id="startTimerButton">
        <x-mdi-timer-sand class="h-6"/>
        <span id="timerDisplay">{{ $rest }}</span>
    </a>
    
    <!-- Modale Timer -->
    <div id="timerModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-xs w-full text-center">
            <div id="modalTimer" class="text-4xl font-bold mb-4">{{ $rest }}</div>
            <!-- Barra di progresso -->
            <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                <div id="progressBar" class="bg-blue-500 h-4 rounded-full" style="width: 100%"></div>
            </div>
            <!-- Bottoni sotto il timer -->
            <button id="reduceButton" class="bg-yellow-500 text-white py-2 px-4 rounded-lg mr-4">Riduci</button>
            <button id="closeButton" class="bg-red-500 text-white py-2 px-4 rounded-lg">Chiudi</button>
        </div>
    </div>
</div>