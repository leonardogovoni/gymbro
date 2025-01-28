<x-app-layout>
	@vite(['resources/css/training.css'])

	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				Allenamento
			</h2>
		</div>
	</x-slot>

	<!-- Non c'è alcuna scheda attiva -->
	@if ($grouped_exercises == null)
		<div class="blue-alert max-w-5xl mx-auto mt-4">
			<x-mdi-exclamation-thick class="h-5 me-2" />
			<p>Non hai creato nessuna scheda. <a href="{{ route('workout_plans.list') }}"><b>Premi qui per andare alla pagina delle schede e crearne una.</b></a></p>
		</div>
	<!-- C'è una shceda attiva, ma non contiene esercizi -->
	@elseif ($grouped_exercises->isEmpty())
		<div class="blue-alert max-w-5xl mx-auto mt-4">
			<x-mdi-exclamation-thick class="h-5 me-2" />
			<p>La scheda attiva non contiene esercizi. <a href="{{ route('workout_plans.edit', $workout_plan_id) }}"><b>Premi qui per modificarla e aggiungerne.</b></a></p>
		</div>
	<!-- C'è una shceda attiva e contiene esercizi -->
	@else
		<div class="blue-alert max-w-5xl mx-auto mt-4">
			<x-mdi-information-outline class="h-5 me-2" />
			<p>Seleziona una giornata per avviare l'allenamento.</p>
		</div>

		<div class="content-div max-w-5xl">
			<div class="w-full lg:w-5/6 mx-auto">
				<div class="grid gap-4">
					@foreach ($grouped_exercises as $day => $exercises)
						<a href="{{ route('training.inspect', [$workout_plan_id, $day]) }}">
							<div class="bg-gray-100 dark:bg-gray-800 shadow-sm border rounded-lg grid grid-cols-1 divide-y text-sm hover:bg-hover-50 group">
								<div class="bg-gray-200 rounded-t-lg text-lg p-3 group-hover:bg-hover-100">
									Giorno {{ $day }}
								</div>
								
								@foreach ($exercises->take(3) as $index => $exercise)
									<div class="p-3">
										{{ $exercise->name }}
									</div>
								@endforeach

								@if ($exercises->count() > 3)
									<div class="p-3">
										+ altri {{ $exercises->count() - 3 }}
									</div>
								@endif
							</div>
						</a>
					@endforeach
				</div>
			</div>
		</div>
	@endif
</x-app-layout>