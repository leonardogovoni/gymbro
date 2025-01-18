<div class="flex items-center">
    <!-- Icona (Default) -->
    @if ($enabled_schema)
        <a href="#" wire:click="enable">
            <x-mdi-check-bold class="fill-green-500 hover:fill-green-700 h-6" />
        </a>
    @endif

    <!-- Icona (Edit) -->
    <a class="ml-3" href="{{ route('workout_plans.edit', $workout_plan->id) }}">
        <x-mdi-pen class="fill-blue-500 hover:fill-blue-700 h-6" />
    </a>

    <!-- Icona (Elimina) -->
    <button @click="deleteWorkout = true">
        <x-mdi-trash-can-outline class="fill-red-500 hover:fill-red-700 ml-3 h-6" title="Elimina" />
    </button>
</div>
