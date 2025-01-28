<div x-data="{showDeleteModal: false, id: 0, showDetailsModal: $wire.entangle('show_details_modal')}">
	<!-- Lista utenti -->
	<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
		<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
			<!-- Top bar -->
			<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
				<div class="w-full">
					<form class="flex items-center">
						<div class="relative w-full">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<x-mdi-magnify class="w-5 h-5 text-gray-500 dark:text-gray-400" />
							</div>
							<input type="text" wire:model.live="search_parameter" placeholder="Cerca esercizio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
						</div>
					</form>
				</div>

				<div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
					<button type="button" x-on:click="$wire.create()" class="primary-button">Nuovo esercizio</button>
				</div>
			</div>

			<!-- Risultati -->
			<div class="overflow-auto">
				<table class="w-full text-sm text-left table-auto text-gray-500 dark:text-gray-400">
					<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th scope="col" class="px-4 py-4">ID</th>
							<th scope="col" class="px-4 py-4">Nome</th>
							<th scope="col" class="px-4 py-3">Descrizione</th>
							<th scope="col" class="px-4 py-3">Categoria</th>
							<th scope="col" class="px-4 py-3">Azioni</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($results as $exercise)
							<tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
								<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $exercise->id }}</th>
								<td class="px-4 py-3">{{ $exercise->name }}</td>
								<td class="px-4 py-3">{{ $exercise->description }}</td>
								<td class="px-4 py-3">{{ $exercise->muscle }}</td>
								<td class="px-4 py-3">
									<button x-on:click="id = {{ $exercise->id }}; showDeleteModal = true" class="h-4 py-auto" title="Elimina">
										<x-mdi-trash-can-outline class="h-5 hover:fill-primary-500 transition duration-75" />
									</button>
									<button x-on:click="$wire.inspectExercise({{ $exercise->id }})" class="h-4 py-auto" title="Dettagli">
										<x-mdi-information-outline class="h-5 hover:fill-primary-500 transition duration-75" />
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

	<!-- Delete modal -->
	<div x-cloak x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 z-50 backdrop-blur-sm flex justify-center items-center">
		<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<x-mdi-trash-can-outline class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

			<p class="mb-4 text-gray-500 dark:text-gray-300">Sicuro di voler eliminare tale esercizio?</p>

			<div class="flex justify-center items-center space-x-4">
				<button x-on:click="showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, annulla</button>
				<button x-on:click="$wire.delete(id); showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Si, ne sono sicuro</button>
			</div>
		</div>
	</div>

	<!-- Dettagli del modali -->
	<!-- Si utilizza lo stesso modale per Creare, Modificare e Ispezionare -->
	<div x-cloak x-show="showDetailsModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 z-50 backdrop-blur-sm flex justify-center items-center">
		<form wire:submit="save" class="fixed top-0 left-0 z-50 w-full h-screen max-w-3xl p-4 overflow-y-auto bg-white dark:bg-gray-800">
			<h4 class="inline-flex items-center mb-4 text-md font-semibold text-gray-600 uppercase dark:text-gray-500">
				@if ($new && !$modal_exercise)
					Nuovo esercizio
				@elseif (!$new && $modal_exercise)
					Modifica esercizio
				@endif
			</h4>

			<button x-on:click="showDetailsModal = false" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
				<x-mdi-close class="w-5 h-5" />
			</button>

			<!-- Caratteristiche -->
			<div class="grid grid-cols-1 gap-4 pb-4">
				<div>
					<label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
					<input id="name" type="text" class="input-text" wire:model="name" required />
					@error('name')
						<p class="text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome file immagine</label>
					<input id="image" type="text" class="input-text" wire:model="image" />
				</div>

				<div>
					<label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrizione</label>
					<input id="description" type="text" class="input-text" wire:model="description" />
				</div>

				<div>
					<label for="muscle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
					<input id="muscle" type="text" class="input-text" wire:model="muscle" required />
					@error ('muscle')
						<p class="text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<!-- Azioni -->
			<div class="flex justify-center gap-2">
				@if ($new && !$modal_exercise)
					<button type="submit" class="primary-button">Crea esercizio</button>
				@elseif (!$new && $modal_exercise)
					<button type="submit" class="primary-button">Aggiorna esericizo</button>
				@endif
			</div>
		</form>
	</div>
</div>