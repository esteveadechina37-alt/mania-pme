@extends('layouts.admin')

@section('title', 'Employés')

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

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .animate-in {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* ========== HEADER ========== */
    .dashboard-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 30px;
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
        font-size: 30px;
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

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: var(--white);
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(10, 10, 10, 0.12), 0 2px 8px var(--primary-glow);
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--primary-glow);
    }

    .alert-success {
        background: #ECFDF5;
        border-left: 4px solid #10B981;
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        margin-bottom: 24px;
        color: #065F46;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    /* ========== BENTO GRID (identique dashboard) ========== */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .bento-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
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
        margin-bottom: 16px;
        position: relative;
        z-index: 1;
    }

    .bento-label {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .bento-icon {
        width: 44px;
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

    .bento-body {
        position: relative;
        z-index: 1;
    }

    .bento-value {
        font-family: 'Clash Display', sans-serif;
        font-size: 34px;
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
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 11px;
    }

    .trend-success { background: rgba(16, 185, 129, 0.1); color: #10B981; }
    .trend-warning { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
    .trend-info { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }

    /* ========== LISTE EMPLOYÉS ========== */
    .members-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 28px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i { color: var(--primary); }

    .badge-count {
        background: var(--primary-light);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid rgba(255, 98, 0, 0.2);
    }

    .member-grid {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .member-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
        gap: 16px;
        flex-wrap: wrap;
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
        gap: 14px;
        flex: 1;
    }

    .member-avatar {
        width: 44px;
        height: 44px;
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
        flex-shrink: 0;
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
        margin-bottom: 4px;
    }

    .member-details span {
        color: var(--gray-600);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
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
        white-space: nowrap;
    }

    .member-row:hover .role-badge {
        border-color: var(--primary-glow);
        background: var(--primary-light);
        color: var(--primary);
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        cursor: pointer;
        transition: var(--transition-smooth);
        text-decoration: none;
        font-size: 14px;
    }

    .action-btn:hover {
        border-color: var(--primary-glow);
        background: var(--primary-light);
        color: var(--primary);
        transform: translateY(-1px);
    }

    .action-btn.delete:hover {
        background: #FEE2E2;
        color: #DC2626;
        border-color: #FEE2E2;
    }

    .pagination-wrap {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }

    .hidden-item { display: none !important; }

    .action-container {
        display: flex;
        justify-content: center;
        margin-top: 24px;
        padding-top: 24px;
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

    @media (max-width: 768px) {
        .bento-value { font-size: 28px; }
        .member-row { flex-direction: column; align-items: flex-start; }
        .role-badge { align-self: flex-start; }
    }
</style>

<div class="dashboard-header animate-in">
    <div>
        <h1 class="welcome-title">Gestion des <span>Employés</span></h1>
        <p class="welcome-subtitle">Pilotez votre effectif et suivez les statuts</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i> Nouvel employé
    </a>
</div>

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

<div class="bento-grid">
    <div class="bento-card animate-in delay-1">
        <div>
            <div class="bento-header">
                <span class="bento-label">Effectif Total</span>
                <div class="bento-icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $totalEmployees }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-success"><i class="fas fa-arrow-up"></i> 100%</span>
            <span>Collaborateurs</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-2">
        <div>
            <div class="bento-header">
                <span class="bento-label">Actifs</span>
                <div class="bento-icon"><i class="fas fa-user-check"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $activeCount }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-success"><i class="fas fa-check"></i> En poste</span>
            <span>Disponibles</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-3">
        <div>
            <div class="bento-header">
                <span class="bento-label">En Congé</span>
                <div class="bento-icon"><i class="fas fa-umbrella-beach"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $onLeaveCount }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-info"><i class="fas fa-calendar"></i> Absents</span>
            <span>Temporairement</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-4">
        <div>
            <div class="bento-header">
                <span class="bento-label">Départements</span>
                <div class="bento-icon"><i class="fas fa-building"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $departmentsCount }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-info"><i class="fas fa-sitemap"></i> Services</span>
            <span>Organisés</span>
        </div>
    </div>
</div>

<div class="members-card animate-in delay-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-layer-group"></i> Membres de l'équipe</h3>
        @if($employees->count() > 0)
            <span class="badge-count">{{ $employees->total() }} employé(s)</span>
        @endif
    </div>

    @if($employees->isEmpty())
        <div style="text-align:center; padding:48px 0; color:var(--gray-600);">
            <i class="fas fa-inbox fa-3x" style="margin-bottom:16px; opacity:0.3;"></i>
            <p>Aucun collaborateur enregistré.</p>
        </div>
    @else
        <div class="member-grid">
            @foreach($employees as $employee)
                @php
                    $statusClass = match(strtolower($employee->status)) {
                        'active' => 'actif',
                        'suspended' => 'suspendu',
                        'terminated' => 'terminé',
                        default => 'inactif'
                    };
                @endphp
                <div class="member-row recent-user">
                    <div class="member-meta">
                        <div class="member-avatar">
                            {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                        </div>
                        <div class="member-details">
                            <strong>{{ $employee->user->name }}</strong>
                            <span>
                                <i class="fas fa-envelope" style="color:var(--gray-300);"></i> {{ $employee->user->email }}
                                <span style="margin:0 4px;">|</span>
                                <span class="badge badge-role">{{ $employee->user->getRoleNames()->first() ?? 'N/A' }}</span>
                                @if($employee->department)
                                    <span style="margin:0 4px;">|</span> {{ $employee->department->name }}
                                @endif
                                @if($employee->position)
                                    <span style="margin:0 4px;">|</span> {{ $employee->position }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <span class="role-badge">{{ ucfirst($employee->status) }}</span>
                        <div style="display:flex; gap:4px;">
                            <a href="{{ route('admin.employees.show', $employee) }}" class="action-btn" title="Voir"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.employees.edit', $employee) }}" class="action-btn" title="Modifier"><i class="fas fa-edit"></i></a>
                            <button type="button" onclick="openConfirmModal('{{ route('admin.employees.destroy', $employee) }}')" class="action-btn delete" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="action-container">
            <button id="showMoreBtn" onclick="toggleUsers('more')" class="btn-glow" style="{{ $employees->count() > 2 ? '' : 'display:none;' }}">
                <span>Déployer la liste ({{ $employees->count() - 2 }})</span>
                <i class="fas fa-arrow-down"></i>
            </button>
            <button id="showLessBtn" onclick="toggleUsers('less')" class="btn-glow" style="display:none;">
                <span>Réduire la liste</span>
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>
    @endif
</div>

<div class="pagination-wrap animate-in delay-4">
    {{ $employees->links() }}
</div>

<script>
    // Fonction toggle (si plus de 2 éléments)
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

    // Initialisation : masquer les éléments au-delà du 2ème
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.recent-user');
        items.forEach((item, index) => {
            if (index >= 2) item.classList.add('hidden-item');
        });
    });
</script>
@endsection