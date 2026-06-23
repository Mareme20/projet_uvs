<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordonnance - {{ $consultation->patient->nom }}</title>
    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: 'Times New Roman', Times, serif; color: #333; line-height: 1.6; padding: 0; margin: 0; }
        .container { width: 100%; max-width: 800px; margin: auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #3B82B5; padding-bottom: 20px; margin-bottom: 30px; }
        .clinic-info h1 { color: #3B82B5; margin: 0; font-size: 28px; }
        .clinic-info p { margin: 5px 0; color: #666; font-size: 14px; }
        .date-info { text-align: right; }
        .doc-title { text-align: center; text-transform: uppercase; text-decoration: underline; margin: 40px 0; font-size: 22px; font-weight: bold; }
        .meta-info { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .patient-box, .doctor-box { width: 48%; }
        .patient-box h3, .doctor-box h3 { border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; font-size: 16px; color: #1A3C4A; }
        .content { margin-bottom: 60px; min-height: 300px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; border-bottom: 2px solid #333; padding: 10px; font-size: 14px; }
        td { padding: 15px 10px; border-bottom: 1px solid #eee; font-size: 15px; }
        .footer { text-align: right; margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; }
        .signature-space { height: 80px; }
        .no-print { margin-bottom: 20px; padding: 15px; background: #e8f4f8; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #3B82B5; }
        @media print { .no-print { display: none; } .container { padding: 0; } }
        .btn-print { padding: 10px 25px; background: #3B82B5; color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: bold; font-family: sans-serif; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn-back { color: #3B82B5; text-decoration: none; font-weight: 600; font-family: sans-serif; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print">
            <a href="javascript:history.back()" class="btn-back">← Retour au tableau de bord</a>
            <button onclick="window.print()" class="btn-print">🖨️ Imprimer / Enregistrer PDF</button>
        </div>

        <div class="header">
            <div class="clinic-info">
                <h1>Clinique IIBS</h1>
                <p>123 Avenue de la Santé, Dakar, Sénégal</p>
                <p>Tél: +221 33 000 00 00 | Email: contact@iibs.sn</p>
            </div>
            <div class="date-info">
                <p><strong>Dakar, le {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}</strong></p>
            </div>
        </div>

        <div class="doc-title">Ordonnance Médicale</div>

        <div class="meta-info">
            <div class="patient-box">
                <h3>Patient</h3>
                <p><strong>Nom:</strong> {{ $consultation->patient->nom }} {{ $consultation->patient->prenom }}</p>
                <p><strong>Code:</strong> {{ $consultation->patient->code }}</p>
                @if($consultation->patient->antecedents)
                    <p><strong>Antécédents:</strong> {{ is_array($consultation->patient->antecedents) ? implode(', ', $consultation->patient->antecedents) : $consultation->patient->antecedents }}</p>
                @endif
            </div>
            <div class="doctor-box">
                <h3>Médecin</h3>
                <p><strong>Dr. {{ $consultation->medecin->user->name ?? 'N/A' }}</strong></p>
                <p>{{ $consultation->medecin->specialite ?? 'Médecin Généraliste' }}</p>
            </div>
        </div>

        <div class="content">
            @if($consultation->ordonnance && $consultation->ordonnance->medicaments->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Médicament (Code)</th>
                            <th>Posologie / Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultation->ordonnance->medicaments as $med)
                            <tr>
                                <td><strong>{{ $med->nom }}</strong> <br><small style="color: #888;">#{{ $med->code }}</small></td>
                                <td>{{ $med->pivot->posologie }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #666; font-style: italic; margin-top: 50px;">Aucun médicament prescrit lors de cette consultation.</p>
            @endif
        </div>

        <div class="footer">
            <p>Cachet et Signature du Médecin</p>
            <div class="signature-space"></div>
        </div>
    </div>
</body>
</html>
