@extends('layouts.bootstrap')

@section('page_title', 'Dossier Médical')

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
        --med-orange: #ED8936;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .page-container {
        animation: fadeUp 0.5s ease-out;
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

    /* Bannière patient */
    .patient-hero {
        background: white;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        margin-bottom: 28px;
        box-shadow: 0 4px 20px rgba(26, 60, 74, 0.04);
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
    }

    .patient-hero-avatar {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #3B82B5 0%, #5EA8A7 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 28px;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 10px 30px rgba(62, 130, 181, 0.3);
    }

    .patient-hero-info {
        flex: 1;
        line-height: 1.3;
    }

    .patient-hero-name {
        font-size: 24px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0;
    }

    .patient-hero-code {
        font-size: 13px;
        color: #A0BCC8;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #F5F8FA;
        padding: 4px 12px;
        border-radius: 20px;
        margin-top: 6px;
    }

    .patient-hero-stats {
        display: flex;
        gap: 20px;
        text-align: center;
    }

    .hero-stat {
        background: #FAFDFF;
        border-radius: 16px;
        padding: 14px 20px;
        border: 1px solid rgba(94, 168, 167, 0.08);
    }

    .hero-stat-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--med-dark);
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 11px;
        color: #8AA0AD;
        font-weight: 500;
        margin-top: 3px;
    }

    /* Antécédents */
    .antecedents-section {
        margin-bottom: 28px;
    }

    .antecedents-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #7A9AAA;
        margin-bottom: 10px;
    }

    .antecedents-tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .ant-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
    }

    .ant-diabete { background: #FFF0E6; color: #D4784C; }
    .ant-hypertension { background: #FFE8EC; color: #C94A5F; }
    .ant-hepatite { background: #FFF8E0; color: #B8942E; }
    .ant-none { background: #F5F8FA; color: #A0BCC8; }

    /* Grille */
    .history-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .history-column {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .column-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(94, 168, 167, 0.12);
    }

    .column-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .ci-blue { background: var(--med-mint); }
    .ci-teal { background: rgba(94, 168, 167, 0.1); }

    .column-header h2 {
        font-size: 17px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0;
    }

    .column-count {
        margin-left: auto;
        background: #F5F8FA;
        color: #8AA0AD;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 28px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: rgba(94, 168, 167, 0.15);
        border-radius: 1px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 22px;
        animation: fadeUp 0.4s ease-out;
    }

    .timeline-dot {
        position: absolute;
        left: -23px;
        top: 14px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 3px solid white;
        z-index: 1;
    }

    .dot-consult { background: var(--med-blue); }
    .dot-prestation { background: var(--med-teal); }

    .timeline-card {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        padding: 18px 20px;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(26, 60, 74, 0.02);
    }

    .timeline-card:hover {
        border-color: rgba(94, 168, 167, 0.25);
        box-shadow: 0 6px 20px rgba(26, 60, 74, 0.05);
        transform: translateX(4px);
    }

    .timeline-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .timeline-date {
        font-weight: 600;
        font-size: 13px;
        color: var(--med-dark);
    }

    .timeline-type {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .type-consult { background: var(--med-mint); color: var(--med-blue); }
    .type-prest { background: rgba(94, 168, 167, 0.1); color: var(--med-teal); }

    .timeline-constantes {
        display: flex;
        gap: 8px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .constante-badge {
        font-size: 11px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        background: #F5F8FA;
        color: #5A7A8A;
        border: 1px solid rgba(94, 168, 167, 0.1);
    }

    .ordonnance-block {
        margin-top: 10px;
        padding: 12px 14px;
        background: #FAFDFF;
        border-radius: 12px;
        border: 1px solid rgba(94, 168, 167, 0.08);
    }

    .ordonnance-title {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #A0BCC8;
        margin-bottom: 8px;
    }

    .ordonnance-med {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 0;
        font-size: 13px;
        color: var(--med-dark);
    }

    .ordonnance-med-dot {
        width: 6px;
        height: 6px;
        background: var(--med-teal);
        border-radius: 50%;
        flex-shrink: 0;
    }

    .ordonnance-posologie {
        font-size: 11px;
        color: #8AA0AD;
        font-style: italic;
        margin-left: 4px;
    }

    .resultats-block {
        margin-top: 8px;
        padding: 12px 14px;
        background: #FAFDFF;
        border-radius: 12px;
        border: 1px solid rgba(94, 168, 167, 0.08);
        font-size: 13px;
        color: var(--med-dark);
        line-height: 1.6;
    }

    .resultats-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #A0BCC8;
        margin-bottom: 6px;
    }

    .resultats-pending {
        color: #B0C8D4;
        font-style: italic;
        font-size: 12px;
    }

    /* Empty state */
    .empty-timeline {
        text-align: center;
        padding: 40px 20px;
        color: #B0C8D4;
        font-size: 14px;
        font-weight: 500;
    }

    .empty-timeline-icon {
        font-size: 36px;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .history-grid {
            grid-template-columns: 1fr;
        }

        .patient-hero {
            flex-direction: column;
            text-align: center;
        }

        .patient-hero-stats {
            width: 100%;
            justify-content: center;
        }

        .hero-stat {
            flex: 1;
        }
    }
</style>

@php
    $consultations = $patient->consultations ?? collect();
    $prestations = $patient->prestations ?? collect();
    $antecedents = $patient->antecedents ?? [];
    $totalConsultations = $consultations->count();
    $totalPrestations = $prestations->count();
@endphp

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-icon">📂</div>
        <div>
            <h1>Dossier Médical</h1>
            <span class="subtitle">Historique complet du patient</span>
        </div>
    </div>

    <!-- Bannière patient -->
    <div class="patient-hero">
        <div class="patient-hero-avatar">
            {{ strtoupper(substr($patient->prenom, 0, 1)) }}
        </div>
        <div class="patient-hero-info">
            <h2 class="patient-hero-name">{{ $patient->prenom }} {{ $patient->nom }}</h2>
            <span class="patient-hero-code">
                🔢 {{ $patient->code }}
            </span>
        </div>
        <div class="patient-hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $totalConsultations }}</div>
                <div class="hero-stat-label">Consultations</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $totalPrestations }}</div>
                <div class="hero-stat-label">Prestations</div>
            </div>
        </div>
    </div>

    <!-- Antécédents -->
    <div class="antecedents-section">
        <div class="antecedents-title">Antécédents médicaux</div>
        <div class="antecedents-tags">
            @if($antecedents && count($antecedents) > 0)
                @foreach($antecedents as $ant)
                    <span class="ant-tag 
                        {{ $ant == 'Diabète' ? 'ant-diabete' : '' }}
                        {{ $ant == 'Hypertension' ? 'ant-hypertension' : '' }}
                        {{ $ant == 'Hépatite' ? 'ant-hepatite' : '' }}
                    ">
                        {{ $ant }}
                    </span>
                @endforeach
            @else
                <span class="ant-tag ant-none">Aucun antécédent signalé</span>
            @endif
        </div>
    </div>

    <!-- Historique -->
    <div class="history-grid">
        <!-- Consultations -->
        <div class="history-column">
            <div class="column-header">
                <div class="column-icon ci-blue">🩺</div>
                <h2>Consultations</h2>
                <span class="column-count">{{ $totalConsultations }}</span>
            </div>

            @if($consultations->count() > 0)
                <div class="timeline">
                    @foreach($consultations as $consult)
                        <div class="timeline-item">
                            <div class="timeline-dot dot-consult"></div>
                            <div class="timeline-card">
                                <div class="timeline-card-header">
                                    <span class="timeline-date">
                                        📅 {{ \Carbon\Carbon::parse($consult->date_consultation)->format('d/m/Y') }}
                                    </span>
                                    <span class="timeline-type type-consult">Consultation</span>
                                </div>

                                <!-- Constantes -->
                                <div class="timeline-constantes">
                                    <span class="constante-badge">
                                        🌡️ {{ $consult->constantes['temperature'] ?? 'N/A' }}°C
                                    </span>
                                    <span class="constante-badge">
                                        💓 {{ $consult->constantes['tension'] ?? 'N/A' }} mmHg
                                    </span>
                                </div>

                                <!-- Ordonnance -->
                                @if($consult->ordonnance && $consult->ordonnance->medicaments->count() > 0)
                                    <div class="ordonnance-block">
                                        <div class="ordonnance-title">💊 Ordonnance</div>
                                        @foreach($consult->ordonnance->medicaments as $med)
                                            <div class="ordonnance-med">
                                                <span class="ordonnance-med-dot"></span>
                                                {{ $med->nom }}
                                                <span class="ordonnance-posologie">— {{ $med->pivot->posologie }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-timeline">
                    <div class="empty-timeline-icon">🩺</div>
                    Aucune consultation enregistrée
                </div>
            @endif
        </div>

        <!-- Prestations -->
        <div class="history-column">
            <div class="column-header">
                <div class="column-icon ci-teal">🔬</div>
                <h2>Prestations</h2>
                <span class="column-count">{{ $totalPrestations }}</span>
            </div>

            @if($prestations->count() > 0)
                <div class="timeline">
                    @foreach($prestations as $prestation)
                        <div class="timeline-item">
                            <div class="timeline-dot dot-prestation"></div>
                            <div class="timeline-card">
                                <div class="timeline-card-header">
                                    <span class="timeline-date">
                                        📅 {{ \Carbon\Carbon::parse($prestation->date_prestation)->format('d/m/Y') }}
                                    </span>
                                    <span class="timeline-type type-prest">Prestation</span>
                                </div>
                                <div style="font-weight:600; font-size:14px; color:var(--med-dark); margin-bottom:8px;">
                                    {{ $prestation->type }}
                                </div>

                                <!-- Résultats -->
                                <div class="resultats-block">
                                    <div class="resultats-label">📋 Résultats</div>
                                    @if($prestation->resultats)
                                        <span>{{ $prestation->resultats }}</span>
                                    @else
                                        <span class="resultats-pending">En attente de résultats...</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-timeline">
                    <div class="empty-timeline-icon">🔬</div>
                    Aucune prestation enregistrée
                </div>
            @endif
        </div>
    </div>
</div>
@endsection