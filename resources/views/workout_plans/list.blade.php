<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('Elenco schede') }}
			</h2>
			<div x-data="{ openModal: false }">
				<button @click="openModal = true"
					class="ml-4 px-4 py-2 bg-blue-500 text-white font-medium text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 flex items-center">
					<x-mdi-plus class="w-5 h-5 mr-2"></x-mdi-plus>
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
									<label for="workout_plan_name" class="block text-sm font-medium text-gray-700">
										Nome scheda
									</label>
									<input type="text" name="workout_plan_name" id="workout_plan_name" placeholder="Nome scheda" maxlength="255"
										class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
								</div>

								<div>
									<label for="workout_plan_description" class="block text-sm font-medium text-gray-700">
										Descrizione
									</label>
									<input type="text" name="workout_plan_description" id="workout_plan_description" placeholder="Descrizione" maxlength="255"
										class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
								</div>

								<div>
									<label for="workout_plan_start_date" class="block text-sm font-medium text-gray-700">
										Data di inizio
									</label>
									<input type="date" name="workout_plan_start_date" id="workout_plan_start_date"
										class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
								</div>

								<div>
									<label for="workout_plan_end_date" class="block text-sm font-medium text-gray-700">
										Data di fine
									</label>
									<input type="date" name="workout_plan_end_date" id="workout_plan_end_date"
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

									<!-- Inizializza Alpine.js con l'attributo x-data -->
									<div class="flex items-center" x-data="{ deleteWorkout: false }">
										<a href="{{ route('workout_plans.edit', $workout_plan->id) }}">
											<x-mdi-pen class="fill-blue-500 hover:fill-blue-700 h-6" />
										</a>

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

	<!-- Necessario per stampare gli errori di validazione nel caso di input errati durante la creazione della scheda -->
	<!-- Overlay opacizzato -->
	<div id="overlay" class="fixed inset-0 bg-gray-900 opacity-50 z-40 hidden"></div>

	<!-- Contenitore principale dell'alert -->
	<div id="alertContainer" class="fixed inset-0 flex items-start justify-center z-50 hidden">
		<div class="relative w-11/12 md:w-1/3 mt-20">
			<!-- Alert per gli errori -->
			<div id="errorAlert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
				<strong class="font-bold">Oops!</strong>
				<span class="block sm:inline">Ci sono dei problemi con i tuoi input.</span>
				<ul class="mt-2">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			<!-- Icona di chiusura esterna -->
			<span class="absolute top-0 right-0 mt-2 mr-2">
				<svg id="closeAlert" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a.5.5 0 0 1 0 .707L10.707 10l3.641 3.641a.5.5 0 0 1-.707.707L10 10.707l-3.641 3.641a.5.5 0 0 1-.707-.707L9.293 10 5.652 6.359a.5.5 0 1 1 .707-.707L10 9.293l3.641-3.641a.5.5 0 0 1 .707 0z"/></svg>
			</span>
		</div>
	</div>

	<!-- Inserito qui visto che si tratta di poco codice, tranquillamente inseribile in un file JS, va modificata la logica dell'if -->
	<script>
		// [TODO] Il controllo effettuato nell'if obbliga a mantenere un tag <script> nel codice, non eliminabile completamente se non con
		// magheggi molto brutti da vedere, per il momento lascio qui.
		if (@json($errors->any())) {
			document.getElementById('alertContainer').classList.remove('hidden');
			document.getElementById('overlay').classList.remove('hidden');
		}

		document.getElementById('closeAlert').onclick = function() {
			document.getElementById('alertContainer').classList.add('hidden');
			document.getElementById('overlay').classList.add('hidden');
		};
	</script>
</x-app-layout>
