@extends('layouts.admin')

@section('title', 'Gestion des contrats')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --primary-glow: rgba(255,98,0,0.25);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 1px 3px rgba(10,10,10,0.06);
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,0.08);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition: 0.2s ease;
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(15px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 24px; flex-wrap: wrap; gap: 16px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 28px; font-weight: 700; color: var(--dark);
        display: flex; align-items: center; gap: 10px;
    }
    .page-title i { color: var(--primary); }
    .page-subtitle { color: var(--gray-600); font-size: 14px; margin-top: 4px; }

    .btn-primary {
        background: var(--primary); color: white; padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; border: none; cursor: pointer; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(255,98,0,0.2);
        transition: var(--transition);
    }
    .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); }

    /* ========== BENTO CARDS ========== */
    .bento-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px; margin-bottom: 24px;
    }
    .bento-card {
        background: var(--white); border-radius: var(--radius-md); padding: 20px 24px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition);
        display: flex; flex-direction: column; justify-content: space-between;
    }
    .bento-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0; transition: var(--transition);
    }
    .bento-card:hover {
        transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary);
    }
    .bento-card:hover::before { opacity: 1; }
    .bento-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 12px; position: relative; z-index: 1;
    }
    .bento-label {
        font-size: 12px; font-weight: 600; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.3px;
    }
    .bento-icon {
        width: 40px; height: 40px; border-radius: var(--radius-sm);
        background: var(--gray-50); color: var(--dark);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; transition: var(--transition); border: 1px solid var(--gray-200);
    }
    .bento-card:hover .bento-icon {
        background: var(--primary); color: white; border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }
    .bento-body { position: relative; z-index: 1; }
    .bento-value {
        font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700;
        color: var(--dark); line-height: 1; margin: 0 0 6px 0;
    }
    .bento-footer {
        display: flex; align-items: center; gap: 8px; font-size: 11px; color: var(--gray-600);
        padding-top: 10px; border-top: 1px solid var(--gray-100); position: relative; z-index: 1;
    }

    /* ========== FILTER BAR ========== */
    .filter-bar {
        display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
        margin-bottom: 20px;
    }
    .filter-bar input[type="text"],
    .filter-bar select {
        padding: 8px 14px; border: 1px solid var(--gray-200); border-radius: var(--radius-full);
        font-size: 13px; background: var(--white); color: var(--dark); outline: none;
        font-family: 'Cabinet Grotesk', sans-serif; transition: border-color var(--transition);
    }
    .filter-bar input[type="text"]:focus,
    .filter-bar select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); }
    .filter-bar select {
        appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%236B7280' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center; padding-right: 32px;
    }
    .btn-filter {
        background: var(--primary); color: white; border: none; padding: 8px 18px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 13px; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px; transition: var(--transition);
    }
    .btn-filter:hover { background: var(--primary-hover); }
    .btn-reset {
        background: var(--white); color: var(--dark); border: 1px solid var(--gray-200);
        padding: 8px 18px; border-radius: var(--radius-full); font-weight: 600; font-size: 13px;
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        transition: var(--transition);
    }
    .btn-reset:hover { background: var(--gray-50); }

    /* ========== PREMIUM TABLE ========== */
    .table-card {
        background: var(--white); border-radius: var(--radius-md);
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        overflow-x: auto; overflow-y: hidden;
    }
    .premium-table { width: 100%; border-collapse: collapse; min-width: 750px; }
    .premium-table th {
        background: var(--gray-50); padding: 14px 20px; font-size: 10.5px; font-weight: 600;
        color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.8px;
        border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .premium-table td {
        padding: 14px 20px; border-bottom: 1px solid var(--gray-100);
        font-size: 14px; color: var(--dark); vertical-align: middle;
    }
    .premium-table tr:last-child td { border-bottom: none; }
    .premium-table tbody tr { transition: background var(--transition); }
    .premium-table tbody tr:hover td { background: rgba(255,98,0,0.03); }

    .badge {
        display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px;
        border-radius: var(--radius-full); font-size: 12px; font-weight: 600;
    }
    .badge-active { background: #DCFCE7; color: #166534; }
    .badge-expired { background: #FEE2E2; color: #991B1B; }
    .badge-expiring { background: #FEF3C7; color: #92400E; }
    .badge-terminated { background: #F3F4F6; color: #4B5563; }

    .action-btn {
        display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px;
        border-radius: var(--radius-full); background: var(--primary); color: white;
        font-size: 12px; font-weight: 600; text-decoration: none; transition: var(--transition);
    }
    .action-btn:hover { background: var(--primary-hover); }

    .empty-state { text-align: center; padding: 60px 20px; color: var(--gray-600); }
    .pagination-wrap { margin-top: 20px; display: flex; justify-content: center; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-file-contract"></i> Gestion des contrats</h1>
        <p class="page-subtitle">Suivez les contrats de vos employés</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nouveau contrat
    </a>
</div>

{{-- Bento Grid KPI --}}
<div class="bento-grid animate-in delay-1">
    <div class="bento-card">
        <div>
            <div class="bento-header">
                <span class="bento-label">Total contrats</span>
                <div class="bento-icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $employees->total() }}</h2>
            </div>
        </div>
        <div class="bento-footer">Tous types confondus</div>
    </div>
    <div class="bento-card">
        <div>
            <div class="bento-header">
                <span class="bento-label">Actifs</span>
                <div class="bento-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $active }}</h2>
            </div>
        </div>
        <div class="bento-footer">Contrats en cours</div>
    </div>
    <div class="bento-card">
        <div>
            <div class="bento-header">
                <span class="bento-label">Expirent bientôt</span>
                <div class="bento-icon"><i class="fas fa-clock"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $expiring }}</h2>
            </div>
        </div>
        <div class="bento-footer">Dans les 30 jours</div>
    </div>
    <div class="bento-card">
        <div>
            <div class="bento-header">
                <span class="bento-label">Expirés</span>
                <div class="bento-icon"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $expired }}</h2>
            </div>
        </div>
        <div class="bento-footer">Action requise</div>
    </div>
</div>

{{-- Filtres --}}
<form method="GET" action="{{ route('admin.contracts.index') }}" class="filter-bar animate-in delay-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un employé…">
    <select name="expiring_within">
        <option value="">Toutes les échéances</option>
        <option value="30"  {{ request('expiring_within') == 30  ? 'selected' : '' }}>Expire dans 30 jours</option>
        <option value="60"  {{ request('expiring_within') == 60  ? 'selected' : '' }}>Expire dans 60 jours</option>
        <option value="90"  {{ request('expiring_within') == 90  ? 'selected' : '' }}>Expire dans 90 jours</option>
    </select>
    <select name="status">
        <option value="">Tous les statuts</option>
        <option value="active"     {{ request('status') == 'active'     ? 'selected' : '' }}>Actif</option>
        <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminé</option>
    </select>
    <select name="contract_type">
        <option value="">Tous les types</option>
        <option value="CDI"   {{ request('contract_type') == 'CDI'   ? 'selected' : '' }}>CDI</option>
        <option value="CDD"   {{ request('contract_type') == 'CDD'   ? 'selected' : '' }}>CDD</option>
        <option value="Stage" {{ request('contract_type') == 'Stage' ? 'selected' : '' }}>Stage</option>
    </select>
    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filtrer</button>
    @if(request()->anyFilled(['search','expiring_within','status','contract_type']))
        <a href="{{ route('admin.contracts.index') }}" class="btn-reset"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</form>

{{-- Tableau --}}
<div class="table-card animate-in delay-3">
    @if($employees->count())
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Type</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
                @php
                    $now = now()->startOfDay();
                    $endDate = $emp->contract_end_date ? \Carbon\Carbon::parse($emp->contract_end_date)->startOfDay() : null;
                    $isExpired  = $endDate && $endDate->isPast();
                    $isExpiring = $endDate && !$isExpired
                        && $endDate->between($now->copy()->addDay(), $now->copy()->addDays(30)->endOfDay());
                @endphp
                <tr>
                    <td style="font-weight:600;">{{ $emp->user->name }}</td>
                    <td>{{ $emp->contract_type ?? '—' }}</td>
                    <td>{{ $emp->hire_date ? \Carbon\Carbon::parse($emp->hire_date)->format('d/m/Y') : '—' }}</td>
                    <td>
                        {{ $endDate ? $endDate->format('d/m/Y') : '—' }}
                        @if($isExpired)
                            <span class="badge badge-expired" style="margin-left:6px;">Expiré</span>
                        @elseif($isExpiring)
                            <span class="badge badge-expiring" style="margin-left:6px;">Expire bientôt</span>
                        @endif
                    </td>
                    <td>
                        @if($emp->status === 'active')
                            <span class="badge badge-active">En cours</span>
                        @else
                            <span class="badge badge-terminated">Terminé</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.employees.edit', $emp) }}" class="action-btn">
                            <i class="fas fa-pen"></i> Modifier
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $employees->links() }}</div>
    @else
        <div class="empty-state">
            <i class="fas fa-file-contract" style="font-size:48px; display:block; margin-bottom:16px; opacity:0.4;"></i>
            <p>Aucun contrat trouvé.</p>
        </div>
    @endif
</div>
@endsection