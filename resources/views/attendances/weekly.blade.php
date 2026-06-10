@extends('layouts.admin')

@section('title', 'Récapitulatif hebdomadaire')

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
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
    .page-subtitle { color: var(--gray-600); font-size: 13px; margin: 0; }

    /* KPI */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px;
    }
    @media (max-width: 700px) { .kpi-grid { grid-template-columns: 1fr; } }

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

    /* Content grid */
    .content-grid {
        display: grid; grid-template-columns: 1fr 240px; gap: 16px; align-items: start;
    }
    @media (max-width: 850px) { .content-grid { grid-template-columns: 1fr; } }

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
        padding: 3px 10px; border-radius: var(--radius-full); font-size: 11px; font-weight: 700;
    }
    .compact-table {
        width: 100%; border-collapse: collapse; min-width: 400px;
    }
    .compact-table th {
        background: var(--gray-50); padding: 10px 14px; font-size: 10px;
        font-weight: 700; color: var(--gray-600); text-transform: uppercase;
        letter-spacing: 0.4px; border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .compact-table td {
        padding: 10px 14px; border-bottom: 1px solid var(--gray-100);
        font-size: 13px; color: var(--dark); vertical-align: middle;
    }
    .compact-table tr:last-child td { border-bottom: none; }
    .compact-table tbody tr:hover td { background: var(--gray-50); }

    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;
    }
    .badge-present { background: #DCFCE7; color: #166534; }
    .badge-late { background: #FEE2E2; color: #991B1B; }

    .empty-state { text-align: center; padding: 30px 20px; color: var(--gray-600); font-size: 13px; }
    .empty-state i { font-size: 30px; opacity: 0.4; display: block; margin-bottom: 8px; }

    /* Guide */
    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        position: sticky; top: 80px;
    }
    .guide-card h4 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h4 i { color: var(--primary); }
    .guide-item { display: flex; gap: 8px; margin-bottom: 10px; font-size: 12px; }
    .guide-icon {
        width: 28px; height: 28px; border-radius: 6px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 13px; display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }

    .btn-outline {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--white); color: var(--dark); padding: 8px 18px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 13px;
        border: 1px solid var(--gray-200); text-decoration: none; transition: var(--transition-smooth);
        margin-top: 16px;
    }
    .btn-outline:hover { background: var(--gray-50); border-color: var(--primary); }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-calendar-week" style="color:var(--primary);"></i> Récapitulatif
        </h1>
        <p class="page-subtitle">Semaine du {{ $startOfWeek->format('d/m') }} au {{ $endOfWeek->format('d/m/Y') }}</p>
    </div>
</div>

{{-- KPIs --}}
<div class="kpi-grid">
    <div class="kpi-card animate-in delay-1">
        <div class="kpi-header">
            <span class="kpi-label">Jours pointés</span>
            <div class="kpi-icon"><i class="fas fa-calendar-check"></i></div>
        </div>
        <div class="kpi-value">{{ $attendances->count() }}</div>
        <div class="kpi-footer"><i class="fas fa-arrow-up" style="color:#10B981;"></i> Cette semaine</div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">À l'heure</span>
            <div class="kpi-icon"><i class="fas fa-clock"></i></div>
        </div>
        <div class="kpi-value">{{ $totalPresent }}</div>
        <div class="kpi-footer"><i class="fas fa-check" style="color:#10B981;"></i> Sans retard</div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">Retards</span>
            <div class="kpi-icon"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
        <div class="kpi-value">{{ $totalLate }}</div>
        <div class="kpi-footer">
            @if($totalLate > 0)
                <i class="fas fa-exclamation" style="color:#EF4444;"></i> Retard(s)
            @else
                <i class="fas fa-check" style="color:#10B981;"></i> Aucun
            @endif
        </div>
    </div>
</div>

{{-- Tableau + Guide --}}
<div class="content-grid">
    <div class="table-card animate-in delay-2">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> Détail des pointages</h3>
            <span class="table-count">{{ $attendances->count() }} jour(s)</span>
        </div>
        @if($attendances->count())
            <div style="overflow-x:auto;">
                <table class="compact-table">
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
                            <td style="font-weight:600;">{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                            <td>{{ $att->check_in }}</td>
                            <td>{{ $att->check_out ?? '—' }}</td>
                            <td>
                                @if($att->status == 'late')
                                    <span class="badge badge-late"><i class="fas fa-exclamation-triangle"></i> Retard</span>
                                @else
                                    <span class="badge badge-present"><i class="fas fa-check-circle"></i> Présent</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i> Aucun pointage cette semaine.
            </div>
        @endif
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Résumé</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="guide-text">
                <strong>Jours pointés</strong>
                <p>Nombre de jours avec une présence enregistrée.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-clock"></i></div>
            <div class="guide-text">
                <strong>À l'heure / Retards</strong>
                <p>Retard = arrivée après 08:30.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-history"></i></div>
            <div class="guide-text">
                <strong>Historique complet</strong>
                <p>Disponible via le bouton ci-dessous.</p>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('attendances.history') }}" class="btn-outline animate-in delay-2">
    <i class="fas fa-history"></i> Voir tout l'historique
</a>
@endsection