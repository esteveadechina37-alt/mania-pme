@extends('layouts.admin')

@section('title', $company->name)

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

    .btn-outline-sm {
        background: var(--white); color: var(--dark); padding: 6px 14px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 12px;
        border: 1px solid var(--gray-200); display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none; transition: var(--transition-smooth);
    }
    .btn-outline-sm:hover { background: var(--gray-50); border-color: var(--primary); }

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

    .content-grid {
        display: grid; grid-template-columns: 1fr 240px; gap: 16px; align-items: start;
    }
    @media (max-width: 850px) { .content-grid { grid-template-columns: 1fr; } }

    .card-panel {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
    }
    .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 700;
        color: var(--dark); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
    }
    .card-title i { color: var(--primary); }

    .info-row {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 0; border-bottom: 1px solid var(--gray-100);
        font-size: 13px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; flex-shrink: 0;
    }
    .info-text strong { font-size: 14px; color: var(--dark); display: block; }
    .info-text span { font-size: 12px; color: var(--gray-600); }

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
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-building" style="color:var(--primary);"></i>
            {{ $company->name }}
        </h1>
        <p class="page-subtitle">Entreprise crée le {{ $company->created_at->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('super-admin.dashboard') }}" class="btn-outline-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

{{-- KPIs --}}
<div class="kpi-grid">
    <div class="kpi-card animate-in delay-1">
        <div class="kpi-header">
            <span class="kpi-label">Employés</span>
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
        </div>
        <div class="kpi-value">{{ $company->employees_count ?? 0 }}</div>
        <div class="kpi-footer"><i class="fas fa-user-friends" style="color:var(--primary);"></i> Actifs</div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">Départements</span>
            <div class="kpi-icon"><i class="fas fa-sitemap"></i></div>
        </div>
        <div class="kpi-value">{{ $company->departments_count ?? 0 }}</div>
        <div class="kpi-footer"><i class="fas fa-layer-group" style="color:#3B82F6;"></i> Structure</div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">Managers</span>
            <div class="kpi-icon"><i class="fas fa-user-tie"></i></div>
        </div>
        <div class="kpi-value">{{ $company->managers_count ?? 0 }}</div>
        <div class="kpi-footer"><i class="fas fa-chess-king" style="color:#F59E0B;"></i> Encadrement</div>
    </div>
</div>

<div class="content-grid">
    {{-- Informations détaillées --}}
    <div class="card-panel animate-in delay-4">
        <div class="card-title"><i class="fas fa-info-circle"></i> Informations générales</div>
        @php
            $details = [
                ['icon' => 'fa-building', 'label' => 'Nom', 'value' => $company->name],
                ['icon' => 'fa-envelope', 'label' => 'Email', 'value' => $company->email ?? '—'],
                ['icon' => 'fa-phone', 'label' => 'Téléphone', 'value' => $company->phone ?? '—'],
                ['icon' => 'fa-map-marker-alt', 'label' => 'Adresse', 'value' => $company->address ?? '—'],
                ['icon' => 'fa-city', 'label' => 'Ville', 'value' => $company->city ?? '—'],
                ['icon' => 'fa-calendar-alt', 'label' => 'Date de création', 'value' => $company->created_at->format('d/m/Y')],
            ];
        @endphp
        @foreach($details as $detail)
        <div class="info-row">
            <div class="info-icon"><i class="fas {{ $detail['icon'] }}"></i></div>
            <div class="info-text">
                <strong>{{ $detail['label'] }}</strong>
                <span>{{ $detail['value'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Guide rapide --}}
    <div class="guide-card animate-in delay-4">
        <h4><i class="fas fa-lightbulb"></i> Guide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-users"></i></div>
            <div class="guide-text">
                <strong>Effectif</strong>
                <p>Nombre total d'employés actifs dans cette entreprise.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-sitemap"></i></div>
            <div class="guide-text">
                <strong>Départements</strong>
                <p>Structure organisationnelle de l'entreprise.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user-tie"></i></div>
            <div class="guide-text">
                <strong>Managers</strong>
                <p>Nombre de responsables d'équipe.</p>
            </div>
        </div>
    </div>
</div>
@endsection