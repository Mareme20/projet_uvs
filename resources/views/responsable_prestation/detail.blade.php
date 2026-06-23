@extends('layouts.bootstrap')

@section('page_title', 'Détails de la Prestation')

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
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulseDot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    .page-container {
        animation: fadeUp 0.5s ease-out;
        max-width: 800px;
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

    /* Carte principale */
    .detail-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        box-shadow: 0 4px 20px rgba(26, 60, 74, 0.04);
        overflow: hidden;
    }

    /* En-tête de la carte */
    .detail-card-header {
        background: linear-gradient(135deg, rgba(59, 130, 181, 0.06) 0%, rgba(94, 168, 167, 0.06) 100%);
        padding: 24px 28px;
        border-bottom: 1px solid rgba(94, 168, 167, 0.1);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .header-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 4px 14px rgba(26, 60, 74, 0.06);
        flex-shrink: 0;
    }

    .header-info h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0 0 2px;
    }

    .header-info .header-meta {
        font-size: 12px;
        color: #8AA0AD;
        font-weight: 500;
    }

    /* Corps */
    .detail-card-body {
        padding: 28px;
    }

    /* Grille d'infos */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }

    .info-block {
        background: #FAFDFF;
        border-radius: 14px;
        padding: 18px 20px;
        border: 1px solid rgba(94, 168, 167, 0.08);
    }

    .info-block.full-width {
        grid-column: 1 / -1;
    }

    .info-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #A0BCC8;
        margin-bottom: 8px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: var(--med-dark);
    }

    .info-value.large {
        font-size: 18px;
    }

    /* Patient */
    .patient-display {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .patient-avatar {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #E0ECF4 0%, #D5EAF0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        color: var(--med-blue);
        flex-shrink: 0;
    }

    .patient-code {
        font-size: 12px;
        color: #A0BCC8;
        font-weight: 500;
        background: #F0F5F8;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 4px;
    }

    /* Badge statut */
    .badge-statut {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-en-attente {
        background: #FFF8E6;
        color: #B8942E;
    }

    .badge-en-attente::before {
        content: '';
        width: 8px;
        height: 8px;
        background: #D4A830;
        border-radius: 50%;
        animation: pulseDot 1.5s ease-in-out infinite;
    }

    .badge-effectue {
        background: #E8F8F0;
        color: #2D7A5F;
    }

    .badge-effectue::before {
        content: '';
        width: 8px;
        height: 8px;
        background: #3DA87A;
        border-radius: 50%;
    }

    .badge-annule {
        background: #FFF0F0;
        color: #C94A5F;
    }

    .badge-annule::before {
        content: '';
        width: 8px;
        height: 8px;
        background: #D95555;
        border-radius: 50%;
    }

    /* Formulaire résultats */
    .results-section {
        margin-top: 4px;
    }

    .results-section label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--med-dark);
        margin-bottom: 10px;
    }

    .results-textarea {
        width: 100%;
        min-height: 200px;
        padding: 18px;
        font-size: 15px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        line-height: 1.7;
        border: 2px solid #E2EEF3;
        border-radius: 14px;
        background: #FAFDFF;
        color: var(--med-dark);
        resize: vertical;
        outline: none;
        transition: all 0.3s;
    }

    .results-textarea:focus {
        border-color: var(--med-teal);
        background: white;
        box-shadow: 0 0 0 6px rgba(94, 168, 167, 0.06);
    }

    .results-textarea::placeholder {
        color: #B0C8D4;
    }

    .char-count {
        text-align: right;
        font-size: 12px;
        color: #B0C8D4;
        margin-top: 6px;
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

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        background: white;
        color: #7A9AAA;
        border: 1px solid rgba(94, 168, 167, 0.2);
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #F7FAFC;
        border-color: #C0D4DD;
        color: var(--med-dark);
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        box-shadow: 0 6px 18px rgba(62, 130, 181, 0.3);
        transition: all 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(62, 130, 181, 0.4);
    }

    .btn-save:active {
        transform: translateY(0);
    }

    .error-message {
        color: #D9444F;
        font-size: 13px;
        font-weight: 500;
        margin-top: 8px;
    }

    @media (max-width: 600px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .btn-row {
            flex-direction: column;
        }

        .btn-back,
        .btn-save {
            justify-content: center;
            width: 100%;
        }
    }
