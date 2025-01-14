<form class="p-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" wire:submit.prevent="submit">
	@if($this->exercises()->isNotEmpty())
		<div class="exercise-item p-4 bg-white dark:bg-gray-900 rounded-lg shadow text-center">
			<h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
				{{ $this->exercises()[$current_index]->name }}: {{ $this->exercises()[$current_index]->pivot->series }} x
				{{ $this->exercises()[$current_index]->pivot->repetitions }}
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
				
	<div class="p-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
		<h4 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Risultati allenamento</h4>

		<table class="w-full border-collapse border border-gray-300 dark:border-gray-600 rounded">
			<thead>
				<tr class="bg-gray-200 dark:bg-gray-700">
					<th class="p-2 border border-gray-300 dark:border-gray-600">#</th>
					<th class="p-2 border border-gray-300 dark:border-gray-600">Ripetizioni</th>
					<th class="p-2 border border-gray-300 dark:border-gray-600">Carico attuale (kg)</th>
					<th class="p-2 border border-gray-300 dark:border-gray-600">Ultimo allenamento (kg)</th>
				</tr>
			</thead>
			<tbody>
				@foreach(range(1, $this->exercises()[$current_index]->pivot->series) as $serie)
					<tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
						<td class="p-2 border text-center border-gray-300 dark:border-gray-600">
							{{ $serie }}
						</td>
						<td class="p-2 border border-gray-300 dark:border-gray-600">
							@unless (strpos($this->exercises()[$current_index]->pivot->repetitions, 'MAX') !== false)
								<input type="number" class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="{{ $this->exercises()[$current_index]->pivot->repetitions }}" />
							@else
								<input type="number" class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="{{ $this->exercises()[$current_index]->pivot->repetitions }}" />
							@endunless
						</td>
						<td class="p-2 border border-gray-300 dark:border-gray-600">
							<input type="number"
								class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" />
						</td>
						<td class="p-2 border border-gray-300 dark:border-gray-600">
							<input type="number" disabled
								class="w-full p-1 rounded border bg-gray-100 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" />
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<!-- Bottone "Invia Dati" -->
		<div class="mt-4 flex justify-center">
			<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
				Invia Dati
			</button>
		</div>
	</div>
</form>