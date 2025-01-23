<div x-data="{showDeleteModal: false, id: 0, showDetailsModal: $wire.entangle('showDetailsModal')}">
	<!-- User list -->
	<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
		<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
			<!-- Top bar -->
			<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
				<div class="w-full md:w-1/2">
					<form class="flex items-center">
						<div class="relative w-full">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<x-mdi-magnify class="w-5 h-5 text-gray-500 dark:text-gray-400" />
							</div>
							<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
						</div>
					</form>
				</div>

				<div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
					<button type="button" x-on:click="$wire.create()" class="primary-button">Nuova scheda</button>
				</div>
			</div>

			<!-- Results -->
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
									<button x-on:click="$wire.editPlan({{ $workout_plan->id }})" class="h-4 py-auto" title="Dettagli">
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

			<!-- Pages -->
			<div class="p-4">
				{{ $results->links() }}
			</div>
		</div>
	</div>

	<!-- Delete modal -->
	<div x-cloak x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 z-50 backdrop-blur-sm flex justify-center items-center">
		<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<x-mdi-trash-can-outline class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

			<p class="mb-4 text-gray-500 dark:text-gray-300">Sicuro di voler eliminare questa scheda?</p>
		
			<div class="flex justify-center items-center space-x-4">
				<button x-on:click="showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, annulla</button>
				<button x-on:click="$wire.delete(id); showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Si, ne sono sicuro</button>
			</div>
		</div>
	</div>

	<!-- Details modal -->
	<!-- Using the same modal for create, edit and inspect -->
	<div x-cloak x-show="showDetailsModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 z-50 backdrop-blur-sm flex justify-center items-center">
		<form wire:submit="save" class="fixed top-0 left-0 z-50 w-full h-screen max-w-3xl p-4 overflow-y-auto bg-white dark:bg-gray-800">
			<h4 class="inline-flex items-center mb-4 text-md font-semibold text-gray-600 uppercase dark:text-gray-500">
				@if($new && !$edit)
					Nuova scheda
				@elseif(!$new && $edit)
					Modifica scheda
				@endif
			</h4>
	
			<button x-on:click="showDetailsModal = false" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
				<x-mdi-close class="w-5 h-5" />
			</button>
	
			{{-- Caratteristiche --}}
			<div class="grid grid-cols-1 gap-4 pb-4 border-b">
				<h5 class="inline-flex items-center text-md font-semibold text-gray-500 uppercase dark:text-gray-400">Caratteristiche</h5>

				<div>
					<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titolo</label>
					<input id="title" type="text" class="input-text" value="{{ $modal_plan ? $modal_plan->title : '' }}" @if($new) required @endif />
				</div>
				<div>
					<label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrizione</label>
					<input id="description" type="text" class="input-text" value="{{ $modal_plan ? $modal_plan->description : '' }}" />
				</div>
				<div>
					<label for="enabled" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Default</label>
					<select id="enabled" class="input-text">
						<option value="1" @if($modal_plan && $modal_plan->enabled) selected @endif>Si</option>
						<option value="0" @if($modal_plan && !$modal_plan->enabled) selected @endif>No</option>
					</select>
				</div>
				<div>
					<label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Utente</label>
					<input id="user_id" type="number" min="0" class="input-text" 
						@if($edit) value="{{ $modal_plan->user_id }}" disabled @endif
						@if($new && $new_plan_user_id==null) required @endif
						@if($new && $new_plan_user_id!=null) value="{{ $new_plan_user_id }}" disabled @endif
					/>
				</div>
			</div>

			{{-- Esericizi --}}
			@if($modal_plan)
				<div class="py-4">
					<h5 class="inline-flex items-center text-md font-semibold text-gray-500 uppercase dark:text-gray-400 pb-4">Esericizi</h5>

					<livewire:workout_plans.workout-editor :workout_plan="$modal_plan" :show_desc_editor="false" />
				</div>
			@else
				<div class="my-4 flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800">
					<x-mdi-exclamation-thick class="h-6 me-2" />

					<p class="text-base">È necessario creare la scheda prima di poter aggiungere degli esercizi, potrai poi aggiungerli cercandola nella dashboard e premendo modifica.</p>
				</div>
			@endif

			@if($new)
				<div class="flex justify-center pt-2">
					<button type="submit" class="primary-button">Crea scheda</button>
				</div>
			@endif
		</form>
	</div>
</div>