<x-app-layout>
    <link href="./css/training.css" rel="stylesheet" />

    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Forza uomo, spingi, non mollare!!!') }}
            </h2>
        </div>
    </x-slot>

    <!-- Spazio aggiunto dopo x-slot -->
    <div class="relative w-[85%] mx-auto border p-4 bg-gray-100 dark:bg-gray-700 rounded mt-4">
        <h2 class="font-bold mb-2 text-blue-600">Scheda attualmente attiva</h2>

        <!-- Contenitore principale con overflow e altezza fissa -->
        <div class="relative h-48 overflow-y-auto scroll-smooth border rounded bg-white dark:bg-gray-800">
            
            <!-- Collegamenti per scorrere su e giù -->
            <a href="#exercise-1" class="absolute top-2 left-1/2 transform -translate-x-1/2 text-gray-500 hover:text-black">
                &#9650;
            </a>

            <a href="#exercise-last" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 text-gray-500 hover:text-black">
                &#9660;
            </a>

            <!-- Lista degli esercizi -->
            <div class="h-full flex flex-col items-center scroll-snap-y">
                @foreach ($workout_plan_enabled as $index => $exercises)
                    <div id="exercise-{{ $index + 1 }}" class="exercise-item p-3 mb-2 bg-gray-200 dark:bg-gray-600 w-full text-center rounded shadow scroll-snap-start">
                        {{ $exercises->name }}
                    </div>
                @endforeach

                <!-- Ancoraggio per l'ultima freccia -->
                <div id="exercise-last"></div>
            </div>
        </div>
    </div>
</x-app-layout>