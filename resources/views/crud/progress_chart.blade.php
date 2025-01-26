@vite(['resources/js/stats_chart.js'])

<x-crud-layout>
	<div class="min-h-screen antialiased">
		<div class="max-w-screen-xl bg-white dark:bg-gray-800 overflow-hidden shadow-lg border sm:rounded-lg p-4 mx-auto py-4 px-4 lg:px-12">
			<livewire:exercise-chart :exercise_id="$exercise_id" :user_id="$user_id" :crud_ui="true" />
		</div>
	</div>
</x-crud-layout>