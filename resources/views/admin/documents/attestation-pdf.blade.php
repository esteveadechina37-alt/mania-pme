<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { font-size: 24px; color: #FF6200; }
        .content { line-height: 1.8; font-size: 14px; }
        .signature { margin-top: 60px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $type == 'work' ? 'ATTESTATION DE TRAVAIL' : 'ATTESTATION DE STAGE' }}</h1>
    </div>
    <div class="content">
        <p>Je soussigné(e) <strong>{{ $employee->company->name }}</strong>, 
           représentée par son Administrateur, atteste que :</p>
        <p><strong>{{ $employee->user->name }}</strong> 
           a {{ $type == 'work' ? 'exercé les fonctions de' : 'effectué un stage en tant que' }} 
           <strong>{{ $employee->position ?? 'Non défini' }}</strong> 
           au sein de notre entreprise 
           @if($employee->hire_date)
               depuis le <strong>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</strong>
               @if($type == 'internship' && $employee->contract_end_date)
                   jusqu'au <strong>{{ \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') }}</strong>
               @endif
               .
           @else
               (date d'entrée non précisée).
           @endif
        </p>
        <p>Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.</p>
    </div>
    <div class="signature">
        <p>Fait à {{ $employee->company->city ?? '...' }}, le {{ $date }}</p>
        <p>L'Administration</p>
    </div>
    <div style="text-align: center; margin-top: 40px;">
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="120" height="120" alt="QR Code">
        <p style="font-size: 10px; color: #666;">Scannez ce code pour vérifier l'authenticité du document.</p>
    </div>
</body>
</html>