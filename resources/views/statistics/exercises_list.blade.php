<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Statistiche
            </h2>
        </div>
    </x-slot>

    <div class="container mx-auto mt-6 w-[95%] lg:w-[80%] md:w-[95%] xl:w-1/2">
        @foreach ($exercises as $exercise)
            <a href="{{ route('exercises-list.exercise-stats', ['exercise' => $exercise]) }}">
                <div class="flex items-center p-4 mb-4 border rounded-lg shadow-sm bg-white dark:bg-gray-800 hover:bg-blue-100">
                    <!-- Immagine -->
                    <img src="{{ asset('images/exercises/' . $exercise->image) }}" alt="{{ $exercise->name }}"
                        class="w-32 h-32 object-contain rounded mr-4">

                    <!-- Informazioni -->
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $exercise->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $exercise->description }}</p>
                    </div>

                    <!-- Gruppo muscolare -->
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $exercise->muscle }}</span>
                </div>
            </a>
        @endforeach
    </div>
</x-app-layout>
