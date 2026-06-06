@extends('layouts.admin')

@section('title', 'Détail de l\'évaluation')

@section('content')
<style>
    /* ========== DESIGN SYSTEM (identique dashboard) ========== */
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

    .btn-outline {
        background: var(--white);
        color: var(--dark);
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 13px;
        border: 1px solid var(--gray-200);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: var(--transition-smooth);
        white-space: nowrap;
    }
    .btn-outline:hover {
        background: var(--gray-50);
        border-color: var(--primary-glow);
    }

    /* ========== CONTENT GRID ========== */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    /* ========== DETAIL CARD ========== */
    .detail-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 28px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }
    .info-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid var(--gray-100);
    }
    .info-row:last-child { border-bottom: none; }
    .icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .badge-score {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 18px;
        border-radius: var(--radius-full);
        font-size: 16px;
        font-weight: 700;
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
        <h1 class="page-title"><i class="fas fa-star" style="color:var(--primary);"></i> <span>Détail de l'évaluation</span></h1>
        <p class="page-subtitle">Période : <strong>{{ $evaluation->period }}</strong></p>
    </div>
    <a href="{{ route('admin.evaluations.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="content-grid">
    <div class="detail-card animate-in delay-1">
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-user"></i></div>
            <div>
                <div style="font-size:11px; color:var(--gray-600); text-transform:uppercase;">Employé</div>
                <div style="font-weight:600;">{{ $evaluation->employee->user->name }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-star"></i></div>
            <div>
                <div style="font-size:11px; color:var(--gray-600); text-transform:uppercase;">Note</div>
                <span class="badge-score" style="background:{{ $evaluation->score >= 4 ? '#dcfce7' : ($evaluation->score >= 3 ? '#fef3c7' : '#fee2e2') }}; color:{{ $evaluation->score >= 4 ? '#166534' : ($evaluation->score >= 3 ? '#92400e' : '#991b1b') }};">
                    <i class="fas fa-star"></i> {{ number_format($evaluation->score, 1) }}/5
                </span>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-user-check"></i></div>
            <div>
                <div style="font-size:11px; color:var(--gray-600); text-transform:uppercase;">Évaluateur</div>
                <div style="font-weight:600;">{{ $evaluation->evaluator->name }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-calendar"></i></div>
            <div>
                <div style="font-size:11px; color:var(--gray-600); text-transform:uppercase;">Date</div>
                <div style="font-weight:600;">{{ $evaluation->evaluated_at->format('d/m/Y') }}</div>
            </div>
        </div>
        @if($evaluation->comments)
        <div style="margin-top:20px; padding:16px; background:var(--gray-50); border-radius:var(--radius-sm); border:1px solid var(--gray-200);">
            <strong style="color:var(--dark);">Commentaires :</strong>
            <p style="margin:8px 0 0; color:var(--gray-600);">{{ $evaluation->comments }}</p>
        </div>
        @endif
    </div>

    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Détails de l'évaluation</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user"></i></div>
            <div class="guide-text">
                <strong>Employé évalué</strong>
                <p>L'évaluation concerne un employé actif de votre entreprise.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-star"></i></div>
            <div class="guide-text">
                <strong>Note</strong>
                <p>Score attribué sur 5. Vert = bon, Jaune = moyen, Rouge = insuffisant.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user-check"></i></div>
            <div class="guide-text">
                <strong>Évaluateur</strong>
                <p>Personne ayant réalisé l'évaluation (manager ou administrateur).</p>
            </div>
        </div>
    </div>
</div>
@endsection