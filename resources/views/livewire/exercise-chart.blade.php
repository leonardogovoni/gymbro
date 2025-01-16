<div>
    @vite(['resources/js/stats_chart.js'])
    <div class="mb-4">
        <label for="filter" class="block text-sm font-medium text-gray-700">Filtro:</label>
        <select id="filter" wire:model.live="filter" class="mt-1 block w-full">
            <option value="1">Ultimo mese</option>
            <option value="3">Ultimi 3 mesi</option>
            <option value="6">Ultimi 6 mesi</option>
            <option value="12">Ultimi 12 mesi</option>
            <option value="0">Tutto</option>
        </select>
    </div>

    <!-- Div per il grafico -->
    <div class="p-6 rounded-lg shadow">
        <div class="w-[90%]">
            <canvas id="exerciseChart"></canvas>
        </div>
    </div>
</div>
