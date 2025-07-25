<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				Statistiche - {{ $exercise_name }}
			</h2>
		</div>
	</x-slot>

	@vite(['resources/js/statsChart.js'])

	<div class="content-div max-w-5xl">
		<livewire:statistics.exercise-chart :exercise_id="$exercise_id" />
	</div>
</x-app-layout>