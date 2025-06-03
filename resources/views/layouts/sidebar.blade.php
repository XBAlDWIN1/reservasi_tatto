<!-- Logo and Title -->
<div class="flex flex-col items-center py-6 border-b border-gray-200">
    <a href="{{url('/')}}">
        <img src="{{ asset('img/logo.jpeg') }}" alt="MK Tattoo Art" class="w-24 h-24">
    </a>
    <h2 class="mt-2 text-lg font-semibold">{{ Auth::user()->name }}</h2>
</div>

<!-- Navigation Links -->
<div class="py-4 space-y-2">
    <!-- Semua pengguna bisa lihat Dashboard -->
    <x-sidebar-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <ion-icon name="home-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Dashboard') }}
    </x-sidebar-nav-link>

    <!-- Konsultasi hanya untuk staff -->
    @hasanyrole('Admin|Pengelola')
    <x-sidebar-nav-link :href="route('konsultasis.index')" :active="request()->routeIs('konsultasis.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="chatbubble-ellipses-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Konsultasi') }}
    </x-sidebar-nav-link>
    @endhasanyrole

    @role('Pengguna')
    <x-sidebar-nav-link :href="route('konsultasi.index')" :active="request()->routeIs('konsultasi.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="chatbubble-ellipses-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Konsultasi') }}
    </x-sidebar-nav-link>
    @endrole

    <!-- Reservasi Pengguna -->
    @role('Pengguna')
    <x-sidebar-nav-link :href="route('user.reservasi.index')" :active="request()->routeIs('user.reservasi.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="calendar-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Reservasi Saya') }}
    </x-sidebar-nav-link>
    @endrole

    <!-- Reservasi hanya untuk staff -->
    @hasanyrole('Admin|Pengelola')
    <x-sidebar-nav-link href="{{ route('reservasis.index') }}" :active="request()->routeIs('reservasis.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="calendar-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Reservasi') }}
    </x-sidebar-nav-link>
    @endhasanyrole

    <!-- Pembayaran hanya untuk admin dan staff -->
    @hasanyrole('Admin|Pengelola')
    <x-sidebar-nav-link :href="route('pembayarans.index')" :active="request()->routeIs('pembayarans.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="card-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Pembayaran') }}
    </x-sidebar-nav-link>
    @endhasanyrole

    <!-- Pelanggan hanya untuk admin dan staff -->
    @hasanyrole('Admin|Pengelola')
    <x-sidebar-nav-link :href="route('pelanggans.index')" :active="request()->routeIs('pelanggans.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="people-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Pelanggan') }}
    </x-sidebar-nav-link>
    @endhasanyrole

    <!-- Kategori hanya untuk admin -->
    @role('Admin')
    <x-sidebar-nav-link :href="route('kategoris.index')" :active="request()->routeIs('kategoris.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="albums-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Kategori') }}
    </x-sidebar-nav-link>
    @endrole

    <!-- Artis Kategori hanya untuk admin -->
    @role('Admin')
    <x-sidebar-nav-link :href="route('artis-kategori.index')" :active="request()->routeIs('artis-kategori.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="layers-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Artis Kategori') }}
    </x-sidebar-nav-link>
    @endrole

    <!-- Portfolio bisa untuk admin & artis -->
    @hasanyrole('Admin|Pengelola')
    <x-sidebar-nav-link :href="route('portfolios.index')" :active="request()->routeIs('portfolios.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="images-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Portfolio') }}
    </x-sidebar-nav-link>
    @endhasanyrole

    <!-- Lokasi Tato hanya untuk admin -->
    @role('Admin')
    <x-sidebar-nav-link :href="route('lokasi_tatos.index')" :active="request()->routeIs('lokasi_tatos.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="location-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Lokasi Tato') }}
    </x-sidebar-nav-link>
    @endrole

    <!-- Artis Tato hanya untuk admin dan owner -->
    @role('Admin')
    <x-sidebar-nav-link :href="route('artis_tatos.index')" :active="request()->routeIs('artis_tatos.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="brush-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Artis Tato') }}
    </x-sidebar-nav-link>
    @endrole

    <!-- User Management hanya untuk admin -->
    @role('Admin')
    <x-sidebar-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="hover:bg-[#FFCDB2]">
        <x-slot name="icon">
            <ion-icon name="person-circle-outline" class="text-xl mr-3"></ion-icon>
        </x-slot>
        {{ __('Pengguna') }}
    </x-sidebar-nav-link>
    @endrole

</div>