<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MK Tattoo Art') }}</title>
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-white">
        <!-- Mobile Sidebar Toggle -->
        <div class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"
            x-show="sidebarOpen"
            @click="sidebarOpen = false">
        </div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-white lg:translate-x-0 lg:static lg:inset-0"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <div class="relative z-10">
                @include('layouts.navigation')
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-white p-4">
                <!-- Mobile menu button -->
                <div class="flex items-center mb-4 lg:hidden">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                @isset($header)
                <header class="mb-4">
                    <div class="max-w-7xl mx-auto">
                        {{ $header }}
                    </div>
                </header>
                @endisset

                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-[#C25E1C] h-12"></footer>
        </div>
    </div>
</body>

</html>
