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

	<livewire:training.switch_exercise_bar :workout_plan="$workout_plan" :day="$day" />
</x-app-layout>