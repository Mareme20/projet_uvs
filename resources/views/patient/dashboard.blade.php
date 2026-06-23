@extends('layouts.bootstrap')

@section('page_title', 'Mon Tableau de Bord Patient')

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

    @keyframes cardPop {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes pulseDot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
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

    .btn-new-rv {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(62, 130, 181, 0.3);
        transition: all 0.3s;
    }

    .btn-new-rv:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(62, 130, 181, 0.4);
        color: white;
    }

    /* KPI */
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
    .km-red { background: rgba(231, 76, 60, 0.07); }

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

    /* Filtres */
    .filter-tabs {
        display: flex;
        gap: 6px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid rgba(94, 168, 167, 0.2);
        background: white;
        color: #7A9AAA;
        transition: all 0.3s;
        text-decoration: none;
    }

    .filter-tab:hover {
        border-color: var(--med-teal);
        color: var(--med-teal);
    }

    .filter-tab.active {
        background: var(--med-teal);
        color: white;
        border-color: var(--med-teal);
    }

    .filter-tab .count {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        margin-left: 4px;
    }

    .filter-tab.active .count {
        background: rgba(255,255,255,0.3);
    }

    /* Liste */
    .rv-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .rv-card {
        background: white;
        border-radius: 18px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        padding: 20px 24px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 20px;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(26, 60, 74, 0.02);
        animation: cardPop 0.4s ease-out;
        animation-fill-mode: both;
    }

    .rv-card:nth-child(1) { animation-delay: 0s; }
    .rv-card:nth-child(2) { animation-delay: 0.04s; }
    .rv-card:nth-child(3) { animation-delay: 0.08s; }
    .rv-card:nth-child(4) { animation-delay: 0.12s; }
    .rv-card:nth-child(5) { animation-delay: 0.16s; }

    .rv-card:hover {
        border-color: rgba(94, 168, 167, 0.25);
        box-shadow: 0 8px 28px rgba(26, 60, 74, 0.06);
        transform: translateY(-2px);
    }

    .rv-card.cancelled {
        opacity: 0.65;
        background: #FAFAFA;
    }

    /* Date */
    .rv-date-block {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 75px;
        padding: 12px 16px;
        background: var(--med-mint);
        border-radius: 14px;
        flex-shrink: 0;
        text-align: center;
    }

    .rv-date-day {
        font-size: 22px;
        font-weight: 700;
        color: var(--med-dark);
        line-height: 1;
    }

    .rv-date-month {
        font-size: 11px;
        font-weight: 600;
        color: var(--med-blue);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rv-date-time {
        font-size: 11px;
        color: #8AA0AD;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Infos */
    .rv-info {
        flex: 1;
        min-width: 200px;
    }

    .rv-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 6px;
    }

    .type-consultation { background: rgba(59, 130, 181, 0.1); color: var(--med-blue); }
    .type-prestation { background: rgba(94, 168, 167, 0.1); color: var(--med-teal); }

    .rv-detail {
        font-weight: 600;
        font-size: 15px;
        color: var(--med-dark);
    }

    /* Statut */
    .rv-status {
        flex-shrink: 0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
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

    .status-valide {
        background: rgba(72, 187, 120, 0.1);
        color: var(--med-green);
    }
    .status-valide::before {
        content: '';
        width: 7px;
        height: 7px;
        background: var(--med-green);
        border-radius: 50%;
    }

    .status-effectue {
        background: rgba(59, 130, 181, 0.1);
        color: var(--med-blue);
    }
    .status-effectue::before {
        content: '';
        width: 7px;
        height: 7px;
        background: var(--med-blue);
        border-radius: 50%;
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

    /* Boutons */
    .btn-action-small {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 16px;
        background: white;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-cancel-rv {
        color: var(--med-red);
        border: 1px solid #FFD5D5;
    }
    .btn-cancel-rv:hover { background: #FFF5F5; border-color: var(--med-red); }

    .btn-details {
        color: var(--med-blue);
        border: 1px solid rgba(59, 130, 181, 0.2);
    }
    .btn-details:hover { background: var(--med-mint); border-color: var(--med-blue); }

    .btn-print-action {
        color: var(--med-teal);
        border: 1px solid rgba(94, 168, 167, 0.2);
    }
    .btn-print-action:hover { background: rgba(94, 168, 167, 0.05); border-color: var(--med-teal); }

    /* Results section */
    .results-section {
        width: 100%;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed rgba(94, 168, 167, 0.2);
        display: none;
    }

    .results-section.show {
        display: block;
    }

    .result-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .result-block h4 {
        font-size: 13px;
        font-weight: 700;
        color: var(--med-dark);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .result-content {
        background: var(--med-sand);
        padding: 12px 15px;
        border-radius: 12px;
        font-size: 14px;
        color: var(--med-dark);
        line-height: 1.5;
    }

    .constantes-list {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .constante-item {
        background: white;
        padding: 4px 12px;
        border-radius: 8px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        font-size: 12px;
    }

    .constante-item strong { color: var(--med-teal); }

    .prescription-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .prescription-item {
        padding: 8px 0;
        border-bottom: 1px solid rgba(94, 168, 167, 0.05);
    }

    .prescription-item:last-child { border-bottom: none; }

    .med-name { font-weight: 600; color: var(--med-blue); }
    .med-poso { font-size: 12px; color: #7A9AAA; display: block; }

    /* Empty */
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
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #A0BCC8;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* Can cancel indicator */
    .can-cancel {
        font-size: 10px;
        color: #B0C8D4;
        margin-top: 4px;
        text-align: center;
    }

    @media (max-width: 900px) {
        .kpi-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .rv-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .rv-date-block {
            flex-direction: row;
            gap: 8px;
            min-width: auto;
            width: 100%;
            justify-content: center;
        }

        .rv-status {
            width: 100%;
            text-align: center;
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

        .btn-new-rv {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@php
    $totalRdv = $appointments->count();
    $enAttente = $appointments->where('statut', 'en_attente')->count();
    $valides = $appointments->where('statut', 'valide')->count();
    $annules = $appointments->where('statut', 'annule')->count();
@endphp

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-title-block">
            <div class="page-icon">📋</div>
            <div>
                <h1>Mes Rendez-vous</h1>
                <span class="subtitle">Gérez vos consultations et prestations</span>
            </div>
        </div>
        <a href="{{ route('patient.rv.create') }}" class="btn-new-rv">
            ＋ Nouveau Rendez-vous
        </a>
    </div>

    <!-- KPI -->
    <div class="kpi-row">
        <div class="kpi-mini">
            <div class="kpi-mini-icon km-blue">📋</div>
            <div>
                <div class="kpi-mini-value">{{ $totalRdv }}</div>
                <div class="kpi-mini-label">Total RDV</div>
            </div>
        </div>
        <div class="kpi-mini">
            <div class="kpi-mini-icon km-green">✅</div>
            <div>
                <div class="kpi-mini-value">{{ $valides }}</div>
                <div class="kpi-mini-label">Confirmés</div>
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
            <div class="kpi-mini-icon km-red">✕</div>
            <div>
                <div class="kpi-mini-value">{{ $annules }}</div>
                <div class="kpi-mini-label">Annulés</div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filter-tabs">
        <a href="{{ route('patient.dashboard') }}" class="filter-tab {{ !request('statut') ? 'active' : '' }}">
            Tous <span class="count">{{ $totalRdv }}</span>
        </a>
        <a href="{{ route('patient.dashboard', ['statut' => 'en_attente']) }}" class="filter-tab {{ request('statut') == 'en_attente' ? 'active' : '' }}">
            En attente <span class="count">{{ $enAttente }}</span>
        </a>
        <a href="{{ route('patient.dashboard', ['statut' => 'valide']) }}" class="filter-tab {{ request('statut') == 'valide' ? 'active' : '' }}">
            Confirmés <span class="count">{{ $valides }}</span>
        </a>
        <a href="{{ route('patient.dashboard', ['statut' => 'annule']) }}" class="filter-tab {{ request('statut') == 'annule' ? 'active' : '' }}">
            Annulés <span class="count">{{ $annules }}</span>
        </a>
    </div>

    <!-- Liste -->
    @if($appointments->count() > 0)
        <div class="rv-list">
            @foreach($appointments as $rv)
                <div class="rv-card {{ $rv->statut == 'annule' ? 'cancelled' : '' }}">
                    <!-- Date -->
                    <div class="rv-date-block">
                        <span class="rv-date-day">{{ \Carbon\Carbon::parse($rv->date_rv)->format('d') }}</span>
                        <span class="rv-date-month">{{ \Carbon\Carbon::parse($rv->date_rv)->locale('fr')->monthName }}</span>
                        <span class="rv-date-time">{{ \Carbon\Carbon::parse($rv->date_rv)->format('H:i') }}</span>
                    </div>

                    <!-- Infos -->
                    <div class="rv-info">
                        <span class="rv-type-badge {{ $rv->type == 'consultation' ? 'type-consultation' : 'type-prestation' }}">
                            @if($rv->type == 'consultation') 🩺 @else 🔬 @endif
                            {{ ucfirst($rv->type) }}
                        </span>
                        <div class="rv-detail">
                            @if($rv->type == 'consultation')
                                Dr. {{ $rv->medecin->user->name ?? 'N/A' }}
                            @else
                                {{ $rv->prestation_type ?? 'N/A' }}
                            @endif
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="rv-status">
                        <span class="status-badge 
                            {{ $rv->statut == 'en_attente' ? 'status-en-attente' : '' }}
                            {{ $rv->statut == 'valide' ? 'status-valide' : '' }}
                            {{ $rv->statut == 'effectue' ? 'status-effectue' : '' }}
                            {{ $rv->statut == 'annule' ? 'status-annule' : '' }}
                        ">
                            {{ ucfirst($rv->statut) }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div style="display:flex; gap:8px; align-items:center;">
                        {{-- Voir détails pour RDV effectués --}}
                        @if($rv->statut == 'effectue')
                            <button type="button" class="btn-action-small btn-details" onclick="toggleResults('results-{{ $rv->id }}')">
                                👁️ Détails
                            </button>
                            
                            {{-- Bouton impression --}}
                            @if($rv->type == 'consultation' && $rv->consultation)
                                <a href="{{ route('patient.consultation.print', $rv->consultation->id) }}" class="btn-action-small btn-print-action" target="_blank">
                                    🖨️ Imprimer
                                </a>
                            @elseif($rv->type == 'prestation' && $rv->prestation)
                                <a href="{{ route('patient.prestation.print', $rv->prestation->id) }}" class="btn-action-small btn-print-action" target="_blank">
                                    🖨️ Imprimer
                                </a>
                            @endif
                        @endif

                        {{-- Action annuler --}}
                        @if($rv->statut != 'annule' && $rv->statut != 'effectue')
                            @php
                                $dateRv = \Carbon\Carbon::parse($rv->date_rv);
                                $now = \Carbon\Carbon::now();
                                $hoursUntil = $now->diffInHours($dateRv, false);
                                $canCancel = $hoursUntil >= 48;
                            @endphp
                            <div style="text-align:center;">
                                @if($canCancel)
                                    <form action="{{ route('patient.rv.cancel', $rv->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-small btn-cancel-rv" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')">
                                            ✕ Annuler
                                        </button>
                                    </form>
                                    <div class="can-cancel">Annulation possible</div>
                                @else
                                    <span style="font-size:11px; color:#B0C8D4; font-weight:500;">
                                        🔒 Moins de 48h
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Section résultats (cachée par défaut) --}}
                    @if($rv->statut == 'effectue')
                        <div id="results-{{ $rv->id }}" class="results-section">
                            <div class="result-grid">
                                @if($rv->type == 'consultation' && $rv->consultation)
                                    <!-- Constantes -->
                                    <div class="result-block">
                                        <h4>🩺 Constantes prises</h4>
                                        <div class="constantes-list">
                                            @if($rv->consultation->constantes)
                                                @foreach($rv->consultation->constantes as $key => $val)
                                                    <span class="constante-item">
                                                        <strong>{{ ucfirst($key) }}:</strong> {{ $val }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <p class="text-muted">Non renseignées</p>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Ordonnance -->
                                    <div class="result-block">
                                        <h4>💊 Ordonnance</h4>
                                        <div class="result-content">
                                            @if($rv->consultation->ordonnance && $rv->consultation->ordonnance->medicaments->count() > 0)
                                                <ul class="prescription-list">
                                                    @foreach($rv->consultation->ordonnance->medicaments as $med)
                                                        <li class="prescription-item">
                                                            <span class="med-name">{{ $med->nom }} ({{ $med->code }})</span>
                                                            <span class="med-poso">{{ $med->pivot->posologie }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">Aucun médicament prescrit</p>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($rv->type == 'prestation' && $rv->prestation)
                                    <!-- Résultats prestation -->
                                    <div class="result-block" style="grid-column: 1 / -1;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                            <h4>🔬 Résultats de l'examen</h4>
                                            @if($rv->prestation->fichier_resultat)
                                                <a href="{{ asset('storage/' . $rv->prestation->fichier_resultat) }}" target="_blank" class="btn-action-small btn-print-action">
                                                    📥 Télécharger le document
                                                </a>
                                            @endif
                                        </div>
                                        <div class="result-content" style="white-space: pre-line;">
                                            {{ $rv->prestation->resultats ?? 'En attente de rédaction...' }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📅</div>
            <h3>Aucun rendez-vous</h3>
            <p>Vous n'avez pas encore de rendez-vous. Prenez votre premier rendez-vous dès maintenant !</p>
            <a href="{{ route('patient.rv.create') }}" class="btn-new-rv" style="display:inline-flex;">
                ＋ Prendre un rendez-vous
            </a>
        </div>
    @endif
</div>

<script>
    function toggleResults(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.toggle('show');
            const btn = event.target;
            if (el.classList.contains('show')) {
                btn.innerHTML = '📂 Masquer';
            } else {
                btn.innerHTML = '👁️ Détails';
            }
        }
    }
</script>
@endsection
