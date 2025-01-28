<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Account creato</title>
		<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	</head>
	<body class="bg-gray-100 font-sans">
		<div class="min-h-screen flex items-center justify-center">
			<div class="bg-white shadow-lg rounded-xl p-8 max-w-md w-full">
				<div class="flex justify-center mb-6">
					<x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
				</div>
				<h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Account creato con successo!</h1>
				<p class="text-gray-600 mb-4">Il tuo account è stato creato con successo. Puoi accedere utilizzando l'email fornita alla palestra con la seguente password:</p>
				<p class="text-center text-lg font-semibold bg-gray-100 p-2 rounded-md text-gray-700">{{ $password }}</p>
				<p class="text-gray-600 mt-4">Accedi al tuo account e comincia subito a usufruire dei vantaggi della tua registrazione.</p>
				<div class="mt-6 text-center">
					<a href="{{ env("APP_URL") }}" class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Accedi</a>
				</div>
			</div>
		</div>
	</body>
</html>
