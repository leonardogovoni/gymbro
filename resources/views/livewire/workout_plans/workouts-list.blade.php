<div x-data="{ showDeleteModal: false, deleteId: null, showEditModal: $wire.entangle('show_edit_modal') }">
	<!-- Div per gli errori durante la validazione -->
	@if (session('error'))
		<div class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
			<x-mdi-information-outline class="h-6 me-2" />

			<p class="text-base">{{ session('error') }}</p>
		</div>
	@endif

	@if ($workout_plans->isEmpty())
		<p>Non ci sono schede da mostrare. Puoi crearne una con il tasto <b>Nuova scheda.</b></p>
	@else
		<div class="grid gap-4">
			@foreach ($workout_plans as $workout_plan)
				<!-- Scheda -->
				<a href="{{ route('workout_plans.edit', $workout_plan->id) }}">
					<div class="bg-gray-100 p-4 shadow-sm dark:bg-gray-800 border rounded-lg grid grid-cols-1 gap-2 text-sm hover:bg-hover-50">
						<!-- Informazioni + pulsanti -->
						<div class="flex justify-between items-center mb-2">
							<h3 class="text-lg font-bold truncate max-w-[85%]">
								{{ $workout_plan->title }}
							</h3>

							<div class="flex items-center" x-data="{ deleteWorkout: false }">
								@if ($workout_plan->enabled == 0)
									<button name="enable" wire:click.prevent="enable({{ $workout_plan->id }})">
										<x-mdi-check-bold class="fill-green-500 hover:fill-green-700 h-6" title="Attiva"/>
									</button>
								@endif

								<button wire:click.prevent="edit({{ $workout_plan->id }})" class="ml-3">
									<x-mdi-pen class="fill-blue-500 hover:fill-blue-700 h-6" title="Modifica" />
								</button>

								<button x-on:click.prevent="deleteId={{ $workout_plan->id }}; showDeleteModal = true">
									<x-mdi-trash-can-outline class="fill-red-500 hover:fill-red-700 ml-3 h-6" title="Elimina" />
								</button>
							</div>
						</div>

						@if ($workout_plan->description)
							<p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-5" title="{{ $workout_plan->description }}">
								{{ $workout_plan->description }}
							</p>
						@endif

						<div>
							<span class="font-semibold">Data di creazione:</span>
							<span class="truncate">{{ $workout_plan->created_at->format('d-m-Y') }}</span>
						</div>

						<div>
							<span class="font-semibold">Data di modifica:</span>
							<span class="truncate">{{ $workout_plan->updated_at->format('d-m-Y') }}</span>
						</div>

						<div>
							<span class="font-semibold">Scheda attiva:</span>
							<span>{{ $workout_plan->enabled ? 'Sì' : 'No' }}</span>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	@endif

	<!-- Modal eliminazione -->
	<div x-cloak x-show="showDeleteModal" x-transition.opacity class="modal-bg">
		<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<x-mdi-trash-can-outline class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

			<p class="mb-4 text-gray-500 dark:text-gray-300">Sicuro di voler eliminare questa scheda?</p>

			<div class="flex justify-center items-center space-x-4">
				<button x-on:click="showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, annulla</button>
				<button x-on:click="$wire.delete(deleteId); showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Si, ne sono sicuro</button>
			</div>
		</div>
	</div>

	<!-- Modal modifica -->
	<div x-cloak x-show="showEditModal" x-transition.opacity class="modal-bg">
		<div class="bg-white w-full max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl rounded-lg shadow-lg p-6 sm:mx-4">
			<h4 class="inline-flex items-center mb-4 text-lg font-semibold text-gray-600 uppercase dark:text-gray-500">
				Modifica scheda
			</h4>

			<form wire:submit="save">
				<div class="space-y-3">
					<div>
						<label for="name" class="block mb-1 text-md font-medium text-gray-900 dark:text-white">
							Nome
						</label>
						<textarea name="name" id="name" maxlength="100" required class="input-text max-h-40"
							oninput="this.style.height = '';this.style.height = this.scrollHeight+ 'px'" wire:model="title"></textarea>
						@error('title')
							<p class="text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label for="description" class="block mb-1 text-md font-medium text-gray-900 dark:text-white">
							Descrizione
						</label>
						<textarea name="description" id="description" placeholder="(opzionale)" maxlength="500" class="input-text max-h-40"
							oninput="this.style.height = '';this.style.height = this.scrollHeight+ 'px'" wire:model="description"></textarea>
						@error('description')
							<p class="text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
						@enderror
					</div>

					<!-- Pulsanti -->
					<div class="flex justify-end space-x-2 mt-4">
						<button type="button" x-on:click="showEditModal = false" class="secondary-button">
							Annulla
						</button>
						<button type="submit" class="primary-button">
							Modifica
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
