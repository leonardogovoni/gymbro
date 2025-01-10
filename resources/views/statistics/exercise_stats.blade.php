<x-app-layout>
    @vite(['resources/js/stats_chart.js'])
    
    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Statistiche - {{ $selectedExercise->name }}
            </h2>
        </div>
    </x-slot>

    <!-- Div per il grafico -->
    <div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow">
        <canvas id="exerciseChart"></canvas>
    </div>

</x-app-layout>
