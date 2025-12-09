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

        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            @if (session('success'))
                <script>
                    Toastify({
                        text: "{{ session('success') }}",
                        duration: 4000,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                            borderRadius: "8px",
                            fontSize: "15px",
                            fontWeight: "500",
                            boxShadow: "0 4px 12px rgba(0,0,0,0.15)"
                        }
                    }).showToast();
                </script>
            @endif

            {{-- Error --}}
            @if (session('error'))
                <script>
                    Toastify({
                        text: "{{ session('error') }}",
                        duration: 6000,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        style: {
                            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                            borderRadius: "8px",
                            fontSize: "15px",
                            fontWeight: "500"
                        }
                    }).showToast();
                </script>
            @endif

            {{-- Warning --}}
            @if (session('warning'))
                <script>
                    Toastify({
                        text: "{{ session('warning') }}",
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #ffc107, #ff9800)",
                        }
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
                        style: {
                            background: "linear-gradient(to right, #2196f3, #00b0ff)",
                        }
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
                            stopOnFocus: true,
                            style: {
                                background: "linear-gradient(to right, #e74c3c, #c0392b)",
                                borderRadius: "8px",
                                fontSize: "15px",
                                fontWeight: "500",
                                boxShadow: "0 4px 15px rgba(231, 76, 60, 0.4)"
                            }
                        }).showToast();
                    </script>
                @endforeach
            @endif
        </div>
    </body>
</html>
