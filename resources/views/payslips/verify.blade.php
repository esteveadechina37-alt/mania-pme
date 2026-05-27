<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification du bulletin</title>
    <style>
        body { font-family: sans-serif; background: #F7F4F0; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); max-width: 500px; width: 100%; text-align: center; }
        .badge { display: inline-block; padding: 6px 16px; border-radius: 100px; font-size: 14px; font-weight: 600; margin-bottom: 20px; }
        .badge-success { background: #dcfce7; color: #166534; }
        .info { text-align: left; background: #F9FAFB; border-radius: 8px; padding: 16px; margin-bottom: 20px; }
        .info div { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #E5E7EB; }
        .info div:last-child { border-bottom: none; }
    </style>
</head>
<body>
<div class="card">
    <span class="badge badge-success">✔ Bulletin authentique</span>
    <h1>Bulletin de paie vérifié</h1>
    <p>Entreprise : <strong>{{ $payslip->company->name }}</strong></p>
    <div class="info">
        <div><span>Employé</span> <strong>{{ $payslip->employee->user->name }}</strong></div>
        <div><span>Période</span> <strong>{{ $payslip->month }} {{ $payslip->year }}</strong></div>
        <div><span>Salaire net</span> <strong>{{ number_format($payslip->net_salary, 0, ',', ' ') }} FCFA</strong></div>
    </div>
</div>
</body>
</html>