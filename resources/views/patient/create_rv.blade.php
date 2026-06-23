@extends('layouts.bootstrap')

@section('page_title', 'Demander un Rendez-vous')

@section('content')
<style>
    :root {
        --med-blue: #3B82B5;
        --med-teal: #5EA8A7;
        --med-mint: #E8F4F8;
        --med-white: #FAFDFF;
        --med-dark: #1A3C4A;
        --med-sand: #FDF6F0;
        --med-green: #48BB78;
        --med-red: #E74C3C;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideDown {
        from { opacity: 0; max-height: 0; transform: translateY(-10px); }
        to { opacity: 1; max-height: 400px; transform: translateY(0); }
    }

    .page-container {
        animation: fadeUp 0.5s ease-out;
        max-width: 650px;
        margin: 0 auto;
    }

    /* En-tête */
    .page-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 28px;
    }

    .page-icon {
        width: 46px;
        height: 46px;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 8px 22px rgba(62, 130, 181, 0.25);
        flex-shrink: 0;
    }

    .page-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0;
    }

    .page-header .subtitle {
        font-size: 13px;
        color: #7A9AAA;
        font-weight: 500;
    }

    /* Carte formulaire */
    .form-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        box-shadow: 0 4px 20px rgba(26, 60, 74, 0.04);
        overflow: hidden;
    }

    .form-card-body {
        padding: 32px 30px;
    }

    /* Sélecteur de type */
    .type-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 28px;
    }

    .type-option {
        position: relative;
    }

    .type-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .type-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 22px 16px;
        border: 2px solid #E2EEF3;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        background: var(--med-white);
    }

    .type-label:hover {
        border-color: #C0D8E0;
        background: white;
    }

    .type-option input:checked + .type-label {
        border-color: var(--med-teal);
        background: rgba(94, 168, 167, 0.04);
        box-shadow: 0 0 0 6px rgba(94, 168, 167, 0.06);
    }

    .type-label-icon {
        font-size: 36px;
    }

    .type-label-title {
        font-weight: 700;
        font-size: 15px;
        color: var(--med-dark);
    }

    .type-label-desc {
        font-size: 11px;
        color: #A0BCC8;
        font-weight: 500;
    }

    .type-option input:checked + .type-label .type-label-title {
        color: var(--med-teal);
    }

    /* Champs */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #7A9AAA;
        margin-bottom: 7px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        z-index: 2;
        pointer-events: none;
    }

    .input-field {
        width: 100%;
        padding: 13px 16px 13px 42px;
        font-size: 15px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        border: 2px solid #E2EEF3;
        border-radius: 13px;
        background: #FAFDFF;
        color: var(--med-dark);
        outline: none;
        transition: all 0.3s;
    }

    .input-field:focus {
        border-color: var(--med-teal);
        background: white;
        box-shadow: 0 0 0 5px rgba(94, 168, 167, 0.06);
    }

    .input-field::placeholder {
        color: #B0C8D4;
    }

    .select-field {
        width: 100%;
        padding: 13px 16px 13px 42px;
        font-size: 15px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        border: 2px solid #E2EEF3;
        border-radius: 13px;
        background: #FAFDFF;
        color: var(--med-dark);
        outline: none;
        transition: all 0.3s;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23A0BCC8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }

    .select-field:focus {
        border-color: var(--med-teal);
        background: white;
        box-shadow: 0 0 0 5px rgba(94, 168, 167, 0.06);
    }

    .error-message {
        color: var(--med-red);
        font-size: 12px;
        font-weight: 500;
        margin-top: 5px;
        padding-left: 4px;
    }

    /* Champ dynamique */
    .dynamic-field {
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .dynamic-field.hidden {
        max-height: 0;
        opacity: 0;
        margin: 0;
        pointer-events: none;
    }

    .dynamic-field.visible {
        max-height: 300px;
        opacity: 1;
        margin-bottom: 20px;
    }

    /* Boutons */
    .btn-row {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(94, 168, 167, 0.1);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 13px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        color: #7A9AAA;
        background: white;
        border: 1px solid rgba(94, 168, 167, 0.2);
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: #F7FAFC;
        border-color: #C0D4DD;
        color: var(--med-dark);
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 30px;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(62, 130, 181, 0.3);
        transition: all 0.3s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(62, 130, 181, 0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Info box */
    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        background: var(--med-mint);
        border-radius: 12px;
        margin-top: 24px;
        font-size: 13px;
        color: #5A7A8A;
        line-height: 1.5;
    }

    .info-box-icon {
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    @media (max-width: 500px) {
        .type-selector {
            grid-template-columns: 1fr;
        }

        .btn-row {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-submit {
            justify-content: center;
            width: 100%;
        }
    }
</style>

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-icon">📅</div>
        <div>
            <h1>Nouveau Rendez-vous</h1>
            <span class="subtitle">Choisissez le type et la date souhaitée</span>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="form-card">
        <div class="form-card-body">
            <form method="POST" action="{{ route('patient.rv.store') }}">
                @csrf

                <!-- Sélecteur de type -->
                <div class="form-group">
                    <label>Type de Rendez-vous</label>
                    <div class="type-selector">
                        <div class="type-option">
                            <input 
                                type="radio" 
                                id="type_consultation" 
                                name="type" 
                                value="consultation" 
                                {{ old('type') == 'consultation' ? 'checked' : '' }}
                                onchange="toggleFields()"
                            >
                            <label class="type-label" for="type_consultation">
                                <span class="type-label-icon">🩺</span>
                                <span class="type-label-title">Consultation</span>
                                <span class="type-label-desc">Avec un médecin</span>
                            </label>
                        </div>
                        <div class="type-option">
                            <input 
                                type="radio" 
                                id="type_prestation" 
                                name="type" 
                                value="prestation" 
                                {{ old('type') == 'prestation' ? 'checked' : '' }}
                                onchange="toggleFields()"
                            >
                            <label class="type-label" for="type_prestation">
                                <span class="type-label-icon">🔬</span>
                                <span class="type-label-title">Prestation</span>
                                <span class="type-label-desc">Analyse, radio, etc.</span>
                            </label>
                        </div>
                    </div>
                    @error('type')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Médecin (consultation) -->
                <div id="medecin_field" class="dynamic-field {{ old('type') == 'consultation' ? 'visible' : 'hidden' }}">
                    <div class="form-group">
                        <label for="medecin_id">Médecin</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👨‍⚕️</span>
                            <select id="medecin_id" name="medecin_id" class="select-field">
                                <option value="">Choisir un médecin...</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('medecin_id') == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->user->name }} — {{ $doctor->specialite }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('medecin_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Prestation -->
                <div id="prestation_field" class="dynamic-field {{ old('type') == 'prestation' ? 'visible' : 'hidden' }}">
                    <div class="form-group">
                        <label for="prestation_type">Type de Prestation</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🔬</span>
                            <input 
                                id="prestation_type" 
                                type="text" 
                                name="prestation_type" 
                                class="input-field" 
                                value="{{ old('prestation_type') }}" 
                                placeholder="Ex: Radio thoracique, Analyse sanguine..."
                            >
                        </div>
                        @error('prestation_type')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Date -->
                <div class="form-group">
                    <label for="date_rv">Date et Heure souhaitée</label>
                    <div class="input-wrapper">
                        <span class="input-icon">📅</span>
                        <input 
                            id="date_rv" 
                            type="datetime-local" 
                            name="date_rv" 
                            class="input-field" 
                            value="{{ old('date_rv') }}" 
                            required
                        >
                    </div>
                    @error('date_rv')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Info -->
                <div class="info-box">
                    <span class="info-box-icon">ℹ️</span>
                    <span>Votre rendez-vous sera <strong>validé par notre secrétaire</strong> selon la disponibilité du médecin ou de la prestation demandée. Vous recevrez une confirmation.</span>
                </div>

                <!-- Boutons -->
                <div class="btn-row">
                    <a href="{{ route('patient.dashboard') }}" class="btn-cancel">
                        ← Retour
                    </a>
                    <button type="submit" class="btn-submit">
                        📩 Envoyer la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleFields() {
        const consultationRadio = document.getElementById('type_consultation');
        const medecinField = document.getElementById('medecin_field');
        const prestationField = document.getElementById('prestation_field');

        if (consultationRadio.checked) {
            medecinField.classList.remove('hidden');
            medecinField.classList.add('visible');
            prestationField.classList.remove('visible');
            prestationField.classList.add('hidden');
        } else {
            medecinField.classList.remove('visible');
            medecinField.classList.add('hidden');
            prestationField.classList.remove('hidden');
            prestationField.classList.add('visible');
        }
    }

    // Initialiser au chargement
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
    });
</script>
@endsection