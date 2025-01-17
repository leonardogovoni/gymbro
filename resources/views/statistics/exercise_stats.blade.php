<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Statistiche - {{ $selectedExercise->name }}
            </h2>
        </div>
    </x-slot>

    @livewire('exercise-chart', ['exerciseId' => $selectedExercise->id])

    
</x-app-layout>