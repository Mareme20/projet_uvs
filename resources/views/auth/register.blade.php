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
        --med-red: #E74C3C;
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
        0%, 100% { box-shadow: 0 0 0 0 rgba(94, 168, 167, 0.4); }
        50% { box-shadow: 0 0 0 20px rgba(94, 168, 167, 0); }
    }

    @keyframes crossMove {
        0% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(2deg) scale(1.03); }
        75% { transform: rotate(-2deg) scale(0.97); }
        100% { transform: rotate(0deg) scale(1); }
    }

    @keyframes checkPop {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }

    .register-wrapper {
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
        width: 550px;
        height: 550px;
        background: var(--med-mint);
        bottom: -200px;
        right: -180px;
        animation: breathe 6s ease-in-out infinite;
    }

    .bg-circle-2 {
        width: 350px;
        height: 350px;
        background: var(--med-sand);
        top: -120px;
        left: -100px;
        animation: breathe 6s ease-in-out 2s infinite;
    }

    .bg-circle-3 {
        width: 120px;
        height: 120px;
        background: rgba(94, 168, 167, 0.08);
        top: 25%;
        left: 10%;
        animation: breathe 4s ease-in-out 3s infinite;
    }

    .bg-dots {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
        opacity: 0.3;
        pointer-events: none;
        background-image: radial-gradient(circle, rgba(62, 130, 181, 0.2) 1px, transparent 1px);
        background-size: 26px 26px;
    }

    .register-card {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 500px;
        background: white;
        border-radius: 24px;
        padding: 44px 40px;
        box-shadow: 0 30px 70px rgba(26, 60, 74, 0.1);
        border: 1px solid rgba(94, 168, 167, 0.12);
        animation: fadeUp 0.7s ease-out;
    }

    .register-logo {
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

    .register-card h4 {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--med-dark);
        letter-spacing: -0.3px;
    }

    .register-subtitle {
        text-align: center;
        color: #7A9AAA;
        font-size: 14px;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        margin-bottom: 18px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #5A7A8A;
        margin-bottom: 6px;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .form-group .input-icon-wrapper {
        position: relative;
    }

    .form-group .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        z-index: 2;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .form-control {
        width: 100%;
        padding: 13px 16px 13px 42px;
        font-size: 15px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        border: 2px solid #E2EEF3;
        border-radius: 13px;
        background: #FAFDFF;
        color: var(--med-dark);
        transition: all 0.3s ease;
        outline: none;
    }

    .form-control:focus {
        border-color: var(--med-teal);
        background: white;
        box-shadow: 0 0 0 5px rgba(94, 168, 167, 0.07);
    }

    .form-control.is-invalid {
        border-color: var(--med-red);
        background: #FFF5F5;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 5px rgba(231, 76, 60, 0.05);
    }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: var(--med-red);
        margin-top: 5px;
        font-weight: 500;
        padding-left: 4px;
        animation: fadeUp 0.25s ease-out;
    }

    /* Antécédents */
    .antecedents-box {
        background: #FAFDFF;
        border: 2px solid #E2EEF3;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: border-color 0.3s;
    }

    .antecedents-box:focus-within {
        border-color: var(--med-teal);
        box-shadow: 0 0 0 5px rgba(94, 168, 167, 0.07);
    }

    .antecedent-item {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        padding: 10px 14px;
        border-radius: 10px;
        transition: background 0.25s;
    }

    .antecedent-item:hover {
        background: var(--med-mint);
    }

    .custom-checkbox {
        appearance: none;
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        border: 2px solid #C8DCE4;
        border-radius: 7px;
        cursor: pointer;
        position: relative;
        flex-shrink: 0;
        transition: all 0.25s;
        background: white;
    }

    .custom-checkbox:checked {
        background: var(--med-teal);
        border-color: var(--med-teal);
    }

    .custom-checkbox:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 13px;
        font-weight: 700;
        animation: checkPop 0.3s ease-out;
    }

    .custom-checkbox:focus-visible {
        outline: 3px solid rgba(94, 168, 167, 0.3);
        outline-offset: 2px;
    }

    .antecedent-label {
        font-size: 14px;
        font-weight: 500;
        color: var(--med-dark);
    }

    .antecedent-badge {
        margin-left: auto;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: 0.3px;
    }

    .badge-diabete { background: #FFF0E6; color: #D4784C; }
    .badge-hypertension { background: #FFE8EC; color: #C94A5F; }
    .badge-hepatite { background: #FFF8E0; color: #B8942E; }

    /* Bouton */
    .btn-register {
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
        margin-top: 6px;
        animation: pulseGlow 2.5s ease-out infinite;
    }

    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 36px rgba(62, 130, 181, 0.45);
    }

    .btn-register:active {
        transform: translateY(-1px);
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 24px 0;
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

    .login-link {
        display: block;
        text-align: center;
        font-size: 14px;
        color: #5A7A8A;
    }

    .login-link a {
        color: var(--med-teal);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.3s;
    }

    .login-link a:hover {
        color: var(--med-blue);
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

    /* Barre de progression */
    .progress-steps {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 28px;
    }

    .progress-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #E2EEF3;
        transition: all 0.3s;
    }

    .progress-dot.active {
        background: var(--med-teal);
        width: 28px;
        border-radius: 10px;
    }

    @media (max-width: 500px) {
        .register-card {
            padding: 36px 22px;
            border-radius: 20px;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .back-home {
            top: 16px;
            left: 16px;
        }
    }
</style>

<div class="register-wrapper">
    <!-- Cercles d'arrière-plan -->
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>
    <div class="bg-dots"></div>

    <!-- Lien retour -->
    <a href="/" class="back-home">
        ← Retour à l'accueil
    </a>

    <!-- Carte d'inscription -->
    <div class="register-card">
        <div class="register-logo">+</div>
        <h4 class="text-center">Créer un compte Patient</h4>
        <p class="register-subtitle">
            Rejoignez la Clinique IIBS et gérez vos rendez-vous en toute simplicité
        </p>

        <!-- Indicateur d'étape -->
        <div class="progress-steps">
            <div class="progress-dot active"></div>
            <div class="progress-dot"></div>
            <div class="progress-dot"></div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nom & Prénom -->
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nom</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon">👤</span>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Dupont"
                        >
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon">👤</span>
                        <input 
                            id="prenom" 
                            type="text" 
                            name="prenom" 
                            class="form-control @error('prenom') is-invalid @enderror" 
                            value="{{ old('prenom') }}" 
                            required 
                            autocomplete="given-name"
                            placeholder="Jean"
                        >
                    </div>
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

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
                        autocomplete="username"
                        placeholder="votre@email.com"
                    >
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Antécédents médicaux -->
            <div class="form-group">
                <label>Antécédents médicaux</label>
                <div class="antecedents-box">
                    <label class="antecedent-item" for="diabete">
                        <input class="custom-checkbox" type="checkbox" name="antecedents[]" value="Diabète" id="diabete">
                        <span class="antecedent-label">Diabète</span>
                        <span class="antecedent-badge badge-diabete">Chronique</span>
                    </label>
                    <label class="antecedent-item" for="hypertension">
                        <input class="custom-checkbox" type="checkbox" name="antecedents[]" value="Hypertension" id="hypertension">
                        <span class="antecedent-label">Hypertension</span>
                        <span class="antecedent-badge badge-hypertension">Cardio</span>
                    </label>
                    <label class="antecedent-item" for="hepatite">
                        <input class="custom-checkbox" type="checkbox" name="antecedents[]" value="Hépatite" id="hepatite">
                        <span class="antecedent-label">Hépatite</span>
                        <span class="antecedent-badge badge-hepatite">Hépatique</span>
                    </label>
                </div>
                @error('antecedents')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-row">
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
                            autocomplete="new-password"
                            placeholder="••••••••"
                        >
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon">🔒</span>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            class="form-control" 
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                        >
                    </div>
                </div>
            </div>

            <!-- Bouton -->
            <button type="submit" class="btn-register">
                Créer mon compte
            </button>

            <!-- Séparateur -->
            <div class="divider">ou</div>

            <!-- Lien connexion -->
            <div class="login-link">
                Déjà inscrit ?
                <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </form>
    </div>
</div>
@endsection