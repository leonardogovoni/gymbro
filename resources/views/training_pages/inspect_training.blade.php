<x-app-layout>
	@vite(['resources/css/training.css'])

	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ $workout_plan_title }}
			</h2>
		</div>
	</x-slot>

	<div class="py-12">
		<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
					@if ($exercises->count() > 0)
						<div class="exercise-item p-4 bg-white dark:bg-gray-900 rounded-lg shadow text-center">
							<h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
								{{ $exercises[$currentIndex]->name }}: {{ $exercises[$currentIndex]->pivot->series }} x
								{{ $exercises[$currentIndex]->pivot->repetitions }}
							</h3>

							<div class="flex items-center justify-center w-full h-full">
								<img src="{{ asset('images/exercises/' . $exercises[$currentIndex]->image) }}"
									alt="{{ $exercises[$currentIndex]->name }}"
									class="w-64 h-48 object-contain rounded mb-2">
							</div>
						</div>
					@else
						<p>Non ci sono esercizi per questo giorno.</p>
					@endif
				</div>

                <livewire:exercise-data-modal :exercise-id="$exercises[$currentIndex]->id" :series="$exercises[$currentIndex]->pivot->series" :repetitions="$exercises[$currentIndex]->pivot->repetitions" :day="$day" />
			</div>
		</div>
	</div>

	<!-- Barra per il cambio esercizio (fissa in fondo alla pagina) -->
	<div class="fixed bottom-0 w-full bg-white shadow-lg py-2 flex justify-center items-center">
		<button
			@if ($currentIndex > 0) class="text-black bg-white p-2 rounded"
				onclick="window.location='{{ route('training_pages.inspect_training', ['day' => $day, 'exercise' => $currentIndex - 1]) }}'"
			@else
				class="text-white bg-white p-2 rounded"
				disabled @endif>
			<x-mdi-arrow-left class="h-6" />
		</button>

		<span class="mx-4 text-gray-800">{{ $currentIndex + 1 }} / {{ $exercises->count() }}</span>

		<button
			@if ($currentIndex < $exercises->count() - 1) class="text-black bg-white p-2 rounded"
				onclick="window.location='{{ route('training_pages.inspect_training', ['day' => $day, 'exercise' => $currentIndex + 1]) }}'"
			@else
				class="text-white bg-white p-2 rounded"
				disabled @endif>
			<x-mdi-arrow-right class="h-6" />
		</button>
	</div>
</x-app-layout>
