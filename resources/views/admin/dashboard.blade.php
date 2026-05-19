@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    /* ========== DESIGN SYSTEM & VARIABLES (inchangé) ========== */
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255, 98, 0, 0.08);
        --primary-glow: rgba(255, 98, 0, 0.25);
        --dark: #0A0A0A;
        --dark-card: #141414;
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

    /* ========== ANIMATIONS ========== */
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes livePulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.4; }
        100% { transform: scale(1); opacity: 1; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    @keyframes barGrow {
        0% { height: 0; opacity: 0; }
        100% { height: var(--h); opacity: 1; }
    }

    .animate-in {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* ========== HEADER SECTION (réduite) ========== */
    .dashboard-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 30px; /* réduit */
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
    }

    .dashboard-header::after {
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

    .welcome-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 30px; /* réduit */
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 6px 0;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .welcome-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .welcome-subtitle {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        margin: 0;
    }

    .tenant-badge {
        background: var(--dark);
        color: var(--white);
        padding: 8px 20px; /* réduit */
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 25px rgba(10, 10, 10, 0.2);
        transition: var(--transition-smooth);
    }

    .tenant-badge:hover {
        transform: translateY(-2px);
        border-color: var(--primary);
        box-shadow: 0 12px 30px var(--primary-glow);
    }

    .live-indicator {
        width: 8px;
        height: 8px;
        background-color: #10B981;
        border-radius: 50%;
        position: relative;
    }

    .live-indicator::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        width: 16px;
        height: 16px;
        background-color: rgba(16, 185, 129, 0.4);
        border-radius: 50%;
        animation: livePulse 2s infinite;
    }

    /* ========== STATS BENTO GRID (réduite) ========== */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); /* plus petit */
        gap: 20px;
        margin-top: 12px;
    }

    .bento-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px; /* réduit */
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .bento-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }

    .bento-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .bento-card:hover::before {
        opacity: 1;
    }

    .bento-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px; /* réduit */
        position: relative;
        z-index: 1;
    }

    .bento-icon {
        width: 44px; /* réduit */
        height: 44px;
        border-radius: var(--radius-sm);
        background: var(--gray-50);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: var(--transition-smooth);
        border: 1px solid var(--gray-200);
    }

    .bento-card:hover .bento-icon {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }

    .bento-label {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 13px; /* réduit */
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .bento-body {
        position: relative;
        z-index: 1;
    }

    .bento-value {
        font-family: 'Clash Display', sans-serif;
        font-size: 34px; /* réduit */
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
        margin: 0 0 8px 0;
    }

    .bento-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 12px;
        font-weight: 500;
        padding-top: 12px;
        border-top: 1px solid var(--gray-100);
    }

    .trend-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 11px;
    }

    .trend-success { background: rgba(16, 185, 129, 0.1); color: #10B981; }
    .trend-warning { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
    .trend-info { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }

    /* ========== SECTION MEMBRES + GRAPHIQUE (nouvelle grille) ========== */
    .analytics-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        .analytics-row {
            grid-template-columns: 1fr;
        }
    }

    .members-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px; /* réduit */
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: var(--primary);
    }

    .badge-count {
        background: var(--primary-light);
        color: var(--primary);
        padding: 5px 14px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid rgba(255, 98, 0, 0.2);
    }

    .member-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .member-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px; /* réduit */
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }

    .member-row:hover {
        background: var(--white);
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
        transform: scale(1.01);
    }

    .member-meta {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .member-avatar {
        width: 42px; /* réduit */
        height: 42px;
        border-radius: var(--radius-sm);
        background: linear-gradient(135deg, var(--dark) 0%, #2A2A2A 100%);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Clash Display', sans-serif;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 4px 10px rgba(10, 10, 10, 0.15);
        transition: var(--transition-smooth);
    }

    .member-row:hover .member-avatar {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        transform: rotate(-5deg) scale(1.05);
        box-shadow: 0 6px 15px var(--primary-glow);
    }

    .member-details strong {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        display: block;
        margin-bottom: 2px;
    }

    .member-details span {
        color: var(--gray-600);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .role-badge {
        background: var(--white);
        color: var(--dark);
        padding: 5px 14px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
    }

    .member-row:hover .role-badge {
        border-color: var(--primary-glow);
        background: var(--primary-light);
        color: var(--primary);
    }

    .hidden-item {
        display: none !important;
    }

    /* Bouton voir plus/moins */
    .action-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-100);
    }

    .btn-glow {
        background: var(--dark);
        color: var(--white);
        padding: 12px 28px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 14px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: var(--transition-smooth);
        box-shadow: 0 8px 20px rgba(10, 10, 10, 0.15);
    }

    .btn-glow:hover {
        background: var(--primary);
        border-color: var(--primary);
        box-shadow: 0 12px 30px var(--primary-glow);
        transform: translateY(-2px);
    }

    /* ========== GRAPHIQUE BARRES ========== */
    .chart-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        display: flex;
        flex-direction: column;
    }

    .chart-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 4px 0;
    }

    .chart-subtitle {
        color: var(--gray-600);
        font-size: 13px;
        margin-bottom: 20px;
    }

    .bar-chart-container {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        height: 180px;
        padding: 0 10px;
    }

    .bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
    }

    .bar {
        width: 100%;
        max-width: 40px;
        background: var(--primary);
        border-radius: var(--radius-sm) var(--radius-sm) 0 0;
        transition: height 0.5s ease, background 0.3s;
        animation: barGrow 0.7s ease-out forwards;
        height: 0; /* sera défini par style inline */
    }

    .bar-label {
        font-size: 11px;
        color: var(--gray-800);
        margin-top: 8px;
        text-align: center;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .bar-value {
        font-size: 10px;
        color: var(--gray-600);
        margin-bottom: 4px;
    }

    /* ========== QUICK LINKS (inchangé, juste espacé) ========== */
    .navigation-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .nav-card {
        text-decoration: none;
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }

    .nav-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary);
        transform: scaleY(0);
        transition: var(--transition-smooth);
    }

    .nav-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .nav-card:hover::before {
        transform: scaleY(1);
    }

    .nav-content-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .nav-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-sm);
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: var(--transition-smooth);
        border: 1px solid rgba(255, 98, 0, 0.15);
    }

    .nav-card:hover .nav-icon {
        background: var(--primary);
        color: var(--white);
        transform: scale(1.1) rotate(5deg);
    }

    .nav-info strong {
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        display: block;
        margin-bottom: 4px;
    }

    .nav-info p {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 13px;
        margin: 0;
    }

    .nav-arrow {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--gray-50);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: var(--transition-smooth);
        border: 1px solid var(--gray-200);
    }

    .nav-card:hover .nav-arrow {
        background: var(--dark);
        color: var(--white);
        border-color: var(--dark);
        transform: translateX(6px);
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .dashboard-header { flex-direction: column; align-items: stretch; }
        .tenant-badge { justify-content: center; }
        .bento-value { font-size: 28px; }
        .member-row { flex-direction: column; align-items: flex-start; gap: 12px; }
        .role-badge { align-self: flex-start; }
        .analytics-row { grid-template-columns: 1fr; }
    }

    /* ========== GRAPHIQUE PREMIUM ========== */
    .chart-card {
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: var(--radius-lg);
        padding: 28px 24px 24px;
        box-shadow: 0 20px 40px rgba(10,10,10,0.04), 0 0 0 1px rgba(255,255,255,0.8) inset;
        border: 1px solid rgba(255,255,255,0.5);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .chart-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,98,0,0.15) 0%, transparent 70%);
        z-index: 0;
        pointer-events: none;
    }

    .chart-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 2px 0;
        position: relative;
        z-index: 1;
    }

    .chart-subtitle {
        color: var(--gray-600);
        font-size: 13px;
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
    }

    .bar-chart-container {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        height: 200px; /* un peu plus haut */
        padding: 0 8px;
        position: relative;
        z-index: 1;
    }

    .bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .bar-wrapper:hover {
        transform: translateY(-6px);
    }

    .bar-value {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 6px;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.3s, transform 0.3s;
    }

    .bar-wrapper:hover .bar-value {
        opacity: 1;
        transform: translateY(0);
    }

    .bar {
        width: 100%;
        max-width: 48px;
        background: linear-gradient(180deg, #FF8C42 0%, #FF6200 100%);
        border-radius: 12px 12px 4px 4px;
        box-shadow: 0 8px 20px rgba(255,98,0,0.3), 0 0 0 1px rgba(255,255,255,0.3) inset;
        transition: height 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }

    .bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 40%;
        background: linear-gradient(180deg, rgba(255,255,255,0.4) 0%, transparent 100%);
        border-radius: 12px 12px 0 0;
        pointer-events: none;
    }

    .bar-wrapper:hover .bar {
        box-shadow: 0 12px 28px rgba(255,98,0,0.5), 0 0 0 1px rgba(255,255,255,0.4) inset;
        background: linear-gradient(180deg, #FFA366 0%, #FF6200 100%);
    }

    .bar-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--gray-800);
        margin-top: 10px;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        transition: color 0.3s;
    }

    .bar-wrapper:hover .bar-label {
        color: var(--primary);
    }

    /* Animation d'entrée */
    .bar {
        animation: barGrow 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        height: 0; /* sera override par style inline */
    }

    @keyframes barGrow {
        0% { height: 0; opacity: 0; }
        100% { height: var(--h); opacity: 1; }
    }
