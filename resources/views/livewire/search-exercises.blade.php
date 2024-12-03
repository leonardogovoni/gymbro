<div>
   <input wire:model.live="search" type="text" placeholder="Cerca" class="w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />

    <div class="grid grid-cols-3 divide-x pt-4">
        <div class="pe-2">
            <h3 class="font-bold mb-2">Categorie</h3>
            <ul class="rounded-lg bg-gray-100 divide-y">
                @foreach($categories as $category)
                    <li class="p-2">{{ $category }}</li>
                @endforeach
            </ul>
        </div>
        
        <div class="col-span-2 ps-2 grid sm:grid-cols-1 grid-cols-2 2xl:grid-cols-4 gap-2">
            @foreach($results as $result)
                <div class="bg-blue-100 p-4 rounded-lg text-center">
                    <div class="h-40 flex items-center justify-center">
                        <img class="h-40" src="{{ asset('/images/exercises/'.$result->image ) }}" />
                    </div>
                    <div class="border-t pt-4">
                        <h3 class="text-lg font-semibold">{{ $result->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $result->muscle }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
