<div>
	@vite(['resources/js/stats_chart.js'])

	<!-- Non è selezionato un utente, mostro la lista di quelli che hanno esercizi registrati -->
	@if (is_null($user_id))
		<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
			<div class="flex items-center p-4 mb-4 text-md text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
				Seleziona l'utente di cui vuoi visualizzare i progressi. Sono mostrati solo gli utenti che hanno registrato almeno un allenamento.
			</div>

			<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
				<!-- Barra ricerca -->
					<div class="w-full p-4">
						<div class="relative w-full">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<x-mdi-magnify class="w-5 h-5 text-gray-500 dark:text-gray-400" />
							</div>

							<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
						</div>
					</div>

				<!-- Utenti -->
				<div>
					<table class="w-full text-sm text-left table-auto text-gray-500 dark:text-gray-400">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
							<tr>
								<th scope="col" class="px-4 py-4">ID Utente</th>
								<th scope="col" class="px-4 py-4">Nome</th>
								<th scope="col" class="px-4 py-3">Serie registrate</th>
								<th scope="col" class="px-4 py-3">Esercizi registrati</th>
							</tr>
						</thead>
						<tbody>
							@foreach($results as $result)
								<tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700" wire:click="selectUser({{ $result->id }})">
									<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $result->id }}</th>
									<td class="px-4 py-3">{{ $result->first_name }} {{ $result->last_name }}</td>
									<td class="px-4 py-3">{{ $result->recorded_sets }}</td>
									<td class="px-4 py-3">{{ $result->recorded_exercises }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<!-- Selettore pagine -->
				<div class="p-4">
					{{ $results->links() }}
				</div>
			</div>
		</div>
	<!-- E' selezionato un utente, mostro gli esercizi registrati -->
	@elseif ($user_id && is_null($exercise_id))
		<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
			<div class="flex items-center p-4 mb-4 text-md text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
				Seleziona l'esercizio di cui vuoi visualizzare i progressi. Sono mostrati solo gli esercizi di cui è stato registrato almeno un allenamento.
			</div>

			<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
				<!-- Barra ricerca -->
					<div class="flex gap-4 w-full p-4">
						<button class="danger-button" wire:click="restart">
							Ricomincia
						</button>

						<div class="grow relative">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<x-mdi-magnify class="w-5 h-5 text-gray-500 dark:text-gray-400" />
							</div>

							<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
						</div>
					</div>

				<!-- Utenti -->
				<div>
					<table class="w-full text-sm text-left table-auto text-gray-500 dark:text-gray-400">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
							<tr>
								<th scope="col" class="px-4 py-4">ID Esericizio</th>
								<th scope="col" class="px-4 py-4">Nome</th>
								<th scope="col" class="px-4 py-3">Serie registrate</th>
							</tr>
						</thead>
						<tbody>
							@foreach($results as $result)
								<tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700" wire:click="selectExercise({{ $result->exercise_id }})">
									<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $result->exercise_id }}</th>
									<td class="px-4 py-3">{{ $result->name }}</td>
									<td class="px-4 py-3">{{ $result->recorded_sets }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<!-- Selettore pagine -->
				<div class="p-4">
					{{ $results->links() }}
				</div>
			</div>
		</div>
	@endif
</div>