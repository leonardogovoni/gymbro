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
		{{-- @include('layouts.navigation', ['dashboard' => true]) --}}

		<div class="px-4 pt-16 mx-auto lg:py-32 md:px-8 xl:px-36 sm:max-w-xl md:max-w-full min-h-screen hero lg:flex items-center justify-between">
			<div class="max-w-xl lg:max-w-screen-xl min-w-screen">
				<div class="w-[520px]">
					<div class="max-w-xl mb-6 text-white">
						<div class="flex">
						<x-application-logo class="h-32 fill-white" />
						<h2 class="ms-2 max-w-lg my-auto font-sans text-6xl font-bold tracking-tight ">
							Gymbro
						</h2></div>
						<p class="md:text-lg">
							Gestionale per palestre che rivoluziona l'allenamento dei tuoi clienti. Crea programmi personalizzati, monitora i progressi in tempo reale e migliora l'esperienza fitness direttamente dall’app.
						</p>
					</div>
					<div class="flex items-center">
						<a href="/" class="primary-button">
							Get started
						</a>
					  <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a>
					</div>
				  </div>
				</div>
		
		<div class="w-1/2">

	<img class="" src="https://kitwind.io/assets/kometa/full-browser.png">
	</div>

				{{-- <div class="flex items-center h-full overflow-hidden lg:w-2/3 xl:w-1/2 lg:absolute lg:justify-start">
				<img src="https://kitwind.io/assets/kometa/full-browser.png" class="object-top w-full h-64 max-w-xl rounded shadow-2xl lg:ml-64 xl:ml-8 lg:h-auto lg:max-w-screen-md " alt="" />
				</div> --}}
			  </div>
		</div>
	</body>
</html>

				{{-- <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 flex-grow">
					<div class="flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
						<div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
							<header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
								<div class="flex lg:justify-center lg:col-start-2">
									<x-application-logo class="h-20 w-auto text-white lg:h-28 lg:text-[#FF2D20] fill-red-400" />
								</div>
							</header>

							<main class="mt-6">
								<div class="grid gap-6 lg:gap-8 lg:grid-cols-1 justify-items-center">
									<a class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm lg:max-w-4xl md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
										<img class="object-cover w-full h-auto lg:w-96 md:w-48 md:h-full md:rounded-none md:rounded-s-lg" src="{{ asset('images/dashboard/schede.jpg') }}" alt="">

										<div class="flex flex-col justify-between p-4 leading-normal">
											<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Schede</h5>
											<p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
												Crea la tua scheda di allenamento personalizzata, potrai sceglierre tra numerosi esercizi e opzioni di personalizzazione.
											</p>
										</div>
									</a>

									<a class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm lg:max-w-4xl md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
										<div class="flex flex-col justify-between p-4 leading-normal">
											<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Allenamenti</h5>
											<p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
												Comincia subito ad allenarti! Potrai salvare i tuoi allenamenti e avere tutti gli esercizi a portata di mano.
											</p>
										</div>

										<img class="object-cover w-full h-auto lg:w-96 md:w-48 md:h-full md:rounded-none md:rounded-e-lg" src="{{ asset('images/dashboard/allenamenti.jpg') }}" alt="">
									</a>

									<a class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm lg:max-w-4xl md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
										<img class="object-cover w-full h-auto lg:w-96 md:w-48 md:h-full md:rounded-none md:rounded-s-lg" src="{{ asset('images/dashboard/statistiche.jpg') }}" alt="">

										<div class="flex flex-col justify-between p-4 leading-normal">
											<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Statistiche</h5>
											<p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
												Visita la pagina delle statistiche per conoscere i frutti del tuo allenamento, potrai visualizzare i grafici dei tuoi progressi.
											</p>
										</div>
									</a>
								</div>
							</main>

							<footer class="py-8 text-center text-sm text-black dark:text-white/70">
								©Progetto TechWeb by Biagio, Govo, Seba
							</footer>
						</div>
					</div>
				</div> --}}

