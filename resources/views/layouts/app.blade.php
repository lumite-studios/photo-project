<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @livewireStyles
		<script src="https://kit.fontawesome.com/0c87cf92b4.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    </head>
    <body>
		<div class="antialiased bg-gray-200 flex flex-col font-sans min-h-screen">
			@include('layouts.partials.navigation')

			@if($title ?? null || $subtitle ?? null)
				<header class="bg-white shadow">
					<div class="max-w-7xl mx-auto p-6">
						@if($title ?? null)
							<h2 class="font-semibold text-xl text-gray-800 leading-tight">
								{{ $title }}
							</h2>
						@endif
						@if($subtitle ?? null)
							<div class="mt-1 text-gray-600 text-sm">{{ $subtitle }}</div>
						@endif
					</div>
				</header>
			@endif

			<main class="flex-grow">
				<div class="max-w-7xl mx-auto py-6 sm:px-6">{{ $slot }}</div>
			</main>

			@include('layouts.partials.footer')
		</div>
		@livewire('livewire.toast')
        @livewireScripts
    </body>
</html>
