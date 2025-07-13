<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body class="bg-white text-gray-800 font-merriweather">

    <!-- Navbar -->
    <nav x-data="{ open: false, dropdown: false }" class="bg-white shadow-md w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2 text-xl">
                    <span class="text-orange-500 font-bold">MK</span>
                    <span class="text-gray-800 tracking-wide">TATTO ART</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6">
                    <a href="/" class="hover:text-orange-500 transition">Home</a>
                    <a href="{{ route('artis.list') }}" class="hover:text-orange-500 transition">Artist</a>
                    <a href="{{ route('gallery') }}" class="hover:text-orange-500 transition">Gallery</a>
                    <a href="{{ route('contact.index') }}" class="hover:text-orange-500 transition">Contact</a>
                </div>

                <div class="hidden md:flex space-x-6 items-center">
                    <!-- Dropdown for All Users -->
                    <div class="relative">
                        <button @click="dropdown = !dropdown"
                            class="bg-orange-500 p-2 rounded-full text-white shadow-md hover:bg-orange-600 flex items-center">
                            <!-- Gambar ikon menu -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 512 512">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352" />
                            </svg>

                            <!-- Gambar ikon profil -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 512 512" fill="currentColor">
                                <path d="M258.9 48C141.92 46.42 46.42 141.92 48 258.9c1.56 112.19 92.91 203.54 205.1 205.1 117 1.6 212.48-93.9 210.88-210.88C462.44 140.91 371.09 49.56 258.9 48zm126.42 327.25a4 4 0 01-6.14-.32 124.27 124.27 0 00-32.35-29.59C321.37 329 289.11 320 256 320s-65.37 9-90.83 25.34a124.24 124.24 0 00-32.35 29.58 4 4 0 01-6.14.32A175.32 175.32 0 0180 259c-1.63-97.31 78.22-178.76 175.57-179S432 158.81 432 256a175.32 175.32 0 01-46.68 119.25z" />
                                <path d="M256 144c-19.72 0-37.55 7.39-50.22 20.82s-19 32-17.57 51.93C191.11 256 221.52 288 256 288s64.83-32 67.79-71.24c1.48-19.74-4.8-38.14-17.68-51.82C293.39 151.44 275.59 144 256 144z" />
                            </svg>
                        </button>

                        <div x-show="dropdown" x-cloak x-transition @click.outside="dropdown = false"
                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <div class="py-2 px-4">
                                @auth
                                <a href="{{ route('dashboard') }}"
                                    class="block px-2 py-1 hover:bg-orange-100 rounded text-sm text-gray-800">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-2 py-1 hover:bg-orange-100 rounded text-sm text-gray-800">Logout</button>
                                </form>
                                @endauth

                                @guest
                                <a href="{{ route('register') }}"
                                    class="block px-2 py-1 hover:bg-orange-100 rounded text-sm text-gray-800">Register</a>
                                <a href="{{ route('login') }}"
                                    class="block px-2 py-1 hover:bg-orange-100 rounded text-sm text-gray-800">Login</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden">
                    <button @click="open = !open"
                        class="bg-orange-500 p-2 rounded-full text-white shadow-md hover:bg-orange-600 focus:outline-none flex items-center">
                        <ion-icon name="menu-outline" size="small"></ion-icon>
                        <ion-icon name="person-circle-outline" size="small"></ion-icon>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-cloak x-transition class="md:hidden mt-2 space-y-2 pb-4">
                <a href="/" class="block hover:text-orange-500">Home</a>
                <a href="{{ route('artis.list') }}" class="block hover:text-orange-500">Artist</a>
                <a href="{{ route('gallery') }}" class="block hover:text-orange-500">Gallery</a>
                <a href="{{ route('contact.index') }}" class="block hover:text-orange-500">Contact</a>

                @auth
                <a href="{{ route('dashboard') }}" class="block hover:text-orange-500">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="hover:text-orange-500">Logout</button>
                </form>
                @endauth

                @guest
                <a href="{{ route('register') }}" class="block hover:text-orange-500">Register</a>
                <a href="{{ route('login') }}" class="block hover:text-orange-500">Login</a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        {{ $slot }}
    </main>
    @stack('scripts')
</body>

</html>