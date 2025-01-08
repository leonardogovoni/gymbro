<div>
	<form wire:submit.prevent="submit">
		<div class="p-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
			<h4 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Risultati allenamento</h4>

			<table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
				<thead>
					<tr class="bg-gray-200 dark:bg-gray-700">
						<th class="p-2 border border-gray-300 dark:border-gray-600">#</th>
						<th class="p-2 border border-gray-300 dark:border-gray-600">Ripetizioni</th>
						<th class="p-2 border border-gray-300 dark:border-gray-600">Carico attuale (kg)</th>
						<th class="p-2 border border-gray-300 dark:border-gray-600">Carico precedente (kg)</th>
					</tr>
				</thead>
				<tbody>
					@for ($i = 0; $i < $series; $i++)
						<tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
							<td class="p-2 border text-center border-gray-300 dark:border-gray-600">
								{{ $i + 1 }}
							</td>
							<td class="p-2 border border-gray-300 dark:border-gray-600">
								@if ($repetitions != "MAX")
									<input type="number" class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ $repetitions }}">
								@else
									<input type="number" class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
								@endif
							</td>
							<td class="p-2 border border-gray-300 dark:border-gray-600">
								<input type="number"
									class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
							</td>
							<td class="p-2 border border-gray-300 dark:border-gray-600">
								<input type="number" readonly
									class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
							</td>
						</tr>
					@endfor
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
</div>
