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
<title>SAHADA GİRİŞ</title>
<div class="min-h-screen flex items-center justify-center bg-gray-800">
    <x-guest-layout>
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
            <x-authentication-card>
                <x-slot name="logo">

                </x-slot>

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="logo-container">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                    </div>
                    <h2>Giriş Yap</h2>
                    <form method="POST" action="/login">
                        @csrf
                        <div class="form-group">
                            <label for="email">E-Posta</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Şifre</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="form-actions">
                            <a href="/register">Kayıt Ol</a>
                            <a href="/password-reset">Şifremi Unuttum</a>
                            <button type="submit">Giriş Yap</button>
                        </div>
                    </form>
                </div>

            </x-authentication-card>
        </div>
    </x-guest-layout>
</div>
