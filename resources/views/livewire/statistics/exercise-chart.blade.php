<div class="w-full max-w-5xl mx-auto sm:px-6 lg:px-8">
    <div class="grid gap-4">
        <!-- Filtri -->
        <div>
            <label for="switch_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filtri</label>
            <div class="flex space-x-2">
                <!-- Switch arco temporale statistiche -->
                <select id="switch_filter" wire:model.live="switch_filter" wire:change="recall" class="input-text flex-1">
                    <option value="0">Tutto</option>
                    <option value="1">Ultimo mese</option>
                    <option value="3">Ultimi 3 mesi</option>
                    <option value="6">Ultimi 6 mesi</option>
                    <option value="12">Ultimi 12 mesi</option>
                </select>

                <!-- Switch tra Kg e Reps -->
                <select id="switch_view" wire:model.live="switch_view" wire:change="recall" class="input-text flex-1">
                    <option value="0">Carico (Kg)</option>
                    <option value="1">Ripetizioni</option>
                </select>
            </div>
            <div class="flex space-x-2 mt-1">
                <!-- Switch tra Schede -->
                <select id="switch_plan" wire:model.live="switch_plan" wire:change="recall" class="input-text flex-1">
                    <option value="0">Tutte le Schede</option>
                    @foreach ($workout_plans as $index => $workout_plan)
                        <option value="{{ $index+1 }}">{{ $workout_plan }}</option>
                    @endforeach
                </select>

                <!-- Switch tra Giorni -->
                <select id="switch_day" wire:model.live="switch_day" wire:change="recall" class="input-text flex-1">		
					<option value="0">Tutti i Giorni</option>
                    @foreach ($days as $index => $day)
                        <option value="{{ $index + 1 }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Div per il grafico Kgs -->
        <div class="p-6 border rounded-lg w-full h-[500px] relative overflow-auto">
            <canvas id="exerciseChart"></canvas>
        </div>

        <!-- Tabelle dinamiche -->
        <div class="overflow-x-auto">
            <table class="w-full rounded-lg">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="p-2 border border-gray-300 dark:border-gray-600 w-1/3">
                            {{ $switch_view ? 'Rip. massime' : 'Carico massimo' }}</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 w-1/3">
                            {{ $switch_view ? 'Rip. minime' : 'Carico minimo' }}</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 w-1/3">Media</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100 w-1/3">
                            <p class="text-gray-500">
                                {{ $switch_view ? $exercise_stats['max_rep'] ?? '?' : $exercise_stats['max_kg'] ?? '?' }}
                            </p>
                        </td>
                        <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100 w-1/3">
                            <p class="text-gray-500">
                                {{ $switch_view ? $exercise_stats['min_rep'] ?? '?' : $exercise_stats['min_kg'] ?? '?' }}
                            </p>
                        </td>
                        <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100 w-1/3">
                            <p class="text-gray-500">
                                {{ $switch_view ? $exercise_stats['average_rep'] ?? '?' : $exercise_stats['average_kg'] ?? '?' }}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
