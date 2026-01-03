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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <a href="/">
                    <x-application-logo class="w-24 h-24 mx-auto fill-current text-indigo-600" />
                </a>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{ config('app.name', 'Laravel') }}</h2>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow-lg sm:rounded-xl sm:px-10 ring-1 ring-gray-200">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>