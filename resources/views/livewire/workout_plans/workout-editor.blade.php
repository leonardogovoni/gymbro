<div>
	<p>Descrizione</p>
	<div class="w-full pb-4 pt-2">
		<textarea class="w-full p-2 border border-gray-300 rounded-md resize-none overflow-auto min-h-[15vh] max-h-[70vh]"
			maxlength="500"
			placeholder="Descrizione"
			wire:model.live.debounce.250ms="description"></textarea>
	</div>

	@if($days == 0)
		<div class="flex items-center justify-center pb-4">
			<p>Nessun giorno presente in questa scheda</p>
		</div>
	@else
		@foreach(range(1, $days) as $day)
			<div class="pb-4">
				<p class="text-xl pb-2">Giorno {{ $day }}</p>

				<div class="bg-gray-100 dark:bg-gray-800 p-4 rounded border shadow-sm">
					<ul class="divide-y divide-slate-200" wire:sortable="update_order" wire:sortable.options="{ animation: 150 }">
						@if($this->exercises($day)->isEmpty())
							<li class="flex items-center justify-center py-4 first:pt-0 last:pb-0">
								<p>Nessun esercizio presente in questa giornata</p>
							</li>
						@else
							@foreach($this->exercises($day) as $exercise)
								<li wire:sortable.item="{{ $exercise->pivot->id }}" class="flex items-center py-4 first:pt-0 last:pb-0">
									<x-mdi-reorder-horizontal class="fill-gray-400 h-10 w-10 flow-grow-0"/>

									<div class="flex-auto ml-3">
										<p class="font-medium text-slate-900 flex-grow">{{ $exercise->name }}</p>
										<p>{{ $exercise->pivot->series }}x{{ $exercise->pivot->repetitions }}</p>
									</div>

									<x-mdi-pen class="h-6 fill-blue-600 hover:fill-blue-700" x-on:click="$dispatch('edit', { pivot_id: {{ $exercise->pivot->id }} })" />
									<x-mdi-close class="h-8 fill-red-600 hover:fill-red-700" wire:click="delete({{ $exercise->pivot->id }})" />
								</li>
							@endforeach
						@endif

						<li class="flex flex-col items-center py-4 first:pt-0 last:pb-0">
							<x-primary-button type="button" class="bg-green-600 hover:bg-green-700" x-on:click="$dispatch('add', { day: {{ $day }} })">
								Aggiungi esercizio
							</x-primary-button>
						</li>
					</ul>
				</div>
			</div>
		@endforeach
	@endif

	<div class="flex flex-col items-center pb-4 first:pt-0 last:pb-0">
		<x-primary-button type="button" class="bg-blue-400 hover:bg-blue-500" wire:click="add_day">
			Aggiungi giornata
		</x-primary-button>
	</div>
</div>