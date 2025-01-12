<div>
	<form class="w-full pb-4">
		<div class="flex">
			<select wire:model.live="category_parameter" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600">

				<option value="all" selected>Tutte le categorie</option>
				@foreach($categories as $index=>$category)
					<option value="{{ $index }}">{{ $category }}</option>
				@endforeach
			</select>

			<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 border-s-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
		</div>
	</form>

	<div class="container mx-auto mt-6 w-[95%] lg:w-[80%] md:w-[95%] xl:w-1/2">
		@foreach ($results as $result)
			<a href="{{ route('exercises-list.exercise-stats', ['exercise' => $result]) }}">
				<div class="flex items-center p-4 mb-4 border rounded-lg shadow-sm bg-white dark:bg-gray-800 hover:bg-blue-100">
					<!-- Immagine -->
					<img src="{{ asset('images/exercises/' . $result->image) }}" alt="{{ $result->name }}"
						class="w-32 h-32 object-contain rounded mr-4">

					<!-- Informazioni -->
					<div class="flex-1">
						<h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $result->name }}</h3>
						<p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $result->description }}</p>
					</div>

					<!-- Gruppo muscolare -->
					<span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $result->muscle }}</span>
				</div>
			</a>
		@endforeach
	</div>
</div>
