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
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bulletin de paie</h1>
        <p>{{ $month }} {{ $year }}</p>
    </div>

    <div class="details">
        <p><strong>Entreprise :</strong> {{ $employee->company->name }}</p>
        <p><strong>Employé :</strong> {{ $employee->user->name }}</p>
        <p><strong>Poste :</strong> {{ $employee->position ?? 'Non défini' }}</p>
    </div>

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