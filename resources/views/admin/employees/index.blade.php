@extends('layouts.admin')

@section('title', 'Employés')

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
        --white: #FFFFFF;
        --shadow-sm: 0 2px 4px rgba(10,10,10,0.02);
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,0.08);
        --shadow-xl: 0 24px 48px rgba(10,10,10,0.1);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity:0; transform:translateY(16px); }
        100% { opacity:1; transform:translateY(0); }
    }
    @keyframes float {
        0%,100% { transform:translateY(0); }
        50% { transform:translateY(-4px); }
    }
    @keyframes glassShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }
    .animate-in { animation: fadeSlideUp 0.55s ease both; opacity:0; }
    .delay-1 { animation-delay:0.1s; }
    .delay-2 { animation-delay:0.2s; }
    .delay-3 { animation-delay:0.3s; }
    .delay-4 { animation-delay:0.4s; }

    .page-header {
        display:flex; align-items:flex-start; justify-content:space-between;
        margin-bottom:24px; flex-wrap:wrap; gap:16px;
    }
    .page-title {
        font-family:'Clash Display',sans-serif; font-size:28px; font-weight:700; color:var(--dark);
        display:flex; align-items:center; gap:10px;
    }
    .page-title span {
        background:linear-gradient(135deg,var(--primary) 0%,#FF3D00 100%);
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    }
    .page-subtitle { color:var(--gray-600); font-size:14px; }
    .btn-primary {
        background:linear-gradient(135deg,var(--primary) 0%,var(--primary-hover) 100%);
        color:white; padding:10px 22px; border-radius:var(--radius-full);
        font-weight:600; font-size:13px; border:none; cursor:pointer;
        display:inline-flex; align-items:center; gap:8px;
        box-shadow:0 4px 12px rgba(255,98,0,0.2);
        text-decoration:none; transition:var(--transition-smooth);
    }
    .btn-primary:hover { transform:translateY(-2px); box-shadow:0 6px 18px var(--primary-glow); }

    .alert-success {
        background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px;
        padding:12px 18px; margin-bottom:20px; color:#065F46;
        display:flex; align-items:center; gap:8px; font-size:14px;
    }

    /* ===== KPIs (glass) ===== */
    .kpi-grid {
        display:grid; grid-template-columns:repeat(4,1fr);
        gap:16px; margin-bottom:24px;
    }
    @media (max-width:1000px) { .kpi-grid { grid-template-columns:repeat(2,1fr); } }
    @media (max-width:600px) { .kpi-grid { grid-template-columns:1fr; } }

    .kpi-card {
        background:rgba(255,255,255,0.8);
        backdrop-filter:blur(16px);
        -webkit-backdrop-filter:blur(16px);
        border-radius:var(--radius-md);
        /* padding:20px 24px; */
            padding: 14px 18px;               /* ← réduit (anciennement 20px 24px) */
        box-shadow:var(--shadow-md);
        border:1px solid rgba(255,255,255,0.6);
        position:relative;
        overflow:hidden;
        transition:var(--transition-smooth);
        display:flex;
        flex-direction:column;
        justify-content:space-between;
    }
    .kpi-card::before {
        content:''; position:absolute; inset:0;
        background:radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity:0; transition:var(--transition-smooth);
    }
    .kpi-card::after {
        content:''; position:absolute; inset:0;
        background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.2) 30%, transparent 60%);
        background-size:200% 100%;
        animation:glassShine 5s infinite;
        opacity:0; transition:opacity 0.4s;
        pointer-events:none;
    }
    .kpi-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-xl); border-color:var(--primary); }
    .kpi-card:hover::before { opacity:1; }
    .kpi-card:hover::after { opacity:1; }
    .kpi-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; z-index:1; }
    .kpi-label { font-size:11px; font-weight:600; color:var(--gray-600); text-transform:uppercase; letter-spacing:0.4px; }
    .kpi-icon {
        width:36px; height:40px; border-radius:8px;
        background:var(--gray-50); color:var(--dark);
        display:flex; align-items:center; justify-content:center;
        font-size:16px; border:1px solid var(--gray-200);
        transition:var(--transition-smooth);
    }
    .kpi-card:hover .kpi-icon {
        background:var(--primary); color:white; border-color:var(--primary);
        animation:float 2s ease-in-out infinite;
    }
    .kpi-value {
        font-family:'Clash Display',sans-serif; font-size:28px; font-weight:700;
        color:var(--dark); line-height:1; margin-bottom:6px; z-index:1;
    }
    .kpi-footer {
        display:flex; align-items:center; gap:8px; font-size:10px;
        color:var(--gray-600); padding-top:6px; border-top:1px solid var(--gray-100); z-index:1;
    }
    .trend-pill {
        display:inline-flex; align-items:center; gap:4px; padding:4px 10px;
        border-radius:var(--radius-full); font-weight:600; font-size:11px;
    }
    .trend-success { background:rgba(16,185,129,0.1); color:#10B981; }
    .trend-info { background:rgba(59,130,246,0.1); color:#3B82F6; }

    /* ===== MAIN GRID ===== */
    .content-grid {
        display:grid; grid-template-columns:2fr 1fr; gap:24px;
    }
    @media (max-width:900px) { .content-grid { grid-template-columns:1fr; } }

    /* ===== EMPLOYEE LIST CARD ===== */
    .list-card {
        background:rgba(255,255,255,0.8);
        backdrop-filter:blur(16px);
        -webkit-backdrop-filter:blur(16px);
        border-radius:var(--radius-md);
        padding:24px;
        box-shadow:var(--shadow-md);
        border:1px solid rgba(255,255,255,0.6);
    }
    .card-header {
        display:flex; align-items:center; justify-content:space-between;
        margin-bottom:20px;
    }
    .card-title {
        font-family:'Clash Display',sans-serif; font-size:20px; font-weight:700;
        color:var(--dark); display:flex; align-items:center; gap:8px;
    }
    .card-title i { color:var(--primary); }
    .badge-count {
        background:var(--primary-light); color:var(--primary);
        padding:4px 14px; border-radius:var(--radius-full); font-size:12px; font-weight:700;
        border:1px solid rgba(255,98,0,0.2);
    }

    .employee-list { display:flex; flex-direction:column; gap:10px; }
    .employee-item {
        display:flex; align-items:center; justify-content:space-between;
        padding:14px 18px; background:var(--gray-50);
        border-radius:var(--radius-sm); border:1px solid var(--gray-200);
        transition:var(--transition-smooth); gap:12px; flex-wrap:wrap;
        position:relative; overflow:hidden;
    }
    .employee-item::after {
        content:''; position:absolute; inset:0;
        background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.3) 40%, transparent 80%);
        background-size:200% 100%; opacity:0; transition:opacity 0.4s; pointer-events:none;
    }
    .employee-item:hover { background:white; border-color:var(--primary); box-shadow:var(--shadow-md); transform:scale(1.01); }
    .employee-item:hover::after { opacity:1; }
    .employee-info { display:flex; align-items:center; gap:12px; flex:1; }
    .avatar {
        width:40px; height:40px; border-radius:10px;
        background:linear-gradient(135deg,var(--dark),#2A2A2A);
        color:white; display:flex; align-items:center; justify-content:center;
        font-family:'Clash Display',sans-serif; font-weight:700; font-size:16px;
        flex-shrink:0; transition:var(--transition-smooth);
    }
    .employee-item:hover .avatar {
        background:linear-gradient(135deg,var(--primary),#FF3D00);
        transform:rotate(-4deg) scale(1.05);
        box-shadow:0 4px 12px var(--primary-glow);
    }
    .employee-details strong { font-size:15px; font-weight:700; color:var(--dark); display:block; }
    .employee-details span { font-size:12px; color:var(--gray-600); display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
    .status-badge {
        background:white; color:var(--dark); padding:4px 12px; border-radius:var(--radius-full);
        font-size:11px; font-weight:600; border:1px solid var(--gray-200);
        white-space:nowrap;
    }
    .employee-item:hover .status-badge { border-color:var(--primary-glow); background:var(--primary-light); color:var(--primary); }
    .action-group { display:flex; gap:4px; }
    .action-btn {
        width:32px; height:32px; border-radius:8px;
        display:inline-flex; align-items:center; justify-content:center;
        background:transparent; color:var(--gray-600);
        border:1px solid var(--gray-200); cursor:pointer; transition:var(--transition-fast);
        text-decoration:none; font-size:13px;
    }
    .action-btn:hover { border-color:var(--primary-glow); background:var(--primary-light); color:var(--primary); }
    .action-btn.delete:hover { background:#FEE2E2; color:#DC2626; border-color:#FEE2E2; }

    /* ===== TOP EVALUATIONS CARD ===== */
    .top-card {
        background:rgba(255,255,255,0.8);
        backdrop-filter:blur(16px);
        -webkit-backdrop-filter:blur(16px);
        border-radius:var(--radius-md);
        padding:20px;
        box-shadow:var(--shadow-md);
        border:1px solid rgba(255,255,255,0.6);
    }
    .top-item {
        display:flex; align-items:center; gap:10px; padding:12px 0;
        border-bottom:1px solid var(--gray-100);
    }
    .top-item:last-child { border-bottom:none; }
    .top-avatar {
        width:36px; height:36px; border-radius:10px;
        background:linear-gradient(135deg,var(--primary),var(--primary-hover));
        color:white; display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:14px; flex-shrink:0;
    }
    .top-info { flex:1; }
    .top-info strong { font-size:14px; color:var(--dark); display:block; }
    .top-info .stars { color:#F59E0B; font-size:13px; }
    .top-score { font-weight:700; color:var(--dark); }

    .pagination-wrap { margin-top:20px; display:flex; justify-content:center; }
    .hidden-item { display:none!important; }
    .action-container { display:flex; justify-content:center; margin-top:16px; padding-top:16px; border-top:1px solid var(--gray-100); }
    .btn-glow {
        background:var(--dark); color:white; padding:10px 24px; border-radius:var(--radius-full);
        font-weight:600; font-size:13px; border:1px solid rgba(255,255,255,0.1);
        cursor:pointer; display:inline-flex; align-items:center; gap:8px;
        box-shadow:0 8px 20px rgba(10,10,10,0.15); transition:var(--transition-smooth);
    }
    .btn-glow:hover { background:var(--primary); border-color:var(--primary); box-shadow:0 12px 30px var(--primary-glow); transform:translateY(-2px); }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-user-friends" style="color:var(--primary);"></i> Gestion des <span>Employés</span></h1>
        <p class="page-subtitle">Pilotez votre effectif et suivez les statuts</p>
    </div>
   <div class="header-actions">
     <a href="{{ route('admin.employees.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i> Nouvel employé
    </a>
    <a href="{{ route('admin.employees.import') }}" class="btn-primary">
        <i class="fas fa-upload"></i> Importer CSV
    </a>
   </div>
</div>

@if(session('import_errors'))
    <div class="alert alert-warning">
        @foreach(session('import_errors') as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
@endif

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

{{-- KPI Cards --}}
<div class="kpi-grid">
    <div class="kpi-card animate-in delay-1">
        <div class="kpi-header">
            <span class="kpi-label">Effectif Total</span>
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
        </div>
        <div class="kpi-value">{{ $totalEmployees }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-success"><i class="fas fa-arrow-up"></i> 100%</span> Collaborateurs</div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">Actifs</span>
            <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
        </div>
        <div class="kpi-value">{{ $activeCount }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-success"><i class="fas fa-check"></i> En poste</span> Disponibles</div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">En Congé</span>
            <div class="kpi-icon"><i class="fas fa-umbrella-beach"></i></div>
        </div>
        <div class="kpi-value">{{ $onLeaveCount }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-info"><i class="fas fa-calendar"></i> Absents</span> Temporairement</div>
    </div>
    <div class="kpi-card animate-in delay-4">
        <div class="kpi-header">
            <span class="kpi-label">Départements</span>
            <div class="kpi-icon"><i class="fas fa-building"></i></div>
        </div>
        <div class="kpi-value">{{ $departmentsCount }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-info"><i class="fas fa-sitemap"></i> Services</span> Organisés</div>
    </div>
</div>

{{-- Liste + Top Évaluations --}}
<div class="content-grid animate-in delay-4">
    {{-- Liste des employés --}}
    <div class="list-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-layer-group"></i> Membres de l'équipe</h3>
            @if($employees->count() > 0)
                <span class="badge-count">{{ $employees->total() }} employé(s)</span>
            @endif
        </div>

        @if($employees->isEmpty())
            <div style="text-align:center; padding:40px; color:var(--gray-600);">
                <i class="fas fa-inbox fa-3x" style="margin-bottom:12px; opacity:0.3;"></i>
                <p>Aucun collaborateur enregistré.</p>
            </div>
        @else
            <div class="employee-list">
                @foreach($employees as $employee)
                    <div class="employee-item recent-user">
                        <div class="employee-info">
                            <div class="avatar">{{ strtoupper(substr($employee->user->name,0,1)) }}</div>
                            <div class="employee-details">
                                <strong>{{ $employee->user->name }}</strong>
                                <span>
                                    <i class="fas fa-envelope" style="color:var(--gray-300);"></i> {{ $employee->user->email }}
                                    | <span class="badge badge-role">{{ $employee->user->getRoleNames()->first() ?? 'N/A' }}</span>
                                    @if($employee->department) | {{ $employee->department->name }} @endif
                                    @if($employee->position) | {{ $employee->position }} @endif
                                </span>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span class="status-badge">{{ ucfirst($employee->status) }}</span>
                            <div class="action-group">
                                <a href="{{ route('admin.employees.show',$employee) }}" class="action-btn"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.employees.edit',$employee) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                                <button type="button" onclick="openConfirmModal('{{ route('admin.employees.destroy',$employee) }}')" class="action-btn delete"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="action-container">
                <button id="showMoreBtn" onclick="toggleUsers('more')" class="btn-glow" style="{{ $employees->count() > 2 ? '' : 'display:none;' }}">
                    <span>Déployer la liste ({{ $employees->count()-2 }})</span>
                    <i class="fas fa-arrow-down"></i>
                </button>
                <button id="showLessBtn" onclick="toggleUsers('less')" class="btn-glow" style="display:none;">
                    <span>Réduire la liste</span>
                    <i class="fas fa-arrow-up"></i>
                </button>
            </div>
        @endif
    </div>

    {{-- Top Évaluations --}}
    <div class="top-card">
        <div class="card-header" style="margin-bottom:16px;">
            <h3 class="card-title" style="font-size:18px;"><i class="fas fa-star" style="color:var(--primary);"></i> Top évaluations</h3>
        </div>
        @if($topEvaluated->isEmpty())
            <p style="color:var(--gray-600); text-align:center;">Aucune évaluation pour le moment.</p>
        @else
            @foreach($topEvaluated as $emp)
                @php $lastEval = $emp->evaluations->first(); @endphp
                <div class="top-item">
                    <div class="top-avatar">{{ strtoupper(substr($emp->user->name,0,1)) }}</div>
                    <div class="top-info">
                        <strong>{{ $emp->user->name }}</strong>
                        <div class="stars">
                            @for ($i = 0; $i < floor($lastEval->score); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            @if ($lastEval->score - floor($lastEval->score) >= 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @endif
                            @for ($i = 0; $i < 5 - ceil($lastEval->score); $i++)
                                <i class="far fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <span class="top-score">{{ number_format($lastEval->score,1) }}/5</span>
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="pagination-wrap animate-in delay-4">
    {{ $employees->links() }}
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
                    item.style.animation = 'fadeSlideUp 0.4s ease both';
                    item.style.animationDelay = `${(index - 2) * 0.08}s`;
                    item.style.opacity = '0';
                }
            });
            showMoreBtn.style.display = 'none';
            showLessBtn.style.display = 'inline-flex';
        } else {
            items.forEach((item, index) => {
                if (index >= 2) item.classList.add('hidden-item');
            });
            showLessBtn.style.display = 'none';
            showMoreBtn.style.display = 'inline-flex';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.recent-user').forEach((item, index) => {
            if (index >= 2) item.classList.add('hidden-item');
        });
    });
</script>
@endsection