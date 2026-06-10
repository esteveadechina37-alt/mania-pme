@extends('layouts.admin')

@section('title', 'Mon stage')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #cc4e00;
        --primary-light: rgba(255,98,0,0.10);
        --primary-border: rgba(255,98,0,0.28);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 24px rgba(10,10,10,0.07);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 20px;
        --radius-full: 9999px;
        --transition: 0.3s ease;
    }

    @keyframes fadeSlideUp {
        0%   { opacity: 0; transform: translateY(14px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity: 0; }
    .delay-1    { animation-delay: 0.08s; }
    .delay-2    { animation-delay: 0.16s; }
    .delay-3    { animation-delay: 0.24s; }

    body { overflow-x: hidden; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; flex-wrap: wrap; gap: 10px;
        max-width: 100%;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 10px;
        white-space: nowrap;
    }
    .page-title i { color: var(--primary); }
    .page-subtitle { color: var(--gray-600); font-size: 13px; margin: 4px 0 0; }
    .role-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px; border-radius: var(--radius-full);
        background: var(--primary-light); border: 0.5px solid var(--primary-border);
        font-size: 12px; font-weight: 600; color: var(--primary);
        white-space: nowrap;
    }

    .content-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 230px;
        gap: 16px; align-items: start;
        max-width: 100%;
    }
    @media (max-width: 768px) { .content-grid { grid-template-columns: 1fr; } }

    /* Carte principale */
    .main-card {
        background: var(--white); border-radius: var(--radius-md);
        border: 0.5px solid var(--gray-200); overflow: hidden;
        box-shadow: var(--shadow-md);
        max-width: 100%;
    }

    .hero-band {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        padding: 28px 24px 44px; position: relative;
    }
    .hero-band::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0;
        height: 28px; background: var(--white); border-radius: 20px 20px 0 0;
    }
    .hero-wrap { display: flex; align-items: flex-end; gap: 16px; flex-wrap: wrap; }
    .avatar {
        width: 72px; height: 72px; border-radius: 18px;
        background: rgba(255,255,255,0.20); backdrop-filter: blur(4px);
        border: 2px solid rgba(255,255,255,0.50);
        color: white; display: flex; align-items: center; justify-content: center;
        font-size: 30px; font-weight: 700; flex-shrink: 0;
        position: relative; z-index: 1;
    }
    .hero-info { position: relative; z-index: 1; flex: 1; min-width: 200px; }
    .hero-name {
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: white; line-height: 1.25; margin: 0 0 4px;
        word-break: break-word;
    }
    .hero-role {
        font-size: 13px; color: rgba(255,255,255,0.80);
        display: flex; align-items: center; gap: 6px; margin: 0; flex-wrap: wrap;
    }
    .hero-role .sep { color: rgba(255,255,255,0.35); }

    .card-body { padding: 16px 24px 22px; }
    .section-label {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.7px; color: var(--gray-600);
        display: flex; align-items: center; gap: 8px; margin: 0 0 12px;
    }
    .section-label i { color: var(--primary); }
    .section-label::after {
        content: ''; flex: 1; height: 0.5px; background: var(--gray-200);
    }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; max-width: 100%; }
    @media (max-width: 480px) { .info-grid { grid-template-columns: 1fr; } }
    .info-cell {
        padding: 11px 0; border-bottom: 0.5px solid var(--gray-100);
        overflow-wrap: break-word; word-break: break-word;
    }
    .info-cell:nth-child(odd) { padding-right: 24px; }
    .info-cell:nth-last-child(-n+2) { border-bottom: none; }
    .info-label {
        font-size: 11px; font-weight: 600; text-transform: uppercase;
        letter-spacing: 0.5px; color: var(--gray-600);
        display: flex; align-items: center; gap: 5px; margin: 0 0 4px;
    }
    .info-label i { color: var(--primary); font-size: 12px; }
    .info-value {
        font-size: 14px; font-weight: 600; color: var(--dark); margin: 0;
    }
    .info-value.salary { font-size: 15px; color: var(--primary); }
    .contract-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: var(--radius-full);
        background: var(--primary-light); border: 0.5px solid var(--primary-border);
        font-size: 12px; font-weight: 600; color: var(--primary);
        white-space: nowrap;
    }

    /* Colonne latérale */
    .side-stack { display: flex; flex-direction: column; gap: 14px; max-width: 100%; }

    .side-card {
        background: var(--white); border-radius: var(--radius-md);
        border: 0.5px solid var(--gray-200); padding: 16px;
        box-shadow: var(--shadow-sm);
        max-width: 100%;
    }
    .side-title {
        font-family: 'Clash Display', sans-serif; font-size: 14px; font-weight: 700;
        color: var(--dark); margin: 0 0 12px;
        display: flex; align-items: center; gap: 7px;
    }
    .side-title i { color: var(--primary); }

    .guide-item { display: flex; gap: 10px; margin-bottom: 11px; }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 28px; height: 28px; border-radius: 8px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; flex-shrink: 0;
    }
    .guide-text strong {
        font-size: 13px; font-weight: 700; color: var(--dark);
        display: block; margin-bottom: 2px;
    }
    .guide-text p { font-size: 12px; color: var(--gray-600); margin: 0; line-height: 1.4; }
