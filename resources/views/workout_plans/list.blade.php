<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('Elenco schede') }}
			</h2>

			<div x-data="{ showModal: false }">
				<button x-on:click="showModal = true" class="primary-button">
					<x-mdi-plus class="w-5 h-5 mr-1" />
					Nuova scheda
				</button>

				<!-- Modale -->
				<div x-cloak x-show="showModal" x-transition.opacity class="modal-bg">
					<div class="bg-white w-full max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl rounded-lg shadow-lg p-6 sm:mx-4">
						<h4 class="inline-flex items-center mb-4 text-lg font-semibold text-gray-600 uppercase dark:text-gray-500">
							Nuova scheda
						</h4>

						<!-- Form -->
						<form action="{{ route('workout_plans.create') }}" method="POST">
							@csrf
							<div class="space-y-3">
								<div>
									<label for="name" class="block mb-1 text-md font-medium text-gray-900 dark:text-white">
										Nome
									</label>
									<textarea name="name" id="name" maxlength="100" required class="input-text max-h-40"
										oninput="this.style.height = '';this.style.height = this.scrollHeight+ 'px'"></textarea>
								</div>

								<div>
									<label for="description" class="block mb-1 text-md font-medium text-gray-900 dark:text-white">
										Descrizione
									</label>
									<textarea name="description" id="description" placeholder="(opzionale)" maxlength="500" 
										class="input-text max-h-40" oninput="this.style.height = '';this.style.height = this.scrollHeight+ 'px'"></textarea>
								</div>
							</div>

							<div class="yellow-alert my-4 text-sm">
								<x-mdi-information-outline class="h-5 me-1" />
								Potrai aggiungere gli esercizi alla scheda dopo averla creata.
							</div>

							<!-- Pulsanti -->
							<div class="flex justify-end space-x-2 mt-4">
								<button type="button" x-on:click="showModal = false" class="secondary-button">
									Annulla
								</button>
								<button type="submit" class="primary-button">
									Crea
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</x-slot>

	@if ($workout_plans_count == 0)
		<div class="blue-alert max-w-5xl mx-auto mt-4">
			<x-mdi-exclamation-thick class="h-5 me-2" />
			<p>Non ci sono schede da mostrare. Puoi crearne una con il tasto <b>Nuova scheda.</b></p>
		</div>
	@else
		<div class="blue-alert max-w-5xl mx-auto mt-4">
			<x-mdi-information-outline class="h-5 me-2" />
			<p>Premi su una scheda per modificarne gli esercizi.</p>
		</div>

		<div class="content-div max-w-5xl">
			<div class="w-full lg:w-5/6 mx-auto">
				<livewire:workout_plans.workouts-list />
			</div>
		</div>
	@endif
</x-app-layout>
