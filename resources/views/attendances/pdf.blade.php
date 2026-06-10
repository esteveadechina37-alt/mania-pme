<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historique des pointages</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1F2937;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            color: #FF6200;
            margin: 0 0 4px;
        }
        .header p {
            font-size: 12px;
            color: #6B7280;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th {
            background-color: #FF6200;
            color: white;
            padding: 8px 10px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left;
        }
        td {
            padding: 7px 10px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 12px;
        }
        tr:nth-child(even) { background: #F9FAFB; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Historique des pointages</h1>
        <p>{{ $employee->user->name }} — {{ $attendances->count() }} enregistrements</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $att)
            <tr>
                <td>{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                <td>{{ $att->check_in }}</td>
                <td>{{ $att->check_out ?? '—' }}</td>
                <td>
                    @if($att->status == 'present')
                        Présent
                    @elseif($att->status == 'late')
                        Retard
                    @else
                        Absent
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>