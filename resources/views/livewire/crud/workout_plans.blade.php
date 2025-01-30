<div x-data="{showDeleteModal: false, showDetailsModal: $wire.entangle('show_details_modal'), userId: $wire.entangle('user_id')}">
	<!-- Lista schede -->
	<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
		<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
			<!-- Top bar -->
			<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
				<div class="w-full">
					<div class="flex items-center">
						<div class="relative w-full">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<x-mdi-magnify class="w-5 h-5 text-gray-500 dark:text-gray-400" />
							</div>

							<input type="text" wire:model.live="search_parameter" placeholder="Cerca tramite nome scheda o persona" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
						</div>
					</div>
				</div>

				<div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end flex-shrink-0">
					<button x-cloak x-show="userId"  wire:click="removeFilter" class="danger-button md:me-3">Rimuovi filtri ricerca</button>

					<button type="button" wire:click="create" class="primary-button">Nuova scheda</button>
				</div>
			</div>

			<!-- Risultati -->
			<div class="overflow-auto">
				<table class="w-full text-sm text-left table-auto text-gray-500 dark:text-gray-400">
					<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th scope="col" class="px-4 py-4">ID</th>
							<th scope="col" class="px-4 py-4">Titolo</th>
							<th scope="col" class="px-4 py-3">Utente</th>
							<th scope="col" class="px-4 py-3">Default</th>
							<th scope="col" class="px-4 py-3">Azioni</th>
						</tr>
					</thead>
					<tbody>
						@foreach($results as $workout_plan)
							<tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
								<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $workout_plan->id }}</th>
								<td class="px-4 py-3">{{ $workout_plan->title }}</td>
								<td class="px-4 py-3">{{ $workout_plan->first_name }} {{ $workout_plan->last_name }}</td>
								<td class="px-4 py-3">{{ $workout_plan->enabled ? 'Si' : 'No' }}</td>
								<td class="px-4 py-3">
									<button x-on:click="$wire.inspectPlan({{ $workout_plan->id }}); $dispatch('workout-plan-changed')" class="h-4 py-auto" title="Dettagli">
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
				<button x-on:click="showDeleteModal = false" class="secondary-button">No, annulla</button>
				<button x-on:click="$wire.delete(id); showDeleteModal = false" class="danger-button">Si, ne sono sicuro</button>
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
			<form wire:submit="save" class="grid grid-cols-1 gap-4 pb-4">
				<h5 class="inline-flex items-center text-md font-semibold text-gray-500 uppercase dark:text-gray-400">Caratteristiche</h5>

				<div>
					<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titolo</label>
					<input id="title" type="text" class="input-text" required maxlength="100" wire:model="title" required />
					@error('title')
						<p class="text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
					@enderror
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
					@elseif (!$modal_plan && $new)
						<select id="default" class="input-text" wire:model="default">
							<option value="0" selected>No</option>
							<option value="1">Si</option>
						</select>
					@endif
				</div>

				<div>
					<label for="user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Utente</label>

					<!-- CREAZIONE - Ricerca utenti nel caso di creazione -->
					@if ($new && $new_plan_user_id == null)
						<div>
							<input id="user" type="text" wire:model.live="search_user_modal_parameter" placeholder="Cerca utente e selezionalo" class="bg-gray-100 text-gray-900 rounded-t-lg w-full p-2.5 border-b border-gray-300 focus:ring-primary-500 focus:border-primary-500" />
							<div class="grid grid-cols-1 bg-gray-50 border-gray-300 border-b border-x rounded-b-lg divide-y divide-gray-300">
								@foreach($search_user_modal_results as $result)
									<div class="hover:bg-hover-50 py-2 px-2.5 text-gray-900" wire:click="selectUser({{  $result->id }})">{{ $result->first_name }} {{ $result->last_name }} ({{ $result->email }})</div>
								@endforeach
							</div>
						</div>
					<!-- CREAZIONE - Utente selezionato -->
					@elseif ($new && $new_plan_user_id)
						<div class="w-full flex gap-2">
							<input id="user" type="text" class="input-text w-2/3" wire:model="user_string" />
							<button type="button" class="secondary-button w-1/3" wire:click="undoUserSelect">Cambia</button>
						</div>
					<!-- MODIFICA - Mostra nome e basta -->
					@elseif (!$new && $modal_plan)
						<input id="user" type="text" class="input-text" wire:model="user_string" disabled />
					@endif
				</div>

				<div>
					@if ($new && !$user_string)
						<div class="red-alert !mx-0">
							Utente non selezionato, inserisci il nome della persona per cercarla dopodiché selezionala nei risultati sotto.
						</div>
					@endif

					<!-- MODIFICA -->
					@if (!$new && $modal_plan)
						<div class="flex justify-center">
							<button type="submit" class="primary-button">Salva modifiche</button>
						</div>
					<!-- CREAZIONE -->
					@elseif ($new && !$modal_plan)
						<div class="yellow-alert !mx-0">
							È necessario creare la scheda prima di poter aggiungere degli esercizi, potrai poi aggiungerli cercandola nella dashboard e premendo modifica.
						</div>

						<div class="flex justify-center">
							<button type="submit" class="primary-button">Crea scheda</button>
						</div>
					@endif
				</div>
			</form>

			{{-- Esericizi --}}
			@if (!$new && $modal_plan)
				<div class="border-t py-4">
					<h5 class="inline-flex items-center text-md font-semibold text-gray-500 uppercase dark:text-gray-400 pb-4">Esericizi</h5>

					<livewire:workout_plans.workout-editor :workout_plan="$modal_plan" :reload_days="true" />
				</div>
			@endif
		</div>
	</div>
</div>