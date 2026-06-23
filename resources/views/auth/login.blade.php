@extends('layouts.auth')

@section('content')
<style>
    :root {
        --med-blue: #3B82B5;
        --med-teal: #5EA8A7;
        --med-mint: #E8F4F8;
        --med-white: #FAFDFF;
        --med-dark: #1A3C4A;
        --med-sand: #FDF6F0;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes breathe {
        0%, 100% { transform: scale(1); opacity: 0.6; }
        50% { transform: scale(1.04); opacity: 0.9; }
    }

    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(62, 130, 181, 0.4); }
        50% { box-shadow: 0 0 0 20px rgba(62, 130, 181, 0); }
    }

    @keyframes crossMove {
        0% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(2deg) scale(1.03); }
        75% { transform: rotate(-2deg) scale(0.97); }
        100% { transform: rotate(0deg) scale(1); }
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--med-white);
        position: relative;
        overflow: hidden;
        padding: 40px 20px;
    }

    .bg-circle {
        position: absolute;
        border-radius: 50%;
        z-index: 0;
    }

    .bg-circle-1 {
        width: 600px;
        height: 600px;
        background: var(--med-mint);
        top: -250px;
        right: -200px;
        animation: breathe 5s ease-in-out infinite;
    }

    .bg-circle-2 {
        width: 400px;
        height: 400px;
        background: var(--med-sand);
        bottom: -150px;
        left: -120px;
        animation: breathe 5s ease-in-out 1.5s infinite;
    }

    .bg-circle-3 {
        width: 150px;
        height: 150px;
        background: rgba(94, 168, 167, 0.1);
        top: 40%;
        left: 60%;
        animation: breathe 4s ease-in-out 2.5s infinite;
    }

    .bg-dots {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
        opacity: 0.35;
        pointer-events: none;
        background-image: radial-gradient(circle, rgba(62, 130, 181, 0.25) 1px, transparent 1px);
        background-size: 28px 28px;
    }

    .login-card {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 440px;
        background: white;
        border-radius: 24px;
        padding: 48px 40px;
        box-shadow: 0 30px 70px rgba(26, 60, 74, 0.1);
        border: 1px solid rgba(94, 168, 167, 0.12);
        animation: fadeUp 0.7s ease-out;
    }

    .login-logo {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 26px;
        font-weight: 700;
        margin: 0 auto 20px;
        box-shadow: 0 10px 28px rgba(62, 130, 181, 0.3);
        animation: crossMove 6s ease-in-out infinite;
    }

    .login-card h4 {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--med-dark);
        letter-spacing: -0.3px;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #5A7A8A;
        margin-bottom: 7px;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .form-group .input-icon-wrapper {
        position: relative;
    }

    .form-group .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #A0BCC8;
        font-size: 16px;
        transition: color 0.3s;
        z-index: 2;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px 14px 44px;
        font-size: 15px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        border: 2px solid #E2EEF3;
        border-radius: 14px;
        background: #FAFDFF;
        color: var(--med-dark);
        transition: all 0.3s ease;
        outline: none;
    }

    .form-control:focus {
        border-color: var(--med-teal);
        background: white;
        box-shadow: 0 0 0 5px rgba(94, 168, 167, 0.08);
    }

    .form-control.is-invalid {
        border-color: #E74C3C;
        background: #FFF5F5;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 5px rgba(231, 76, 60, 0.06);
    }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #E74C3C;
        margin-top: 6px;
        font-weight: 500;
        padding-left: 4px;
        animation: fadeUp 0.25s ease-out;
    }

    .remember-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
    }

    .custom-checkbox {
        width: 20px;
        height: 20px;
        accent-color: var(--med-teal);
        cursor: pointer;
    }

    .remember-row label {
        font-size: 14px;
        color: #5A7A8A;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-login {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1.2);
        box-shadow: 0 8px 24px rgba(62, 130, 181, 0.3);
        letter-spacing: 0.3px;
        animation: pulseGlow 2.5s ease-out infinite;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 36px rgba(62, 130, 181, 0.45);
    }

    .btn-login:active {
        transform: translateY(-1px);
    }

    .links-row {
        text-align: center;
        margin-top: 22px;
    }

    .links-row a {
        color: var(--med-teal);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: color 0.3s;
    }

    .links-row a:hover {
        color: var(--med-blue);
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 22px 0;
        color: #B0C8D4;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #E2EEF3;
    }

    .register-link {
        display: block;
        text-align: center;
        font-size: 14px;
        color: #5A7A8A;
        margin-top: 6px;
    }

    .register-link a {
        color: var(--med-teal);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.3s;
    }

    .register-link a:hover {
        color: var(--med-blue);
    }

    .alert-success {
        background: #E8F8F0;
        color: #2D7A5F;
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 24px;
        border: 1px solid rgba(45, 122, 95, 0.15);
        animation: fadeUp 0.4s ease-out;
    }

    .back-home {
        position: absolute;
        top: 32px;
        left: 32px;
        z-index: 20;
        color: var(--med-dark);
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .back-home:hover {
        opacity: 1;
    }

    @media (max-width: 500px) {
        .login-card {
            padding: 36px 24px;
            border-radius: 20px;
        }
        .back-home {
            top: 16px;
            left: 16px;
        }
    }
</style>

<div class="login-wrapper">
    <!-- Cercles d'arrière-plan -->
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>
    <div class="bg-dots"></div>

    <!-- Lien retour -->
    <a href="/" class="back-home">
        ← Retour à l'accueil
    </a>

    <!-- Carte de connexion -->
    <div class="login-card">
        <div class="login-logo">+</div>
        <h4 class="text-center">Connexion</h4>
        <p style="text-align:center; color:#7A9AAA; font-size:14px; margin-bottom:28px;">
            Accédez à votre espace Clinique IIBS
        </p>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-icon-wrapper">
                    <span class="input-icon">✉️</span>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="votre@email.com"
                    >
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-icon-wrapper">
                    <span class="input-icon">🔒</span>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••"
                    >
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Se souvenir de moi -->
            <div class="remember-row">
                <input id="remember_me" type="checkbox" class="custom-checkbox" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>

            <!-- Bouton -->
            <button type="submit" class="btn-login">
                Se connecter
            </button>

            <!-- Mot de passe oublié -->
            @if (Route::has('password.request'))
            <div class="links-row">
                <a href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            </div>
            @endif

            <!-- Séparateur -->
            <div class="divider">ou</div>

            <!-- Lien inscription -->
            <div class="register-link">
                Pas encore de compte ?
                <a href="{{ route('register') }}">S'inscrire</a>
            </div>
        </form>
    </div>
</div>
@endsection