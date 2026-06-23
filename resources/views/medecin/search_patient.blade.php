@extends('layouts.bootstrap')

@section('page_title', 'Recherche de Patient')

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

    @keyframes cardPop {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes pulseSearch {
        0%, 100% { box-shadow: 0 0 0 0 rgba(94, 168, 167, 0.3); }
        50% { box-shadow: 0 0 0 15px rgba(94, 168, 167, 0); }
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

    /* Barre de recherche */
    .search-hero {
        background: white;
        border-radius: 24px;
        padding: 40px 36px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        box-shadow: 0 4px 20px rgba(26, 60, 74, 0.04);
        margin-bottom: 28px;
        text-align: center;
    }

    .search-hero-icon {
        font-size: 48px;
        margin-bottom: 16px;
        display: block;
    }

    .search-hero h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0 0 8px;
    }

    .search-hero p {
        font-size: 14px;
        color: #8AA0AD;
        margin-bottom: 28px;
    }

    .search-form {
        display: flex;
        gap: 0;
        max-width: 600px;
        margin: 0 auto;
        background: #FAFDFF;
        border-radius: 50px;
        border: 2px solid #E2EEF3;
        overflow: hidden;
        transition: all 0.3s;
    }

    .search-form:focus-within {
        border-color: var(--med-teal);
        box-shadow: 0 0 0 8px rgba(94, 168, 167, 0.07);
        animation: pulseSearch 1.5s ease-in-out;
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 16px 22px;
        font-size: 15px;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        color: var(--med-dark);
        background: transparent;
    }

    .search-input::placeholder {
        color: #B0C8D4;
    }

    .search-btn {
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        border: none;
        padding: 16px 32px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .search-btn:hover {
        opacity: 0.95;
    }

    /* Résultats */
    .results-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }

    .results-count {
        font-size: 14px;
        font-weight: 600;
        color: var(--med-dark);
    }

    .results-count-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 26px;
        background: var(--med-mint);
        color: var(--med-blue);
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        padding: 0 12px;
        margin-left: 6px;
    }

    .btn-clear-search {
        margin-left: auto;
        font-size: 12px;
        font-weight: 600;
        color: #A0BCC8;
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 20px;
        transition: all 0.2s;
    }

    .btn-clear-search:hover {
        background: #F5F8FA;
        color: var(--med-dark);
    }

    /* Grille patients */
    .patient-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 14px;
    }

    .patient-card {
        background: white;
        border-radius: 18px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(26, 60, 74, 0.02);
        animation: cardPop 0.4s ease-out;
        animation-fill-mode: both;
    }

    .patient-card:nth-child(1) { animation-delay: 0s; }
    .patient-card:nth-child(2) { animation-delay: 0.05s; }
    .patient-card:nth-child(3) { animation-delay: 0.1s; }
    .patient-card:nth-child(4) { animation-delay: 0.15s; }
    .patient-card:nth-child(5) { animation-delay: 0.2s; }
    .patient-card:nth-child(6) { animation-delay: 0.25s; }

    .patient-card:hover {
        border-color: rgba(94, 168, 167, 0.3);
        box-shadow: 0 10px 28px rgba(26, 60, 74, 0.07);
        transform: translateY(-3px);
    }

    .card-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #E0ECF4 0%, #D5EAF0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: var(--med-blue);
        flex-shrink: 0;
    }

    .card-info {
        flex: 1;
        line-height: 1.4;
        min-width: 0;
    }

    .card-name {
        font-weight: 700;
        font-size: 15px;
        color: var(--med-dark);
    }

    .card-code {
        font-size: 11px;
        color: #A0BCC8;
        font-weight: 500;
        background: #F5F8FA;
        padding: 2px 9px;
        border-radius: 10px;
        display: inline-block;
        margin-top: 3px;
    }

    .card-antecedents {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
        margin-top: 6px;
    }

    .mini-tag {
        font-size: 9px;
        font-weight: 600;
        padding: 3px 7px;
        border-radius: 10px;
        white-space: nowrap;
    }

    .mt-diabete { background: #FFF0E6; color: #D4784C; }
    .mt-hypertension { background: #FFE8EC; color: #C94A5F; }
    .mt-hepatite { background: #FFF8E0; color: #B8942E; }

    .card-action {
        flex-shrink: 0;
    }

    .btn-dossier {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: rgba(94, 168, 167, 0.08);
        color: var(--med-teal);
        border: 1px solid rgba(94, 168, 167, 0.2);
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .btn-dossier:hover {
        background: rgba(94, 168, 167, 0.15);
        border-color: var(--med-teal);
        transform: translateY(-1px);
    }

    /* Empty / No search */
    .empty-results {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(94, 168, 167, 0.1);
    }

    .empty-results-icon {
        font-size: 48px;
        margin-bottom: 14px;
        opacity: 0.6;
    }

    .empty-results h3 {
        font-size: 17px;
        font-weight: 700;
        color: var(--med-dark);
        margin-bottom: 6px;
    }

    .empty-results p {
        font-size: 14px;
        color: #A0BCC8;
    }

    .no-search-yet {
        text-align: center;
        padding: 60px 20px;
    }

    .no-search-yet-icon {
        font-size: 56px;
        margin-bottom: 14px;
        opacity: 0.5;
    }

    .no-search-yet p {
        font-size: 15px;
        color: #A0BCC8;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 600px) {
        .search-hero {
            padding: 28px 20px;
        }

        .search-form {
            flex-direction: column;
            border-radius: 16px;
            border: none;
            gap: 8px;
            background: transparent;
        }

        .search-input {
            border: 2px solid #E2EEF3;
            border-radius: 14px;
            padding: 14px 18px;
        }

        .search-btn {
            border-radius: 14px;
            justify-content: center;
        }

        .patient-grid {
            grid-template-columns: 1fr;
        }

        .patient-card {
            flex-direction: column;
            text-align: center;
        }

        .card-antecedents {
            justify-content: center;
        }

        .card-action {
            width: 100%;
        }

        .btn-dossier {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="page-icon">🔍</div>
        <div>
            <h1>Recherche de Patient</h1>
            <span class="subtitle">Consultez le dossier médical d'un patient</span>
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="search-hero">
        <span class="search-hero-icon">🔍</span>
        <h2>Trouver un patient</h2>
        <p>Recherchez par nom, prénom ou code patient</p>

        <form action="{{ route('medecin.patient.search') }}" method="GET" class="search-form">
            <input 
                type="text" 
                name="query" 
                class="search-input" 
                placeholder="Ex: Dupont, Jean, P00123..." 
                value="{{ request('query') }}"
                autofocus
            >
            <button type="submit" class="search-btn">
                🔍 Rechercher
            </button>
        </form>
    </div>

    <!-- Résultats -->
    @if(isset($patients))
        <div class="results-header">
            <span class="results-count">
                Résultats
                <span class="results-count-badge">{{ $patients->count() }}</span>
            </span>
            @if(request('query'))
                <a href="{{ route('medecin.patient.search') }}" class="btn-clear-search">
                    ✕ Effacer la recherche
                </a>
            @endif
        </div>

        @if($patients->count() > 0)
            <div class="patient-grid">
                @foreach($patients as $patient)
                    <div class="patient-card">
                        <div class="card-avatar">
                            {{ strtoupper(substr($patient->prenom, 0, 1)) }}
                        </div>
                        <div class="card-info">
                            <div class="card-name">{{ $patient->prenom }} {{ $patient->nom }}</div>
                            <span class="card-code">{{ $patient->code }}</span>
                            <div class="card-antecedents">
                                @if($patient->antecedents && count($patient->antecedents) > 0)
                                    @foreach($patient->antecedents as $ant)
                                        <span class="mini-tag 
                                            {{ $ant == 'Diabète' ? 'mt-diabete' : '' }}
                                            {{ $ant == 'Hypertension' ? 'mt-hypertension' : '' }}
                                            {{ $ant == 'Hépatite' ? 'mt-hepatite' : '' }}
                                        ">
                                            {{ $ant }}
                                        </span>
                                    @endforeach
                                @else
                                    <span style="font-size:10px; color:#B0C8D4;">Aucun antécédent</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('medecin.patient.history', $patient->id) }}" class="btn-dossier">
                                📂 Dossier
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-results">
                <div class="empty-results-icon">😕</div>
                <h3>Aucun patient trouvé</h3>
                <p>Aucun résultat pour "{{ request('query') }}". Essayez un autre nom, prénom ou code.</p>
            </div>
        @endif
    @else
        <!-- Pas encore de recherche -->
        <div class="no-search-yet">
            <div class="no-search-yet-icon">👆</div>
            <p>Utilisez la barre de recherche ci-dessus pour trouver un patient.</p>
        </div>
    @endif
</div>
@endsection