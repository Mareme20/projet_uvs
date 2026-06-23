@extends('layouts.bootstrap')

@section('page_title', 'Gestion des Prestations')

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
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
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

    /* Filtres */
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

    .filter-bar input[type="date"]:focus {
        color: var(--med-teal);
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

    .btn-reset {
        background: none;
        border: none;
        color: #A0BCC8;
        cursor: pointer;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        padding: 6px 10px;
        transition: color 0.2s;
    }

    .btn-reset:hover {
        color: var(--med-dark);
    }

    /* Stats rapides */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-mini {
        background: white;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        transition: all 0.3s;
    }

    .stat-mini:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26, 60, 74, 0.06);
    }

    .stat-mini-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .smi-blue { background: var(--med-mint); }
    .smi-teal { background: rgba(94, 168, 167, 0.12); }
    .smi-sand { background: var(--med-sand); }

    .stat-mini-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--med-dark);
        line-height: 1;
    }

    .stat-mini-label {
        font-size: 12px;
        color: #8AA0AD;
        font-weight: 500;
    }

    /* Table */
    .table-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(26, 60, 74, 0.04);
    }

    .table-card table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .table-card thead th {
        background: #FAFDFF;
        padding: 14px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #7A9AAA;
        border-bottom: 1px solid rgba(94, 168, 167, 0.12);
    }

    .table-card thead th:last-child {
        text-align: right;
    }

    .table-card tbody tr {
        transition: all 0.3s;
        border-bottom: 1px solid rgba(94, 168, 167, 0.06);
    }

    .table-card tbody tr:last-child {
        border-bottom: none;
    }

    .table-card tbody tr:hover {
        background: #FAFDFF;
    }

    .table-card tbody td {
        padding: 16px 20px;
        color: var(--med-dark);
        vertical-align: middle;
    }

    .table-card tbody td:last-child {
        text-align: right;
    }

    /* Cellules stylisées */
    .cell-date {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-icon {
        width: 38px;
        height: 38px;
        background: var(--med-mint);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .date-text {
        font-weight: 600;
        font-size: 13px;
    }

    .date-time {
        font-size: 11px;
        color: #8AA0AD;
        font-weight: 500;
    }

    .cell-patient {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .patient-avatar {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #E0ECF4 0%, #D5EAF0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: var(--med-blue);
        flex-shrink: 0;
    }

    .patient-name {
        font-weight: 600;
        color: var(--med-dark);
    }

    .cell-type {
        font-weight: 500;
        color: var(--med-dark);
    }

    /* Badges statut */
    .badge-statut {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .badge-en-attente {
        background: #FFF8E6;
        color: #B8942E;
    }

    .badge-en-attente::before {
        content: '';
        width: 7px;
        height: 7px;
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
        width: 7px;
        height: 7px;
        background: #3DA87A;
        border-radius: 50%;
    }

    .badge-annule {
        background: #FFF0F0;
        color: #C94A5F;
    }

    .badge-annule::before {
        content: '';
        width: 7px;
        height: 7px;
        background: #D95555;
        border-radius: 50%;
    }

    /* Bouton action */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        background: rgba(94, 168, 167, 0.08);
        color: var(--med-teal);
        border: 1px solid rgba(94, 168, 167, 0.2);
        transition: all 0.3s;
    }

    .btn-action:hover {
        background: rgba(94, 168, 167, 0.16);
        border-color: var(--med-teal);
        transform: translateY(-1px);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 14px;
        opacity: 0.6;
    }

    .empty-state p {
        color: #A0BCC8;
        font-size: 15px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quick-stats {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .table-card table,
        .table-card thead,
        .table-card tbody,
        .table-card th,
        .table-card td,
        .table-card tr {
            display: block;
        }

        .table-card thead {
            display: none;
        }

        .table-card tbody tr {
            padding: 16px;
            border-bottom: 1px solid rgba(94, 168, 167, 0.1);
        }

        .table-card tbody td {
            padding: 6px 0;
            text-align: left !important;
        }

        .table-card tbody td:last-child {
            margin-top: 8px;
        }

        .table-card tbody td::before {
            content: attr(data-label);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #A0BCC8;
            display: block;
            margin-bottom: 2px;
        }
    }
</style>

@php
    $totalPrestations = $prestations->count();
    $effectuees = $prestations->where('statut', 'effectue')->count();
    $enAttente = $prestations->where('statut', 'en_attente')->count();
@endphp

<div>
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-title-block">
            <div class="page-icon">🔬</div>
            <div>
                <h1>Liste des Prestations</h1>
                <span class="subtitle">Gestion des analyses, radios et examens</span>
            </div>
        </div>

        <form action="{{ route('responsable.dashboard') }}" method="GET" class="filter-bar">
            <input type="date" name="date" value="{{ request('date') }}" placeholder="Filtrer par date">
            <button type="submit" class="btn-filter">Filtrer</button>
            @if(request('date'))
                <a href="{{ route('responsable.dashboard') }}" class="btn-reset">✕ Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Mini stats -->
    <div class="quick-stats">
        <div class="stat-mini">
            <div class="stat-mini-icon smi-blue">📋</div>
            <div>
                <div class="stat-mini-value">{{ $totalPrestations }}</div>
                <div class="stat-mini-label">Total prestations</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon smi-teal">✅</div>
            <div>
                <div class="stat-mini-value">{{ $effectuees }}</div>
                <div class="stat-mini-label">Effectuées</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon smi-sand">⏳</div>
            <div>
                <div class="stat-mini-value">{{ $enAttente }}</div>
                <div class="stat-mini-label">En attente</div>
            </div>
        </div>
    </div>

    <!-- Tableau -->
    <div class="table-card">
        @if($prestations->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Patient</th>
                        <th>Type de Prestation</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestations as $prestation)
                        <tr>
                            <td data-label="Date & Heure">
                                <div class="cell-date">
                                    <div class="date-icon">📅</div>
                                    <div>
                                        <div class="date-text">{{ \Carbon\Carbon::parse($prestation->date_prestation)->format('d/m/Y') }}</div>
                                        <div class="date-time">{{ \Carbon\Carbon::parse($prestation->date_prestation)->format('H:i') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Patient">
                                <div class="cell-patient">
                                    <div class="patient-avatar">
                                        {{ strtoupper(substr($prestation->patient->prenom, 0, 1)) }}
                                    </div>
                                    <span class="patient-name">{{ $prestation->patient->prenom }} {{ $prestation->patient->nom }}</span>
                                </div>
                            </td>
                            <td data-label="Type" class="cell-type">
                                {{ $prestation->type }}
                            </td>
                            <td data-label="Statut">
                                @if($prestation->statut == 'effectue')
                                    <span class="badge-statut badge-effectue">Effectuée</span>
                                @elseif($prestation->statut == 'annule')
                                    <span class="badge-statut badge-annule">Annulée</span>
                                @else
                                    <span class="badge-statut badge-en-attente">En attente</span>
                                @endif
                            </td>
                            <td data-label="Actions">
                                <a href="{{ route('responsable.prestation.show', $prestation->id) }}" class="btn-action">
                                    🔬 Gérer / Résultats
                                </a>

                                @if(in_array($prestation->statut, ['en_attente','valide']))
                                    <form method="POST" action="{{ route('responsable.prestation.cancel', $prestation->id) }}" style="display:inline-block; margin-left:8px;" onsubmit="return confirm('Annuler cette prestation ?');">
                                        @csrf
                                        <button type="submit" class="btn-action" style="background: rgba(231, 76, 60, 0.07); color: var(--med-dark); border: 1px solid rgba(231, 76, 60, 0.2);">
                                            ✕ Annuler
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
           
           
           
           
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🔬</div>
                <p>Aucune prestation trouvée</p>
            </div>
        @endif
    </div>
</div>
@endsection