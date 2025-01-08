<div>
    <form wire:submit.prevent="submit">
        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th class="p-2 border border-gray-300 dark:border-gray-600">#</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600">Carico attuale (kg)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usedKg as $index => $kg)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="p-2 border border-gray-300 dark:border-gray-600 text-center">
                        {{ $index + 1 }}
                    </td>
                    <td class="p-2 border border-gray-300 dark:border-gray-600">
                        <input type="number" wire:model="usedKg.{{ $index }}" class="w-full p-1 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Invia Dati</button>
    </form>
    @if (session()->has('message'))
        <div class="mt-4 text-green-500">
            {{ session('message') }}
        </div>
    @endif
</div>
