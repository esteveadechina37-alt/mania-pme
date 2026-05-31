<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du document</title>
    <style>
        body {
            font-family: 'Cabinet Grotesk', sans-serif;
            background: #F7F4F0;
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; margin: 0; padding: 20px;
        }
        .card {
            background: white; border-radius: 16px; padding: 32px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05); max-width: 500px;
            width: 100%; text-align: center;
        }
        .badge {
            display: inline-block; padding: 6px 16px; border-radius: 100px;
            font-size: 14px; font-weight: 600; margin-bottom: 20px;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        h1 { color: #0A0A0A; font-size: 24px; margin: 0 0 8px; }
        p { color: #6B6B6B; font-size: 14px; margin: 0 0 20px; }
        .info {
            background: #F9FAFB; border-radius: 8px; padding: 16px;
            text-align: left; margin-bottom: 20px;
        }
        .info div { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #E5E7EB; }
        .info div:last-child { border-bottom: none; }
        .info strong { color: #0A0A0A; }
        .info span { color: #6B6B6B; }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge badge-success">✔ Document authentique</span>
        <h1>{{ $document->title }}</h1>
        <p>Ce document a bien été émis par <strong>{{ $document->company->name }}</strong>.</p>
        <div class="info">
            <div>
                <strong>Employé</strong>
                <span>{{ $document->employee->user->name }}</span>
            </div>
            <div>
                <strong>Type</strong>
                <span>
                    @if($document->type == 'certificate') Attestation
                    @elseif($document->type == 'contract') Contrat
                    @else Autre
                    @endif
                </span>
            </div>
            <div>
                <strong>Date d'émission</strong>
                <span>{{ $document->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</body>
</html>