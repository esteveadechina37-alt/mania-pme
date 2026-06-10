<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Attestation - {{ $employee->user->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1F2937;
            margin: 25px 30px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #FF6200;
            padding-bottom: 12px;
        }
        .header .company-name {
            font-size: 18px;
            font-weight: 700;
            color: #FF6200;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .header .company-details {
            font-size: 9px;
            color: #6B7280;
        }
        .header .doc-title {
            font-size: 15px;
            font-weight: 700;
            color: #0A0A0A;
            letter-spacing: 1px;
            margin-top: 8px;
        }
        .company-info {
            text-align: right;
            font-size: 9px;
            color: #6B7280;
            margin-bottom: 20px;
        }
        .content {
            text-align: justify;
            margin-bottom: 20px;
        }
        .content p {
            margin: 8px 0;
        }
        .employee-details {
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 5px;
            padding: 10px 14px;
            margin: 15px 0;
        }
        .employee-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .employee-details td {
            padding: 2px 0;
            font-size: 11px;
        }
        .employee-details .label {
            color: #6B7280;
            font-weight: 600;
            width: 130px;
        }
        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature .left {
            width: 55%;
        }
        .signature .right {
            width: 35%;
            text-align: center;
            border-left: 1px solid #E5E7EB;
            padding-left: 15px;
        }
        .qr-wrapper {
            display: inline-block;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 6px;
            padding: 6px;
            margin-top: 8px;
        }
        .footer-note {
            margin-top: 25px;
            font-size: 9px;
            color: #9CA3AF;
            text-align: center;
            border-top: 1px solid #E5E7EB;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $employee->company->name }}</div>
        <div class="company-details">
            @if($employee->company->address){{ $employee->company->address }}<br>@endif
            @if($employee->company->city){{ $employee->company->city }} @endif
            @if($employee->company->phone) · Tél : {{ $employee->company->phone }}@endif
        </div>
        <div class="doc-title">{{ $type == 'work' ? 'ATTESTATION DE TRAVAIL' : 'ATTESTATION DE STAGE' }}</div>
    </div>

    <div class="company-info">
        Fait à {{ $employee->company->city ?? '...' }}, le {{ $date }}
    </div>

    <div class="content">
        <p>
            Je soussigné(e) <strong>{{ $employee->company->name }}</strong>,
            @if($employee->company->address)
                dont le siège social est situé à {{ $employee->company->address }},
            @endif
            représentée par son représentant légal, atteste par la présente que :
        </p>

        <div class="employee-details">
            <table>
                <tr>
                    <td class="label">Nom et prénom</td>
                    <td><strong>{{ $employee->user->name }}</strong></td>
                </tr>
                @if($employee->position)
                <tr>
                    <td class="label">Fonction / Poste</td>
                    <td>{{ $employee->position }}</td>
                </tr>
                @endif
                @if($employee->department)
                <tr>
                    <td class="label">Département</td>
                    <td>{{ $employee->department->name }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Date d'entrée</td>
                    <td>
                        @if($employee->hire_date)
                            {{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}
                        @else
                            Non précisée
                        @endif
                    </td>
                </tr>
                @if($type == 'internship' && $employee->contract_end_date)
                <tr>
                    <td class="label">Date de fin de stage</td>
                    <td>{{ \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') }}</td>
                </tr>
                @endif
                @if($type == 'work')
                <tr>
                    <td class="label">Statut actuel</td>
                    <td>
                        @if($employee->status == 'active')
                            En poste
                        @else
                            Contrat terminé
                        @endif
                    </td>
                </tr>
                @endif
            </table>
        </div>

        <p>
            @if($type == 'work')
                {{ $employee->user->name }} occupe le poste de <strong>{{ $employee->position ?? 'employé(e)' }}</strong>
                au sein de notre entreprise depuis le 
                <strong>{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '...' }}</strong>
                et y est toujours en activité à ce jour.
                {{ $employee->user->name }} fait preuve de sérieux, de ponctualité et d’une réelle implication dans ses missions.
            @else
                {{ $employee->user->name }} a effectué un stage en qualité de 
                <strong>{{ $employee->position ?? 'stagiaire' }}</strong> du 
                <strong>{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '...' }}</strong>
                au <strong>{{ $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') : '...' }}</strong>.
                Durant cette période, {{ $employee->user->name }} a fait preuve d’assiduité et a démontré de bonnes aptitudes professionnelles.
            @endif
        </p>

        <p>
            La présente attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.
        </p>
    </div>

    <div class="signature">
        <div class="left">
            <p>Fait pour valoir ce que de droit.</p>
            <p>À {{ $employee->company->city ?? '...' }}, le {{ $date }}</p>
            <p><strong>La Direction</strong></p>
        </div>
        <div class="right">
            <div class="qr-wrapper">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="100" height="100" alt="QR Code">
            </div>
            <p style="font-size:9px; color:#6B7280; margin-top:6px;">
                Vérification en ligne<br>du document
            </p>
        </div>
    </div>

    <div class="footer-note">
        Document généré électroniquement le {{ now()->format('d/m/Y à H:i') }} — 
        L'authenticité de ce document peut être vérifiée en scannant le QR code ci-dessus.
    </div>
</body>
</html>