<form wire:submit="save">
    @if($exercise_data != NULL)
        <div class="flex justify-between items-center pb-4">
            <p class="">Tempo di recupero (sec)</p>
            <x-text-input class="w-1/3" type="number" min="0" step="1" required wire:model="rest" />
        </div>

        <div class="flex justify-between items-center pb-4">
            <p class="">Numero di serie</p>
            <x-text-input class="w-1/3" type="number" min="1" step="1" required wire:model.live="sets" />
        </div>

        <div class="flex justify-between items-center pb-4 h-14">
            <p class="">Stesse ripetizioni per tutte le serie?</p>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" wire:model.live="same_reps">
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
            </label>
        </div>

        @if($same_reps)
            <div class="flex justify-between items-center pb-4">
                <p class="">Numero di ripetizioni</p>
                <x-text-input class="w-1/3" type="number" min="1" step="1" required wire:model="reps.0" />
            </div>
        @else
            @foreach(range(1, $sets) as $set)
            <div class="flex justify-between items-center pb-4">
                <p class="">Numero di ripetizioni (Serie {{ $set }})</p>
                <x-text-input class="w-1/3" type="number" min="1" step="1" required wire:model="reps.{{ $set-1 }}" />
            </div>
            @endforeach
        @endif
    @endif

    <div class="flex flex-col items-center">
        <x-primary-button type="submit" class="bg-green-600 hover:bg-green-700">
            Salva
        </x-primary-button>
    </div>
</form>
