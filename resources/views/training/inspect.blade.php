<x-app-layout>
	@vite(['resources/css/training.css'])

	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ $workout_plan->title }} - Giorno {{ $day }}
			</h2>
		</div>
	</x-slot>

	<div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-center p-0 py-4 sm:p-4">
                <div class="w-full sm:w-5/6 mx-auto grid grid-cols-1 gap-4">
                    <livewire:training.data-model :workout_plan="$workout_plan" :day="$day" >
                </div>
            </div>
        </div>
    </div>

	{{-- <!-- Bottone flottante "Timer" --> 
	<livewire:training.timer :rest="$exercises[$currentIndex]->pivot->rest"/>
	--}}

	<!-- Barra per il cambio esercizio (fissa in fondo alla pagina) -->
	<div class="fixed bottom-0 w-full bg-white dark:bg-gray-800 shadow-lg py-2 flex justify-center items-center" x-data="">
			{{-- @if ($currentIndex > 0) class="text-black dark:text-white bg-white dark:bg-gray-800 p-2 rounded" x-on:click="$dispatch('back')" />
				onclick="window.location='{{ route('training.inspect_training', ['day' => $day, 'exercise' => $currentIndex - 1]) }}'"
			@else
				class="text-white bg-white dark:text-gray-800 dark:bg-gray-800 p-2 rounded"
				disabled @endif> --}}
		<x-mdi-arrow-left class="fill-black dark:fill-white h-10 py-2" x-on:click="$dispatch('previous')" />

		{{-- <button  --}}
		{{-- @if ($currentIndex > 0) class="text-black dark:text-white bg-white dark:bg-gray-800 p-2 rounded" x-on:click="$dispatch('back')" />
			onclick="window.location='{{ route('training.inspect_training', ['day' => $day, 'exercise' => $currentIndex - 1]) }}'"
		@else
			class="text-white bg-white dark:text-gray-800 dark:bg-gray-800 p-2 rounded"
			disabled @endif> --}}
		<x-mdi-arrow-right class="fill-black dark:fill-white h-10 py-2" x-on:click="$dispatch('next')" />
	{{-- </button> --}}

		{{-- <span class="mx-4 text-gray-800 dark:text-white">{{ $currentIndex + 1 }} / {{ $exercises->count() }}</span>

		<button

			@if ($currentIndex < $exercises->count() - 1) class="text-black dark:text-white bg-white dark:bg-gray-800 p-2 rounded"
				onclick="window.location='{{ route('training.inspect_training', ['day' => $day, 'exercise' => $currentIndex + 1]) }}'"
			@else
				class="text-white bg-white dark:text-gray-800 dark:bg-gray-800 p-2 rounded"
				disabled @endif>
			<x-mdi-arrow-right class="h-6" />
		</button> --}}
	</div>
</x-app-layout>
