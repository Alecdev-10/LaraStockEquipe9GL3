<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaraStock') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="flex min-h-screen flex-col items-center bg-gradient-to-b from-slate-100 to-slate-200 pt-10 sm:justify-center sm:pt-0">
            <div>
                <a href="/">
                    <img src="{{ asset('images/larastock-icone.svg') }}" alt="LaraStock" class="h-20 w-20">
                </a>
            </div>

            <div class="mt-6 w-full border border-slate-200 bg-white px-8 py-8 shadow-lg sm:max-w-md sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
