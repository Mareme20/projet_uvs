@extends('layouts.bootstrap')

@section('page_title', 'Détails de la Consultation')

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
        to { opacity: 1; max-height: 1000px; transform: translateY(0); }
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

    /* Carte patient */
    .patient-banner {
        background: white;
        border-radius: 20px;
        padding: 22px 26px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(26, 60, 74, 0.03);
    }

    .patient-banner-avatar {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #E0ECF4 0%, #D5EAF0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        color: var(--med-blue);
        flex-shrink: 0;
    }

    .patient-banner-info {
        flex: 1;
        line-height: 1.3;
    }

    .patient-banner-name {
        font-weight: 700;
        font-size: 17px;
        color: var(--med-dark);
    }

    .patient-banner-code {
        font-size: 12px;
        color: #A0BCC8;
        font-weight: 500;
        background: #F5F8FA;
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 3px;
    }

    .patient-banner-antecedents {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .antecedent-tag {
        font-size: 10px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .tag-diabete { background: #FFF0E6; color: #D4784C; }
    .tag-hypertension { background: #FFE8EC; color: #C94A5F; }
    .tag-hepatite { background: #FFF8E0; color: #B8942E; }

    /* Sections */
    .section-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(94, 168, 167, 0.1);
        padding: 28px;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(26, 60, 74, 0.03);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(94, 168, 167, 0.1);
    }

    .section-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .si-blue { background: var(--med-mint); }
    .si-teal { background: rgba(94, 168, 167, 0.1); }

    .section-header h2 {
        font-size: 17px;
        font-weight: 700;
        color: var(--med-dark);
        margin: 0;
    }

    .section-header .section-badge {
        margin-left: auto;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #A0BCC8;
    }

    /* Inputs */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
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

    .input-field {
        width: 100%;
        padding: 13px 16px;
        font-size: 15px;
        border: 2px solid #E2EEF3;
        border-radius: 12px;
        background: #FAFDFF;
        color: var(--med-dark);
        outline: none;
    }

    .readonly-value {
        font-size: 16px;
        font-weight: 600;
        color: var(--med-dark);
        padding: 10px 0;
    }

    /* Médicaments */
    .med-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 12px;
        align-items: end;
        margin-bottom: 12px;
        padding: 16px;
        background: #FAFDFF;
        border-radius: 14px;
        border: 1px solid rgba(94, 168, 167, 0.08);
    }

    .med-view-item {
        padding: 12px 16px;
        background: var(--med-sand);
        border-radius: 12px;
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Boutons */
    .btn-row {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
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

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 30px;
        background: linear-gradient(135deg, var(--med-green) 0%, #38A169 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(72, 187, 120, 0.3);
    }
</style>

@php
    $isCompleted = $consultation->rendezVous->statut === 'effectue';
    $constantes = $consultation->constantes ?? [];
@endphp

<div class="page-container">
    <div class="page-header">
        <div class="page-icon">🩺</div>
        <div>
            <h1>{{ $isCompleted ? 'Récapitulatif Consultation' : 'Consultation en cours' }}</h1>
            <span class="subtitle">{{ $isCompleted ? 'Détails de la visite effectuée' : 'Saisie des constantes et ordonnance' }}</span>
        </div>
    </div>

    <!-- Patient -->
    <div class="patient-banner">
        <div class="patient-banner-avatar">{{ strtoupper(substr($consultation->patient->prenom, 0, 1)) }}</div>
        <div class="patient-banner-info">
            <div class="patient-banner-name">{{ $consultation->patient->prenom }} {{ $consultation->patient->nom }}</div>
            <span class="patient-banner-code">{{ $consultation->patient->code }}</span>
        </div>
        <div class="patient-banner-antecedents">
            @foreach(($consultation->patient->antecedents ?? []) as $ant)
                <span class="antecedent-tag {{ $ant == 'Diabète' ? 'tag-diabete' : ($ant == 'Hypertension' ? 'tag-hypertension' : 'tag-hepatite') }}">{{ $ant }}</span>
            @endforeach
        </div>
    </div>

    @if(!$isCompleted)
        <form method="POST" action="{{ route('medecin.consultation.complete', $consultation->id) }}">
            @csrf
            <!-- Constantes -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon si-blue">🌡️</div>
                    <h2>Constantes</h2>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Température (°C)</label>
                        <input type="text" name="constantes[temperature]" class="input-field" required placeholder="37.5">
                    </div>
                    <div class="form-group">
                        <label>Tension (mmHg)</label>
                        <input type="text" name="constantes[tension]" class="input-field" required placeholder="12/8">
                    </div>
                </div>
            </div>

            <!-- Ordonnance -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon si-teal">💊</div>
                    <h2>Ordonnance</h2>
                </div>
                <div id="medicaments-container">
                    <div class="med-row">
                        <div class="form-group" style="margin-bottom:0;"><label>Médicament</label>
                            <select name="medicaments[]" class="input-field" style="padding: 10px;">
                                <option value="">Choisir...</option>
                                @foreach($medicaments as $med)<option value="{{ $med->id }}">{{ $med->nom }}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:0;"><label>Posologie</label>
                            <input type="text" name="posologie[]" class="input-field" placeholder="ex: 1 comprimé 3x/jour">
                        </div>
                        <button type="button" class="btn-submit" style="background:var(--med-red); padding: 10px;" onclick="removeMedRow(this)">🗑️</button>
                    </div>
                </div>
                <button type="button" onclick="addMedRow()" class="btn-cancel" style="margin-top:10px;">＋ Ajouter un médicament</button>
            </div>

            <!-- Antécédents (Mise à jour) -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon si-teal" style="background: rgba(237, 137, 54, 0.1);">🧬</div>
                    <h2>Antécédents du patient</h2>
                    <span class="section-badge">Mise à jour</span>
                </div>
                <p class="text-muted mb-3" style="font-size: 13px;">Cochez les antécédents médicaux confirmés pour ce patient.</p>
                <div class="antecedents-tags">
                    @php
                        $availableAnt = ['Diabète', 'Hypertension', 'Hépatite', 'Asthme', 'Allergie'];
                        $patientAnt = $consultation->patient->antecedents ?? [];
                    @endphp
                    @foreach($availableAnt as $ant)
                        @php $isActive = in_array($ant, $patientAnt); @endphp
                        <label class="ant-tag-label" style="cursor: pointer;">
                            <input type="checkbox" name="patient_antecedents[]" value="{{ $ant }}" 
                                {{ $isActive ? 'checked' : '' }}
                                style="display: none;"
                                onchange="this.nextElementSibling.classList.toggle('active', this.checked)"
                            >
                            <span class="ant-tag {{ $isActive ? 'active' : '' }}">{{ $ant }}</span>
                        </label>
                    @endforeach
                </div>
                <style>
                    .antecedents-tags { display: flex; gap: 10px; flex-wrap: wrap; }
                    .ant-tag { 
                        display: inline-block; padding: 8px 20px; border-radius: 50px; background: #F5F8FA; color: #7A9AAA; 
                        font-size: 13px; font-weight: 600; border: 2px solid transparent; transition: all 0.2s;
                    }
                    .ant-tag.active { background: #FFF0E6; color: #D4784C; border-color: #D4784C; }
                    .ant-tag:hover { background: #E2EEF3; }
                </style>
            </div>

            <!-- Prochain RV -->
            <div class="section-card">
                <div class="section-header"><div class="section-icon si-blue">📅</div><h2>Prochain Rendez-vous</h2></div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="next_rv[plan]" id="planNextRv" onchange="document.getElementById('next-rv-fields').style.display = this.checked ? 'block' : 'none'">
                    <label class="form-check-label" for="planNextRv" style="margin-left:8px; cursor:pointer;">Planifier une suite ?</label>
                </div>
                <div id="next-rv-fields" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="next_rv[type]" class="input-field" onchange="toggleNextRvPrestationField()">
                                <option value="consultation">Consultation</option>
                                <option value="prestation">Prestation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="datetime-local" name="next_rv[date_rv]" class="input-field">
                        </div>
                    </div>

                    <div id="next-rv-prestation-type" style="display:none; margin-top: 18px;">
                        <div class="form-group">
                            <label>Type de prestation</label>
                            <input type="text" name="next_rv[prestation_type]" class="input-field" placeholder="Ex: Radio thoracique, Analyse sanguine...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-row">
                <a href="{{ route('medecin.dashboard') }}" class="btn-cancel">← Annuler</a>
                <button type="submit" class="btn-submit">✅ Terminer</button>
            </div>
        </form>
    @else
        <!-- Mode lecture seule (Déjà terminé) -->
        <div class="section-card">
            <div class="section-header"><div class="section-icon si-blue">🌡️</div><h2>Constantes relevées</h2></div>
            <div class="form-row">
                <div><label>Température</label><div class="readonly-value">{{ $constantes['temperature'] ?? 'N/A' }} °C</div></div>
                <div><label>Tension</label><div class="readonly-value">{{ $constantes['tension'] ?? 'N/A' }} mmHg</div></div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header"><div class="section-icon si-teal">💊</div><h2>Ordonnance délivrée</h2></div>
            @if($consultation->ordonnance && $consultation->ordonnance->medicaments->count() > 0)
                @foreach($consultation->ordonnance->medicaments as $med)
                    <div class="med-view-item">
                        <div><strong>{{ $med->nom }}</strong></div>
                        <div style="color:var(--med-teal);">{{ $med->pivot->posologie }}</div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Aucune ordonnance.</p>
            @endif
        </div>

        <div class="btn-row">
            <a href="{{ route('medecin.dashboard') }}" class="btn-cancel">← Retour</a>
        </div>
    @endif
</div>

<script>
    function addMedRow() {
        const container = document.getElementById('medicaments-container');
        const firstRow = container.querySelector('.med-row');
        if (firstRow) {
            const row = firstRow.cloneNode(true);
            row.querySelectorAll('input').forEach(i => i.value = '');
            row.querySelectorAll('select').forEach(s => s.value = '');
            container.appendChild(row);
        }
    }

    function removeMedRow(btn) {
        const container = document.getElementById('medicaments-container');
        if (container.querySelectorAll('.med-row').length > 1) {
            btn.closest('.med-row').remove();
        } else {
            alert('Il faut au moins un médicament si vous remplissez l\'ordonnance, ou laissez vide.');
        }
    }

    function toggleNextRvPrestationField() {
        const select = document.querySelector('select[name="next_rv[type]"]');
        const wrapper = document.getElementById('next-rv-prestation-type');
        if (!select || !wrapper) return;
        wrapper.style.display = select.value === 'prestation' ? 'block' : 'none';
    }
</script>
@endsection
