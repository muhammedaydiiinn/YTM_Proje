<style>
    /* Genel stil ayarları */
    body {
        margin: 0;
        padding: 0;
        background-color: #1E2739;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: Arial, sans-serif;
        color: #333;
    }

    /* Kart stili */
    .card {
        background-color: #ffffff;
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    /* Logo stil */
    .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .logo-container img {
        height: 80px;
    }

    /* Form elemanları */
    .card h2 {
        margin-bottom: 1.5rem;
        color: #1E2739;
    }

    .form-group {
        margin-bottom: 1rem;
        text-align: left;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #1E2739;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
    }

    .form-group input:focus {
        border-color: #1E2739;
        box-shadow: 0 0 5px rgba(30, 39, 57, 0.5);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }

    .form-actions a {
        font-size: 0.9rem;
        color: #1E2739;
        text-decoration: none;
    }

    .form-actions a:hover {
        text-decoration: underline;
    }

    .form-actions button {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        background-color: #1E2739;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-actions button:hover {
        background-color: #2C3E50;
    }
</style>
<link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon.ico')}}" />
<title>SAHADA KAYIT OL</title>
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">

        </x-slot>

        <x-validation-errors class="mb-4" />

        <div class="card">
            <div class="logo-container">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            </div>
            <h2>SAHADA KAYIT OL</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">İsim</label>
                    <input id="name" type="text" name="name" required autofocus autocomplete="name" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">E-Posta</label>
                    <input id="email" type="email" name="email" required autocomplete="username" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">Şifre</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Şifre Tekrarla</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">Kullanım Şartları</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">Gizlilik Politikası</a>',
                            ]) !!}
                        </label>
                    </div>
                @endif

                <div class="form-actions">
                    <a href="{{ route('login') }}">Kayıtlı mısınız? Giriş yapın</a>
                    <button type="submit">Kayıt Ol</button>
                </div>
            </form>
        </div>

    </x-authentication-card>
</x-guest-layout>
