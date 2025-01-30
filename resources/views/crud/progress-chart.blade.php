@vite(['resources/js/statsChart.js'])

<x-crud-layout>
	<div class="min-h-screen antialiased">
		<div class="max-w-5xl bg-white dark:bg-gray-800 overflow-hidden shadow-lg border sm:rounded-lg p-4 mx-auto mt-4 py-4 px-4 lg:px-12">
			<livewire:statistics.exercise-chart :exercise_id="$exercise_id" :user_id="$user_id" :crud_ui="true" />
		</div>
	</div>
</x-crud-layout>