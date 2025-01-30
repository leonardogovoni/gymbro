<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Gymbro</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

		<!-- Styles / Scripts -->
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="font-sans antialiased dark:bg-black dark:text-white/50">
		<div class="pt-16 lg:pt-0 lg:px-8 xl:px-16 lg:flex w-full min-h-screen items-center justify-between hero">
			<div class="w-full lg:w-[520px] text-white">
				<div class="flex lg:justify-start justify-center">
					<x-application-logo class="h-32 fill-white" />
					<h2 class="ms-2 max-w-lg my-auto font-sans text-6xl font-bold tracking-tight ">
						Gymbro
					</h2>
				</div>
				
				<p class="px-4 lg:px-0 text-center lg:text-left text-lg">
					Gestionale per palestre che rivoluziona l'allenamento dei tuoi clienti. Crea programmi personalizzati, monitora i progressi in tempo reale e migliora l'esperienza fitness direttamente dall’app.
				</p>

				<div class="flex items-center gap-2 mt-3 justify-center lg:justify-start">
					@auth
						<a href="{{ route('training.select-day') }}" class="primary-button border-primary-800">
							Entra nell'app
						</a>
					@else
						<a href="{{ route('login') }}" class="primary-button border-primary-800">
							Login
						</a>
					@endauth
				  	<a href="mailto:info@gymbro.com" class="secondary-button border-secondary-800">
						Scopri di più
					</a>
				</div>
			</div>
						
			<div class="w-full p-6 lg:w-1/2">
				<img class="border-gray-800 border-y-lg rounded-t-lg" src="{{ asset('images/home/topbar.png') }}" />

				<!-- Pesca una foto random -->
				@php
					$images = [
						asset('images/home/workout_plans.png'),
						asset('images/home/training.png'),
						asset('images/home/statistics.png'),
						asset('images/home/crud.png'),
					];
					$random = rand(0, count($images) - 1);
				@endphp
			
				<img class="shadow-lg border-gray-800 border-y-lg rounded-b-lg" src="{{ $images[$random] }}" />
			</div>
		</div>

		<footer class="bottom fixed bottom-0 w-full bg-black bg-opacity-50 text-gray-400 text-center py-3">
			<x-mdi-xml class="inline-block h-6 w-6" />
			with
			<x-application-logo class="inline-block fill-gray-400 h-7 w-7" />
			 by Biagio, Leonardo, Sebastian
		</footer>
	</body>
</html>