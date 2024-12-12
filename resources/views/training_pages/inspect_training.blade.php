<x-app-layout>
    <link href="./css/training.css" rel="stylesheet" />

    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Forza uomo, spingi, non mollare!!!') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <h2 class="text-center text-3xl text-gray-900 dark:text-white mb-4">
                        Esercizi per il giorno {{ $day }}
                    </h2>
                    @if ($exercises->isEmpty())
                        <p class="text-center">Non ci sono esercizi pianificati per questo giorno.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($exercises as $exercise)
                                <div
                                    class="exercise-item p-4 bg-white dark:bg-gray-900 rounded-lg shadow flex items-center justify-between">
                                    <!-- Sezione immagine e nome esercizio -->
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ asset('images/exercises/' . $exercise->image) }}"
                                            alt="{{ $exercise->name }}"
                                            class="w-20 h-20 object-contain rounded bg-gray-200">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $exercise->name }}
                                        </h3>
                                    </div>

                                    <!-- Sezione serie e ripetizioni -->
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $exercise->pivot->series }} x {{ $exercise->pivot->repetitions }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
