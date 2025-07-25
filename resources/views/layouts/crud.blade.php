<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

		<!-- Mdi -->
		<link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

		<!-- Scripts -->
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		@livewireStyles
	</head>
	<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
		@include('layouts.crud-sidebar')

		<div class="sm:ml-64">
			{{ $slot }}
		</div>
		@livewireScripts
	</body>
</html>
