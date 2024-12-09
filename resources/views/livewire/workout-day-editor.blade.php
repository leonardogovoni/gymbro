<ul class="divide-y divide-slate-200 pb-4" wire:sortable="updateOrder" wire:sortable.options="{ animation: 150 }">
    @foreach($exercises as $exercise)
    <li wire:sortable.item="{{ $exercise->pivot->id }}" class="flex items-center py-4 first:pt-0 last:pb-0">
        <x-mdi-reorder-horizontal class="fill-gray-400 h-10 w-10 flow-grow-0"/>

        <p class="ml-3 font-medium text-slate-900 flex-grow">{{ $exercise->name }}</p>

        <x-mdi-close class="h-8 fill-red-600" wire:click="delete({{ $exercise->pivot->id }})" />
    </li>
    @endforeach
</ul>