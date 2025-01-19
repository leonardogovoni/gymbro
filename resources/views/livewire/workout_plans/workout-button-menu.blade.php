<div class="py-12">
	<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
		<div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
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
										<button wire:click="$set('show_delete_modal', true)">
											<x-mdi-trash-can-outline class="fill-red-500 hover:fill-red-700 ml-3 h-6" title="Elimina" />
										</button>

										<!-- Modale di conferma -->
										@if ($show_delete_modal == true)
											<div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
												<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-sm w-full">
													<h2 class="text-lg font-bold mb-4">Sei sicuro di voler eliminare questa scheda?</h2>

													<!-- Contenuti del Modale -->
													<div class="flex justify-between">
														<!-- Pulsante Annulla -->
														<button wire:click="$set('show_delete_modal', false)" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
															Annulla
														</button>

														<!-- Form di eliminazione -->
														<button wire:click="delete({{ $workout_plan->id }})" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
															Elimina
														</button>
													</div>
												</div>
											</div>
										@endif
									</div>
								</div>

								<p class="text-sm text-gray-700 dark:text-gray-300 mb-2 line-clamp-5" title="{{ $workout_plan->description }}">
									{{ $workout_plan->description }}
								</p>

								<div class="text-sm mb-2">
									<span class="font-semibold">Data di inizio:</span>
									<span class="truncate">{{ $workout_plan->start }}</span>
								</div>

								<div class="text-sm mb-2">
									<span class="font-semibold">Data di fine:</span>
									<span class="truncate">{{ $workout_plan->end }}</span>
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
