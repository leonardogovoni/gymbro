<div>
    <h2 class="flex-grow text-xl">Giorno {{ $day }}</h2>
    <ul class="bg-gray-100 dark:bg-gray-800 p-4 divide-y divide-slate-200 rounded border shadow-sm" wire:sortable="updateOrder" wire:sortable.options="{ animation: 150 }">
    
        @foreach($exercises as $exercise)
        <li wire:sortable.item="{{ $exercise->pivot->id }}" class="flex items-center py-4 first:pt-0 last:pb-0">
            <svg class="h-10 w-10 fill-gray-400 flow-grow-0" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="m21 15.75c0-.414-.336-.75-.75-.75h-16.5c-.414 0-.75.336-.75.75s.336.75.75.75h16.5c.414 0 .75-.336.75-.75zm0-4c0-.414-.336-.75-.75-.75h-16.5c-.414 0-.75.336-.75.75s.336.75.75.75h16.5c.414 0 .75-.336.75-.75zm0-4c0-.414-.336-.75-.75-.75h-16.5c-.414 0-.75.336-.75.75s.336.75.75.75h16.5c.414 0 .75-.336.75-.75z" fill-rule="nonzero"/>
            </svg>
            <p class="ml-3 font-medium text-slate-900 flex-grow">{{ $exercise->name }}</p>
            <svg class="h-8 fill-red-600" viewBox="0 0 1024 1024" fill="#000000" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg" wire:click="delete({{ $exercise->pivot->sequence }})">
                <path d="M512 897.6c-108 0-209.6-42.4-285.6-118.4-76-76-118.4-177.6-118.4-285.6 0-108 42.4-209.6 118.4-285.6 76-76 177.6-118.4 285.6-118.4 108 0 209.6 42.4 285.6 118.4 157.6 157.6 157.6 413.6 0 571.2-76 76-177.6 118.4-285.6 118.4z m0-760c-95.2 0-184.8 36.8-252 104-67.2 67.2-104 156.8-104 252s36.8 184.8 104 252c67.2 67.2 156.8 104 252 104 95.2 0 184.8-36.8 252-104 139.2-139.2 139.2-364.8 0-504-67.2-67.2-156.8-104-252-104z" fill="" />
                <path d="M707.872 329.392L348.096 689.16l-31.68-31.68 359.776-359.768z" fill="" />
                <path d="M328 340.8l32-31.2 348 348-32 32z" fill="" />
            </svg>
        </li>
        @endforeach

        <div class="pt-4 flex flex-col items-center">
            <livewire:add-exercise-button :workout_plan_id="$workout_plan_id" :day="$day" />
        </div>
    </ul>
</div>
