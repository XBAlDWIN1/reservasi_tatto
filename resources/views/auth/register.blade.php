<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Heading -->
        <div class="w-full mt-4 text-center text-accent">
            <h1 class="text-2xl font-bold">
                {{ __('Welcome') }}
            </h1>
            <h2 class="text-2xl font-bolds ">{{ __('Sign Up to create an account') }}</h2>
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Username')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                    <ion-icon name="eye-outline" id="eyeIcon1"></ion-icon>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password_confirmation"
                    required autocomplete="new-password" />
                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                    <ion-icon name="eye-outline" id="eyeIcon2"></ion-icon>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center w-full mt-4">
            <a class="underline text-sm text-accent hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already have account?') }}
            </a>
        </div>

        <div class="flex items-center justify-center w-full mt-4">
            <x-primary-button class="w-full items-center justify-center">
                {{ __('Sign Up') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.name = 'eye-off-outline';
            } else {
                input.type = 'password';
                icon.name = 'eye-outline';
            }
        }
    </script>
    @endpush
</x-guest-layout>