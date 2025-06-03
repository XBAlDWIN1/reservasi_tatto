<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Heading -->
        <div class="w-full mt-4 text-center text-accent">
            <h1 class="text-2xl font-bold">
                {{ __('Welcome') }}
            </h1>
            <h2 class="text-2xl font-bolds ">{{ __('Log in to your account') }}</h2>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />

                <!-- Toggle button -->
                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                    <ion-icon name="eye-outline" id="eyeIcon"></ion-icon>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded  border-gray-300  text-indigo-600 shadow-sm focus:ring-indigo-500  " name="remember">
                <span class="ms-2 text-sm text-accent">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-accent hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 " href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full items-center justify-center">
                {{ __('Sign in') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.name = 'eye-off-outline';
            } else {
                passwordInput.type = 'password';
                eyeIcon.name = 'eye-outline';
            }
        }
    </script>
    @endpush

</x-guest-layout>