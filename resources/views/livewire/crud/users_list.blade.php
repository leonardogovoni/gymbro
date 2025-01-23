<div x-data="{showDeleteModal: false, id: 0, showDetailsModal: $wire.entangle('showDetailsModal')}">
	<!-- User list -->
	<div class="mx-auto max-w-screen-xl py-4 px-4 lg:px-12">
		<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
			<!-- Top bar -->
			<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
				<div class="w-full md:w-1/2">
					<form class="flex items-center">
						<div class="relative w-full">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<x-mdi-magnify class="w-5 h-5 text-gray-500 dark:text-gray-400" />
							</div>
							<input type="text" wire:model.live="search_parameter" placeholder="Cerca" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
						</div>
					</form>
				</div>

				<div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
					<button type="button" x-on:click="$wire.create()" class="primary-button">Nuovo utente</button>
				</div>
			</div>

			<!-- Results -->
			<div>
				<table class="w-full text-sm text-left table-auto text-gray-500 dark:text-gray-400">
					<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th scope="col" class="px-4 py-4">ID</th>
							<th scope="col" class="px-4 py-4">Nome</th>
							<th scope="col" class="px-4 py-3">Cognome</th>
							<th scope="col" class="px-4 py-3">Mail</th>
							<th scope="col" class="px-4 py-3">Azioni</th>
						</tr>
					</thead>
					<tbody>
						@foreach($results as $user)
							<tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
								<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->id }}</th>
								<td class="px-4 py-3">{{ $user->first_name }}</td>
								<td class="px-4 py-3">{{ $user->last_name }}</td>
								<td class="px-4 py-3">{{ $user->email }}</td>
								<td class="px-4 py-3">
									<button x-on:click="id = {{ $user->id }}; showDeleteModal = true" class="h-4 py-auto" title="Elimina">
										<x-mdi-trash-can-outline class="h-5 hover:fill-primary-500 transition duration-75" />
									</button>
									<button x-on:click="$wire.inspectUser({{ $user->id }})" class="h-4 py-auto" title="Dettagli">
										<x-mdi-information-outline class="h-5 hover:fill-primary-500 transition duration-75" />
									</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<!-- Pages -->
			<div class="p-4">
				{{ $results->links() }}
			</div>
		</div>
	</div>

	<!-- Delete modal -->
	<div x-cloak x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 z-50 backdrop-blur-sm flex justify-center items-center">
		<div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<x-mdi-trash-can-outline class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" />

			<p class="mb-4 text-gray-500 dark:text-gray-300">Sicuro di voler eliminare tale utente?</p>
		
			<div class="flex justify-center items-center space-x-4">
				<button x-on:click="showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, annulla</button>
				<button x-on:click="$wire.delete(id); showDeleteModal = false" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Si, ne sono sicuro</button>
			</div>
		</div>
	</div>

	<!-- Details modal -->
	<!-- Using the same modal for create, edit and inspect -->
	<div x-cloak x-show="showDetailsModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 z-50 backdrop-blur-sm flex justify-center items-center">
		<form class="fixed top-0 left-0 z-50 w-full h-screen max-w-3xl p-4 overflow-y-auto bg-white dark:bg-gray-800">
			<h5 id="drawer-label" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
				@if($new && !$edit && !$inspect)
					Nuovo utente
				@elseif(!$new && $edit && !$inspect)
					Modifica utente
				@elseif(!$new && !$edit && $inspect)
					Visualizza utente
				@endif
			</h5>
	
			<button x-on:click="showDetailsModal = false" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
				<x-mdi-close class="w-5 h-5" />
			</button>
	
			<div class="grid grid-cols-2 gap-4">
				<div>
					<label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
					<input id="first_name" type="text" class="input-text" value="{{ $modal_user ? $modal_user->first_name : '' }}" @if($inspect) disabled @endif />
				</div>
				<div>
					<label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cognome</label>
					<input id="last_name" type="text" class="input-text" value="{{ $modal_user ? $modal_user->last_name : '' }}" @if($inspect) disabled @endif />
				</div>
				<div>
					<label for="ssn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codice fiscale</label>
					<input id="ssn" type="text" class="input-text" value="{{ $modal_user ? $modal_user->ssn : '' }}" @if($inspect) disabled @endif />
				</div>
				<div>
					<label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
					<input id="email" type="text" class="input-text" value="{{ $modal_user ? $modal_user->email : '' }}" @if($inspect) disabled @endif />
				</div>
				<div>
					<label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sesso</label>
					@if($inspect)
						<input id="gender" type="text" class="input-text" disabled value="@switch($modal_user->gender)
								@case('M')Uomo @break
								@case('F')Donna @break
								@case('N')Non specificato @break
						@endswitch" />
					@else
						<select id="gender" class="input-text">
							<option value="M" @if($modal_user && $modal_user->gender=='M') selected @endif>Uomo</option>
							<option value="F" @if($modal_user && $modal_user->gender=='F') selected @endif>Donna</option>
							<option value="N" @if($modal_user && $modal_user->gender=='N') selected @endif>Non specificato</option>
						</select>
					@endif
				</div>
				<div>
					<label for="birth_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data di nascita</label>
					<input id="birth_date" type="date" class="input-text" value="{{ $modal_user ? $modal_user->birth_date : '' }}" @if($inspect) disabled @endif />
				</div>
				<div>
					<label for="is_admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amministratore</label>
					<input type="switch">
			</div>
		</form>
	</div>
</div>