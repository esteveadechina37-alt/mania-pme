@extends('layouts.admin')

@section('title', 'Mes demandes de congés')

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
    .delay-3 { animation-delay:0.24s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 24px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 13px; margin: 0; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 8px 18px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: var(--transition-smooth); white-space: nowrap; border: none; cursor: pointer;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }

    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981; border-radius: 8px;
        padding: 10px 14px; margin-bottom: 16px; color: #065F46;
        display: flex; align-items: center; gap: 8px; font-size: 13px;
    }

    /* KPIs */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px;
    }
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

    /* Filter */
    .filter-bar {
        display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
        margin-bottom: 16px; background: var(--white); padding: 10px 14px;
        border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
    }
    .filter-bar form {
        display: flex; gap: 8px; flex-wrap: wrap; align-items: center; width: 100%;
    }
    .filter-select {
        padding: 7px 12px; border: 1px solid var(--gray-200); border-radius: var(--radius-full);
        font-size: 13px; background: var(--gray-50); color: var(--dark); outline: none;
        transition: 0.2s; min-width: 140px;
    }
    .filter-select:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 3px var(--primary-light); }
    .filter-btn {
        background: var(--primary); color: white; border: none; padding: 7px 18px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 13px; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;
    }
    .filter-btn:hover { background: var(--primary-hover); }
    .reset-btn {
        background: var(--white); color: var(--dark); border: 1px solid var(--gray-200);
        padding: 7px 16px; border-radius: var(--radius-full); font-weight: 600; font-size: 13px;
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;
    }
    .reset-btn:hover { background: var(--gray-50); border-color: var(--primary); }

    /* Table */
    .table-card {
        background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200); overflow: hidden;
    }
    .compact-table {
        width: 100%; border-collapse: collapse; min-width: 600px;
    }
    .compact-table th {
        background: var(--gray-50); padding: 10px 16px; font-size: 11px; font-weight: 600;
        color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.3px;
        border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .compact-table td {
        padding: 12px 16px; border-bottom: 1px solid var(--gray-100);
        font-size: 13px; color: var(--dark); vertical-align: middle;
    }
    .compact-table tr:last-child td { border-bottom: none; }
    .compact-table tbody tr:hover td { background: var(--gray-50); }

    .badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600;
    }
    .badge-pending { background: #FEF3C7; color: #92400E; }
    .badge-approved { background: #DCFCE7; color: #166534; }
    .badge-rejected { background: #FEE2E2; color: #991B1B; }

    .action-btn {
        width: 34px; height: 34px; display: inline-flex; align-items: center;
        justify-content: center; border-radius: 8px; background: transparent;
        color: var(--gray-600); border: 1px solid var(--gray-200);
        cursor: pointer; transition: 0.2s; text-decoration: none; font-size: 14px;
    }
    .action-btn:hover { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }

    .empty-state { text-align: center; padding: 50px 20px; color: var(--gray-600); }
    .empty-state i { font-size: 44px; display: block; margin-bottom: 12px; opacity: 0.4; }

    /* Layout */
    .content-grid {
        display: grid; grid-template-columns: 1fr 240px; gap: 16px; align-items: start;
    }
    @media (max-width: 850px) { .content-grid { grid-template-columns: 1fr; } }
    .guide-card {
        background: var(--white); border-radius: var(--radius-md); padding: 16px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: sticky; top: 80px;
    }
    .guide-card h3 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0 0 12px; display: flex; align-items: center; gap: 8px;
    }
    .guide-card h3 i { color: var(--primary); }
    .guide-item { display: flex; gap: 8px; margin-bottom: 12px; font-size: 12px; }
    .guide-icon {
        width: 28px; height: 28px; border-radius: 6px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 13px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 13px; display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-clipboard-list" style="color:var(--primary);"></i>
            Consulter mes demandes
        </h1>
        <p class="page-subtitle">Suivez vos demandes de congé</p>
    </div>
    <a href="{{ route('leave-requests.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i> Nouvelle demande
    </a>
</div>

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- KPIs --}}
<div class="kpi-grid">
    <div class="kpi-card animate-in delay-1">
        <div class="kpi-header">
            <span class="kpi-label">Total demandes</span>
            <div class="kpi-icon"><i class="fas fa-clipboard-list"></i></div>
        </div>
        <div class="kpi-value">{{ $totalRequests ?? 0 }}</div>
        <div class="kpi-footer"><i class="fas fa-archive" style="color:var(--primary);"></i> Toutes</div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">En attente</span>
            <div class="kpi-icon"><i class="fas fa-clock"></i></div>
        </div>
        <div class="kpi-value">{{ $pendingCount ?? 0 }}</div>
        <div class="kpi-footer"><i class="fas fa-hourglass-half" style="color:#F59E0B;"></i> À traiter</div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">Approuvées</span>
            <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="kpi-value">{{ $approvedCount ?? 0 }}</div>
        <div class="kpi-footer"><i class="fas fa-check" style="color:#10B981;"></i> Validées</div>
    </div>
</div>

{{-- Filtre --}}
<div class="filter-bar animate-in delay-1">
    <form method="GET" action="{{ route('leave-requests.index') }}">
        <select name="status" class="filter-select">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusé</option>
        </select>
        <select name="leave_type_id" class="filter-select">
            <option value="">Tous les types</option>
            @foreach($leaveTypes as $lt)
                <option value="{{ $lt->id }}" {{ request('leave_type_id') == $lt->id ? 'selected' : '' }}>{{ $lt->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="filter-btn"><i class="fas fa-filter"></i> Filtrer</button>
        @if(request()->anyFilled(['status','leave_type_id']))
            <a href="{{ route('leave-requests.index') }}" class="reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
        @endif
    </form>
</div>

<div class="content-grid">
    {{-- Tableau --}}
    <div class="table-card animate-in delay-2">
        @if($requests->count())
            <div style="overflow-x:auto;">
                <table class="compact-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Dates</th>
                            <th>Statut</th>
                            <th>Approbateur</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td style="font-weight:600;">{{ $req->leaveType->name }}</td>
                            <td>{{ $req->start_date->format('d/m/Y') }} - {{ $req->end_date->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $status = $req->status;
                                    if ($status === 'approved') { $badgeClass = 'badge-approved'; $icon = 'fa-check-circle'; $label = 'Approuvé'; }
                                    elseif ($status === 'rejected') { $badgeClass = 'badge-rejected'; $icon = 'fa-times-circle'; $label = 'Refusé'; }
                                    else { $badgeClass = 'badge-pending'; $icon = 'fa-clock'; $label = 'En attente'; }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="fas {{ $icon }}"></i> {{ $label }}
                                </span>
                            </td>
                            <td>{{ $req->approver?->name ?? '—' }}</td>
                            <td style="text-align:right;">
                                <a href="{{ route('leave-requests.show', $req) }}" class="action-btn" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding: 12px 16px;">
                {{ $requests->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p style="font-weight:500;">Aucune demande trouvée.</p>
            </div>
        @endif
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-2">
        <h3><i class="fas fa-lightbulb"></i> Guide</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-plus-circle"></i></div>
            <div class="guide-text">
                <strong>Nouvelle demande</strong>
                <p>Soumettez un congé en quelques clics.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-clock"></i></div>
            <div class="guide-text">
                <strong>Suivi</strong>
                <p>Votre manager est notifié automatiquement.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-history"></i></div>
            <div class="guide-text">
                <strong>Historique</strong>
                <p>Retrouvez toutes vos demandes passées.</p>
            </div>
        </div>
    </div>
</div>
@endsection