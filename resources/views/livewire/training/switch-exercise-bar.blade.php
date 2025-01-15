<div class="fixed bottom-0 w-full bg-white dark:bg-gray-800 py-4 flex justify-center border-t"> 
	{{-- justify-center items-center flex --}}
	<div class="flex justify-center w-10">
		@if($current_index > 0)
			<x-mdi-arrow-left class="fill-black dark:fill-white hover:bg-gray-200 rounded-lg  h-6" wire:click="previous" />
		@endif
	</div>

	<div class="flex justify-center w-12">
		<span class="text-gray-800 dark:text-white">{{ $current_index + 1 }} / {{ $max_index + 1 }}</span>
	</div>

	<div class="flex justify-center w-10">
		@if($current_index < $max_index)
			<x-mdi-arrow-right class="fill-black dark:fill-white hover:bg-gray-200 rounded-lg  h-6" wire:click="next" />
		@endif
	</div>
</div>