</style>

{{-- Header Section --}}
<div class="dashboard-header animate-in">
    <div>
        <h1 class="welcome-title">
            Bienvenue, <span>{{ auth()->user()->name }}</span>
        </h1>
        <p class="welcome-subtitle">Aperçu en temps réel de votre espace de gestion</p>
    </div>
    <div class="tenant-badge">
        <span class="live-indicator"></span>
        {{ auth()->user()->company->name ?? 'Mania-PME' }}
    </div>
</div>

{{-- Bento Grid Statistiques (réduit) --}}
<div class="bento-grid">
    <div class="bento-card animate-in delay-1">
        <div>
            <div class="bento-header">
                <span class="bento-label">Collaborateurs</span>
                <div class="bento-icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $totalEmployees }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-success"><i class="fas fa-arrow-up"></i> 100%</span>
            <span>Comptes actifs</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-2">
        <div>
            <div class="bento-header">
                <span class="bento-label">Congés en attente</span>
                <div class="bento-icon"><i class="fas fa-calendar-alt"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $pendingLeaves }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-warning"><i class="fas fa-clock"></i> Action requise</span>
            <span>Demandes en attente</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-3">
        <div>
            <div class="bento-header">
                <span class="bento-label">Présents Aujourd'hui</span>
                <div class="bento-icon"><i class="fas fa-user-check"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $todayAttendances }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-info"><i class="fas fa-bolt"></i> En direct</span>
            <span>Pointages enregistrés</span>
        </div>
    </div>
