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
		<div class="pt-16 mx-auto lg:py-32 md:px-8 xl:px-36 w-full min-h-screen lg:flex items-center justify-between hero">
			<div class="w-[520px] text-white">
				<div class="flex">
					<x-application-logo class="h-32 fill-white" />
					<h2 class="ms-2 max-w-lg my-auto font-sans text-6xl font-bold tracking-tight ">
						Gymbro
					</h2>
				</div>
				
				<p class="md:text-lg">
					Gestionale per palestre che rivoluziona l'allenamento dei tuoi clienti. Crea programmi personalizzati, monitora i progressi in tempo reale e migliora l'esperienza fitness direttamente dall’app.
				</p>

				<div class="flex items-center gap-2">
					@auth
						<a href="{{ route('training.select-day') }}" class="primary-button border-primary-800">
							Entra nell'app
						</a>
					@else
						<a href="{{ route('login') }}" class="primary-button border-primary-800">
							Login
						</a>
					@endauth
				  	<a href="/" class="secondary-button border-secondary-800">
						Scopri di più
					</a>
				</div>
			</div>
						
			<div class="w-1/2 shadow-lg border rounded-lg border-gray-800">
				<img class="rounded-t-lg" src="{{ asset('images/home/topbar.png') }}" />

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
			
				<img class="rounded-b-lg" src="{{ $images[$random] }}" />
			</div>
		</div>
	</body>
</html>