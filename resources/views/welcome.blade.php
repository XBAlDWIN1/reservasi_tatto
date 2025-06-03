<x-home-layout>
    <div class="flex flex-col md:flex-row items-center justify-between px-6 md:px-20 py-16 bg-white space-y-8 md:space-y-0">
        <!-- Text Section -->
        <div class="md:w-1/2 text-center md:text-left space-y-4">
            <p class="text-sm tracking-wide text-orange-500 uppercase font-semibold">Easy Steps To Make A Tattoo</p>

            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight text-gray-900">
                <span class="text-orange-600">Look, Consultation</span><br>
                <span class="text-gray-800">And</span>
                <span class="text-orange-600">Reservation</span>.
            </h1>

            <p class="text-lg md:text-xl text-gray-700 mt-2 font-medium">
                Enjoy The Sensation Of Getting A Tattoo At
                <span class="text-orange-600 font-extrabold">MK TATTO ART!</span>
            </p>

            <div class="flex justify-center md:justify-start mt-6">
                <a href="{{ route('artis.list') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-base px-6 py-3 rounded-full shadow-lg transition duration-300">
                    Get Started
                </a>
            </div>
        </div>

        <!-- Logo Section -->
        <div class="md:w-1/2 flex justify-center">
            <img src="{{ asset('img/logo.jpeg') }}"
                alt="MK Tattoo Logo"
                class="w-[300px] md:w-[360px] h-auto">
        </div>
    </div>

    <!-- Footer Social -->
    <div class="bg-white text-center py-6 border-t border-orange-200">
        <p class="text-sm text-orange-600 mb-2 font-semibold">We Are In Social Media</p>
        <div class="flex justify-center space-x-6 text-2xl">
            <a href="#" class="text-gray-600 hover:text-orange-500 transition"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="#" class="text-gray-600 hover:text-orange-500 transition"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="#" class="text-gray-600 hover:text-orange-500 transition"><ion-icon name="logo-youtube"></ion-icon></a>
        </div>
    </div>
</x-home-layout>