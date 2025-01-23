<form wire:submit="save">
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
			<input type="checkbox" value="" class="sr-only peer" wire:model.live="maximal">
			<div class="switch peer"></div>
		</label>
	</div>

	@if(!$maximal)
		<div class="flex justify-between items-center pb-4 h-14">
			<p class="">Stesse ripetizioni per tutte le serie?</p>
			<label class="inline-flex items-center cursor-pointer">
				<input type="checkbox" value="" class="sr-only peer" wire:model.live="same_reps">
				<div class="switch peer"></div>
			</label>
		</div>
		
		@if($same_reps)
			<div class="flex justify-between items-center pb-4">
				<p class="">Numero di ripetizioni</p>
				<div class="w-1/3">
					<input class="input-text" type="number" min="1" step="1" required wire:model.live="reps.0" />
				</div>
			</div>
		@else
			@foreach(range(1, $sets) as $set)
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
		<x-primary-button type="submit" class="bg-green-600 hover:bg-green-700">
			Salva
		</x-primary-button>
	</div>
</form>