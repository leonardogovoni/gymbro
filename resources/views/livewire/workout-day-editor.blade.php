<div class="bg-gray-100 dark:bg-gray-800 p-4 rounded border shadow-sm divide-y divide-slate-200">
    <ul class="divide-y divide-slate-200" wire:sortable="updateOrder" wire:sortable.options="{ animation: 150 }">
        @foreach($exercises as $exercise)
        <li wire:sortable.item="{{ $exercise->pivot->id }}" class="flex items-center py-4 first:pt-0 last:pb-0">
            <x-mdi-reorder-horizontal class="fill-gray-400 h-10 w-10 flow-grow-0"/>
    
            <div class="flex-auto ml-3">
                <p class="font-medium text-slate-900 flex-grow">{{ $exercise->name }}</p>
                <p>{{ $exercise->pivot->series }}x{{ $exercise->pivot->repetitions }}</p>
            </div>
    
            <x-mdi-pen class="h-6 fill-blue-600 hover:fill-blue-800" wire:click="edit({{ $exercise->pivot->id }})" />
            <x-mdi-close class="h-8 fill-red-600 hover:fill-red-800" wire:click="delete({{ $exercise->pivot->id }})" />
        </li>
        @endforeach

        <li class="flex flex-col items-center py-4 first:pt-0 last:pb-0">
            <x-primary-button type="button" class="bg-green-600 hover:bg-green-700" wire:click="add()">
                Aggiungi esercizio
            </x-primary-button>
        </li>
    </ul>
</div>