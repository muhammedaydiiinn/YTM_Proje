<style>
    .bg-gray-100{
        background-color: #1E2739 !important;
    }
</style>
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="{{route('index_home')}}" class="app-brand-link">
            <img src="{{asset('assets/img/logo.png')}}"style="height: 80px">
            </a>
        </x-slot>
        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="E-Posta" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Şifre" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">Beni Hatırla</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Kayıt Ol
                </a>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Şifremi Unuttum
                    </a>
                @endif

                <x-button class="ms-4">
                    Giriş Yap
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
