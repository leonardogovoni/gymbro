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
					<div class="bg-white w-full max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl rounded-lg shadow-lg p-6 mx-4">
						<h2 class="text-lg font-bold mb-2">Inserisci i dati</h2>

						<!-- Form -->
						<form action="{{ route('workout_plans.create') }}" method="POST">
							@csrf
							<!-- Aggiungi margine tra ogni campo -->
							<div class="space-y-2">
								<div>
									<label for="workout_plan_name" class="block text-sm font-medium text-gray-700">
										Nome scheda
									</label>
									<textarea name="workout_plan_name" id="workout_plan_name" placeholder="Nome scheda" maxlength="100" required 
										class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none overflow-y-auto" 
										style="max-height: 15vh"
										oninput="this.style.height = '';this.style.height = this.scrollHeight+ 'px'"></textarea>
								</div>

								<div>
									<label for="workout_plan_description" class="block text-sm font-medium text-gray-700">
										Descrizione
									</label>
									<textarea name="workout_plan_description" id="workout_plan_description" placeholder="Descrizione" maxlength="400" required 
										class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none overflow-y-auto" 
										style="max-height: 25vh"
										oninput="this.style.height = '';this.style.height = this.scrollHeight+ 'px'"></textarea>
								</div>

								<div>
									<label for="workout_plan_start_date" class="block text-sm font-medium text-gray-700">
										Data di inizio
									</label>
									<input type="date" name="workout_plan_start_date" id="workout_plan_start_date" required
										class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
								</div>

								<div>
									<label for="workout_plan_end_date" class="block text-sm font-medium text-gray-700">
										Data di fine
									</label>
									<input type="date" name="workout_plan_end_date" id="workout_plan_end_date" required
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

	<!-- Pulsanti: Default, Edit, Delete -->
	<livewire:workout_plans.workout-button-menu :wp="$workout_plans" />
</x-app-layout>
