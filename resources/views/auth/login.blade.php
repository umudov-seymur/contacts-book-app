<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <h1 class="text-white text-3xl pt-8">Welcome Back</h1>
        <h2 class="text-blue-300">Enter your credentials below</h2>

        <form method="POST" action="{{ route('login') }}" class="pt-8">
            @csrf

            <div class="relative">
                <x-auth.label for="email" :value="__('Email')" />

                <div>
                    <x-auth.input id="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>
            </div>

            <div class="relative mt-4">
                <x-auth.label for="password" :value="__('Password')" />

                <div>
                    <x-auth.input id="password" type="password" name="password" :value="old('password')" required autofocus />
                </div>
            </div>

            <div class="pt-3">
                <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="text-white" for="remember">{{ __('Remember Me') }}</label>
            </div>

            <div class="pt-8">
                <x-button class="w-full" type="submit">
                    {{ __('Login') }}
                </x-button>
            </div>

            <div class="flex justify-between pt-8 text-white text-sm font-bold">
                @if (Route::has('password.request'))
                    <a class="hover:text-blue-200" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                @endif
                <a class="hover:text-blue-200" href="{{ route('register') }}">
                    Register
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
