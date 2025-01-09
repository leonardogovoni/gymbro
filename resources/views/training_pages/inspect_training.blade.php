<x-app-layout>
	@vite(['resources/css/training.css'])

	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ $workout_plan_title }} - Giorno {{ $day }}
			</h2>
		</div>
	</x-slot>

	<livewire:exercise-data-modal :count="$exercises->count()" :name="$exercises[$currentIndex]->name" :image="$exercises[$currentIndex]->image" :exercise-id="$exercises[$currentIndex]->id" :series="$exercises[$currentIndex]->pivot->series" :repetitions="$exercises[$currentIndex]->pivot->repetitions" :day="$day" />
	
	<!-- Bottone flottante "Timer" -->
	<livewire:exercise-timer :rest="$exercises[$currentIndex]->pivot->rest"/>

	<!-- Barra per il cambio esercizio (fissa in fondo alla pagina) -->
	<div class="fixed bottom-0 w-full bg-white dark:bg-gray-800 shadow-lg py-2 flex justify-center items-center">
		<button
			@if ($currentIndex > 0) class="text-black dark:text-white bg-white dark:bg-gray-800 p-2 rounded"
				onclick="window.location='{{ route('training_pages.inspect_training', ['day' => $day, 'exercise' => $currentIndex - 1]) }}'"
			@else
				class="text-white bg-white dark:text-gray-800 dark:bg-gray-800 p-2 rounded"
				disabled @endif>
			<x-mdi-arrow-left class="h-6" />
		</button>

		<span class="mx-4 text-gray-800 dark:text-white">{{ $currentIndex + 1 }} / {{ $exercises->count() }}</span>

		<button
			@if ($currentIndex < $exercises->count() - 1) class="text-black dark:text-white bg-white dark:bg-gray-800 p-2 rounded"
				onclick="window.location='{{ route('training_pages.inspect_training', ['day' => $day, 'exercise' => $currentIndex + 1]) }}'"
			@else
				class="text-white bg-white dark:text-gray-800 dark:bg-gray-800 p-2 rounded"
				disabled @endif>
			<x-mdi-arrow-right class="h-6" />
		</button>
	</div>
</x-app-layout>
