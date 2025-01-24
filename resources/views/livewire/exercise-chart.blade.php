<div>
    @vite(['resources/js/stats_chart.js'])

    <div class="py-3">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid gap-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">


                    <!-- Filtro -->
                    <div>
                        <label for="filter"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filtro:</label>
                        <select id="filter" wire:model.live="filter" class="mt-1 block w-full max-w-xs">
                            <option value="1">Ultimo mese</option>
                            <option value="3">Ultimi 3 mesi</option>
                            <option value="6">Ultimi 6 mesi</option>
                            <option value="12">Ultimi 12 mesi</option>
                            <option value="0">Tutto</option>
                        </select>
                    </div>

                    <!-- Switch tra Kg e Reps -->
                    <div class="flex items-center">
                        <span class="text-gray-700 dark:text-gray-300 mr-2">Kg</span>

                        <label for="switchView" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="switchView" value="" class="sr-only peer"
                                wire:model.live="switchView">
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <span class="text-gray-700 dark:text-gray-300 ml-2">Reps</span>
                    </div>


                    <!-- Div per il grafico Kgs -->
                    <div class="p-6 rounded-lg shadow bg-white dark:bg-gray-900 overflow-x-auto">
                        <div class="w-full">
                            <canvas class="h-[400px] w-full" id="exerciseChart"></canvas>
                        </div>
                    </div>

                    @if ($switchView)
                        <!-- Tabella Reps -->
                        <div class="overflow-x-auto">
                            <table class="w-full rounded-lg">
                                <thead>
                                    <tr class="bg-gray-200 dark:bg-gray-700">
                                        <th class="p-2 border border-gray-300 dark:border-gray-600">Rep Massime</th>
                                        <th class="p-2 border border-gray-300 dark:border-gray-600">Rep Minime</th>
                                        <th class="p-2 border border-gray-300 dark:border-gray-600">Media Rep</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td
                                            class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                            <p class="text-gray-500">{{ $maxRep ?? 0 }}</p>
                                        </td>
                                        <td
                                            class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                            <p class="text-gray-500">{{ $minRep ?? 0 }}</p>
                                        </td>
                                        <td
                                            class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                            <p class="text-gray-500">{{ $averageRep ?? 0 }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <!-- Tabella Kgs -->
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
                                        <td
                                            class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                            <p class="text-gray-500">{{ $maxKg ?? 0 }}</p>
                                        </td>
                                        <td
                                            class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                            <p class="text-gray-500">{{ $minKg ?? 0 }}</p>
                                        </td>
                                        <td
                                            class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                            <p class="text-gray-500">{{ $averageKg ?? 0 }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
