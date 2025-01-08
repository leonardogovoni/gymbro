<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Elenco schede') }}
            </h2>
            <div x-data="{ openModal: false }">
                <button @click="openModal = true"
                    class="ml-4 px-4 py-2 bg-blue-500 text-white font-medium text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuova scheda
                </button>

                <!-- Modale -->
                <div x-show="openModal" x-transition
                    class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
                    style="display: none;">
                    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-bold mb-4">Inserisci i dati</h2>

                        <!-- Form -->
                        <form action="{{ route('workout_plans.create') }}" method="POST">
                            @csrf
                            <!-- Aggiungi margine tra ogni campo -->
                            <div class="space-y-4">
                                <div>
                                    <label for="data1" class="block text-sm font-medium text-gray-700">Nome
                                        scheda</label>
                                    <input type="text" name="data1" id="data1" placeholder="Nome scheda" maxlength="255"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="data2"
                                        class="block text-sm font-medium text-gray-700">Descrizione</label>
                                    <input type="text" name="data2" id="data2" placeholder="Descrizione" maxlength="255"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="data3" class="block text-sm font-medium text-gray-700">Data di
                                        inizio</label>
                                    <input type="date" name="data3" id="data3"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="data3" class="block text-sm font-medium text-gray-700">Data di
                                        fine</label>
                                    <input type="date" name="data4" id="data4"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- Pulsanti -->
                            <div class="flex justify-end space-x-4 mt-4">
                                <button type="button" @click="openModal = false"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 focus:outline-none focus:ring focus:ring-gray-200">
                                    Annulla
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                                    Salva
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
		<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
					@if ($workout_plans->isEmpty())
						<p>Non ci sono schede da mostrare.</p>
					@else
						<div class="grid grid-cols-1 gap-6">
							@foreach ($workout_plans as $workout_plan)
							<div class="border rounded-lg p-4 shadow-md bg-white dark:bg-gray-900 max-w-full">
								<div class="flex justify-between items-center mb-2">
									<h3 class="text-lg font-bold truncate max-w-[85%]" title="{{ $workout_plan->title }}">
										{{ $workout_plan->title }}
									</h3>
							
									<div class="flex items-center">
										<!-- Form per la prima icona (Modifica) -->
										<form action="{{ route('workout_plans.edit') }}" method="POST">
											@csrf
											<input type="hidden" name="id" value="{{ $workout_plan->id }}">
											<button type="submit" title="Modifica">
												<x-mdi-pen class="fill-blue-500 hover:fill-blue-700 h-6" />
											</button>
										</form>
										
										<!-- Inizializza Alpine.js con l'attributo x-data -->
										<div x-data="{ deleteWorkout: false }">
											<!-- Form per la seconda icona (Elimina) -->
											<input type="hidden" name="id" value="{{ $workout_plan->id }}">
											<button @click="deleteWorkout = true">
												<x-mdi-trash-can-outline class="fill-red-500 hover:fill-red-700 ml-3 h-6" title="Elimina" />
											</button>
										
											<!-- Modale di conferma -->
											<div x-show="deleteWorkout" x-cloak x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
												<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-sm w-full">
													<h2 class="text-lg font-bold mb-4">Sei sicuro di voler eliminare questa scheda?</h2>
										
													<!-- Contenuti del Modale -->
													<div class="flex justify-between">
														<!-- Pulsante Annulla -->
														<button @click="deleteWorkout = false" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
															Annulla
														</button>
										
														<!-- Form di eliminazione -->
														<form action="{{ route('workout_plans.delete', ['id' => $workout_plan->id]) }}" method="POST">
															@csrf
															@method('DELETE')
															<button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
																Elimina
															</button>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
								<p class="text-sm text-gray-700 dark:text-gray-300 mb-2 line-clamp-2" title="{{ $workout_plan->description }}">
									{{ $workout_plan->description }}
								</p>
							
								<div class="text-sm mb-2">
									<span class="font-semibold">Inizio:</span>
									<span class="truncate">{{ $workout_plan->start }}</span>
								</div>
							
								<div class="text-sm mb-2">
									<span class="font-semibold">Fine:</span>
									<span class="truncate">{{ $workout_plan->end }}</span>
								</div>
							
								<div class="text-sm mb-4">
									<span class="font-semibold">Default:</span>
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
</x-app-layout>
