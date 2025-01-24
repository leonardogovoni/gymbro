<div>
	@vite(['resources/js/stats_chart.js'])

	<div class="py-3">
		<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 grid gap-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">

					<!-- Filtri -->
					<div>
						<label for="filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filtri:</label>
						<div class="flex space-x-2">
							<!-- Switch arco temporale statistiche -->
							<select id="filter" wire:model.live="filter" class="input-text flex-1">
								<option value="1">Ultimo mese</option>
								<option value="3">Ultimi 3 mesi</option>
								<option value="6">Ultimi 6 mesi</option>
								<option value="12">Ultimi 12 mesi</option>
								<option value="0">Tutto</option>
							</select>

							<!-- Switch tra Kg e Reps -->
							<select id="switchView" wire:model.live="switchView" class="input-text flex-1">
								<option value="0">Carico (Kg)</option>
								<option value="1">Ripetizioni</option>
							</select>
						</div>
					</div>

					<!-- Div per il grafico Kgs -->
					<div class="p-6 rounded-lg shadow bg-white dark:bg-gray-900 overflow-x-auto">
						<div class="w-full">
							<canvas class="h-[400px] w-full" id="exerciseChart"></canvas>
						</div>
					</div>

					<!-- Tabelle dinamiche -->
					<div class="overflow-x-auto">
						<table class="w-full rounded-lg">
							<thead>
								<tr class="bg-gray-200 dark:bg-gray-700">
									<th class="p-2 border border-gray-300 dark:border-gray-600 w-1/3">{{ $switchView ? 'Rip. massime' : 'Carico massimo'}}</th>
									<th class="p-2 border border-gray-300 dark:border-gray-600 w-1/3">{{ $switchView ? 'Rip. minime' : 'Carico minimo'}}</th>
									<th class="p-2 border border-gray-300 dark:border-gray-600 w-1/3">Media</th>
								</tr>
							</thead>
							<tbody>
								<tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
									<td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100 w-1/3">
										<p class="text-gray-500">{{ $switchView ? ($maxRep ?? 0) : ($maxKg ?? 0) }}</p>
									</td>
									<td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100 w-1/3">
										<p class="text-gray-500">{{ $switchView ? ($minRep ?? 0) : ($minKg ?? 0) }}</p>
									</td>
									<td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100 w-1/3">
										<p class="text-gray-500">{{ $switchView ? ($averageRep ?? 0) : ($averageKg ?? 0) }}</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
