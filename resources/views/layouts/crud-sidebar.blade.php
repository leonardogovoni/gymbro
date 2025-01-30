<div x-data="{ showSidebar: false }">
	<!-- Tasto sidebar su telefono -->
	<button x-on:click="showSidebar = !showSidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 ">
		<x-mdi-page-layout-sidebar-left class="w-6 h-6" />
	</button>

	<!-- Sidebar -->
	<aside x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-64'" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 border-x">
		<div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 flex flex-col">
			<ul class="pt-2 space-y-2 font-medium grow">
				<li>
					<a href="{{ route('admin.users') }}"
						@if (request()->routeIs('admin.users'))
							class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white group bg-gray-200 dark:bg-gray-600"
						@else
							class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
						@endif
					>
						<x-mdi-account class="w-6 h-6 text-gray-500 transition duration-75 @if(!request()->routeIs('admin.users')) dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white @endif " />
						<span class="ms-3">Utenti</span>
					</a>
				</li>

				<li>
					<a href="{{ route('admin.workout_plans') }}"
						@if (request()->routeIs('admin.workout_plans'))
							class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white group bg-gray-200 dark:bg-gray-600"
						@else
							class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
						@endif
					>
						<x-mdi-file class="w-6 h-6 text-gray-500 transition duration-75 @if(!request()->routeIs('admin.workout_plans')) dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white @endif " />
						<span class="ms-3">Schede</span>
					</a>
				</li>

				<li>
					<a href="{{ route('admin.progress') }}"
						@if (request()->routeIs('admin.progress'))
							class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white group bg-gray-200 dark:bg-gray-600"
						@else
							class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
						@endif
					>
						<x-mdi-chart-timeline-variant class="w-6 h-6 text-gray-500 transition duration-75 @if(!request()->routeIs('admin.progress')) dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white @endif " />
						<span class="ms-3">Progressi utenti</span>
					</a>
				</li>

				@if (request()->user()->is_admin)
					<li>
						<a href="{{ route('admin.exercises') }}"
							@if (request()->routeIs('admin.exercises'))
								class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white group bg-gray-200 dark:bg-gray-600"
							@else
								class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
							@endif
						>
							<x-mdi-dumbbell class="w-6 h-6 text-gray-500 transition duration-75 @if(!request()->routeIs('admin.exercises')) dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white @endif " />
							<span class="ms-3">Esercizi</span>
						</a>
					</li>
				@endif

				@if (request()->user()->is_admin)
					<li>
						<a href="/" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
							<x-mdi-arrow-left class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
							<span class="ms-3">Torna alla app</span> 
						</a>
					</li>
				@endif
			</ul>

			<ul class="font-medium pt-4 border-t">
				@if (request()->user()->is_admin)
					<li class="flex items-center justify-center text-sm pb-2">
						Accesso amministratore
					</li>
				@endif
				<li class="flex items-center justify-center text-gray-900 dark:text-white">
					<x-application-logo class="h-6 w-auto fill-gray-800 dark:fill-gray-200" />
					<span class="ml-1">{{ config('app.name', 'Laravel') }}</span>
				</li>			
			</ul>
		</div>
	</aside>

	<!-- Overlay per telefono -->
	<div class="fixed z-30 inset-0 bg-gray-900 bg-opacity-40" x-cloak x-show="showSidebar" x-on:click="showSidebar = false">
	</div>
</div>