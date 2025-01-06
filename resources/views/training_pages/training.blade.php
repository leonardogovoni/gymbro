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
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
					@if ($workout_plan_enabled->isEmpty())
						<p>Non hai una scheda attiva.</p>
					@else
						@foreach ($exercises_by_day as $day => $exercises)
							<a href="{{ route('training_pages.inspect_training', ['day' => $day]) }}">
								<div class="hover:bg-blue-100 border rounded-lg p-4 shadow-md bg-white dark:bg-gray-900 max-w-full mb-3 exercise-container"
									id="exercise-container-{{ $day }}">
									<p class="text-left text-lg text-gray-900 dark:text-white"> Giorno:
										{{ $day }}
									</p>

									@foreach ($exercises->take(3) as $index => $exercise)
										<div id="exercise-{{ $index + 1 }}"
											class="exercise-item p-3 mb-2 bg-gray-200 dark:bg-gray-600 w-full text-center rounded shadow scroll-snap-start">
											{{ $exercise->name }}
										</div>
									@endforeach

									@if ($exercises->count() > 3)
										<div
											class="exercise-item p-3 mb-2 bg-gray-400 dark:bg-gray-600 w-full text-center rounded shadow scroll-snap-start">
											Altri +{{ $exercises->count() - 3 }}
										</div>
									@endif
								</div>
							</a>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
