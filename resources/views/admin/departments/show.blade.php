@extends('layouts.admin')

@section('title', $department->name)

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255, 98, 0, 0.08);
        --primary-glow: rgba(255, 98, 0, 0.25);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-600: #6B7280;
        --gray-800: #1F2937;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 4px rgba(10, 10, 10, 0.02);
        --shadow-md: 0 8px 24px rgba(10, 10, 10, 0.05);
        --shadow-lg: 0 16px 40px rgba(255, 98, 0, 0.08);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(16px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    @keyframes glassShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }
    .animate-in { animation: fadeSlideUp 0.55s ease both; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 24px; flex-wrap: wrap; gap: 16px; position: relative;
    }
    .page-header::after {
        content: ''; position: absolute; top: -20px; left: 0;
        width: 150px; height: 150px; background: var(--primary-glow);
        filter: blur(80px); z-index: -1; pointer-events: none;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 28px; font-weight: 700; color: var(--dark);
        display: flex; align-items: center; gap: 10px; line-height: 1.2;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 14px; margin: 0; }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 10px 22px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.2); text-decoration: none;
        transition: var(--transition-smooth);
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }
    .btn-outline {
        background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        color: var(--dark); padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; border: 1px solid rgba(255,255,255,0.6);
        display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        transition: var(--transition-smooth); box-shadow: var(--shadow-sm);
    }
    .btn-outline:hover { background: white; border-color: var(--primary-glow); transform: translateY(-1px); }

    /* ========== KPI CARDS ========== */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 24px;
    }
    @media (max-width: 1000px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .kpi-grid { grid-template-columns: 1fr; } }

    .kpi-card {
        background: rgba(255,255,255,0.8); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border-radius: var(--radius-md); padding: 14px 18px;
        box-shadow: var(--shadow-md); border: 1px solid rgba(255,255,255,0.6);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
        display: flex; flex-direction: column; justify-content: space-between;
    }
    .kpi-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth);
    }
    .kpi-card::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.2) 30%, transparent 60%);
        background-size: 200% 100%; animation: glassShine 5s infinite;
        opacity: 0; transition: opacity 0.4s; pointer-events: none;
    }
    .kpi-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .kpi-card:hover::before { opacity: 1; }
    .kpi-card:hover::after { opacity: 1; }
    .kpi-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; z-index: 1; }
    .kpi-label { font-size: 11px; font-weight: 600; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.4px; }
    .kpi-icon {
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--gray-50); color: var(--dark);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; border: 1px solid var(--gray-200); transition: var(--transition-smooth);
    }
    .kpi-card:hover .kpi-icon {
        background: var(--primary); color: white; border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }
    .kpi-value { font-family: 'Clash Display', sans-serif; font-size: 28px; font-weight: 700; color: var(--dark); line-height: 1; margin-bottom: 6px; z-index: 1; }
    .kpi-footer { display: flex; align-items: center; gap: 6px; font-size: 10px; color: var(--gray-600); padding-top: 6px; border-top: 1px solid var(--gray-100); z-index: 1; }
    .trend-pill {
        display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 11px;
    }
    .trend-success { background: rgba(16,185,129,0.1); color: #10B981; }
    .trend-info { background: rgba(59,130,246,0.1); color: #3B82F6; }

    /* ========== DETAIL CARDS ========== */
    .detail-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 24px;
    }
    @media (max-width: 800px) { .detail-grid { grid-template-columns: 1fr; } }

    .glass-card {
        background: rgba(255,255,255,0.8); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border-radius: var(--radius-md); padding: 24px;
        box-shadow: var(--shadow-md); border: 1px solid rgba(255,255,255,0.6);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
    }
    .glass-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth);
    }
    .glass-card::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.2) 30%, transparent 60%);
        background-size: 200% 100%; animation: glassShine 5s infinite;
        opacity: 0; transition: opacity 0.4s; pointer-events: none;
    }
    .glass-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .glass-card:hover::before { opacity: 1; }
    .glass-card:hover::after { opacity: 1; }

    .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700; color: var(--dark);
        margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;
        position: relative; z-index: 1;
    }
    .card-title i { color: var(--primary); }

    .info-row {
        display: flex; align-items: center; gap: 14px; padding: 14px 0;
        border-bottom: 1px solid var(--gray-100); position: relative; z-index: 1;
    }
    .info-row:last-child { border-bottom: none; }
    .icon-circle {
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; flex-shrink: 0;
    }
    .badge-pill {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px;
        border-radius: var(--radius-full); font-size: 13px; font-weight: 600;
        background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;
    }

    /* Membres */
    .member-list {
        list-style: none; padding: 0; margin: 0;
        display: flex; flex-direction: column; gap: 10px; position: relative; z-index: 1;
    }
    .member-item {
        display: flex; align-items: center; gap: 12px; padding: 12px 14px;
        background: var(--gray-50); border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200); transition: var(--transition-smooth);
    }
    .member-item:hover {
        background: white; border-color: var(--primary); box-shadow: var(--shadow-sm);
        transform: translateX(3px);
    }
    .avatar-sm {
        width: 36px; height: 36px; border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px; flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(255,98,0,0.2);
    }
    .empty-state {
        display: flex; align-items: center; gap: 12px; padding: 24px 0;
        color: var(--gray-600); font-size: 14px; position: relative; z-index: 1;
    }

    /* Manager highlight card */
    .manager-highlight {
        background: linear-gradient(135deg, rgba(255,98,0,0.06) 0%, rgba(255,255,255,0.9) 100%);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border-radius: var(--radius-md); padding: 20px 24px;
        box-shadow: var(--shadow-md); border: 1px solid rgba(255,98,0,0.2);
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 24px; position: relative; overflow: hidden;
    }
    .manager-avatar {
        width: 56px; height: 56px; border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 22px; flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(255,98,0,0.3);
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-building" style="color:var(--primary);"></i> <span>{{ $department->name }}</span></h1>
        <p class="page-subtitle">{{ $activeEmployees ?? $department->employees->count() }} employé(s) actif(s) dans ce département</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.departments.edit', $department) }}" class="btn-primary">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <a href="{{ route('admin.departments.index') }}" class="btn-outline">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

{{-- Manager Highlight --}}
<!-- <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px; font-size:13px;">
    <i class="fas fa-user-tie" style="color:var(--primary);"></i>
    @if($department->manager && $department->manager->is_active)
        <span style="font-weight:600; color:var(--dark);">{{ $department->manager->name }}</span>
        <span style="color:var(--gray-600);">· Manager</span>
    @else
        <span style="color:var(--gray-500);">Aucun manager assigné</span>
    @endif
</div> -->
@if($department->manager && $department->manager->is_active)
<div class="manager-highlight animate-in delay-1">
    <div class="manager-avatar">{{ strtoupper(substr($department->manager->name, 0, 1)) }}</div>
    <div>
        <div style="font-size: 13px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Manager du département</div>
        <div style="font-size: 20px; font-weight: 700; color: var(--dark); margin-top: 2px;">{{ $department->manager->name }}</div>
    </div>
</div>
@else
<div class="manager-highlight animate-in delay-1" style="opacity: 0.6;">
    <div class="manager-avatar" style="background: var(--gray-300); box-shadow: none;"><i class="fas fa-user-slash"></i></div>
    <div>
        <div style="font-size: 13px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Manager du département</div>
        <div style="font-size: 20px; font-weight: 700; color: var(--gray-600); margin-top: 2px;">Non assigné</div>
    </div>
</div>
@endif

{{-- KPI Cards --}}
<div class="kpi-grid">
    <div class="kpi-card animate-in delay-1">
        <div class="kpi-header">
            <span class="kpi-label">Membres totaux</span>
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
        </div>
        <div class="kpi-value">{{ $totalMembers ?? $department->employees->count() }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-info"><i class="fas fa-building"></i> Effectif complet</span></div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">Actifs</span>
            <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
        </div>
        <div class="kpi-value">{{ $activeCount ?? $department->employees->where('status','active')->count() }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-success"><i class="fas fa-check-circle"></i> En poste</span></div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">En congé aujourd'hui</span>
            <div class="kpi-icon"><i class="fas fa-umbrella-beach"></i></div>
        </div>
        <div class="kpi-value">{{ $onLeaveToday ?? 0 }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-info"><i class="fas fa-calendar"></i> Absences</span></div>
    </div>
    <div class="kpi-card animate-in delay-4">
        <div class="kpi-header">
            <span class="kpi-label">Présents aujourd'hui</span>
            <div class="kpi-icon"><i class="fas fa-clock"></i></div>
        </div>
        <div class="kpi-value">{{ $presentToday ?? 0 }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-success"><i class="fas fa-bolt"></i> Pointages</span></div>
    </div>
</div>

{{-- Detail Grid --}}
<div class="detail-grid">
    {{-- Carte Infos (ultra‑compacte) --}}
    <div class="glass-card animate-in delay-1" style="padding:14px;">
        <div style="display:flex; flex-direction:column; gap:10px;">
            <div style="display:flex; align-items:center; gap:8px; font-size:13px;">
                <span style="width:24px; height:24px; border-radius:6px; background:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-size:12px;"><i class="fas fa-align-left"></i></span>
                <span style="font-weight:500;">{{ $department->description ?? 'Aucune description' }}</span>
            </div>
            <div style="display:flex; align-items:center; gap:8px; font-size:13px;">
                <span style="width:24px; height:24px; border-radius:6px; background:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-size:12px;"><i class="fas fa-user-tie"></i></span>
                <span style="font-weight:500;">
                    @if($department->manager && $department->manager->is_active)
                        {{ $department->manager->name }}
                    @else
                        Non assigné
                    @endif
                </span>
            </div>
            <div style="display:flex; align-items:center; gap:8px; font-size:13px;">
                <span style="width:24px; height:24px; border-radius:6px; background:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-size:12px;"><i class="fas fa-users"></i></span>
                <span style="font-weight:500;">{{ $department->employees->count() }} personne(s)</span>
            </div>
        </div>
    </div>

    {{-- Carte Membres (compacte, chip design) --}}
    <div class="glass-card animate-in delay-2" style="padding:14px;">
        <div style="font-size:13px; font-weight:700; color:var(--dark); margin-bottom:8px; display:flex; align-items:center; gap:6px;">
            <span style="width:24px; height:24px; border-radius:6px; background:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-size:12px;"><i class="fas fa-user-friends"></i></span>
            Équipe
        </div>
        @if($department->employees->isEmpty())
            <div style="font-size:12px; color:var(--gray-600); text-align:center; padding:8px;">Aucun employé</div>
        @else
            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                @foreach($department->employees as $employee)
                    <div style="display:flex; align-items:center; gap:6px; background:var(--gray-50); padding:4px 10px; border-radius:20px; font-size:12px; white-space:nowrap;">
                        <div style="width:22px; height:22px; border-radius:50%; background:linear-gradient(135deg,var(--primary),var(--primary-hover)); color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:10px;">
                            {{ strtoupper(substr($employee->user->name,0,1)) }}
                        </div>
                        <span style="font-weight:600;">{{ $employee->user->name }}</span>
                        @if($employee->position)
                            <span style="color:var(--gray-600);">· {{ $employee->position }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- <div class="detail-grid">
    {{-- Carte Informations --}}
    <div class="glass-card animate-in delay-1">
        <h3 class="card-title">
            <span style="background: var(--primary-light); color: var(--primary); padding: 6px 12px; border-radius: 10px;">
                <i class="fas fa-clipboard-list"></i>
            </span>
            Informations
        </h3>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-align-left"></i></div>
            <div>
                <div style="font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Description</div>
                <div style="font-weight: 600; font-size: 14px;">{{ $department->description ?? 'Aucune description' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-user-tie"></i></div>
            <div>
                <div style="font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Manager</div>
                <div style="font-weight: 600;">
                    @if($department->manager && $department->manager->is_active)
                        <span class="badge-pill"><i class="fas fa-user-check"></i> {{ $department->manager->name }}</span>
                    @else
                        <span style="color: var(--gray-600);">Non assigné</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-users"></i></div>
            <div>
                <div style="font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Effectif total</div>
                <div style="font-weight: 600; font-size: 14px;">{{ $department->employees->count() }} personne(s)</div>
            </div>
        </div>
    </div>

    {{-- Carte Membres --}}
    <div class="glass-card animate-in delay-2">
        <h3 class="card-title">
            <span style="background: var(--primary-light); color: var(--primary); padding: 6px 12px; border-radius: 10px;">
                <i class="fas fa-user-friends"></i>
            </span>
            Membres de l'équipe
        </h3>
        @if($department->employees->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user-slash" style="font-size: 28px; opacity: 0.4;"></i>
                <span>Aucun employé dans ce département.</span>
            </div>
        @else
            <ul class="member-list">
                @foreach($department->employees as $employee)
                    <li class="member-item">
                        <div class="avatar-sm">
                            {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                        </div>
                        <div style="flex: 1; font-weight: 600;">{{ $employee->user->name }}</div>
                        <span style="font-size: 12px; color: var(--gray-600);">{{ $employee->position ?? '' }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div> -->
@endsection