</div>

{{-- NOUVELLE SECTION : Derniers membres + Graphique en deux colonnes --}}
<div class="analytics-row">
    {{-- Colonne gauche : Derniers membres --}}
    <div class="members-card animate-in delay-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-plus"></i> Derniers Membres</h3>
            @if($recentUsers->count() > 0)
                <span class="badge-count">{{ $recentUsers->count() }} récent(s)</span>
            @endif
        </div>

        @if($recentUsers->isEmpty())
            <div style="text-align:center; padding: 48px 0; color: var(--gray-600);">
                <i class="fas fa-inbox fa-3x" style="margin-bottom: 16px; opacity: 0.3;"></i>
                <p style="font-family: 'Cabinet Grotesk', sans-serif; font-size: 16px;">Aucun collaborateur enregistré.</p>
            </div>
        @else
            <ul id="recentUsersList" class="member-grid">
                @foreach($recentUsers as $index => $user)
                    <li class="member-row recent-user {{ $index >= 2 ? 'hidden-item' : '' }}">
                        <div class="member-meta">
                            <div class="member-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="member-details">
                                <strong>{{ $user->name }}</strong>
                                <span><i class="fas fa-envelope" style="color: var(--gray-300);"></i> {{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="role-badge">
                            {{ $user->getRoleNames()->first() ?? 'N/A' }}
                        </div>
                    </li>
                @endforeach
            </ul>

            @if($recentUsers->count() > 2)
                <div class="action-container" id="buttonsContainer">
                    <button id="showMoreBtn" onclick="toggleUsers('more')" class="btn-glow">
                        <span>Déployer ({{ $recentUsers->count() - 2 }})</span>
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <button id="showLessBtn" onclick="toggleUsers('less')" class="btn-glow" style="display: none;">
                        <span>Réduire</span>
                        <i class="fas fa-arrow-up"></i>
                    </button>
                </div>
            @endif
        @endif
    </div>

    {{-- Colonne droite : Graphique dynamique --}}
    <div class="chart-card animate-in delay-4">
        <h3 class="chart-title">Répartition par département</h3>
        <p class="chart-subtitle">Employés actifs</p>
        <div class="bar-chart-container">
            @forelse($departmentsStats as $dept)
                @php
                    $max = $departmentsStats->max('employees_count') ?: 1;
                    $heightPercent = ($max > 0) ? ($dept->employees_count / $max) * 100 : 0;
                @endphp
                <div class="bar-wrapper">
                    <span class="bar-value">{{ $dept->employees_count }}</span>
                    <div class="bar" style="--h: {{ $heightPercent }}%; height: {{ $heightPercent }}%;"></div>
                    <span class="bar-label" title="{{ $dept->name }}">{{ \Illuminate\Support\Str::limit($dept->name, 10) }}</span>
                </div>
            @empty
                <div style="color: var(--gray-600); display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                    <p>Aucun département</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Section Navigation Rapide (inchangée) --}}
<div class="navigation-grid">
    <a href="{{ route('admin.employees.index') }}" class="nav-card animate-in delay-1">
        <div class="nav-content-wrapper">
            <div class="nav-icon"><i class="fas fa-users"></i></div>
            <div class="nav-info">
                <strong>Pôle Employés</strong>
                <p>Gestion administrative et dossiers</p>
            </div>
        </div>
        <div class="nav-arrow"><i class="fas fa-chevron-right"></i></div>
    </a>

    <a href="{{ route('admin.departments.index') }}" class="nav-card animate-in delay-2">
        <div class="nav-content-wrapper">
            <div class="nav-icon"><i class="fas fa-sitemap"></i></div>
            <div class="nav-info">
                <strong>Organigramme</strong>
                <p>Départements et affectations</p>
            </div>
        </div>
        <div class="nav-arrow"><i class="fas fa-chevron-right"></i></div>
    </a>

    <a href="{{ route('leave-requests.pending') }}" class="nav-card animate-in delay-3">
        <div class="nav-content-wrapper">
            <div class="nav-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="nav-info">
                <strong>Gestion des Congés</strong>
                <p>Validation et suivi des plannings</p>
            </div>
        </div>
        <div class="nav-arrow"><i class="fas fa-chevron-right"></i></div>
    </a>
</div>

<script>
    function toggleUsers(action) {
        const items = document.querySelectorAll('.recent-user');
        const showMoreBtn = document.getElementById('showMoreBtn');
        const showLessBtn = document.getElementById('showLessBtn');

        if (action === 'more') {
            items.forEach((item, index) => {
                if (index >= 2) {
                    item.classList.remove('hidden-item');
                    item.style.animation = 'fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards';
                    item.style.animationDelay = `${(index - 2) * 0.08}s`;
                    item.style.opacity = '0';
                }
            });
            showMoreBtn.style.display = 'none';
            showLessBtn.style.display = 'inline-flex';
        } else {
            items.forEach((item, index) => {
                if (index >= 2) {
                    item.classList.add('hidden-item');
                }
            });
            showLessBtn.style.display = 'none';
            showMoreBtn.style.display = 'inline-flex';
        }
    }
</script>
@endsection