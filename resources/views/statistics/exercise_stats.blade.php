<x-app-layout>
    {{-- @vite(['resources/js/stats_chart.js']) --}}
    
    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Statistiche - {{ $selectedExercise->name }}
            </h2>
        </div>
    </x-slot>

    @livewire('exercise-chart', ['exerciseId' => $selectedExercise->id])

    
</x-app-layout>

{{-- BIAGIO - ERA DENTRO x-app-layout, ora ho spostato tutto in livewire --}}
{{-- <!-- Div per il grafico -->
    <div class="p-6 rounded-lg shadow">
        <div class="w-[90%]">
            <canvas id="exerciseChart"></canvas>
        </div>

        <!-- Filtro per periodo -->
        <div class="mt-4">
            <label for="timeFilter" class="mr-2">Filtra per periodo:</label>
            <select id="timeFilter">
                <option value="3">Ultimi 3 mesi</option>
                <option value="6">Ultimi 6 mesi</option>
                <option value="12">Ultimi 12 mesi</option>
            </select>
        </div>
    </div>

    <!-- Passa i dati a JavaScript -->
    <script>
        window.exerciseData = @json($exerciseData); // Passa i dati come JSON
    </script> --}}