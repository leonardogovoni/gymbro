<div x-data="{showAddModal: $wire.entangle('show_add_modal'), addDay: $wire.entangle('add_day'), showEditModal: $wire.entangle('show_edit_modal'), showDeleteModal: false, deleteId: null}">
	@if ($days == 0)
		<div class="flex items-center justify-center pb-4">
			<p>Nessun giorno presente in questa scheda</p>
		</div>
	@else
		@foreach (range(1, $days) as $day)
			<div class="pb-4">
				<p class="text-xl pb-2">Giorno {{ $day }}</p>

				<div class="bg-gray-100 dark:bg-gray-800 p-4 rounded border shadow-sm">
					<ul class="divide-y divide-slate-200" wire:sortable="updateOrder" wire:sortable.options="{ animation: 150 }">
						@if ($this->exercises($day)->isEmpty())
							<li class="flex items-center justify-center py-4 first:pt-0 last:pb-0">
								<p>Nessun esercizio presente in questa giornata</p>
							</li>
						@else
							@foreach ($this->exercises($day) as $exercise)
								<li wire:sortable.item="{{ $exercise->pivot->id }}" class="flex items-center py-4 first:pt-0 last:pb-0">
									<x-mdi-reorder-horizontal class="fill-gray-400 h-10 w-10 flow-grow-0"/>

									<div class="flex-auto ml-3">
										<p class="font-medium text-slate-900 flex-grow">{{ $exercise->name }}</p>
										<p>{{ $exercise->pivot->sets }}x{{ $exercise->pivot->reps }}</p>
									</div>

									<x-mdi-pen class="h-6 fill-blue-600 hover:fill-blue-700" wire:click="loadEdit({{ $exercise->pivot->id }})" />
									<x-mdi-close class="h-8 fill-red-600 hover:fill-red-700" x-on:click="deleteId={{ $exercise->pivot->id }}; showDeleteModal = true" />
								</li>
							@endforeach
						@endif

						<li class="flex flex-col items-center py-4 first:pt-0 last:pb-0">
							<button type="button" class="primary-button" x-on:click="addDay={{ $day }}; showAddModal=true">
								Aggiungi esercizio
							</button>
						</li>
					</ul>
				</div>
			</div>
		@endforeach
	@endif

	<div class="flex flex-col items-center first:pt-0 last:pb-0">
		<button type="button" class="secondary-button" wire:click="incrementDay">
			Aggiungi giornata
		</button>
	</div>

	<!-- Modal aggiungi esercizio -->
	<div x-cloak x-show="showAddModal" x-transition.opacity class="modal-bg md:p-8">
		<div class="relative bg-white dark:bg-gray-700 min-h-full min-w-full lg:min-w-0 lg:max-w-7xl md:rounded-lg">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
				<h3 class="text-lg font-semibold uppercase text-gray-600 dark:text-gray-500">
					Aggiungi esercizio
				</h3>

				<button type="button" x-on:click="showAddModal=false" class="bg-transparent hover:bg-gray-200 rounded-lg w-7 h-7 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
					<x-mdi-close class="w-6 fill-gray-400" />
				</button>
			</div>

			<!-- Modal body -->
			<div class="p-4 md:p-5 space-y-4 justify-center w-full">
				<div class="w-full flex">
					<select wire:model.live="category_parameter" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600">						
						<option value="all" selected>Tutte le categorie</option>
						@foreach ($categories as $index=>$category)
							<option value="{{ $index }}">{{ $category }}</option>
						@endforeach
					</select>	

					<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 border-s-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
				</div>

				<div class="grid gap-2 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 overflow-y-auto max-h-[calc(100vh-10rem)]">
					@foreach ($results as $result)
						<div class="bg-blue-100 p-4 rounded-lg text-center cursor-pointer hover:bg-blue-300" wire:click="add({{ $result->id }})">
							<div class="h-40 flex items-center justify-center">
								<img class="h-40" src="{{ asset('/images/exercises/'.$result->image ) }}" />
							</div>

							<div class="border-t pt-4">
								<h3 class="text-lg font-semibold">{{ $result->name }}</h3>
								<p class="text-gray-600 text-sm">{{ $result->muscle }}</p>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<!-- Modal modifica esercizio -->
	<div x-cloak x-show="showEditModal" x-transition.opacity class="modal-bg px-4">
		<div class="relative bg-white dark:bg-gray-700 rounded-lg" style="width: 500px;">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
				<h3 class="text-lg font-semibold uppercase text-gray-600 dark:text-gray-500">
					Modifica esercizio
				</h3>

				<button type="button" x-on:click="showEditModal=false" class="bg-transparent hover:bg-gray-200 rounded-lg w-7 h-7 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
					<x-mdi-close class="w-6 fill-gray-400" />
				</button>
			</div>

			<!-- Modal body -->
			<div class="p-4 md:p-5 space-y-4 justify-center w-full">
				<form wire:submit="edit">
					<div class="flex justify-between items-center pb-4">
						<p>Tempo di recupero (sec)</p>
						<div class="w-1/3">
							<input class="input-text" type="number" min="0" step="1" required wire:model.live="rest" />
						</div>
					</div>

					<div class="flex justify-between items-center pb-4">
						<p>Numero di serie</p>
						<div class="w-1/3">
							<input class="input-text" type="number" min="1" step="1" required wire:model.live="sets" />
						</div>
					</div>

					<div class="flex justify-between items-center pb-4 h-14">
						<p>A cedimento?</p>
						<label class="inline-flex items-center cursor-pointer">
							<input type="checkbox" value="" class="sr-only peer" wire:model.live="to_failure">
							<div class="switch peer"></div>
						</label>
					</div>

					@if (!$to_failure)
						<div class="flex justify-between items-center pb-4 h-14">
							<p class="">Stesse ripetizioni per tutte le serie?</p>
							<label class="inline-flex items-center cursor-pointer">
								<input type="checkbox" value="" class="sr-only peer" wire:model.live="same_reps">
								<div class="switch peer"></div>
							</label>
						</div>

						@if ($same_reps)
							<div class="flex justify-between items-center pb-4">
								<p class="">Numero di ripetizioni</p>
								<div class="w-1/3">
									<input class="input-text" type="number" min="1" step="1" required wire:model.live="reps.0" />
								</div>
							</div>
						@else
							@foreach (range(1, $sets) as $set)
								<div class="flex justify-between items-center pb-4">
									<p class="">Numero di ripetizioni (Serie {{ $set }})</p>
									<div class="w-1/3">
										<input class="input-text" type="number" min="1" step="1" required wire:model.live="reps.{{ $set-1 }}" />
									</div>
								</div>
							@endforeach
						@endif
					@endif

					<div class="flex flex-col items-center">
						<button type="submit" class="primary-button">
							Salva
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal elimina esercizio -->
	<div x-cloak x-show="showDeleteModal" x-transition.opacity class="modal-bg">
		<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<x-mdi-trash-can-outline class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

			<p class="mb-4 text-gray-500 dark:text-gray-300">Sicuro di voler rimuovere questo esercizio?</p>

			<div class="flex justify-center items-center space-x-4">
				<button x-on:click="showDeleteModal = false" class="secondary-button">No, annulla</button>
				<button x-on:click="$wire.delete(deleteId); showDeleteModal = false" class="danger-button">Si, ne sono sicuro</button>
			</div>
		</div>
	</div>
</div>