@extends('layouts.admin')

@section('title', 'Super Admin Dashboard')

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
    .delay-4 { animation-delay:0.32s; }

    .dashboard {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Header */
    .dash-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 16px;
        padding: 20px 24px; background: var(--white);
        border-radius: var(--radius-md); box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200); position: relative; overflow: hidden;
    }
    .dash-header::before {
        content: ''; position: absolute; top: -30px; right: -30px;
        width: 120px; height: 120px; background: var(--primary-glow);
        filter: blur(60px); z-index: 0;
    }
    .dash-header > * { position: relative; z-index: 1; }
    .welcome-block { display: flex; align-items: center; gap: 16px; }
    .avatar-admin {
        width: 52px; height: 52px; border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; display: flex; align-items: center; justify-content: center;
        font-size: 22px; font-weight: 700;
        box-shadow: 0 8px 16px rgba(255,98,0,0.3); flex-shrink: 0;
    }
    .dash-title {
        font-family: 'Clash Display', sans-serif; font-size: 24px; font-weight: 700;
        color: var(--dark); line-height: 1.2;
    }
    .dash-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .dash-subtitle { color: var(--gray-600); font-size: 13px; font-weight: 500; }
    .live-dot {
        width: 7px; height: 7px; background: #10B981; border-radius: 50%;
        display: inline-block; margin-right: 4px;
        animation: livePulse 2s infinite;
    }
    @keyframes livePulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.6); opacity: 0.4; }
        100% { transform: scale(1); opacity: 1; }
    }
    .stats-inline { display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
    .stat-mini {
        display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600;
        color: var(--dark); background: var(--gray-50); padding: 8px 14px;
        border-radius: var(--radius-full); border: 1px solid var(--gray-200);
    }
    .stat-mini i { color: var(--primary); font-size: 15px; }

    /* KPI */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
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

    /* Companies grid */
    .companies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 16px;
    }
    .company-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        transition: var(--transition-smooth); display: flex; flex-direction: column; gap: 12px;
    }
    .company-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .company-header { display: flex; align-items: center; gap: 12px; }
    .company-logo {
        width: 44px; height: 44px; border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 700;
    }
    .company-name {
        font-family: 'Clash Display', sans-serif; font-size: 18px; font-weight: 700;
        color: var(--dark);
    }
    .company-meta { font-size: 12px; color: var(--gray-600); }
    .company-stats {
        display: flex; gap: 16px; margin-top: 8px;
    }
    .company-stat {
        display: flex; flex-direction: column; align-items: center;
        background: var(--gray-50); border-radius: var(--radius-sm);
        padding: 8px 12px; flex: 1;
    }
    .company-stat-value { font-weight: 700; font-size: 18px; color: var(--dark); }
    .company-stat-label { font-size: 10px; color: var(--gray-600); text-transform: uppercase; }
</style>

<div class="dashboard">
    {{-- HEADER --}}
    <div class="dash-header animate-in">
        <div class="welcome-block">
            <div class="avatar-admin">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="dash-title">Super Admin, <span>{{ auth()->user()->name }}</span></h1>
                <p class="dash-subtitle">
                    <span class="live-dot"></span>
                    Plateforme multi‑entreprises · {{ now()->isoFormat('dddd D MMMM YYYY') }}
                </p>
            </div>
        </div>
    </div>

    {{-- KPI GLOBALES --}}
    <div class="kpi-grid">
        <div class="kpi-card animate-in delay-1">
            <div class="kpi-header">
                <span class="kpi-label">Entreprises</span>
                <div class="kpi-icon"><i class="fas fa-building"></i></div>
            </div>
            <div class="kpi-value">{{ $totalCompanies }}</div>
            <div class="kpi-footer"><i class="fas fa-globe" style="color:var(--primary);"></i> Actives</div>
        </div>
        <div class="kpi-card animate-in delay-2">
            <div class="kpi-header">
                <span class="kpi-label">Employés</span>
                <div class="kpi-icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="kpi-value">{{ $totalEmployees }}</div>
            <div class="kpi-footer"><i class="fas fa-user-friends" style="color:#10B981;"></i> Toutes entreprises</div>
        </div>
        <div class="kpi-card animate-in delay-3">
            <div class="kpi-header">
                <span class="kpi-label">Départements</span>
                <div class="kpi-icon"><i class="fas fa-sitemap"></i></div>
            </div>
            <div class="kpi-value">{{ $totalDepartments }}</div>
            <div class="kpi-footer"><i class="fas fa-layer-group" style="color:#3B82F6;"></i> Structure globale</div>
        </div>
        <div class="kpi-card animate-in delay-4">
            <div class="kpi-header">
                <span class="kpi-label">Managers</span>
                <div class="kpi-icon"><i class="fas fa-user-tie"></i></div>
            </div>
            <div class="kpi-value">{{ $totalManagers }}</div>
            <div class="kpi-footer"><i class="fas fa-chess-king" style="color:#F59E0B;"></i> Encadrement</div>
        </div>
    </div>

    {{-- LISTE DES ENTREPRISES --}}
    <div class="companies-grid animate-in delay-4">
        @foreach($companies as $company)
            <div class="company-card">
                <div class="company-header">
                    <div class="company-logo">
                        {{ strtoupper(substr($company->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="company-name">{{ $company->name }}</div>
                        <div class="company-meta">
                            Créée le {{ $company->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                <div class="company-stats">
                    <div class="company-stat">
                        <span class="company-stat-value">{{ $company->employees_count ?? 0 }}</span>
                        <span class="company-stat-label">Employés</span>
                    </div>
                    <div class="company-stat">
                        <span class="company-stat-value">{{ $company->departments_count ?? 0 }}</span>
                        <span class="company-stat-label">Départements</span>
                    </div>
                    <div class="company-stat">
                        <span class="company-stat-value">{{ $company->managers_count ?? 0 }}</span>
                        <span class="company-stat-label">Managers</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection