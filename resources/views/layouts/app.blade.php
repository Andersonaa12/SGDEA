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

    <!-- Scripts y CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.navigation')

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col ml-0 md:ml-64 lg:ml-72 transition-all duration-300">
            <!-- Header opcional -->
            @isset($header)
                <header class="bg-white shadow-md border-b border-gray-200 sticky top-0 z-40">
                    <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main content -->
            <main class="flex-1 p-4 sm:p-6 overflow-y-auto bg-gray-50">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Toastify notifications -->
    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                style: { background: "linear-gradient(to right, #00b09b, #96c93d)", borderRadius: "8px", fontSize: "15px", fontWeight: "500" }
            }).showToast();
        </script>
    @endif

    @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 6000,
                gravity: "top",
                position: "right",
                style: { background: "linear-gradient(to right, #ff5f6d, #ffc371)", borderRadius: "8px", fontSize: "15px", fontWeight: "500" }
            }).showToast();
        </script>
    @endif

    @if (session('warning'))
        <script>
            Toastify({
                text: "{{ session('warning') }}",
                duration: 5000,
                gravity: "top",
                position: "right",
                style: { background: "linear-gradient(to right, #ffc107, #ff9800)", borderRadius: "8px", fontSize: "15px", fontWeight: "500" }
            }).showToast();
        </script>
    @endif

    @if (session('info'))
        <script>
            Toastify({
                text: "{{ session('info') }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                style: { background: "linear-gradient(to right, #2196f3, #00b0ff)", borderRadius: "8px", fontSize: "15px", fontWeight: "500" }
            }).showToast();
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Toastify({
                    text: "{{ $error }}",
                    duration: 7000,
                    gravity: "top",
                    position: "right",
                    style: { background: "linear-gradient(to right, #e74c3c, #c0392b)", borderRadius: "8px", fontSize: "15px", fontWeight: "500" }
                }).showToast();
            </script>
        @endforeach
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</body>
</html>