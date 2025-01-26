<div class="py-12" x-data="{ showDeleteModal: false, id: null }">
	{{-- Modal eliminazione --}}
	<div x-cloak x-show="showDeleteModal" x-transition.opacity class="modal-bg">
		<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<x-mdi-trash-can-outline class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

			<p class="mb-4 text-gray-500 dark:text-gray-300">Sicuro di voler eliminare questa scheda?</p>
		
			<div class="flex justify-center items-center space-x-4">
				<button x-on:click="showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, annulla</button>
				<button x-on:click="$wire.delete(id); showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Si, ne sono sicuro</button>
			</div>
		</div>
	</div>

	<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
		<div class="overflow-hidden shadow-sm sm:rounded-lg">
			<!-- div per gli errori durante la validazione -->
			@if(session('error'))
				<div class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
					<x-mdi-information-outline class="h-6 me-2" />

					<p class="text-lg">{{ session('error') }}</p>
				</div>
			@endif

			<div class="p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
				@if ($workout_plans->isEmpty())
					<p>Non ci sono schede da mostrare.</p>
				@else
					<div class="grid grid-cols-1 gap-6">
						@foreach ($workout_plans as $workout_plan)
							<div wire:key="workout_plan_{{ $workout_plan->id }}" class="border rounded-lg p-4 shadow-md bg-white dark:bg-gray-900 max-w-full">
								<div class="flex justify-between items-center mb-2">
									<h3 class="text-lg font-bold truncate max-w-[85%]" title="{{ $workout_plan->title }}">
										{{ $workout_plan->title }}
									</h3>

									<!-- Inizializza Alpine.js con l'attributo x-data -->
									<div class="flex items-center" x-data="{ deleteWorkout: false }">
										<!-- Icona (Default) -->
										@if ($workout_plan->enabled == 0)
											<button name="enable" wire:click="enable({{ $workout_plan->id }})">
												<x-mdi-check-bold class="fill-green-500 hover:fill-green-700 h-6" title="Attiva"/>
											</button>
										@endif

										<!-- Icona (Edit) -->
										<a class="ml-3" href="{{ route('workout_plans.edit', $workout_plan->id) }}">
											<x-mdi-pen class="fill-blue-500 hover:fill-blue-700 h-6" title="Modifica" />
										</a>

										<!-- Icona (Elimina) -->
										<button x-on:click="id={{ $workout_plan->id }}; showDeleteModal = true">
											<x-mdi-trash-can-outline class="fill-red-500 hover:fill-red-700 ml-3 h-6" title="Elimina" />
										</button>
									</div>
								</div>

								<p class="text-sm text-gray-700 dark:text-gray-300 mb-2 line-clamp-5" title="{{ $workout_plan->description }}">
									{{ $workout_plan->description }}
								</p>

								<div class="text-sm mb-2">
									<span class="font-semibold">Data di creazione:</span>
									<span class="truncate">{{ $workout_plan->created_at->format('d-m-Y H:i:s') }}</span>
								</div>

								<div class="text-sm mb-2">
									<span class="font-semibold">Data di modifica:</span>
									<span class="truncate">{{ $workout_plan->updated_at->format('d-m-Y H:i:s') }}</span>
								</div>

								<div class="text-sm mb-4">
									<span class="font-semibold">Scheda attiva:</span>
									<span>{{ $workout_plan->enabled ? 'Sì' : 'No' }}</span>
								</div>
							</div>
						@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
