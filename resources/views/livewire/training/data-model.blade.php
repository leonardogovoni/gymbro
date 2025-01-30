<div x-data="{showWarningModal: $wire.entangle('show_warning_modal'), confirm: $wire.entangle('modal_confirm'), showInfoModal: false}">
	<!-- ALert esercizio salvato -->
	@if ($saved)
		<div class="green-alert">
			<x-mdi-information class="h-5 me-2" />
			<p>Esercizio salvato, puoi procedere al prossimo.</p>
		</div>
	@endif

	<!-- ALert esercizio già svolto -->
	@if ($already_done && !$saved)
		<div class="yellow-alert">
			<x-mdi-exclamation-thick class="h-5 me-2" />
			<p>Hai già svolto questo esercizio oggi.</p>
		</div>
	@endif

	<!-- Alert ripetizioni ultimo allenamento -->
	@if ($this->show_last_training_reps == true && $this->is_to_failure == false)
		<div class="blue-alert">
			<x-mdi-exclamation-thick class="h-6 me-2" />

			<p class="text-base">Ti mostriamo anche le ripetizioni svolte nell'ultimo allenamento
				in quanto non corrispondono a quelle segnate in scheda.</p>
		</div>
	@endif

	<div class="bg-white shadow-lg border sm:rounded-lg">
		<form class="p-4 dark:bg-gray-800 text-gray-900 dark:text-gray-100" wire:submit.prevent="submit">
			@if ($this->exercises()->isNotEmpty())
				<div class="text-center border-b">
					<h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
						{{ $this->exercises()[$current_index]->name }}:
						{{ $this->exercises()[$current_index]->pivot->sets }} x
						{{ $this->exercises()[$current_index]->pivot->reps }}
					</h3>

					<div class="flex items-center justify-center w-full h-full">
						<img src="{{ asset('images/exercises/' . $this->exercises()[$current_index]->image) }}"
							alt="{{ $this->exercises()[$current_index]->name }}"
							class="w-64 h-48 object-contain rounded mb-2">
					</div>
				</div>
			@else
				<p>Non ci sono esercizi per questo giorno.</p>
			@endif

			<div class="pt-4 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
				<h4 class="text-lg font-bold mb-4 text-gray-900 dark:text-white flex items-center justify-between">
					Dati allenamento @if($this->is_to_failure) (a cedimento) @endif
					<button type="button" x-on:click="showInfoModal = true">
						<x-mdi-help-circle-outline class="fill-secondary-500 hover:fill-primary-500 transition duration-150 h-6" title="Informazioni" />
					</button>
				</h4>

				<table class="w-full rounded-lg table-fixed border-collapse">
					<thead class="bg-gray-100 text-sm">
						<!-- Riga header superiore -->
						<tr>
							<th class="border border-gray-300 p-2 bg-gray-200">Serie</th>
							<th class="border border-gray-300 border-x-gray-500 border-x-2 p-2 bg-gray-200" colspan="2">Attuale</th>
							<th class="border border-gray-300 bg-gray-200" colspan="{{ ($is_to_failure || $show_last_training_reps) ? 2 : 1 }}">Precedente</th>
						</tr>
						<!-- Riga header inferiore -->
						<tr>
							<th class="border border-gray-300 border-e-gray-500 border-e-2 p-2">#</th>
							<th class="border border-gray-300 p-2">Ripetizioni</th>
							<th class="border border-gray-300 border-e-gray-500 border-e-2 p-2">Carico (kg)</th>
							@if ($is_to_failure || $show_last_training_reps)
								<th class="border border-gray-300 p-2">Ripetizioni</th>
							@endif
							<th class="border border-gray-300 p-2">Carico (kg)</th>
						</tr>
					</thead>
					<tbody>
						@foreach (range(1, $this->exercises()[$current_index]->pivot->sets) as $set)
							<tr>
								<td class="p-2 border text-center border-gray-300 dark:border-gray-600 border-e-gray-500 border-e-2">
									{{ $set }}
								</td>
								<td class="border border-gray-300 ">
									<input class="w-full block text-center bg-transparent border-none shadow-none rounded-none focus:ring-0 focus:outline-primary-500 outline-2"
										type="number" min="0" step="1" placeholder="Inserisci ripetizioni" required
										wire:model="reps.{{ $set - 1 }}" />
								</td>

								<td class="border border-gray-300 dark:border-gray-600 border-e-gray-500 border-e-2 ">
									<input class="w-full block text-center bg-transparent border-none shadow-none rounded-none focus:ring-0 focus:outline-primary-500 outline-2"
										type="number" min="0" step=".01" placeholder="Inserisci carico" required
										wire:model.live="used_weights.{{ $set - 1 }}" />
								</td>
								@if ($is_to_failure || $show_last_training_reps)
									<td class="p-2 border border-gray-300 text-center bg-gray-100">
										<p class="text-gray-500">{{ $last_training_reps[$set - 1] }}</p>
									</td>
								@endif
								<td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
									<p class="text-gray-500">{{ $last_training_weights[$set - 1] }}</p>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div class="mt-4 flex justify-center">
					<button type="submit" class="primary-button">Salva esercizio</button>
				</div>
			</div>
		</form>

		<!-- Modale avvertimento sovrascrittura dati -->
		<div x-cloak x-show="showWarningModal" x-transition.opacity class="modal-bg">
			<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5 max-w-96">
				<x-mdi-alert class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

				<p class="mb-4 text-gray-500 dark:text-gray-300">Sono già stati inseriti dati per questo esercizio nella giornata odierna, vuoi sovrascriverli?</p>

				<div class="flex justify-center items-center space-x-4">
					<button x-on:click="showWarningModal = false" class="secondary-button">No, annulla</button>
					<button x-on:click="confirm = true; $wire.submit()" class="danger-button ">Si, sovrascrivi</button>
				</div>
			</div>
		</div>

		<!-- Modale informazioni sull'uso -->
		<div x-cloak x-show="showInfoModal" x-transition.opacity class="modal-bg">
			<div class="mb-4 p-6 bg-white rounded-lg shadow-xl max-w-md w-full text-left mx-4">
				<div class="flex items-center justify-between mb-4">
					<div class="flex items-center">
						<x-mdi-information-outline class="fill-gray-600 h-6 mr-2" />
						<h4 class="inline-flex items-center text-lg font-semibold text-gray-600 uppercase dark:text-gray-500">
							Informazioni
						</h4>
					</div>
					<button x-on:click="showInfoModal = false" class="hover:bg-gray-200 rounded-lg focus:outline-none">
						<x-mdi-close class="fill-gray-600 h-6" />
					</button>
				</div>

				<ul class="list-disc list-inside font-sans space-y-2 text-justify">
					<li>Compila i campi della tabella relativi alle ripetizioni svolte durante il tuo allenamento e ai corrispettivi carichi utilizzati.</li>
					<li>La colonna <em>Precedente</em> mostrerà i dati registrati dell'ultimo allenamento caricato.</li>
				</ul>
			</div>
		</div>
	</div>
</div>
