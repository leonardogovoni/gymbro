<x-app-layout>
	@vite(['resources/css/training.css'])

	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ $workout_plan->title }} - Giorno {{ $day }}
			</h2>
		</div>
	</x-slot>

	<div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
		<livewire:training.data-model :workout_plan="$workout_plan" :day="$day" >
	</div>

	{{-- <!-- Bottone flottante "Timer" --> 
	<livewire:training.timer :rest="$exercises[$currentIndex]->pivot->rest"/>
	--}}

	<livewire:training.switch_exercise_bar :workout_plan="$workout_plan" :day="$day" />
</x-app-layout>