<div>
    @vite(['resources/js/stats_chart.js'])

    <div class="py-3">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid gap-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    
                    <div class="mb-4">
                        <label for="filter" class="block text-sm font-medium text-gray-700">Filtro:</label>
                        <select id="filter" wire:model.live="filter" class="mt-1 block w-full max-w-xs">
                            <option value="1">Ultimo mese</option>
                            <option value="3">Ultimi 3 mesi</option>
                            <option value="6">Ultimi 6 mesi</option>
                            <option value="12">Ultimi 12 mesi</option>
                            <option value="0">Tutto</option>
                        </select>
                    </div>

                    <!-- Div per il grafico -->
                    <div class="p-6 rounded-lg shadow bg-white dark:bg-gray-900 overflow-x-auto">
                        <div class="w-full">
                            <canvas class="h-[400px] w-full" id="exerciseChart"></canvas>
                        </div>
                    </div>

                    <!-- Tabella responsiva -->
                    <div class="overflow-x-auto">
                        <table class="w-full rounded-lg">
                            <thead>
                                <tr class="bg-gray-200 dark:bg-gray-700">
                                    <th class="p-2 border border-gray-300 dark:border-gray-600">Kg Massimi</th>
                                    <th class="p-2 border border-gray-300 dark:border-gray-600">Kg Minimi</th>
                                    <th class="p-2 border border-gray-300 dark:border-gray-600">Media Kg</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                        <p class="text-gray-500">{{ $maxKg }}</p>
                                    </td>
                                    <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                        <p class="text-gray-500">{{ $minKg }}</p>
                                    </td>
                                    <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                        <p class="text-gray-500">{{ $averageKg }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
