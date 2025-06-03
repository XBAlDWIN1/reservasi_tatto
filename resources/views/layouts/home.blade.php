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
                            <ion-icon name="menu-outline" size="large"></ion-icon>
                            <ion-icon name="person-circle-outline" size="large"></ion-icon>
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
            <div x-show="open" x-transition class="md:hidden mt-2 space-y-2 pb-4">
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