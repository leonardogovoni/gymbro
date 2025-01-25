<x-app-layout>
	@vite(['resources/css/training.css'])

	<!-- Header -->
	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ $workout_plan->title }} - Giorno {{ $day }}
			</h2>
		</div>
	</x-slot>

	<!-- Form exercise data -->
	<div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
		<livewire:training.data-model :workout_plan="$workout_plan" :day="$day" >
	</div>

	<!-- Timer logic -->
	@vite(['resources/js/timer.js'])

	<!-- Timer floating button -->
	<a id="timerFloatingButton" class="cursor-pointer fixed bottom-16 left-6 bg-blue-500 text-white text-lg font-bold py-2 px-4 rounded-full shadow-lg hover:bg-blue-600 flex items-center space-x-2">
		<x-mdi-timer-sand class="h-6"/>
		<span id="timerFloatingText">
			0
		</span>
	</a>

	<!-- Timer modal -->
	<div id="timerModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden transition">
	    <div class="bg-white p-8 rounded-lg shadow-xl max-w-xs w-full text-center">
	        <div id="timerText" class="text-4xl font-bold mb-4"></div>

	        <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
	            <div id="timerProgressBar" class="bg-blue-500 h-4 rounded-full" style="width: 100%"></div>
	        </div>

	        <!-- Contenitore per i pulsanti -->
        	<div class="flex justify-center space-x-4">
				<button id="timerReduce" class="bg-yellow-500 text-white py-2 px-4 rounded-lg">
					Riduci
				</button>
				<button id="timerStop" class="bg-red-500 text-white py-2 px-4 rounded-lg">
					Termina
				</button>
			</div>
	    </div>
	</div>

	<!-- Switch exercise bar -->
	<livewire:training.switch_exercise_bar :workout_plan="$workout_plan" :day="$day" />
</x-app-layout>