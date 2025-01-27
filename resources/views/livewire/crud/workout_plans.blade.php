<div x-data="{showDeleteModal: false, showDetailsModal: $wire.entangle('show_details_modal'), userId: $wire.entangle('user_id')}">
	<!-- Lista utenti -->
	<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
		<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
			<!-- Top bar -->
			<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
				<div class="w-full md:w-1/2">
					<div class="flex items-center">
						<div class="relative w-full">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<x-mdi-magnify class="w-5 h-5 text-gray-500 dark:text-gray-400" />
							</div>

							<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
						</div>
					</div>
				</div>

				<div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
					<button x-cloak x-show="userId"  wire:click="removeFilter" class="danger-button">Rimuovi filtri ricerca</button>

					<button type="button" wire:click="create" class="primary-button">Nuova scheda</button>
				</div>
			</div>

			<!-- Risultati -->
			<div>
				<table class="w-full text-sm text-left table-auto text-gray-500 dark:text-gray-400">
					<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th scope="col" class="px-4 py-4">ID</th>
							<th scope="col" class="px-4 py-4">Titolo</th>
							<th scope="col" class="px-4 py-3">Proprietario</th>
							<th scope="col" class="px-4 py-3">Default</th>
							<th scope="col" class="px-4 py-3">Azioni</th>
						</tr>
					</thead>
					<tbody>
						@foreach($results as $workout_plan)
							<tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
								<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $workout_plan->id }}</th>
								<td class="px-4 py-3">{{ $workout_plan->title }}</td>
								<td class="px-4 py-3">{{ $workout_plan->user()->get()[0]->first_name }} {{ $workout_plan->user()->get()[0]->last_name }}</td>
								<td class="px-4 py-3">{{ $workout_plan->enabled ? 'Si' : 'No' }}</td>
								<td class="px-4 py-3">
									<button x-on:click="$wire.editPlan({{ $workout_plan->id }}); $dispatch('workout-plan-changed')" class="h-4 py-auto" title="Dettagli">
										<x-mdi-pen class="h-5 hover:fill-primary-500 transition duration-75" />
									</button>
									<button x-on:click="id = {{ $workout_plan->id }}; showDeleteModal = true" class="h-4 py-auto" title="Elimina">
										<x-mdi-trash-can-outline class="h-5 hover:fill-primary-500 transition duration-75" />
									</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<!-- Pagine -->
			<div class="p-4">
				{{ $results->links() }}
			</div>
		</div>
	</div>

	<!-- Mostra il modale per eliminare la scheda -->
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

	<!-- Dettagli del modali -->
	<!-- Si utilizza lo stesso modale per Creare, Modificare e Ispezionare -->
	<div x-cloak x-show="showDetailsModal" x-transition.opacity class="modal-bg">
		<div class="fixed top-0 left-0 z-50 w-full h-screen max-w-3xl p-4 overflow-y-auto bg-white dark:bg-gray-800">
			<h4 class="inline-flex items-center mb-4 text-md font-semibold text-gray-600 uppercase dark:text-gray-500">
				@if ($new && !$modal_plan)
					Nuova scheda
				@elseif (!$new && $modal_plan)
					Modifica scheda
				@endif
			</h4>

			<button x-on:click="showDetailsModal=false" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
				<x-mdi-close class="w-5 h-5" />
			</button>

			<!-- Caratteristiche -->
			<div class="grid grid-cols-1 gap-4 pb-4 border-b">
				<h5 class="inline-flex items-center text-md font-semibold text-gray-500 uppercase dark:text-gray-400">Caratteristiche</h5>

				<div>
					<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titolo</label>
					<input id="title" type="text" class="input-text" required maxlength="100" wire:model="title" required />
				</div>

				<div>
					<label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrizione</label>
					<textarea id="description" class="input-text" maxlength="500" wire:model="description">
					</textarea>
				</div>

				<div>
					<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Default</label>
					@if ($modal_plan && !$modal_plan->enabled)
						<div class="w-full flex gap-2">
							<input id="default" type="text" class="input-text w-2/3" value="No" disabled />

							<button type="button" class="secondary-button w-1/3" wire:click="makeDefault">Rendi default</button>
						</div>
					@elseif ($modal_plan && $modal_plan->enabled)
						<input id="default" type="text" class="input-text" value="Si" disabled />
					@elseif (is_null($modal_plan) && $new)
						<select id="default" class="input-text" wire:model="default">
							<option value="0" selected>No</option>
							<option value="1">Si</option>
						</select>
					@endif
				</div>
				<!-- IMPLEMENTARE GESTITO DA PALESTRA -->
				<div>
					<label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Utente</label>
					<input id="user_id" type="number" min="0" class="input-text" wire:model="new_plan_user_id"
					@if (!$new && $modal_plan)
						disabled
					@elseif ($new && is_null($modal_plan))
						required
					@endif
					/>
				</div>

				@if ($new && $user_not_found)
					<div class="flex items-center p-4 text-md text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">
						Utente non trovato, controlla l'ID inserito.
					</div>
				@endif

				@if (!$new && $modal_plan)
					<div class="flex justify-center">
						<button wire:click="save" class="primary-button">Salva modifiche</button>
					</div>
				@endif
			</div>

			{{-- Esericizi --}}
			@if (!is_null($modal_plan))
				<div class="py-4">
					<h5 class="inline-flex items-center text-md font-semibold text-gray-500 uppercase dark:text-gray-400 pb-4">Esericizi</h5>

					<livewire:workout_plans.workout-editor :workout_plan="$modal_plan" :reload_days="true" />
				</div>
			@elseif ($new)
				<div class="my-4 flex items-center p-4 mb-4 text-md text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800">
					È necessario creare la scheda prima di poter aggiungere degli esercizi, potrai poi aggiungerli cercandola nella dashboard e premendo modifica.
				</div>

				<div class="flex justify-center">
					<button wire:click="save" class="primary-button">Crea scheda</button>
				</div>
			@endif
		</div>
	</div>
</div>