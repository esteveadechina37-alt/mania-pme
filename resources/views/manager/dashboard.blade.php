@extends('layouts.admin')

@section('title', 'Dashboard Manager')

@section('content')
<style>
    /* ========== DESIGN SYSTEM ========== */
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
        --shadow-md: 0 6px 16px rgba(10, 10, 10, 0.04);
        --shadow-lg: 0 10px 24px rgba(255, 98, 0, 0.08);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 22px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .animate-in {
        animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.15s; }
    .delay-3 { animation-delay: 0.2s; }
    .delay-4 { animation-delay: 0.25s; }

    /* Header */
    .dashboard-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .welcome-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 4px 0;
        line-height: 1.2;
    }
    .welcome-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .welcome-subtitle {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 14px;
        margin: 0;
    }
    .role-badge {
        background: var(--dark);
        color: var(--white);
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 20px rgba(10, 10, 10, 0.15);
        white-space: nowrap;
    }
    .live-indicator {
        width: 7px;
        height: 7px;
        background-color: #10B981;
        border-radius: 50%;
        position: relative;
    }
    .live-indicator::after {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        width: 13px;
        height: 13px;
        background-color: rgba(16, 185, 129, 0.4);
        border-radius: 50%;
        animation: livePulse 2s infinite;
    }
    @keyframes livePulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.4; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Bento grid */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }
    .bento-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 16px;
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
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .bento-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .bento-card:hover::before { opacity: 1; }
    .bento-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }
    .bento-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .bento-icon {
        width: 38px;
        height: 38px;
        border-radius: var(--radius-sm);
        background: var(--gray-50);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: var(--transition-smooth);
        border: 1px solid var(--gray-200);
    }
    .bento-card:hover .bento-icon {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }
    .bento-body {
        position: relative;
        z-index: 1;
    }
    .bento-value {
        font-family: 'Clash Display', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
        margin: 0 0 6px 0;
    }
    .bento-footer {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 500;
        padding-top: 8px;
        border-top: 1px solid var(--gray-100);
    }
    .trend-pill {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 3px 8px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 10px;
    }
    .trend-success { background: rgba(16, 185, 129, 0.1); color: #10B981; }
    .trend-warning { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
    .trend-info { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }

    /* Deux colonnes */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-top: 4px;
    }
    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; }
    }
    .info-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 18px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
    }
    .info-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    .info-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .info-card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
    }

    /* Équipe */
    .member-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .member-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }
    .member-item:hover {
        background: var(--white);
        border-color: var(--primary);
        transform: translateX(2px);
    }
    .member-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }
    .member-info strong {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        display: block;
    }
    .member-info span {
        font-size: 11px;
        color: var(--gray-600);
    }
    .empty-state {
        color: var(--gray-600);
        font-size: 13px;
        padding: 10px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Guide */
    .guide-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .guide-item {
        display: flex;
        gap: 10px;
    }
    .guide-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .guide-text strong {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        display: block;
        margin-bottom: 2px;
    }
    .guide-text p {
        font-size: 11px;
        color: var(--gray-600);
        margin: 0;
    }

    /* Utilitaires */
    .hidden-item { display: none !important; }
    .action-container {
        display: flex;
        justify-content: center;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid var(--gray-100);
    }
    .btn-glow {
        background: var(--dark);
        color: var(--white);
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 13px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(10, 10, 10, 0.15);
    }
    .btn-glow:hover {
        background: var(--primary);
        border-color: var(--primary);
        box-shadow: 0 8px 20px var(--primary-glow);
        transform: translateY(-1px);
    }
</style>

<div class="dashboard-header animate-in">
    <div>
        <h1 class="welcome-title">
            Bienvenue, <span>{{ auth()->user()->name }}</span>
        </h1>
        <p class="welcome-subtitle">Gérez votre équipe et les demandes</p>
        @if($department)
            <span style="display:inline-flex; align-items:center; gap:6px; background: var(--primary-light); color: var(--primary); padding: 4px 14px; border-radius: var(--radius-full); font-weight:600; font-size:13px; margin-top: 8px;">
                <i class="fas fa-building"></i> {{ $department->name }}
            </span>
        @endif
    </div>
    <div class="role-badge">
        <span class="live-indicator"></span>
        {{ auth()->user()->company->name ?? 'Mania-PME' }} · Manager
    </div>
</div>

{{-- Bento Grid Statistiques --}}
<div class="bento-grid">
    <div class="bento-card animate-in delay-1">
        <div>
            <div class="bento-header">
                <span class="bento-label">Équipe</span>
                <div class="bento-icon"><i class="fas fa-user-friends"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $teamMembersCount }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-success"><i class="fas fa-users"></i> Actifs</span>
            <span>Dans l'entreprise</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-2">
        <div>
            <div class="bento-header">
                <span class="bento-label">Demandes</span>
                <div class="bento-icon"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $pendingRequests }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-warning"><i class="fas fa-clock"></i> En attente</span>
            <span>Dans votre département</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-3">
        <div>
            <div class="bento-header">
                <span class="bento-label">Présents</span>
                <div class="bento-icon"><i class="fas fa-user-check"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $presentToday }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-info"><i class="fas fa-bolt"></i> Aujourd'hui</span>
            <span>Pointages</span>
        </div>
    </div>
</div>

{{-- Guide + Équipe --}}
<div class="info-grid">
    {{-- Carte Guide --}}
    <div class="info-card animate-in delay-4">
        <div class="info-card-header">
            <div class="info-card-icon"><i class="fas fa-compass"></i></div>
            <h3 class="info-card-title">Comment gérer votre espace</h3>
        </div>
        <div class="guide-list">
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-users"></i></div>
                <div class="guide-text">
                    <strong>Consultez votre équipe</strong>
                    <p>Visualisez les membres de votre département et leurs postes.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="guide-text">
                    <strong>Validez les congés</strong>
                    <p>Approuvez ou refusez les demandes de congé depuis la section dédiée.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-chart-line"></i></div>
                <div class="guide-text">
                    <strong>Suivez les présences</strong>
                    <p>Consultez les pointages quotidiens de vos collaborateurs.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Carte Mon équipe --}}
    <div class="info-card animate-in delay-4">
        <div class="info-card-header">
            <div class="info-card-icon"><i class="fas fa-user-friends"></i></div>
            <h3 class="info-card-title">Mon équipe</h3>
        </div>

        @if($teamUsers->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user-slash" style="opacity: 0.4;"></i>
                <span>Aucun membre pour l'instant.</span>
            </div>
        @else
            <div class="member-list" id="teamList">
                @foreach($teamUsers as $index => $employee)
                    <div class="member-item recent-user {{ $index >= 2 ? 'hidden-item' : '' }}">
                        <div class="member-avatar">
                            {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                        </div>
                        <div class="member-info">
                            <strong>{{ $employee->user->name }}</strong>
                            <span>{{ $employee->position ?? 'Sans poste' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($teamUsers->count() > 2)
                <div class="action-container" id="buttonsContainer">
                    <button id="showMoreBtn" onclick="toggleUsers('more')" class="btn-glow">
                        <span>Déployer ({{ $teamUsers->count() - 2 }})</span>
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