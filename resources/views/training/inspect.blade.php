<x-app-layout>
	<!-- Header -->
	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ $workout_plan->title }} - Giorno {{ $day }}
			</h2>
		</div>
	</x-slot>

	<!-- Form esecuzione esercizio -->
	<div class="max-w-3xl mt-4 mx-auto pb-20">
		<livewire:training.data-model :workout_plan="$workout_plan" :day="$day" />
	</div>

	<!-- JS Timer -->
	@vite(['resources/js/timer.js'])

	<!-- Pulsante Timer -->
	<a id="timerFloatingButton" class="cursor-pointer fixed bottom-16 left-6 bg-primary-500 text-white text-lg font-bold py-2 px-4 rounded-full shadow-lg hover:bg-primary-600 flex items-center space-x-2">
		<x-mdi-timer-sand class="h-6"/>
		<span id="timerFloatingText">
			0
		</span>
	</a>

	<!-- Modale Timer -->
	<div id="timerModal" class="bg-black bg-opacity-40 z-50 backdrop-blur-sm fixed inset-0 flex justify-center items-center hidden transition">
		<div class="bg-white p-8 rounded-lg shadow-xl max-w-xs w-full text-center">
			<div id="timerText" class="text-4xl font-bold mb-4"></div>

			<div class="w-full bg-gray-200 rounded-full h-4 mb-4">
				<div id="timerProgressBar" class="bg-primary-500 h-4 rounded-full" style="width: 100%"></div>
			</div>

			<!-- Contenitore per i pulsanti -->
			<div class="flex justify-center space-x-4">
				<button id="timerReduce" class="secondary-button">
					Riduci
				</button>
				<button id="timerStop" class="danger-button">
					Termina
				</button>
			</div>
		</div>
	</div>

	<!-- Barra cambio esercizio -->
	<livewire:training.switch_exercise_bar :workout_plan="$workout_plan" :day="$day" />
</x-app-layout>