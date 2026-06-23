@extends('layouts.bootstrap')

@section('page_title', 'Tableau de Bord Médecin')

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
        --med-orange: #ED8936;
        --med-red: #E74C3C;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseDot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    @keyframes cardPop {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .page-container {
        animation: fadeUp 0.5s ease-out;
    }

    /* En-tête */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }

    .page-title-block {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 8px 22px rgba(62, 130, 181, 0.25);
    }

    .page-title-block h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0;
    }

    .page-title-block .subtitle {
        font-size: 13px;
        color: #7A9AAA;
        font-weight: 500;
    }

    /* Recherche */
    .search-bar {
        display: flex;
        align-items: center;
        gap: 0;
        background: white;
        border-radius: 50px;
        border: 1px solid rgba(94, 168, 167, 0.2);
        box-shadow: 0 2px 12px rgba(26, 60, 74, 0.04);
        overflow: hidden;
        transition: all 0.3s;
    }

    .search-bar:focus-within {
        border-color: var(--med-teal);
        box-shadow: 0 0 0 5px rgba(94, 168, 167, 0.08);
    }

    .search-bar input {
        border: none;
        outline: none;
        padding: 11px 8px 11px 18px;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        color: var(--med-dark);
        background: transparent;
        width: 220px;
    }

    .search-bar input::placeholder {
        color: #B0C8D4;
    }

    .search-bar button {
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        border: none;
        padding: 11px 18px;
        cursor: pointer;
        font-size: 16px;
        transition: opacity 0.2s;
        display: flex;
        align-items: center;
    }

    .search-bar button:hover {
        opacity: 0.9;
    }

    /* KPI rapides */
    .kpi-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .kpi-mini {
        background: white;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        transition: all 0.3s;
    }

    .kpi-mini:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26, 60, 74, 0.05);
    }

    .kpi-mini-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .km-blue { background: var(--med-mint); }
    .km-green { background: rgba(72, 187, 120, 0.1); }
    .km-orange { background: rgba(237, 137, 54, 0.08); }
    .km-teal { background: rgba(94, 168, 167, 0.1); }

    .kpi-mini-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--med-dark);
        line-height: 1;
    }

    .kpi-mini-label {
        font-size: 11px;
        color: #8AA0AD;
        font-weight: 500;
    }

    /* Liste des consultations */
    .consultation-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .consultation-card {
        background: white;
        border-radius: 18px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(26, 60, 74, 0.02);
        animation: cardPop 0.4s ease-out;
    }

    .consultation-card:hover {
        border-color: rgba(94, 168, 167, 0.25);
        box-shadow: 0 8px 28px rgba(26, 60, 74, 0.06);
        transform: translateY(-1px);
    }

    /* Heure */
    .time-block {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 70px;
        padding: 10px 14px;
        background: var(--med-mint);
        border-radius: 14px;
        flex-shrink: 0;
    }

    .time-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--med-dark);
        line-height: 1;
    }

    .time-label {
        font-size: 10px;
        color: var(--med-blue);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    /* Patient */
    .patient-block {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 200px;
        flex-shrink: 0;
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

    .patient-info {
        line-height: 1.3;
    }

    .patient-name {
        font-weight: 600;
        font-size: 15px;
        color: var(--med-dark);
    }

    .patient-code {
        font-size: 11px;
        color: #A0BCC8;
        font-weight: 500;
        background: #F5F8FA;
        padding: 2px 9px;
        border-radius: 10px;
        display: inline-block;
        margin-top: 2px;
    }

    /* Statut */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .status-effectue {
        background: rgba(72, 187, 120, 0.1);
        color: var(--med-green);
    }

    .status-effectue::before {
        content: '';
        width: 7px;
        height: 7px;
        background: var(--med-green);
        border-radius: 50%;
    }

    .status-en-attente {
        background: #FFF8E6;
        color: #B8942E;
    }

    .status-en-attente::before {
        content: '';
        width: 7px;
        height: 7px;
        background: #D4A830;
        border-radius: 50%;
        animation: pulseDot 1.5s ease-in-out infinite;
    }

    .status-annule {
        background: rgba(231, 76, 60, 0.07);
        color: var(--med-red);
    }

    .status-annule::before {
        content: '';
        width: 7px;
        height: 7px;
        background: var(--med-red);
        border-radius: 50%;
    }

    /* Actions */
    .actions-block {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
        margin-left: auto;
    }

    .btn-action-card {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .btn-gerer {
        background: rgba(59, 130, 181, 0.08);
        color: var(--med-blue);
        border: 1px solid rgba(59, 130, 181, 0.15);
    }

    .btn-gerer:hover {
        background: rgba(59, 130, 181, 0.15);
        border-color: var(--med-blue);
        transform: translateY(-1px);
    }

    .btn-dossier {
        background: rgba(94, 168, 167, 0.08);
        color: var(--med-teal);
        border: 1px solid rgba(94, 168, 167, 0.15);
    }

    .btn-dossier:hover {
        background: rgba(94, 168, 167, 0.15);
        border-color: var(--med-teal);
        transform: translateY(-1px);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(94, 168, 167, 0.1);
    }

    .empty-state-icon {
        font-size: 56px;
        margin-bottom: 16px;
        opacity: 0.7;
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--med-dark);
        margin-bottom: 6px;
    }

    .empty-state p {
        color: #A0BCC8;
        font-size: 14px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .kpi-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .consultation-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .actions-block {
            margin-left: 0;
            width: 100%;
        }

        .btn-action-card {
            flex: 1;
            justify-content: center;
        }

        .patient-block {
            min-width: auto;
        }
    }

    @media (max-width: 600px) {
        .kpi-row {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-bar {
            width: 100%;
        }

        .search-bar input {
            flex: 1;
            width: auto;
        }
    }
</style>

@php
    $totalConsultations = $consultations->count();
    $effectuees = $consultations->where('rendezVous.statut', 'effectue')->count();
    $enAttente = $consultations->where('rendezVous.statut', 'en_attente')->count();
    $annulees = $consultations->where('rendezVous.statut', 'annule')->count();
@endphp

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-title-block">
            <div class="page-icon">🩺</div>
            <div>
                <h1>Consultations</h1>
                <span class="subtitle">
                    Tableau de bord — {{ ucfirst(Auth::user()->getRoleNames()->first()) }}
                </span>
            </div>
        </div>

        <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
            <!-- Filtre par date -->
            <form action="{{ route('medecin.dashboard') }}" method="GET" class="filter-bar" style="display:flex; gap:10px;">
                <input type="date" name="date" value="{{ request('date') }}" style="border:none; outline:none; background:transparent; font-size:14px;">
                <button type="submit" class="btn-filter" style="border-radius:50px; padding:9px 18px;">Filtrer</button>
                @if(request('date'))
                    <a href="{{ route('medecin.dashboard') }}" class="btn-reset">✕</a>
                @endif
            </form>

            <!-- Recherche patient -->
            <form action="{{ route('medecin.patient.search') }}" method="GET" class="search-bar">
                <input type="text" name="query" placeholder="Rechercher un patient..." value="{{ request('query') }}">
                <button type="submit" title="Rechercher">
                    🔍
                </button>
            </form>
        </div>
    </div>


    <!-- KPI -->
    <div class="kpi-row">
        <div class="kpi-mini">
            <div class="kpi-mini-icon km-blue">📋</div>
            <div>
                <div class="kpi-mini-value">{{ $totalConsultations }}</div>
                <div class="kpi-mini-label">Total aujourd'hui</div>
            </div>
        </div>
        <div class="kpi-mini">
            <div class="kpi-mini-icon km-green">✅</div>
            <div>
                <div class="kpi-mini-value">{{ $effectuees }}</div>
                <div class="kpi-mini-label">Effectuées</div>
            </div>
        </div>
        <div class="kpi-mini">
            <div class="kpi-mini-icon km-orange">⏳</div>
            <div>
                <div class="kpi-mini-value">{{ $enAttente }}</div>
                <div class="kpi-mini-label">En attente</div>
            </div>
        </div>
        <div class="kpi-mini">
            <div class="kpi-mini-icon km-teal">✕</div>
            <div>
                <div class="kpi-mini-value">{{ $annulees }}</div>
                <div class="kpi-mini-label">Annulées</div>
            </div>
        </div>
    </div>

    <!-- Liste des consultations -->
    @if($consultations->count() > 0)
        <div class="consultation-list">
            @foreach($consultations as $consultation)
                <div class="consultation-card">
                    <!-- Heure -->
                    <div class="time-block">
                        <span class="time-value">{{ \Carbon\Carbon::parse($consultation->date_consultation)->format('H:i') }}</span>
                        <span class="time-label">RV</span>
                    </div>

                    <!-- Patient -->
                    <div class="patient-block">
                        <div class="patient-avatar">
                            {{ strtoupper(substr($consultation->patient->prenom, 0, 1)) }}
                        </div>
                        <div class="patient-info">
                            <div class="patient-name">{{ $consultation->patient->prenom }} {{ $consultation->patient->nom }}</div>
                            <span class="patient-code">{{ $consultation->patient->code }}</span>
                        </div>
                    </div>

                    <!-- Antécédents rapides -->
                    @if($consultation->patient->antecedents && count($consultation->patient->antecedents) > 0)
                        <div style="display:flex; gap:4px; flex-wrap:wrap; max-width:160px; flex-shrink:1;">
                            @foreach($consultation->patient->antecedents as $ant)
                                <span style="font-size:10px; font-weight:600; padding:3px 8px; border-radius:20px; background:#FFF0E6; color:#D4784C; white-space:nowrap;">
                                    {{ $ant }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Statut -->
                    <span class="status-badge {{ $consultation->rendezVous->statut == 'effectue' ? 'status-effectue' : ($consultation->rendezVous->statut == 'annule' ? 'status-annule' : 'status-en-attente') }}">
                        {{ ucfirst($consultation->rendezVous->statut) }}
                    </span>

                    <!-- Actions -->
                    <div class="actions-block">
                        <a href="{{ route('medecin.consultation.show', $consultation->id) }}" class="btn-action-card btn-gerer">
                            📝 Gérer
                        </a>
                        <a href="{{ route('medecin.patient.history', $consultation->patient->id) }}" class="btn-action-card btn-dossier">
                            📂 Dossier
                        </a>

                        @if(in_array($consultation->rendezVous->statut, ['en_attente', 'valide']))
                            <form method="POST" action="{{ route('medecin.consultation.cancel', $consultation->id) }}" onsubmit="return confirm('Annuler cette consultation ?');">
                                @csrf
                                <button type="submit" class="btn-action-card" style="background: rgba(231, 76, 60, 0.07); color: var(--med-red); border: 1px solid rgba(231, 76, 60, 0.2);">
                                    ✕ Annuler
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <!-- État vide -->
        <div class="empty-state">
            <div class="empty-state-icon">🩺</div>
            <h3>Aucune consultation aujourd'hui</h3>
            <p>Votre agenda est vide pour le moment.</p>
        </div>
    @endif
</div>
@endsection