<div>
    <h2 class="flex-grow text-xl">Giorno {{ $day }}</h2>
    <ul class="bg-gray-100 dark:bg-gray-800 p-4 divide-y divide-slate-200 rounded border shadow-sm" wire:sortable="updateOrder" wire:sortable.options="{ animation: 150 }">
    
        @foreach($exercises as $exercise)
        <li wire:sortable.item="{{ $exercise->pivot->id }}" class="flex items-center py-4 first:pt-0 last:pb-0">
            <x-mdi-reorder-horizontal class="fill-gray-400 h-10 w-10 flow-grow-0"/>

            <p class="ml-3 font-medium text-slate-900 flex-grow">{{ $exercise->name }}</p>

            <x-mdi-close class="h-8 fill-red-600" wire:click="delete({{ $exercise->pivot->id }})" />
        </li>
        @endforeach

        <div class="pt-4 flex flex-col items-center">
            <livewire:add-exercise-button :workout_plan_id="$workout_plan_id" :day="$day" />
        </div>
    </ul>
</div>