</style>

<div class="page-header animate-in">
    <div class="full-width" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-graduate"></i> Mon stage
            </h1>
            <p class="page-subtitle">Informations relatives à votre stage</p>
        </div>
        <span class="role-badge">
            <i class="fas fa-briefcase"></i> Stagiaire
        </span>
    </div>
</div>

<div class="content-grid">
    <!-- Carte principale -->
    <div class="main-card animate-in delay-1">
        <div class="hero-band">
            <div class="hero-wrap">
                <div class="avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="hero-info">
                    <p class="hero-name">{{ $user->name }}</p>
                    <p class="hero-role">
                        <i class="fas fa-user-graduate"></i>
                        {{ $employee->position ?? 'Stagiaire' }}
                        <span class="sep">|</span>
                        {{ $user->company->name ?? '' }}
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="section-label">
                <i class="fas fa-id-badge"></i> Informations du stage
            </p>
            <div class="info-grid">
                <div class="info-cell">
                    <p class="info-label"><i class="fas fa-building"></i> Département</p>
                    <p class="info-value">{{ $employee->department->name ?? '—' }}</p>
                </div>
                <div class="info-cell">
                    <p class="info-label"><i class="fas fa-file-contract"></i> Type de contrat</p>
                    <p class="info-value">
                        @if($employee->contract_type)
                            <span class="contract-pill">
                                <i class="fas fa-check-circle"></i>
                                {{ $employee->contract_type }}
                            </span>
                        @else
                            —
                        @endif
                    </p>
                </div>
                <div class="info-cell">
                    <p class="info-label"><i class="fas fa-calendar-alt"></i> Date de début</p>
                    <p class="info-value">
                        {{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—' }}
                    </p>
                </div>
                <div class="info-cell">
                    <p class="info-label"><i class="fas fa-calendar-times"></i> Date de fin</p>
                    <p class="info-value">
                        {{ $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') : '—' }}
                    </p>
                </div>
                <div class="info-cell">
                    <p class="info-label"><i class="fas fa-user-tie"></i> Tuteur / Manager</p>
                    <p class="info-value">{{ $employee->department->manager->name ?? '—' }}</p>
                </div>
                <div class="info-cell">
                    <p class="info-label"><i class="fas fa-money-bill-wave"></i> Gratification</p>
                    <p class="info-value salary">
                        {{ $employee->salary ? number_format($employee->salary, 0, ',', ' ') . ' FCFA' : '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Colonne latérale -->
    <div class="side-stack">
        <div class="side-card animate-in delay-2">
            <p class="side-title"><i class="fas fa-lightbulb"></i> Votre stage</p>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="guide-text">
                    <strong>Période de stage</strong>
                    <p>Votre stage a une durée déterminée. La date de fin est indiquée sur votre contrat.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-user-tie"></i></div>
                <div class="guide-text">
                    <strong>Votre tuteur</strong>
                    <p>Votre manager est votre tuteur de stage. Contactez-le pour toute question.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-file-alt"></i></div>
                <div class="guide-text">
                    <strong>Attestation de stage</strong>
                    <p>À la fin de votre stage, une attestation sera générée par l'administration.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection