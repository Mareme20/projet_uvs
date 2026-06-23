@extends('layouts.bootstrap')

@section('page_title', 'Gestion des Rendez-vous')

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

    @keyframes pulseDot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.3); }
    }

    @keyframes validatePop {
        0% { transform: scale(0.95); }
        50% { transform: scale(1.03); }
        100% { transform: scale(1); }
    }

    @keyframes cardPop {
        from { opacity: 0; transform: scale(0.96); }
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

    /* Badge compteur */
    .pending-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #FFF8E6;
        color: #B8942E;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        border: 1px solid rgba(184, 148, 46, 0.15);
    }

    .pending-count .dot {
        width: 9px;
        height: 9px;
        background: #D4A830;
        border-radius: 50%;
        animation: pulseDot 1.5s ease-in-out infinite;
    }

    /* Liste des demandes */
    .rv-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .rv-card {
        background: white;
        border-radius: 18px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        padding: 22px 26px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px rgba(26, 60, 74, 0.03);
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
        box-shadow: 0 8px 28px rgba(26, 60, 74, 0.07);
        transform: translateY(-1px);
    }

    /* Patient */
    .rv-patient {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 200px;
        flex-shrink: 0;
    }

    .patient-avatar {
        width: 46px;
        height: 46px;
        background: linear-gradient(135deg, #E0ECF4 0%, #D5EAF0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 17px;
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

    /* Infos RV */
    .rv-details {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
        flex-wrap: wrap;
    }

    .rv-detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--med-dark);
    }

    .rv-detail-icon {
        width: 36px;
        height: 36px;
        background: var(--med-mint);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .rv-detail-text {
        font-weight: 500;
    }

    .rv-detail-sub {
        font-size: 11px;
        color: #8AA0AD;
        font-weight: 500;
    }

    /* Type badge */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .type-consultation {
        background: rgba(59, 130, 181, 0.1);
        color: var(--med-blue);
    }

    .type-prestation {
        background: rgba(94, 168, 167, 0.1);
        color: var(--med-teal);
    }

    /* Statut badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-en-attente { background: #FFF8E6; color: #B8942E; }
    .status-valide { background: rgba(72, 187, 120, 0.1); color: var(--med-green); }
    .status-annule { background: rgba(231, 76, 60, 0.07); color: var(--med-red); }
    .status-effectue { background: rgba(59, 130, 181, 0.1); color: var(--med-blue); }

    /* Boutons d'action */
    .actions-group {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1.2);
        white-space: nowrap;
        text-decoration: none;
    }

    .btn-validate {
        background: linear-gradient(135deg, #48BB78 0%, #38A169 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
    }

    .btn-validate:hover {
        transform: scale(1.04);
        box-shadow: 0 8px 22px rgba(72, 187, 120, 0.4);
    }

    .btn-cancel-rv {
        background: white;
        color: var(--med-red);
        border: 1px solid #FFD5D5;
    }

    .btn-cancel-rv:hover {
        background: #FFF5F5;
        border-color: var(--med-red);
        transform: scale(1.02);
    }

    .btn-complete {
        background: rgba(59, 130, 181, 0.08);
        color: var(--med-blue);
        border: 1px solid rgba(59, 130, 181, 0.2);
    }

    .btn-complete:hover {
        background: rgba(59, 130, 181, 0.15);
        border-color: var(--med-blue);
        transform: scale(1.02);
    }

    /* Modal de confirmation */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(26, 60, 74, 0.5);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-dialog {
        background: white;
        border-radius: 20px;
        padding: 32px 28px;
        max-width: 420px;
        width: 90%;
        text-align: center;
        box-shadow: 0 30px 60px rgba(26, 60, 74, 0.2);
        animation: fadeUp 0.3s ease-out;
    }

    .modal-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .modal-dialog h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--med-dark);
        margin-bottom: 8px;
    }

    .modal-dialog p {
        font-size: 14px;
        color: #7A9AAA;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-modal-cancel {
        padding: 11px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        background: #F5F8FA;
        color: #7A9AAA;
        border: 1px solid rgba(94, 168, 167, 0.2);
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-modal-cancel:hover {
        background: #EEE;
    }

    .btn-modal-confirm {
        padding: 11px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-modal-danger {
        background: var(--med-red);
        color: white;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .btn-modal-danger:hover {
        box-shadow: 0 8px 22px rgba(231, 76, 60, 0.4);
        transform: scale(1.02);
    }

    .btn-modal-primary {
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(62, 130, 181, 0.3);
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
        .rv-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .rv-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .rv-patient {
            min-width: auto;
        }

        .actions-group {
            width: 100%;
        }

        .btn-action {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-title-block">
            <div class="page-icon">✅</div>
            <div>
                <h1>Gestion des Rendez-vous</h1>
                <span class="subtitle">Validation et suivi des demandes</span>
            </div>
        </div>

        <!-- Compteur -->
        <div class="pending-count">
            <span class="dot"></span>
            {{ $counts['en_attente'] }} demande{{ $counts['en_attente'] !== 1 ? 's' : '' }} en attente
        </div>
    </div>

    <!-- Filtres -->
    <div class="filter-tabs">
        <a href="{{ route('secretaire.dashboard') }}" class="filter-tab {{ !request('statut') || request('statut') == 'en_attente' ? 'active' : '' }}">
            En attente <span class="count">{{ $counts['en_attente'] }}</span>
        </a>
        <a href="{{ route('secretaire.dashboard', ['statut' => 'valide']) }}" class="filter-tab {{ request('statut') == 'valide' ? 'active' : '' }}">
            Validés <span class="count">{{ $counts['valide'] }}</span>
        </a>
        <a href="{{ route('secretaire.dashboard', ['statut' => 'effectue']) }}" class="filter-tab {{ request('statut') == 'effectue' ? 'active' : '' }}">
            Effectués <span class="count">{{ $counts['effectue'] }}</span>
        </a>
        <a href="{{ route('secretaire.dashboard', ['statut' => 'annule']) }}" class="filter-tab {{ request('statut') == 'annule' ? 'active' : '' }}">
            Annulés <span class="count">{{ $counts['annule'] }}</span>
        </a>
    </div>

    <!-- Liste -->
    @if($pendingRVs->count() > 0)
        <div class="rv-list">
            @foreach($pendingRVs as $rv)
                <div class="rv-card">
                    <!-- Patient -->
                    <div class="rv-patient">
                        <div class="patient-avatar">
                            {{ strtoupper(substr($rv->patient->prenom, 0, 1)) }}
                        </div>
                        <div class="patient-info">
                            <div class="patient-name">{{ $rv->patient->prenom }} {{ $rv->patient->nom }}</div>
                            <span class="patient-code">{{ $rv->patient->code }}</span>
                        </div>
                    </div>

                    <!-- Détails -->
                    <div class="rv-details">
                        <!-- Date -->
                        <div class="rv-detail-item">
                            <div class="rv-detail-icon">📅</div>
                            <div>
                                <div class="rv-detail-text">{{ \Carbon\Carbon::parse($rv->date_rv)->format('d/m/Y') }}</div>
                                <div class="rv-detail-sub">{{ \Carbon\Carbon::parse($rv->date_rv)->format('H:i') }}</div>
                            </div>
                        </div>

                        <!-- Type -->
                        <div class="rv-detail-item">
                            <div class="rv-detail-icon">
                                @if($rv->type == 'consultation') 🩺 @else 🔬 @endif
                            </div>
                            <div>
                                <span class="type-badge {{ $rv->type == 'consultation' ? 'type-consultation' : 'type-prestation' }}">
                                    {{ ucfirst($rv->type) }}
                                </span>
                            </div>
                        </div>

                        <!-- Détail supplémentaire -->
                        <div class="rv-detail-item">
                            <div class="rv-detail-icon">👤</div>
                            <div>
                                <div class="rv-detail-text">
                                    @if($rv->type == 'consultation')
                                        Dr. {{ $rv->medecin->user->name ?? 'N/A' }}
                                    @else
                                        {{ $rv->prestation_type }}
                                    @endif
                                </div>
                                <div class="rv-detail-sub">
                                    @if($rv->type == 'consultation') Médecin @else Prestation @endif
                                </div>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="rv-detail-item">
                            <span class="status-badge status-{{ $rv->statut }}">
                                {{ ucfirst($rv->statut) }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="actions-group">
                        {{-- Valider (seulement si en_attente) --}}
                        @if($rv->statut === 'en_attente')
                            <form action="{{ route('secretaire.rv.validate', $rv->id) }}" method="POST" style="display:contents;">
                                @csrf
                                <button type="submit" class="btn-action btn-validate">
                                    ✅ Valider
                                </button>
                            </form>
                        @endif

                        {{-- Terminer (seulement si valide) --}}
                        @if($rv->statut === 'valide')
                            <form action="{{ route('secretaire.rv.complete', $rv->id) }}" method="POST" style="display:contents;">
                                @csrf
                                <button type="submit" class="btn-action btn-complete" onclick="return confirm('Marquer ce rendez-vous comme effectué ?')">
                                    ✔️ Terminer
                                </button>
                            </form>
                        @endif

                        {{-- Annuler (si en_attente ou valide) --}}
                        @if(in_array($rv->statut, ['en_attente', 'valide']))
                            <form action="{{ route('secretaire.rv.cancel', $rv->id) }}" method="POST" style="display:contents;">
                                @csrf
                                <button type="submit" class="btn-action btn-cancel-rv" onclick="return confirm('Annuler ce rendez-vous ? Cette action est irréversible.')">
                                    ✕ Annuler
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                @if(request('statut') == 'valide') ✅
                @elseif(request('statut') == 'effectue') ✔️
                @elseif(request('statut') == 'annule') ✕
                @else 🎉 @endif
            </div>
            <h3>Aucun rendez-vous</h3>
            <p>
                @if(request('statut') == 'valide') Aucun rendez-vous validé pour le moment.
                @elseif(request('statut') == 'effectue') Aucun rendez-vous effectué pour le moment.
                @elseif(request('statut') == 'annule') Aucun rendez-vous annulé pour le moment.
                @else Tous les rendez-vous sont traités pour le moment. @endif
            </p>
        </div>
    @endif
</div>

@endsection
