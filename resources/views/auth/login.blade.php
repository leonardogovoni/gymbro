<x-guest-layout>
	<!-- Session Status -->
	<x-auth-session-status class="mb-4" :status="session('status')" />

	<form method="POST" action="{{ route('login') }}">
		@csrf

		<!-- Email Address -->
		<div>
			<label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Indirizzo email</label>
			<input id="email" class="input-text" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />
			@error ('email')
				<p class="text-red-500 dark:text-red-400 mt-2">{{ $message }}</p>
			@enderror
		</div>

		<!-- Password -->
		<div class="mt-2">
			<label for="password" class="block mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
			<input id="password" class="input-text" type="password" name="password" required autofocus autocomplete="current-password" />
			@error ('password')
				<p class="text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
			@enderror
		</div>

		<!-- Remember Me -->
		<div class="my-2 flex justify-between">
			<div>
				<label for="remember_me" class="inline-flex items-center gap-2 mt-2">
					<input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-primary-600 shadow-sm focus:ring-primary-500 dark:focus:ring-primary-600 dark:focus:ring-offset-gray-800 bg-gray-50" name="remember">
					<span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Ricordami') }}</span>
				</label>
			</div>

			@if (Route::has('password.request'))
				<div class="my-auto">
					<a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
						{{ __('Hai dimenticato la password?') }}
					</a>
				</div>
			@endif
		</div>

		@if (Route::has('register'))
			<a class="px-2 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
				{{ __('Registrati') }}
			</a>
		@endif

		<div class="flex items-center justify-end pt-2">
			<button type="submit" class="primary-button">
				{{ __('Login') }}
			</button>
		</div>
	</form>
</x-guest-layout>
