<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats Examen - {{ $prestation->patient->nom }}</title>
    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: 'Times New Roman', Times, serif; color: #333; line-height: 1.6; padding: 0; margin: 0; }
        .container { width: 100%; max-width: 800px; margin: auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #5EA8A7; padding-bottom: 20px; margin-bottom: 30px; }
        .clinic-info h1 { color: #5EA8A7; margin: 0; font-size: 28px; }
        .clinic-info p { margin: 5px 0; color: #666; font-size: 14px; }
        .date-info { text-align: right; }
        .doc-title { text-align: center; text-transform: uppercase; text-decoration: underline; margin: 40px 0; font-size: 22px; font-weight: bold; }
        .patient-info-bar { background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 30px; display: flex; justify-content: space-between; border: 1px solid #eee; }
        .content { margin-bottom: 60px; min-height: 350px; background: white; padding: 20px; border: 1px solid #f0f0f0; border-radius: 10px; }
        .results-text { white-space: pre-line; font-size: 16px; color: #1A3C4A; }
        .footer { display: flex; justify-content: space-between; margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; font-size: 14px; }
        .signature-box { text-align: center; width: 200px; }
        .signature-space { height: 70px; }
        .no-print { margin-bottom: 20px; padding: 15px; background: #E8F4F8; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #5EA8A7; }
        @media print { .no-print { display: none; } .container { padding: 0; } .content { border: none; padding: 0; } }
        .btn-print { padding: 10px 25px; background: #5EA8A7; color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: bold; font-family: sans-serif; }
        .btn-back { color: #5EA8A7; text-decoration: none; font-weight: 600; font-family: sans-serif; }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print">
            <a href="javascript:history.back()" class="btn-back">← Retour au tableau de bord</a>
            <button onclick="window.print()" class="btn-print">🖨️ Imprimer les résultats</button>
        </div>

        <div class="header">
            <div class="clinic-info">
                <h1>Clinique IIBS</h1>
                <p>Département des Prestations Médicales</p>
                <p>Tél: +221 33 000 00 00 | Email: labo@iibs.sn</p>
            </div>
            <div class="date-info">
                <p><strong>Dakar, le {{ \Carbon\Carbon::parse($prestation->date_prestation)->format('d/m/Y') }}</strong></p>
            </div>
        </div>

        <div class="doc-title">Rapport d'Examen : {{ $prestation->type }}</div>

        <div class="patient-info-bar">
            <div>
                <strong>Patient:</strong> {{ $prestation->patient->prenom }} {{ $prestation->patient->nom }}
            </div>
            <div>
                <strong>Identifiant:</strong> {{ $prestation->patient->code }}
            </div>
            <div>
                <strong>Date de l'examen:</strong> {{ \Carbon\Carbon::parse($prestation->date_prestation)->format('d/m/Y') }}
            </div>
        </div>

        <div class="content">
            <div style="font-weight: bold; margin-bottom: 15px; color: #5EA8A7;">COMPTE-RENDU :</div>
            <div class="results-text">
                {{ $prestation->resultats ?? 'Aucun résultat disponible pour le moment.' }}
            </div>
        </div>

        <div class="footer">
            <div>
                <p>Réf: PREST-{{ $prestation->id }}-{{ date('Y') }}</p>
            </div>
            <div class="signature-box">
                <p><strong>Responsable Technique</strong></p>
                <div class="signature-space"></div>
                <p>Validation électronique</p>
            </div>
        </div>
    </div>
</body>
</html>
