<x-app-layout>
    @vite(['resources/js/chart.js'])

    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Statistiche - {{ $selectedExercise->name }}
            </h2>
        </div>
    </x-slot>

    <!-- Canvas per il grafico -->
    <div class="py-6">
        <canvas id="exerciseChart"></canvas>
    </div>
    
</x-app-layout>
