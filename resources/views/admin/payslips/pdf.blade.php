<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #FF6200; color: white; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #FF6200; }
        .details p { margin: 5px 0; }

        /* Layout côte à côte */
        .details-wrapper {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-wrapper td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }
        .details-cell {
            width: 70%;
        }
        .qr-cell {
            width: 30%;
            text-align: center;
        }
        .qr-cell p {
            font-size: 9px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bulletin de paie</h1>
        <p>{{ $month }} {{ $year }}</p>
    </div>

    {{-- Bloc détails + QR code côte à côte --}}
    <table class="details-wrapper">
        <tr>
            <td class="details-cell">
                <p><strong>Entreprise :</strong> {{ $employee->company->name }}</p>
                <p><strong>Employé :</strong> {{ $employee->user->name }}</p>
                <p><strong>Poste :</strong> {{ $employee->position ?? 'Non défini' }}</p>
            </td>
            <td class="qr-cell">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="120" height="120" alt="QR Code">
                <p>Scannez pour vérifier<br>l'authenticité du bulletin.</p>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Rubrique</th>
            <th>Montant</th>
        </tr>
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
        <tr>
            <td><strong>Salaire net</strong></td>
            <td><strong>{{ number_format($net_salary, 0, ',', ' ') }} FCFA</strong></td>
        </tr>
    </table>
</body>
</html>