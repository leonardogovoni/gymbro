<div>
	<form class="w-full pb-4">
		<div class="flex">
			<select wire:model.live="category_parameter" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600">

				<option value="all" selected>Tutte le categorie</option>
				@foreach($categories as $index=>$category)
					<option value="{{ $index }}">{{ $category }}</option>
				@endforeach
			</select>

			<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 border-s-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
		</div>
	</form>

	<div class="grid gap-2 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4  overflow-y-auto">
		@foreach($results as $result)
			<div class="bg-blue-100 p-4 rounded-lg text-center cursor-pointer hover:bg-blue-300" wire:click="add({{ $result->id }})">
				<div class="h-40 flex items-center justify-center">
					<img class="h-40" src="{{ asset('/images/exercises/'.$result->image ) }}" />
				</div>

				<div class="border-t pt-4">
					<h3 class="text-lg font-semibold">{{ $result->name }}</h3>
					<p class="text-gray-600 text-sm">{{ $result->muscle }}</p>
				</div>
			</div>
		@endforeach
	</div>
</div>

