<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bulletin de paie - {{ $employee->user->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1F2937;
            margin: 0;
            padding: 30px;
        }
        .header {
            border-bottom: 3px solid #FF6200;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .header .company-name {
            font-size: 22px;
            font-weight: 700;
            color: #FF6200;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .header .doc-title {
            font-size: 16px;
            font-weight: 600;
            color: #0A0A0A;
        }
        .header .period {
            font-size: 12px;
            color: #6B7280;
            margin-top: 4px;
        }

        .info-qr-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-qr-table td {
            vertical-align: top;
            padding: 0;
        }
        .info-cell {
            width: 70%;
            padding-right: 20px;
        }
        .info-table {
            border-collapse: collapse;
            width: 100%;
        }
        .info-table td {
            padding: 6px 0;
            border: none;
            font-size: 12px;
        }
        .info-table .label {
            color: #6B7280;
            font-weight: 600;
            width: 100px;
        }
        .qr-cell {
            width: 30%;
            text-align: center;
            vertical-align: middle;
            border-left: 1px solid #E5E7EB;
            padding-left: 15px;
        }
        .qr-cell .qr-wrapper {
            display: inline-block;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 10px;
        }
        .qr-cell p {
            font-size: 10px;
            color: #6B7280;
            margin: 8px 0 0;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #E5E7EB;
        }
        .salary-table th {
            background-color: #FF6200;
            color: white;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            padding: 10px 12px;
            text-align: left;
        }
        .salary-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 12px;
        }
        .salary-table tr:last-child td {
            border-bottom: none;
        }
        .salary-table .net-row {
            background-color: #FFF7ED;
            font-weight: 700;
            font-size: 13px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            font-size: 10px;
            color: #9CA3AF;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <div class="company-name">{{ $employee->company->name ?? 'Entreprise' }}</div>
        <div class="doc-title">Bulletin de Paie</div>
        <div class="period">{{ $month }} {{ $year }}</div>
    </div>

    <!-- Informations et QR code -->
    <table class="info-qr-table">
        <tr>
            <td class="info-cell">
                <table class="info-table">
                    <tr>
                        <td class="label">Employé</td>
                        <td><strong>{{ $employee->user->name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Poste</td>
                        <td>{{ $employee->position ?? 'Non défini' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Département</td>
                        <td>{{ $employee->department->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Date d'embauche</td>
                        <td>{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—' }}</td>
                    </tr>
                </table>
            </td>
            <td class="qr-cell">
                <div class="qr-wrapper">
                    <!-- QR code inchangé : utilisation de la variable $qrCode (base64) -->
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="120" height="120" alt="QR Code">
                </div>
                <p>Scannez pour vérifier<br>l'authenticité de ce bulletin.</p>
            </td>
        </tr>
    </table>

    <!-- Tableau des salaires -->
    <table class="salary-table">
        <thead>
            <tr>
                <th>Rubrique</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de base</td>
                <td>{{ number_format($base_salary, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td>Primes</td>
                <td>{{ number_format($bonuses, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td>Retenues</td>
                <td>{{ number_format($deductions, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr class="net-row">
                <td>Salaire net à payer</td>
                <td>{{ number_format($net_salary, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <!-- Pied de page -->
    <div class="footer">
        Document généré le {{ now()->format('d/m/Y à H:i') }} — Ce bulletin est confidentiel et ne peut être modifié.
    </div>
</body>
</html>