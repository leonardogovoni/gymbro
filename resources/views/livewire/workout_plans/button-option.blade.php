<!-- Inizializza Alpine.js con l'attributo x-data -->
<div class="flex items-center" x-data="{ deleteWorkout: false }">
    <!-- Icona (Default) -->
    @if ($enabled_schema)
        <button name="enable" wire:click="enable">
            <x-mdi-check-bold class="fill-green-500 hover:fill-green-700 h-6" />
		</button>
    @endif

    <!-- Icona (Edit) -->
    <a class="ml-3" href="{{ route('workout_plans.edit', $workout_plan->id) }}">
        <x-mdi-pen class="fill-blue-500 hover:fill-blue-700 h-6" />
    </a>

    <!-- Icona (Elimina) -->
    <button @click="deleteWorkout = true">
        <x-mdi-trash-can-outline class="fill-red-500 hover:fill-red-700 ml-3 h-6" title="Elimina" />
    </button>

	<!-- Modale di conferma -->
	<div x-show="deleteWorkout" x-cloak x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
		<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-sm w-full">
			<h2 class="text-lg font-bold mb-4">Sei sicuro di voler eliminare questa scheda?</h2>

			<!-- Contenuti del Modale -->
			<div class="flex justify-between">
				<!-- Pulsante Annulla -->
				<button @click="deleteWorkout = false" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
					Annulla
				</button>

				<!-- Form di eliminazione -->
				<form action="{{ route('workout_plans.delete', ['id' => $workout_plan->id]) }}" method="POST">
					@csrf
					@method('DELETE')
					<button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
						Elimina
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
