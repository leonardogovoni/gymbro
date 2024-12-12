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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    @if ($exercises->count() > 0)
                        <div class="exercise-item p-4 bg-white dark:bg-gray-900 rounded-lg shadow">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $exercises[$currentIndex]->name }}
                            </h3>

                            <img src="{{ asset('images/exercises/' . $exercises[$currentIndex]->image) }}"
                                alt="{{ $exercises[$currentIndex]->name }}"
                                class="max-w-full h-auto object-contain rounded mb-4">

                            <p class="text-left text-md text-gray-900 dark:text-white">
                                {{ $exercises[$currentIndex]->pivot->series }} x
                                {{ $exercises[$currentIndex]->pivot->repetitions }}
                            </p>
                        </div>
                    @else
                        <p>Non ci sono esercizi per questo giorno.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Barra per il cambio esercizio (fissa in fondo alla pagina) -->
    <div class="fixed bottom-0 w-full bg-white shadow-lg py-2 flex justify-center items-center">
        <button class="text-white bg-blue-600 p-2 rounded-full"
            @if ($currentIndex > 0) onclick="window.location='{{ route('training_pages.inspect_training', ['day' => $day, 'exercise' => $currentIndex - 1]) }}'"
                @else
                    disabled @endif>
            &lt; Precedente
        </button>
        <span class="mx-4 text-gray-800">{{ $currentIndex + 1 }} / {{ $exercises->count() }}</span>
        <button class="text-white bg-blue-600 p-2 rounded-full"
            @if ($currentIndex < $exercises->count() - 1) onclick="window.location='{{ route('training_pages.inspect_training', ['day' => $day, 'exercise' => $currentIndex + 1]) }}'"
                @else
                    disabled @endif>
            Successivo &gt;
        </button>
    </div>
</x-app-layout>
