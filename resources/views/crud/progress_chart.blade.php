@vite(['resources/js/stats_chart.js'])

<x-crud-layout>
	<div class="min-h-screen antialiased">
		<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
			<livewire:exercise-chart :exercise_id="$exercise_id" :user_id="$user_id" :crud_ui="true" />
		</div>
	</div>
</x-crud-layout>