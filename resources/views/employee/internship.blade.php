@extends('layouts.admin')

@section('title', 'Mon stage')

@section('content')
<style>
    /* ========== DESIGN SYSTEM PREMIUM ========== */
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
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    /* ========== HEADER ========== */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
    }
    .page-header::after {
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 150px;
        height: 150px;
        background: var(--primary-glow);
        filter: blur(80px);
        z-index: -1;
        pointer-events: none;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 6px 0;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .page-subtitle {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        margin: 0;
    }

    /* ========== MAIN LAYOUT ========== */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    /* ========== INTERNSHIP CARD ========== */
    .internship-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 28px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }
    .internship-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .internship-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
        border-color: var(--primary);
    }
    .internship-card:hover::before { opacity: 1; }

    .internship-header {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 24px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    .avatar-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        position: relative;
        z-index: 1;
    }
    @media (max-width: 500px) {
        .info-grid { grid-template-columns: 1fr; }
    }
    .info-label {
        font-size: 11px;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--dark);
    }

    /* ========== GUIDE CARD ========== */
    .guide-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .guide-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .guide-card:hover::before { opacity: 1; }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    .guide-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .guide-text strong {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        display: block;
        margin-bottom: 4px;
    }
    .guide-text p {
        color: var(--gray-600);
        font-size: 13px;
        margin: 0;
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-user-graduate" style="color:var(--primary);"></i> <span>Mon stage</span></h1>
        <p class="page-subtitle">Informations relatives à votre stage</p>
    </div>
</div>

<div class="content-grid">
    {{-- Colonne gauche : Détails du stage --}}
    <div class="internship-card animate-in delay-1">
        <div class="internship-header">
            <div class="avatar-placeholder">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-family:'Clash Display',sans-serif; font-size:24px; margin:0; color:var(--dark);">
                    {{ $user->name }}
                </h2>
                <p style="color:var(--gray-600); margin:4px 0 0; font-family:'Cabinet Grotesk',sans-serif;">
                    {{ $employee->position ?? 'Stagiaire' }} · {{ $user->company->name ?? '' }}
                </p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Département</div>
                <div class="info-value">{{ $employee->department->name ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Type de contrat</div>
                <div class="info-value">{{ $employee->contract_type ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date de début</div>
                <div class="info-value">{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date de fin</div>
                <div class="info-value">{{ $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') : '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tuteur / Manager</div>
                <div class="info-value">{{ $employee->department->manager->name ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Salaire / Gratification</div>
                <div class="info-value">{{ $employee->salary ? number_format($employee->salary, 0, ',', ' ') . ' FCFA' : '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Colonne droite : Guide --}}
    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Votre stage</h3>
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
@endsection