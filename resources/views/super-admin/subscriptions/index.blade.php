@extends('layouts.admin')

@section('title', 'Abonnements')

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
        0% { opacity:0; transform:translateY(12px); }
        100% { opacity:1; transform:translateY(0); }
    }
    @keyframes float {
        0%,100% { transform:translateY(0); }
        50% { transform:translateY(-4px); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.08s; }
    .delay-2 { animation-delay:0.16s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 24px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }

    /* KPI */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 16px;
    }
    @media (max-width: 1000px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .kpi-grid { grid-template-columns: 1fr; } }

    .kpi-card {
        background: var(--white); border-radius: var(--radius-md); padding: 14px 18px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
        display: flex; flex-direction: column; justify-content: space-between;
    }
    .kpi-card::before {
        content:''; position:absolute; inset:0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity:0; transition: var(--transition-smooth);
    }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .kpi-card:hover::before { opacity:1; }
    .kpi-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; z-index:1; }
    .kpi-label { font-size:11px; font-weight:600; color:var(--gray-600); text-transform:uppercase; letter-spacing:0.4px; }
    .kpi-icon {
        width:36px; height:36px; border-radius:8px; background:var(--gray-50);
        display:flex; align-items:center; justify-content:center; font-size:17px;
        transition: var(--transition-smooth); border:1px solid var(--gray-200);
    }
    .kpi-card:hover .kpi-icon { background:var(--primary); color:white; border-color:var(--primary); animation:float 2s ease-in-out infinite; }
    .kpi-value { font-family:'Clash Display',sans-serif; font-size:32px; font-weight:700; color:var(--dark); line-height:1; margin-bottom:6px; }
    .kpi-footer { font-size:11px; color:var(--gray-600); padding-top:8px; border-top:1px solid var(--gray-100); display:flex; align-items:center; gap:8px; }

    /* Table */
    .table-card {
        background: var(--white); border-radius: var(--radius-md);
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200); overflow: hidden;
    }
    .table-header {
        padding: 14px 18px; border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; justify-content: space-between;
    }
    .table-header h3 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .table-header h3 i { color: var(--primary); }
    .table-count {
        background: var(--primary-light); color: var(--primary);
        padding: 3px 10px; border-radius: var(--radius-full);
        font-size: 11px; font-weight: 700;
    }
    .compact-table {
        width: 100%; border-collapse: collapse; min-width: 600px;
    }
    .compact-table th {
        background: var(--gray-50); padding: 10px 16px; font-size: 10px;
        font-weight: 700; color: var(--gray-600); text-transform: uppercase;
        letter-spacing: 0.4px; border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .compact-table td {
        padding: 12px 16px; border-bottom: 1px solid var(--gray-100);
        font-size: 13px; color: var(--dark); vertical-align: middle;
    }
    .compact-table tr:last-child td { border-bottom: none; }
    .compact-table tbody tr:hover td { background: var(--gray-50); }

    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;
    }
    .badge-active { background: #DCFCE7; color: #166534; }
    .badge-expired { background: #FEE2E2; color: #991B1B; }
    .badge-cancelled { background: #F3F4F6; color: #4B5563; }

    .btn-outline-sm {
        background: var(--white); color: var(--dark); padding: 6px 14px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 12px;
        border: 1px solid var(--gray-200); cursor: pointer; display: inline-flex;
        align-items: center; gap: 4px; transition: var(--transition-smooth);
    }
    .btn-outline-sm:hover { background: var(--gray-50); border-color: var(--primary); }

    .pagination-wrap { padding: 12px 16px; display: flex; justify-content: center; }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-file-invoice"></i> Abonnements
    </h1>
</div>

{{-- KPIs (calculés à la volée) --}}
@php
    $totalActive = $subscriptions->filter(fn($s) => $s->status === 'active')->count();
    $totalExpired = $subscriptions->filter(fn($s) => $s->status === 'expired')->count();
    $totalCancelled = $subscriptions->filter(fn($s) => $s->status === 'cancelled')->count();
@endphp

<div class="kpi-grid">
    <div class="kpi-card animate-in delay-1">
        <div class="kpi-header">
            <span class="kpi-label">Total abonnements</span>
            <div class="kpi-icon"><i class="fas fa-file-invoice"></i></div>
        </div>
        <div class="kpi-value">{{ $subscriptions->total() }}</div>
        <div class="kpi-footer"><i class="fas fa-layer-group" style="color:var(--primary);"></i> Tous</div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">Actifs</span>
            <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="kpi-value">{{ $totalActive }}</div>
        <div class="kpi-footer"><i class="fas fa-check" style="color:#10B981;"></i> En cours</div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">Expirés</span>
            <div class="kpi-icon"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
        <div class="kpi-value">{{ $totalExpired }}</div>
        <div class="kpi-footer"><i class="fas fa-times" style="color:#EF4444;"></i> À renouveler</div>
    </div>
    <div class="kpi-card animate-in delay-4">
        <div class="kpi-header">
            <span class="kpi-label">Annulés</span>
            <div class="kpi-icon"><i class="fas fa-ban"></i></div>
        </div>
        <div class="kpi-value">{{ $totalCancelled }}</div>
        <div class="kpi-footer"><i class="fas fa-stop-circle" style="color:#6B7280;"></i> Résiliés</div>
    </div>
</div>

<div class="table-card animate-in delay-2">
    <div class="table-header">
        <h3><i class="fas fa-list"></i> Liste des abonnements</h3>
        <span class="table-count">{{ $subscriptions->total() }} abonnement(s)</span>
    </div>
    @if($subscriptions->count())
        <div style="overflow-x:auto;">
            <table class="compact-table">
                <thead>
                    <tr>
                        <th>Entreprise</th>
                        <th>Plan</th>
                        <th>Statut</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $sub)
                    <tr>
                        <td style="font-weight:600;">{{ $sub->company->name }}</td>
                        <td>{{ $sub->plan->name }}</td>
                        <td>
                            @if($sub->status === 'active')
                                <span class="badge badge-active"><i class="fas fa-check-circle"></i> Actif</span>
                            @elseif($sub->status === 'expired')
                                <span class="badge badge-expired"><i class="fas fa-clock"></i> Expiré</span>
                            @else
                                <span class="badge badge-cancelled"><i class="fas fa-ban"></i> Annulé</span>
                            @endif
                        </td>
                        <td>{{ $sub->starts_at?->format('d/m/Y') }}</td>
                        <td>{{ $sub->ends_at?->format('d/m/Y') ?? '—' }}</td>
                        <td style="text-align:right">
                            @if($sub->status == 'active')
                            <form action="{{ route('super-admin.subscriptions.cancel', $sub) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-outline-sm" onclick="return confirm('Annuler cet abonnement ?')">
                                    <i class="fas fa-times"></i> Annuler
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            {{ $subscriptions->links() }}
        </div>
    @else
        <div style="text-align:center; padding:40px; color:var(--gray-600);">
            <i class="fas fa-inbox" style="font-size:40px; display:block; margin-bottom:12px; opacity:0.4;"></i>
            Aucun abonnement trouvé.
        </div>
    @endif
</div>
@endsection