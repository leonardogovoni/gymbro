<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				Modifica scheda - {{ $workout_plan->title }}
			</h2>
		</div>
	</x-slot>

	<div class="content-div max-w-5xl">
		<div class="w-full lg:w-5/6 mx-auto">
			<livewire:workout_plans.workout-editor :workout_plan="$workout_plan" />
		</div>
	</div>
</x-app-layout>