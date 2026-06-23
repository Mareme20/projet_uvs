@extends('layouts.bootstrap')

@section('page_title', 'Statistiques du Jour')

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
        --med-green: #48BB78;
        --med-orange: #ED8936;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
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

    /* Barre de filtre */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        padding: 6px 6px 6px 16px;
        border-radius: 50px;
        border: 1px solid rgba(94, 168, 167, 0.2);
        box-shadow: 0 2px 12px rgba(26, 60, 74, 0.04);
    }

    .filter-bar input[type="date"] {
        border: none;
        outline: none;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        color: var(--med-dark);
        background: transparent;
        padding: 6px 0;
    }

    .btn-filter {
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        border: none;
        padding: 9px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(62, 130, 181, 0.35);
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .kpi-card {
        background: white;
        border-radius: 18px;
        padding: 22px 22px 18px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(26, 60, 74, 0.08);
    }

    .kpi-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
    }

    .kpi-blue::after { background: var(--med-blue); }
    .kpi-teal::after { background: var(--med-teal); }
    .kpi-green::after { background: var(--med-green); }
    .kpi-red::after { background: var(--med-red); }

    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .kpi-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .ki-blue { background: var(--med-mint); }
    .ki-teal { background: rgba(94, 168, 167, 0.12); }
    .ki-green { background: rgba(72, 187, 120, 0.1); }
    .ki-red { background: rgba(231, 76, 60, 0.07); }

    .kpi-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--med-dark);
        line-height: 1;
    }

    .kpi-label {
        font-size: 12px;
        color: #8AA0AD;
        font-weight: 500;
        margin-top: 4px;
    }

    /* Listes détaillées */
    .list-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .list-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        padding: 24px;
        box-shadow: 0 2px 12px rgba(26, 60, 74, 0.03);
    }

    .list-card h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0 0 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .list-card .badge-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 26px;
        background: var(--med-mint);
        color: var(--med-blue);
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        padding: 0 10px;
    }

    .list-card .chart-subtitle {
        font-size: 12px;
        color: #A0BCC8;
        font-weight: 500;
        margin-bottom: 18px;
    }

    .list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(94, 168, 167, 0.06);
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .av-blue { background: #E0ECF4; color: var(--med-blue); }
    .av-teal { background: rgba(94, 168, 167, 0.15); color: var(--med-teal); }
    .av-red { background: #FFECEC; color: var(--med-red); }

    .list-item-info {
        flex: 1;
        line-height: 1.3;
    }

    .list-item-name {
        font-weight: 600;
        font-size: 14px;
        color: var(--med-dark);
    }

    .list-item-detail {
        font-size: 12px;
        color: #8AA0AD;
        font-weight: 500;
    }

    .list-item-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .lb-blue { background: var(--med-mint); color: var(--med-blue); }
    .lb-teal { background: rgba(94, 168, 167, 0.1); color: var(--med-teal); }
    .lb-red { background: #FFECEC; color: var(--med-red); }

    .empty-list {
        text-align: center;
        padding: 30px;
        color: #B0C8D4;
        font-size: 14px;
        font-weight: 500;
    }

    @media (max-width: 1024px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .list-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .kpi-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; }
    }
</style>

@php
    $totalMedecins = $medecinsDisponibles->count();
    $totalPrestations = $prestationsDuJour->count();
    $totalConsultations = $consultationsDuJour->count();
    $totalAnnulations = $consultationsAnnulees->count();
@endphp

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-title-block">
            <div class="page-icon">📊</div>
            <div>
                <h1>Statistiques du Jour</h1>
                <span class="subtitle">Vue d'ensemble de l'activité de la clinique</span>
            </div>
        </div>

        <form action="{{ route('statistics.index') }}" method="GET" class="filter-bar">
            <input type="date" name="date" value="{{ $date }}">
            <button type="submit" class="btn-filter">Actualiser</button>
        </form>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid">
        <div class="kpi-card kpi-blue">
            <div class="kpi-header"><div class="kpi-icon ki-blue">🩺</div></div>
            <div class="kpi-value">{{ $totalMedecins }}</div>
            <div class="kpi-label">Médecins disponibles</div>
        </div>
        <div class="kpi-card kpi-teal">
            <div class="kpi-header"><div class="kpi-icon ki-teal">🔬</div></div>
            <div class="kpi-value">{{ $totalPrestations }}</div>
            <div class="kpi-label">Prestations du jour</div>
        </div>
        <div class="kpi-card kpi-green">
            <div class="kpi-header"><div class="kpi-icon ki-green">👨‍⚕️</div></div>
            <div class="kpi-value">{{ $totalConsultations }}</div>
            <div class="kpi-label">Consultations du jour</div>
        </div>
        <div class="kpi-card kpi-red">
            <div class="kpi-header"><div class="kpi-icon ki-red">✕</div></div>
            <div class="kpi-value">{{ $totalAnnulations }}</div>
            <div class="kpi-label">Annulations du jour</div>
        </div>
    </div>

    <!-- Listes détaillées (Grille 1) -->
    <div class="list-grid" style="margin-bottom: 24px;">
        <!-- Médecins disponibles -->
        <div class="list-card">
            <h3>🩺 Médecins Disponibles <span class="badge-count">{{ $totalMedecins }}</span></h3>
            <p class="chart-subtitle">Présents aujourd'hui</p>
            @if($medecinsDisponibles->count() > 0)
                @foreach($medecinsDisponibles as $med)
                    <div class="list-item">
                        <div class="list-item-avatar av-blue">
                            {{ strtoupper(substr($med->user->name, 0, 1)) }}
                        </div>
                        <div class="list-item-info">
                            <div class="list-item-name">Dr. {{ $med->user->name }}</div>
                            <div class="list-item-detail">{{ $med->specialite }} — <strong>{{ $med->rendezVouses->count() }} RDV</strong></div>
                        </div>
                        <span class="list-item-badge lb-blue">Disponible</span>
                    </div>
                @endforeach
            @else
                <div class="empty-list">Aucun médecin disponible</div>
            @endif
        </div>

        <!-- Consultations annulées -->
        <div class="list-card">
            <h3>✕ Consultations annulées <span class="badge-count">{{ $totalAnnulations }}</span></h3>
            <p class="chart-subtitle">Annulations du jour</p>
            @if($consultationsAnnulees->count() > 0)
                @foreach($consultationsAnnulees as $ann)
                    <div class="list-item">
                        <div class="list-item-avatar av-red">
                            {{ strtoupper(substr($ann->patient->prenom, 0, 1)) }}
                        </div>
                        <div class="list-item-info">
                            <div class="list-item-name">{{ $ann->patient->prenom }} {{ $ann->patient->nom }}</div>
                            <div class="list-item-detail">Dr. {{ $ann->medecin->user->name ?? 'N/A' }}</div>
                        </div>
                        <span class="list-item-badge lb-red">Annulée</span>
                    </div>
                @endforeach
            @else
                <div class="empty-list">Aucune annulation aujourd'hui</div>
            @endif
        </div>
    </div>

    <!-- Listes détaillées (Grille 2) -->
    <div class="list-grid">
        <!-- Consultations du jour -->
        <div class="list-card">
            <h3>👨‍⚕️ Consultations du Jour <span class="badge-count">{{ $totalConsultations }}</span></h3>
            <p class="chart-subtitle">Flux des consultations</p>
            @if($consultationsDuJour->count() > 0)
                @foreach($consultationsDuJour as $consult)
                    <div class="list-item">
                        <div class="list-item-avatar av-teal">
                            {{ strtoupper(substr($consult->patient->prenom, 0, 1)) }}
                        </div>
                        <div class="list-item-info">
                            <div class="list-item-name">{{ $consult->patient->prenom }} {{ $consult->patient->nom }}</div>
                            <div class="list-item-detail">Dr. {{ $consult->medecin->user->name ?? 'N/A' }} — <strong>{{ \Carbon\Carbon::parse($consult->date_consultation)->format('H:i') }}</strong></div>
                        </div>
                        <span class="list-item-badge lb-teal">En cours</span>
                    </div>
                @endforeach
            @else
                <div class="empty-list">Aucune consultation pour ce jour</div>
            @endif
        </div>

        <!-- Prestations du jour -->
        <div class="list-card">
            <h3>🔬 Prestations du Jour <span class="badge-count">{{ $totalPrestations }}</span></h3>
            <p class="chart-subtitle">Analyses et examens</p>
            @if($prestationsDuJour->count() > 0)
                @foreach($prestationsDuJour as $prest)
                    <div class="list-item">
                        <div class="list-item-avatar av-blue" style="background: rgba(59, 130, 181, 0.1);">
                            {{ strtoupper(substr($prest->patient->prenom, 0, 1)) }}
                        </div>
                        <div class="list-item-info">
                            <div class="list-item-name">{{ $prest->patient->prenom }} {{ $prest->patient->nom }}</div>
                            <div class="list-item-detail">{{ $prest->type }} — <strong>{{ \Carbon\Carbon::parse($prest->date_prestation)->format('H:i') }}</strong></div>
                        </div>
                        <span class="list-item-badge lb-blue">
                            {{ ucfirst($prest->statut) }}
                        </span>
                    </div>
                @endforeach
            @else
                <div class="empty-list">Aucune prestation pour ce jour</div>
            @endif
        </div>
    </div>
</div>
@endsection
