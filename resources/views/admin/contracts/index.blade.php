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
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 20px rgba(10,10,10,0.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,0.08);
        --radius-sm: 6px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s ease;
    }
    @keyframes fadeSlideUp {
        0%   { opacity: 0; transform: translateY(12px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-4px); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity: 0; }
    .delay-1 { animation-delay: 0.08s; }
    .delay-2 { animation-delay: 0.16s; }
    .delay-3 { animation-delay: 0.24s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 18px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 24px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 10px;
    }
    .page-title i { color: var(--primary); }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 8px 18px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: var(--transition-smooth); white-space: nowrap; border: none; cursor: pointer;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }

    /* ========= KPI (style bulletins) ========= */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }
    @media (max-width: 900px) { .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 480px) { .kpi-grid { grid-template-columns: 1fr; } }

    .kpi-card {
        background: white;
        border-radius: var(--radius-md);
        padding: 14px 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0;
        transition: var(--transition-smooth);
        pointer-events: none;
    }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .kpi-card:hover::before { opacity: 1; }

    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }
    .kpi-label {
        font-size: 10px;
        font-weight: 700;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .kpi-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        flex-shrink: 0;
        background: var(--gray-50);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }
    .kpi-card:hover .kpi-icon {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }
    .kpi-value {
        font-size: clamp(18px, 3vw, 26px);
        font-weight: 700;
        color: var(--dark);
        line-height: 1.2;
        margin-bottom: 6px;
        position: relative;
        z-index: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .kpi-footer {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        color: var(--gray-600);
        padding-top: 6px;
        border-top: 1px solid var(--gray-100);
        position: relative;
        z-index: 1;
    }
    .trend-pill {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 3px 8px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 10px;
        white-space: nowrap;
    }
    .trend-success { background: rgba(16,185,129,.1); color: #10B981; }
    .trend-warning { background: rgba(245,158,11,.1);  color: #F59E0B; }
    .trend-info    { background: rgba(59,130,246,.1);  color: #3B82F6; }
    .trend-danger   { background: rgba(239,68,68,.1);  color: #EF4444; }

    /* ========= FILTRE ========= */
    .filter-bar {
        display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
        margin-bottom: 16px;
    }
    .filter-bar input[type="text"],
    .filter-bar select {
        padding: 8px 14px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-full); font-size: 13px;
        background: var(--gray-50); color: var(--dark); outline: none;
        font-family: 'Cabinet Grotesk', sans-serif; transition: border-color 0.2s;
    }
    .filter-bar input[type="text"]:focus,
    .filter-bar select:focus {
        border-color: var(--primary); background: white;
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    .filter-bar select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%236B7280' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
        padding-right: 32px;
    }
    .btn-filter {
        padding: 8px 18px; border-radius: var(--radius-full); font-size: 13px;
        font-weight: 600; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; box-shadow: 0 4px 10px rgba(255,98,0,0.2);
        transition: var(--transition-smooth); white-space: nowrap;
    }
    .btn-filter:hover { transform: translateY(-1px); box-shadow: 0 6px 16px var(--primary-glow); }
    .btn-reset {
        background: var(--white); color: var(--dark); border: 1px solid var(--gray-200);
        padding: 8px 18px; border-radius: var(--radius-full); font-weight: 600; font-size: 13px;
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        transition: var(--transition-smooth);
    }
    .btn-reset:hover { background: var(--gray-50); border-color: var(--primary); }

    /* ========= CONTRACTS GRID ========= */
    .contracts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 16px;
    }
    .contract-card {
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        padding: 18px 20px;
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .contract-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        border-color: var(--primary-light);
    }
    .contract-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .employee-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .avatar {
        width: 44px; height: 44px; border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), #FF3D00);
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px; text-transform: uppercase;
    }
    .employee-details h4 {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 16px; font-weight: 700; color: var(--dark); margin: 0 0 2px;
    }
    .employee-details .position {
        font-size: 12px; color: var(--gray-600);
    }
    .badge-status {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 12px; border-radius: var(--radius-full);
        font-size: 11px; font-weight: 600;
    }
    .badge-active { background: #DCFCE7; color: #166534; }
    .badge-expired { background: #FEE2E2; color: #991B1B; }
    .badge-terminated { background: #F3F4F6; color: #4B5563; }

    .contract-details {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px 20px;
        font-size: 12px;
    }
    .contract-details span {
        display: flex; align-items: center; gap: 4px;
        color: var(--gray-600);
    }
    .contract-details strong { color: var(--dark); }

    /* Jauge d'expiration */
    .gauge-section {
        margin-top: 6px;
    }
    .gauge-header {
        display: flex; justify-content: space-between; align-items: center;
        font-size: 11px; margin-bottom: 4px;
    }
    .gauge-header .remaining { color: var(--gray-600); }
    .gauge-header .percent { font-weight: 600; }
    .progress-bar {
        height: 6px; background: var(--gray-200); border-radius: 3px;
        overflow: hidden; width: 100%;
    }
    .progress-fill {
        height: 100%; border-radius: 3px;
        transition: width 0.5s ease;
    }
    .progress-fill.high { background: #10B981; }
    .progress-fill.medium { background: #F59E0B; }
    .progress-fill.low { background: #EF4444; }

    .card-actions {
        display: flex; gap: 8px; justify-content: flex-end;
        border-top: 1px solid var(--gray-100); padding-top: 10px; margin-top: auto;
    }
    .action-btn {
        width: 34px; height: 34px; display: inline-flex; align-items: center;
        justify-content: center; border-radius: 8px; background: transparent;
        color: var(--gray-600); border: 1px solid var(--gray-200);
        cursor: pointer; transition: 0.2s; text-decoration: none; font-size: 14px;
    }
    .action-btn:hover { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }

    .pagination-wrap { margin-top: 20px; display: flex; justify-content: center; }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-file-contract"></i> Gestion des <span style="color:var(--primary);">contrats</span>
    </h1>
    <a href="{{ route('admin.employees.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nouveau contrat
    </a>
</div>

{{-- KPI --}}
<div class="kpi-grid animate-in delay-1">
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Total contrats</span>
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
        </div>
        <div class="kpi-value">{{ $employees->total() }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-info"><i class="fas fa-database"></i> Tous types</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Actifs</span>
            <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="kpi-value">{{ $active }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-success"><i class="fas fa-check"></i> En cours</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Expirent bientôt</span>
            <div class="kpi-icon"><i class="fas fa-clock"></i></div>
        </div>
        <div class="kpi-value">{{ $expiring }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-warning"><i class="fas fa-exclamation"></i> 30 jours</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Expirés</span>
            <div class="kpi-icon"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
        <div class="kpi-value">{{ $expired }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-danger"><i class="fas fa-times"></i> Action requise</span>
        </div>
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

{{-- Liste des contrats --}}
<div class="contracts-grid animate-in delay-3">
    @forelse($employees as $emp)
        @php
            $now = \Carbon\Carbon::now()->startOfDay();
            $endDate = $emp->contract_end_date ? \Carbon\Carbon::parse($emp->contract_end_date)->startOfDay() : null;
            $startDate = $emp->hire_date ? \Carbon\Carbon::parse($emp->hire_date)->startOfDay() : null;

            // Calcul de la jauge seulement si date de début et de fin existent et contrat non terminé
            $gaugePercent = null;
            $gaugeLabel = '';
            $gaugeColor = '';
            if ($startDate && $endDate && $emp->status === 'active') {
                $totalDuration = $startDate->diffInDays($endDate) ?: 1;
                $elapsed = $startDate->diffInDays($now);
                $remainingPercent = max(0, min(100, 100 - ($elapsed / $totalDuration) * 100));
                $gaugePercent = round($remainingPercent);
                $daysRemaining = $now->diffInDays($endDate, false);
                if ($daysRemaining <= 0) {
                    $gaugeLabel = 'Expiré';
                    $gaugeColor = 'low';
                    $gaugePercent = 0;
                } elseif ($daysRemaining <= 30) {
                    $gaugeLabel = "Expire dans $daysRemaining j";
                    $gaugeColor = $daysRemaining <= 15 ? 'low' : 'medium';
                } else {
                    $gaugeLabel = "Expire dans $daysRemaining j";
                    $gaugeColor = 'high';
                }
            } elseif ($emp->status === 'active' && !$endDate) {
                // CDI ou sans date de fin : pas de jauge
                $gaugePercent = null;
            } elseif ($emp->status !== 'active') {
                $gaugePercent = null;
            }
        @endphp
        <div class="contract-card">
            <div class="contract-top">
                <div class="employee-info">
                    <div class="avatar">{{ strtoupper(substr($emp->user->name, 0, 2)) }}</div>
                    <div class="employee-details">
                        <h4>{{ $emp->user->name }}</h4>
                        <div class="position">{{ $emp->position ?? 'Poste non défini' }}</div>
                    </div>
                </div>
                <span class="badge-status {{ $emp->status === 'active' ? 'badge-active' : 'badge-terminated' }}">
                    {{ $emp->status === 'active' ? 'Actif' : 'Terminé' }}
                </span>
            </div>

            <div class="contract-details">
                <span><i class="fas fa-file-signature"></i> <strong>{{ $emp->contract_type ?? '—' }}</strong></span>
                <span><i class="fas fa-calendar-plus"></i> Début : <strong>{{ $startDate ? $startDate->format('d/m/Y') : '—' }}</strong></span>
                <span><i class="fas fa-calendar-times"></i> Fin : <strong>{{ $endDate ? $endDate->format('d/m/Y') : '—' }}</strong></span>
            </div>

            @if(isset($gaugePercent))
            <div class="gauge-section">
                <div class="gauge-header">
                    <span class="remaining">{{ $gaugeLabel }}</span>
                    <span class="percent" style="color: {{ $gaugeColor === 'high' ? '#10B981' : ($gaugeColor === 'medium' ? '#F59E0B' : '#EF4444') }}">
                        {{ $gaugePercent }}%
                    </span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill {{ $gaugeColor }}" style="width: {{ $gaugePercent }}%;"></div>
                </div>
            </div>
            @endif

            <div class="card-actions">
                <a href="{{ route('admin.employees.edit', $emp) }}" class="action-btn" title="Modifier le contrat">
                    <i class="fas fa-pen"></i>
                </a>
                <a href="{{ route('admin.employees.show', $emp) }}" class="action-btn" title="Voir le profil">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; color: var(--gray-600);">
            <i class="fas fa-file-contract" style="font-size:48px; display:block; margin-bottom:16px; opacity:0.4;"></i>
            <p>Aucun contrat trouvé.</p>
        </div>
    @endforelse
</div>

<div class="pagination-wrap animate-in delay-3">
    {{ $employees->links() }}
</div>
@endsection