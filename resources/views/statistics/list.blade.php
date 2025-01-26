<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center justify-between h-6">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				Statistiche
			</h2>
		</div>
	</x-slot>

	<div class="blue-alert max-w-5xl mx-auto mt-4">
		<x-mdi-exclamation-thick class="h-5 me-2" />

		<p class="text-base">Seleziona l'esercizio di cui vuoi vedere le statistiche. Ti vengono mostrati solo gli esercizi dei quali hai registrato almeno un allenamento.</p>
	</div>

	<div class="content-div max-w-5xl">
		<div class="w-full lg:w-5/6 mx-auto">
			<livewire:statistics.exercises-list />
		</div>
	</div>
</x-app-layout>
