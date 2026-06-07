<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rapport de présences - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header .company {
            font-size: 22px;
            font-weight: bold;
            color: #FF6200;
            margin-bottom: 5px;
        }
        .header .report-title {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .summary-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .summary-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 20px;
            width: 22%;
            text-align: center;
            background-color: #fafafa;
        }
        .summary-card .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #777;
        }
        .summary-card .value {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
        }
        .present .value { color: #28a745; }
        .late .value { color: #ffc107; }
        .absent .value { color: #dc3545; }
        .rate .value { color: #17a2b8; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #FF6200;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        .status-present { background: #d4edda; color: #155724; }
        .status-late    { background: #fff3cd; color: #856404; }
        .status-absent  { background: #f8d7da; color: #721c24; }

        .duration {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <div class="company">{{ $company->name ?? 'Entreprise' }}</div>
        <div class="report-title">Feuille de présences</div>
        <div>Date : <strong>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</strong></div>
    </div>

    <!-- Tableau détaillé -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employé</th>
                <th>Département</th>
                <th>Heure d'arrivée</th>
                <th>Heure de départ</th>
                <th>Temps travaillé</th>
                <th>Retard</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($attendances as $att)
            @php
                $employee = $att->employee;
                $user = $employee->user ?? null;
                $department = $employee->department->name ?? '—';
                $checkIn = \Carbon\Carbon::parse($att->check_in);
                $checkOut = $att->check_out ? \Carbon\Carbon::parse($att->check_out) : null;
                $hoursWorked = $checkOut ? $checkOut->diff($checkIn)->format('%Hh %Im') : '—';
                $lateBy = null;
                if ($att->status === 'late') {
                    $lateBy = $checkIn->diff(\Carbon\Carbon::parse($date.' 08:30:00'))->format('%Hh %Im');
                }
            @endphp
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $user->name ?? 'Employé inconnu' }}</td>
                <td>{{ $department }}</td>
                <td>{{ $checkIn->format('H:i') }}</td>
                <td>{{ $checkOut ? $checkOut->format('H:i') : '—' }}</td>
                <td>{{ $hoursWorked }}</td>
                <td>{{ $lateBy ?? '—' }}</td>
                <td>
                    @if($att->status === 'present')
                        <span class="status-badge status-present">Présent</span>
                    @elseif($att->status === 'late')
                        <span class="status-badge status-late">Retard</span>
                    @else
                        <span class="status-badge status-absent">Absent</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Aucun pointage enregistré pour cette date.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Liste des employés absents (sans pointage) -->
    @if($absent > 0)
    <div style="margin-top: 20px;">
        <strong>Employés absents (non pointés) :</strong>
        <ul>
            @php
                $attendedIds = $attendances->pluck('employee_id')->toArray();
                $absentEmployees = $allEmployees->filter(function($emp) use ($attendedIds) {
                    return !in_array($emp->id, $attendedIds);
                });
            @endphp
            @foreach($absentEmployees as $emp)
                <li>{{ $emp->user->name ?? 'N/A' }} - {{ $emp->department->name ?? '—' }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="footer">
        Rapport généré le {{ now()->format('d/m/Y à H:i') }} par {{ auth()->user()->name ?? 'Système' }}
    </div>
</body>
</html>