<div x-data="{showDeleteModal: false}">
    @if ($saved)
        <div class="flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert">
            <x-mdi-information class="h-6 me-2" />

            <p class="text-lg">Esercizio salvato con successo, puoi procedere al prossimo esercizio.</p>
        </div>
    @endif

    @if (!$saved && $is_done)
        <div class="flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert">
            <x-mdi-information class="h-6 me-2" />

            <p class="text-lg">Esercizio già eseguito, puoi procedere al prossimo esercizio.</p>
        </div>
    @endif

    @if ($this->show_last_training_reps == true && $this->is_to_failure == false)
        <div class="blue-alert">
            <x-mdi-exclamation-thick class="h-6 me-2" />

            <p class="text-base">Ti mostriamo anche le ripetizioni svolte nell'ultimo allenamento in quanto non
                corrispondono a quelle segnate in scheda.</p>
        </div>
    @endif

    <div class="bg-white shadow sm:rounded-lg">
        <form class="p-4 dark:bg-gray-800 text-gray-900 dark:text-gray-100" wire:submit.prevent="submit">
            @if ($this->exercises()->isNotEmpty())
                <div class="text-center border-b">
                    <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
                        {{ $this->exercises()[$current_index]->name }}:
                        {{ $this->exercises()[$current_index]->pivot->sets }} x
                        {{ $this->exercises()[$current_index]->pivot->reps }}
                    </h3>

                    <div class="flex items-center justify-center w-full h-full">
                        <img src="{{ asset('images/exercises/' . $this->exercises()[$current_index]->image) }}"
                            alt="{{ $this->exercises()[$current_index]->name }}"
                            class="w-64 h-48 object-contain rounded mb-2">
                    </div>
                </div>
            @else
                <p>Non ci sono esercizi per questo giorno.</p>
            @endif

            <div class="pt-4 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                <h4 class="text-lg font-bold mb-4 text-gray-900 dark:text-white flex items-center justify-between">
                    Risultati allenamento
                    <button type="button">
                        <x-mdi-information-outline id="infoButton" class="fill-secondary-500 h-6 me-2"
                            title="Informazioni" />
                    </button>
                </h4>

                <table class="w-full rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="p-2 border border-gray-300 dark:border-gray-600">#</th>
                            <th class="p-2 border border-gray-300 dark:border-gray-600">Ripetizioni</th>
                            @if ($is_to_failure || $show_last_training_reps)
                                <th class="p-2 border border-gray-300 dark:border-gray-600">Ripetizioni ultimo
                                    allenamento</th>
                            @endif
                            <th class="p-2 border border-gray-300 dark:border-gray-600">Carico attuale (kg)</th>
                            <th class="p-2 border border-gray-300 dark:border-gray-600">Ultimo allenamento (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (range(1, $this->exercises()[$current_index]->pivot->sets) as $set)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-2 border text-center border-gray-300 dark:border-gray-600">
                                    {{ $set }}
                                </td>
                                <td class="border border-gray-300 dark:border-gray-600">
                                    <x-text-input
                                        class="w-full text-center bg-transparent border-none shadow-none rounded-none"
                                        type="number" min="0" step="1" required
                                        wire:model="reps.{{ $set - 1 }}" />
                                </td>
                                @if ($is_to_failure || $show_last_training_reps)
                                    <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                        <p class="text-gray-500">{{ $last_training_reps[$set - 1] }}</p>
                                    </td>
                                @endif
                                <td class="border border-gray-300 dark:border-gray-600">
                                    <x-text-input
                                        class="w-full text-center bg-transparent border-none shadow-none rounded-none"
                                        type="number" min="0" step=".01" required
                                        wire:model.live="used_weights.{{ $set - 1 }}"
                                        placeholder="Inserisci carico" />
                                </td>
                                <td class="p-2 border border-gray-300 dark:border-gray-600 text-center bg-gray-100">
                                    <p class="text-gray-500">{{ $last_training_weights[$set - 1] }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 flex justify-center">
					@if (!$is_done || !$saved)
						<x-primary-button type="submit"
							class="bg-blue-500 hover:bg-blue-700 focus:bg-blue-500 text-white font-bold">
							Salva esercizio
						</x-primary-button>
					@else
						<x-primary-button x-on:click="showUpdateModal = true" 
						class="bg-blue-500 hover:bg-blue-700 focus:bg-blue-500 text-white font-bold">
							Salva esercizio
						</x-primary-button>
					@endif
                </div>

                

            </div>
        </form>

		<!-- Mostra il modale per eliminare la scheda -->
		<div x-cloak x-show="showUpdateModal" x-transition.opacity class="modal-bg">
			<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
				<x-mdi-trash-can-outline class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

				<p class="mb-4 text-gray-500 dark:text-gray-300">Vuoi sovrascrivere i dati dell'esercizio corrente?</p>

				<div class="flex justify-center items-center space-x-4">
					<button x-on:click="showUpdateModal = false"
						class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
						annulla</button>
					<button x-on:click="$wire.updateExerciseData(); showUpdateModal = false"
						class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Si,
						ne sono sicuro</button>
				</div>
			</div>
		</div>

    </div>
</div>
