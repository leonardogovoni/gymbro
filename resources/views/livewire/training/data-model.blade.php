<div>
	@if ($saved)
		<div class="flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
			<x-mdi-information class="h-6 me-2" />

			<p class="text-lg">Esercizio salvato con successo, puoi procedere al prossimo esercizio.</p>
		</div>
	@endif

	@if ($this->show_last_training_reps == true && $this->is_to_failure == false)
	<div class="blue-alert">
		<x-mdi-exclamation-thick class="h-6 me-2" />

		<p class="text-base">Ti mostriamo anche le ripetizioni svolte nell'ultimo allenamento in quanto non corrispondono a quelle segnate in scheda.</p>
	</div>
	@endif

	<div class="bg-white shadow sm:rounded-lg">
		<form class="p-4 dark:bg-gray-800 text-gray-900 dark:text-gray-100" wire:submit.prevent="submit">
			@if ($this->exercises()->isNotEmpty())
				<div class="text-center border-b">
					<h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
						{{ $this->exercises()[$current_index]->name }}: {{ $this->exercises()[$current_index]->pivot->sets }} x
						{{ $this->exercises()[$current_index]->pivot->reps }}
					</h3>

					<div class="flex items-center justify-center w-full h-full">
						<img src="{{ asset('images/exercises/'.$this->exercises()[$current_index]->image) }}"
							alt="{{ $this->exercises()[$current_index]->name }}"
							class="w-64 h-48 object-contain rounded mb-2">
					</div>
				</div>
			@else
				<p>Non ci sono esercizi per questo giorno.</p>
			@endif

			<div class="pt-4 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
				<h4 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Risultati allenamento</h4>

				<table class="w-full rounded-lg">
					<thead>
						<tr class="bg-gray-200 dark:bg-gray-700">
							<th class="p-2 border border-gray-300 dark:border-gray-600">#</th>
							<th class="p-2 border border-gray-300 dark:border-gray-600">Ripetizioni</th>
							@if($is_to_failure || $show_last_training_reps)
								<th class="p-2 border border-gray-300 dark:border-gray-600">Ripetizioni ultimo allenamento</th>
							@endif
							<th class="p-2 border border-gray-300 dark:border-gray-600">Carico attuale (kg)</th>
							<th class="p-2 border border-gray-300 dark:border-gray-600">Ultimo allenamento (kg)</th>
						</tr>
					</thead>
					<tbody>
						@foreach (range(1, $this->exercises()[$current_index]->pivot->sets) as $set)
							<tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
								<td class="p-2 border text-center border-gray-300 dark:border-gray-600">
									{{ $set }}
								</td>
								<td class="border border-gray-300 dark:border-gray-600">
									<x-text-input class="w-full text-center bg-transparent border-none shadow-none rounded-none" type="number" min="0" step="1" required wire:model="reps.{{ $set-1 }}" />
								</td>
								@if ($is_to_failure || $show_last_training_reps)
									<td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
										<p class="text-gray-500">{{ $last_training_reps[$set-1] }}</p>
									</td>
								@endif
								<td class="border border-gray-300 dark:border-gray-600">
									<x-text-input class="w-full text-center bg-transparent border-none shadow-none rounded-none" type="number" min="0" step=".01" required wire:model.live="used_weights.{{ $set-1 }}" placeholder="Inserisci carico" />
								</td>
								<td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
									<p class="text-gray-500">{{ $last_training_weights[$set-1] }}</p>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div class="mt-4 flex justify-center">
					<x-primary-button type="submit" class="bg-blue-500 hover:bg-blue-700 focus:bg-blue-500 text-white font-bold">
						Salva esercizio
					</x-primary-button>
				</div>
			</div>
		</form>
	</div>
</div>