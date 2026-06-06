@extends('layouts.admin')

@section('title', 'Gestion des contrats')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --radius-md: 16px;
        --radius-full: 9999px;
    }
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 30px; flex-wrap: wrap; gap: 20px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 30px; font-weight: 700; color: var(--dark);
    }
    .page-title i { color: var(--primary); }
    .page-subtitle { color: var(--gray-600); font-size: 15px; }

    .filter-bar {
        display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; align-items: center;
    }
    .filter-bar select, .filter-bar input {
        padding: 8px 14px; border: 1px solid var(--gray-200); border-radius: var(--radius-full);
        font-size: 13px; background: var(--white); color: var(--dark);
    }
    .btn-filter {
        background: var(--primary); color: white; border: none; padding: 8px 18px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 13px; cursor: pointer;
    }

    .table-card {
        background: var(--white); border-radius: var(--radius-md);
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        overflow-x: auto;
    }
    .premium-table { width: 100%; border-collapse: collapse; min-width: 700px; }
    .premium-table th {
        background: var(--gray-50); padding: 14px 20px; font-size: 11px;
        color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .premium-table td {
        padding: 14px 20px; border-bottom: 1px solid var(--gray-100);
        font-size: 14px; color: var(--dark);
    }
    .premium-table tr:last-child td { border-bottom: none; }
    .premium-table tr:hover td { background: var(--gray-50); }

    .badge-expired { background: #FEE2E2; color: #991B1B; padding: 4px 12px; border-radius: var(--radius-full); font-size: 12px; font-weight: 600; }
    .badge-active { background: #DCFCE7; color: #166534; padding: 4px 12px; border-radius: var(--radius-full); font-size: 12px; font-weight: 600; }
    .badge-expiring { background: #FEF3C7; color: #92400E; padding: 4px 12px; border-radius: var(--radius-full); font-size: 12px; font-weight: 600; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-file-contract"></i> Gestion des contrats</h1>
        <p class="page-subtitle">Suivez les contrats de vos employés</p>
    </div>
</div>

{{-- Filtres --}}
<form method="GET" action="{{ route('admin.contracts.index') }}" class="filter-bar animate-in delay-1">
    <select name="expiring_within">
        <option value="">Tous les contrats</option>
        <option value="30" {{ request('expiring_within') == 30 ? 'selected' : '' }}>Expire dans 30 jours</option>
        <option value="60" {{ request('expiring_within') == 60 ? 'selected' : '' }}>Expire dans 60 jours</option>
        <option value="90" {{ request('expiring_within') == 90 ? 'selected' : '' }}>Expire dans 90 jours</option>
    </select>
    <select name="status">
        <option value="">Tous les statuts</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
        <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminé</option>
    </select>
    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filtrer</button>
</form>

<div class="table-card animate-in delay-1">
    @if($employees->count())
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Type de contrat</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
               @php
                    $now = now()->startOfDay();
                    $endDate = $emp->contract_end_date ? \Carbon\Carbon::parse($emp->contract_end_date)->startOfDay() : null;
                    $isExpired  = $endDate && $endDate->isPast();
                    $isExpiring = $endDate
                                && !$isExpired
                                && $endDate->between(
                                    $now->copy()->addDay(),               // demain (on ignore aujourd'hui)
                                    $now->copy()->addDays(30)->endOfDay() // dans 30 jours fin de journée
                                );
                @endphp
                <tr>
                    <td style="font-weight:600;">{{ $emp->user->name }}</td>
                    <td>{{ $emp->contract_type ?? '—' }}</td>
                    <td>{{ $emp->hire_date ? \Carbon\Carbon::parse($emp->hire_date)->format('d/m/Y') : '—' }}</td>
                    <td>
                        {{ $emp->contract_end_date ? \Carbon\Carbon::parse($emp->contract_end_date)->format('d/m/Y') : '—' }}
                        @if($isExpired)
                            <span class="badge-expired">Expiré</span>
                        @elseif($isExpiring)
                            <span class="badge-expiring">Expire bientôt</span>
                        @endif
                    </td>
                    <td>
                        @if($emp->status === 'active')
                            <span class="badge-active">En cours</span>
                        @else
                            <span class="badge-expired">Terminé</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.employees.edit', $emp) }}" class="btn-filter" style="text-decoration:none;">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding: 0 20px 20px;">{{ $employees->links() }}</div>
    @else
        <div style="text-align:center; padding:60px; color:var(--gray-600);">
            <i class="fas fa-file-contract" style="font-size:48px; display:block; margin-bottom:16px; opacity:0.4;"></i>
            <p>Aucun contrat trouvé.</p>
        </div>
    @endif
</div>
@endsection