</style>

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-icon">🔬</div>
        <div>
            <h1>Détails de la Prestation</h1>
            <span class="subtitle">Gestion des résultats d'examen</span>
        </div>
    </div>

    <!-- Carte -->
    <div class="detail-card">
        <!-- En-tête carte -->
        <div class="detail-card-header">
            <div class="header-icon">🔬</div>
            <div class="header-info">
                <h2>{{ $prestation->type }}</h2>
                <span class="header-meta">Prestation médicale</span>
            </div>
        </div>

        <!-- Corps -->
        <div class="detail-card-body">
            <!-- Infos -->
            <div class="info-grid">
                <!-- Patient -->
                <div class="info-block">
                    <div class="info-label">Patient</div>
                    <div class="patient-display">
                        <div class="patient-avatar">
                            {{ strtoupper(substr($prestation->patient->prenom, 0, 1)) }}
                        </div>
                        <div>
                            <div class="info-value">{{ $prestation->patient->prenom }} {{ $prestation->patient->nom }}</div>
                            <span class="patient-code">Code : {{ $prestation->patient->code }}</span>
                        </div>
                    </div>
                </div>

                <!-- Statut -->
                <div class="info-block">
                    <div class="info-label">Statut</div>
                    @if($prestation->statut == 'effectue')
                        <span class="badge-statut badge-effectue">Effectuée</span>
                    @elseif($prestation->statut == 'annule')
                        <span class="badge-statut badge-annule">Annulée</span>
                    @else
                        <span class="badge-statut badge-en-attente">En attente</span>
                    @endif
                </div>

                <!-- Date -->
                <div class="info-block full-width">
                    <div class="info-label">Date & Heure</div>
                    <div class="info-value large">
                        📅 {{ \Carbon\Carbon::parse($prestation->date_prestation)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($prestation->date_prestation)->format('H:i') }}
                    </div>
                </div>
            </div>

            <!-- Formulaire résultats -->
            <form method="POST" action="{{ route('responsable.prestation.update', $prestation->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="results-section">
                    <label for="resultats">
                        📝 Résultats / Compte-rendu de l'examen
                    </label>
                    <textarea 
                        id="resultats" 
                        name="resultats" 
                        rows="10" 
                        class="results-textarea" 
                        placeholder="Saisissez ici les résultats détaillés de la prestation…"
                        required
                    >{{ $prestation->resultats }}</textarea>
                    <div class="char-count" id="charCount">0 caractères</div>
                    @error('resultats')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="results-section" style="margin-top: 20px;">
                    <label for="fichier_resultat">
                        📁 Joindre un document (PDF, JPG, PNG)
                    </label>
                    <input type="file" name="fichier_resultat" id="fichier_resultat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    @if($prestation->fichier_resultat)
                        <div style="margin-top: 10px; font-size: 13px;">
                            <span style="color: var(--med-teal);">✓ Document déjà joint :</span>
                            <a href="{{ asset('storage/' . $prestation->fichier_resultat) }}" target="_blank" style="color: var(--med-blue); font-weight: 600;">Voir le fichier actuel</a>
                        </div>
                    @endif
                    @error('fichier_resultat')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="btn-row">
                    <a href="{{ route('responsable.dashboard') }}" class="btn-back">
                        ← Retour à la liste
                    </a>
                    <button type="submit" class="btn-save">
                        💾 Enregistrer les résultats
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script compteur de caractères -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('resultats');
        const charCount = document.getElementById('charCount');

        function updateCount() {
            const count = textarea.value.length;
            charCount.textContent = count + ' caractère' + (count !== 1 ? 's' : '');
        }

        updateCount();
        textarea.addEventListener('input', updateCount);
    });
</script>
@endsection