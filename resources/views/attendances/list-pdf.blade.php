<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #FF6200; color: white; }
    </style>
</head>
<body>
    <h1>Présences du {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h1>
    <table>
        <thead>
            <tr>
                <th>Employé</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $att)
            <tr>
                <td>{{ $att->employee->user->name }}</td>
                <td>{{ $att->check_in }}</td>
                <td>{{ $att->check_out ?? '—' }}</td>
                <td>{{ $att->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>