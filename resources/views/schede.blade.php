<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Elenco schede') }}
            </h2>
            <div x-data="{ openModal: false }">
                <button @click="openModal = true"
                    class="ml-4 px-4 py-2 bg-blue-500 text-white font-medium text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuova scheda
                </button>

                <!-- Modale -->
                <div x-show="openModal" x-transition
                    class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
                    style="display: none;">
                    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-bold mb-4">Inserisci i dati</h2>

                        <!-- Form -->
                        <form action="{{ route('schede.store') }}" method="POST">
                            @csrf
                            <!-- Aggiungi margine tra ogni campo -->
                            <div class="space-y-4">
                                <div>
                                    <label for="data1" class="block text-sm font-medium text-gray-700">Nome
                                        scheda</label>
                                    <input type="text" name="data1" id="data1" placeholder="Nome scheda"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="data2"
                                        class="block text-sm font-medium text-gray-700">Descrizione</label>
                                    <input type="text" name="data2" id="data2" placeholder="Descrizione"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="data3" class="block text-sm font-medium text-gray-700">Data di
                                        inizio</label>
                                    <input type="date" name="data3" id="data3"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="data3" class="block text-sm font-medium text-gray-700">Data di
                                        fine</label>
                                    <input type="date" name="data4" id="data4"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- Pulsanti -->
                            <div class="flex justify-end space-x-4 mt-4">
                                <button type="button" @click="openModal = false"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 focus:outline-none focus:ring focus:ring-gray-200">
                                    Annulla
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                                    Salva
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-semibold">Elenco delle schede</h2>

                    @if ($schede->isEmpty())
                        <p>Non ci sono schede da mostrare.</p>
                    @else
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Titolo</th>
                                    <th class="px-4 py-2 text-left">Descrizione</th>
                                    <th class="px-4 py-2 text-left">Inizio</th>
                                    <th class="px-4 py-2 text-left">Fine</th>
                                    <th class="px-4 py-2 text-left">Abilitata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schede as $scheda)
                                    <tr>
                                        <td class="px-4 py-2">{{ $scheda->id }}</td>
                                        <td class="px-4 py-2">{{ $scheda->titolo }}</td>
                                        <td class="px-4 py-2">{{ $scheda->descrizione }}</td>
                                        <td class="px-4 py-2">{{ $scheda->inizio }}</td>
                                        <td class="px-4 py-2">{{ $scheda->fine }}</td>
                                        <td class="px-4 py-2">{{ $scheda->abilitata ? 'Sì' : 'No' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
