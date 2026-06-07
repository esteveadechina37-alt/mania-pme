@extends('layouts.admin')

@section('title', 'Dashboard Admin')

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
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 4px rgba(10,10,10,0.02);
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,0.08);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes fadeSlideUp {
        0% { opacity:0; transform:translateY(12px); }
        100% { opacity:1; transform:translateY(0); }
    }
    @keyframes float {
        0%,100% { transform:translateY(0); }
        50% { transform:translateY(-3px); }
    }
    @keyframes progressBar {
        from { width:0; }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.08s; }
    .delay-2 { animation-delay:0.16s; }
    .delay-3 { animation-delay:0.24s; }
    .delay-4 { animation-delay:0.32s; }

    /* COMPACT LAYOUT */
    .dashboard {
        display: flex;
        flex-direction: column;
        gap: 16px;
        max-height: calc(100vh - 100px); /* adapte à la hauteur de l'écran */
    }
    @media (max-width: 768px) {
        .dashboard { max-height: none; }
    }

    /* HEADER */
    /* .dash-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
    }
    .dash-title {
        font-family: 'Clash Display', sans-serif; font-size: 26px; font-weight: 700; color: var(--dark);
        display: flex; align-items: center; gap: 10px; line-height: 1.2;
    }
    .dash-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .tenant-badge {
        background: var(--dark); color: var(--white); padding: 6px 16px;
        border-radius: var(--radius-full); font-size: 12px; font-weight: 600;
        display: flex; align-items: center; gap: 8px; white-space: nowrap;
    }
    .live-dot { width:7px; height:7px; background:#10B981; border-radius:50%; } */

      /* ===== HEADER AMÉLIORÉ ===== */
        .dash-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 20px 24px;
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
        }
        .dash-header::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: var(--primary-glow);
            filter: blur(60px);
            z-index: 0;
        }
        .dash-header > * {
            position: relative;
            z-index: 1;
        }
        .welcome-block {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .avatar-admin {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
            box-shadow: 0 8px 16px rgba(255,98,0,0.3);
            flex-shrink: 0;
        }
        .dash-title {
            font-family: 'Clash Display', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
        }
        .dash-title span {
            background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dash-subtitle {
            color: var(--gray-600);
            font-size: 13px;
            font-weight: 500;
        }
        .stats-inline {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }
        .stat-mini {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
            background: var(--gray-50);
            padding: 8px 14px;
            border-radius: var(--radius-full);
            border: 1px solid var(--gray-200);
        }
        .stat-mini i {
            color: var(--primary);
            font-size: 15px;
        }
        .live-dot {
            width: 7px;
            height: 7px;
            background: #10B981;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
            animation: livePulse 2s infinite;
        }
        @keyframes livePulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.6); opacity: 0.4; }
            100% { transform: scale(1); opacity: 1; }
        }


    /* KPI BENTO (4 cartes) */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 12px;
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

    /* SECTION PRINCIPALE (activité + jauges) */
    .main-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 16px;
        flex: 1; /* prend l'espace restant */
        min-height: 0; /* important pour éviter le débordement */
    }
    @media (max-width: 800px) { .main-row { grid-template-columns: 1fr; } }

    .card-panel {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        display: flex; flex-direction: column; overflow: hidden;
    }
    .card-panel .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 18px; font-weight: 700;
        color: var(--dark); margin-bottom: 8px; display: flex; align-items: center; gap: 8px;
    }
    .card-panel .card-title i { color: var(--primary); }

    /* ACTIVITÉ ONGLETS */
    .tabs-nav { display:flex; gap:6px; margin-bottom:10px; flex-wrap:wrap; }
    .tab-btn {
        padding:4px 12px; border-radius: var(--radius-full); font-size:11px; font-weight:600;
        background:var(--gray-50); border:1px solid var(--gray-200); color:var(--gray-600); cursor:pointer;
        transition:0.15s;
    }
    .tab-btn.active { background:var(--primary); color:white; border-color:var(--primary); }
    .tab-content { display:none; overflow-y: auto; flex:1; }
    .tab-content.active { display:block; }
    .activity-item {
        display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid var(--gray-100); font-size:13px;
    }
    .activity-item:last-child { border-bottom:none; }
    .act-icon {
        width:32px; height:32px; border-radius:8px; background:var(--primary-light); color:var(--primary);
        display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0;
    }
    .act-text strong { color:var(--dark); font-weight:600; }
    .act-text span { color:var(--gray-600); font-size:11px; }

    /* JAUGE DYNAMIQUE */
    .gauge-list { display:flex; flex-direction:column; gap:10px; overflow-y:auto; flex:1; }
    .gauge-item { }
    .gauge-label { display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:var(--dark); }
    .gauge-label strong { font-weight:600; }
    .gauge-bar {
        height:8px; background:var(--gray-100); border-radius:4px; overflow:hidden;
    }
    .gauge-fill {
        height:100%; background: linear-gradient(90deg, #FF8C42, #FF6200);
        border-radius:4px; width:0%; animation: progressBar 0.8s ease forwards;
        box-shadow: 0 0 8px rgba(255,98,0,0.3);
    }

    /* LIENS RAPIDES */
    .quick-links {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 10px; margin-top: 12px;
    }
    .quick-link {
        background: var(--white); border-radius: var(--radius-md); padding: 12px 16px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        text-decoration: none; display: flex; align-items: center; gap: 10px;
        transition: var(--transition-smooth);
    }
    .quick-link:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .ql-icon {
        width: 36px; height: 36px; border-radius: 8px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 16px;
    }
    .ql-text strong { font-size: 14px; color: var(--dark); display: block; }
    .ql-text span { font-size: 11px; color: var(--gray-600); }
</style>

<div class="dashboard">
    {{-- Header --}}
        <div class="dash-header animate-in">
        <div class="welcome-block">
            <div class="avatar-admin">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="dash-title">Bienvenue, <span>{{ auth()->user()->name }}</span></h1>
                <p class="dash-subtitle">
                    <span class="live-dot"></span>
                    {{ auth()->user()->company->name ?? 'Mania-PME' }}
                    · {{ now()->isoFormat('dddd D MMMM YYYY') }}
                </p>
            </div>
        </div>
        <div class="stats-inline">
            <div class="stat-mini">
                <i class="fas fa-user-check"></i>
                <span>{{ $activeEmployees }} actifs</span>
            </div>
            <div class="stat-mini">
                <i class="fas fa-bell"></i>
                <span>{{ $notifications->whereNull('read_at')->count() }} non lues</span>
            </div>
        </div>
    </div>
    <!-- <div class="dash-header animate-in">
        <h1 class="dash-title">Bienvenue, <span>{{ auth()->user()->name }}</span></h1>
        <div class="tenant-badge"><span class="live-dot"></span> {{ auth()->user()->company->name ?? 'Mania-PME' }}</div>
    </div> -->

    {{-- 4 KPI Cards --}}
    <div class="kpi-grid">
        <div class="kpi-card animate-in delay-1">
            <div class="kpi-header">
                <span class="kpi-label">Employés actifs</span>
                <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
            </div>
            <div class="kpi-value">{{ $activeEmployees }}</div>
            <div class="kpi-footer"><i class="fas fa-users" style="color:var(--primary);"></i> Actifs</div>
        </div>
        <div class="kpi-card animate-in delay-2">
            <div class="kpi-header">
                <span class="kpi-label">Congés en attente</span>
                <div class="kpi-icon"><i class="fas fa-calendar-alt"></i></div>
            </div>
            <div class="kpi-value">{{ $pendingLeaves }}</div>
            <div class="kpi-footer"><i class="fas fa-clock" style="color:#F59E0B;"></i> À traiter</div>
        </div>
        <div class="kpi-card animate-in delay-3">
            <div class="kpi-header">
                <span class="kpi-label">Présents aujourd'hui</span>
                <div class="kpi-icon"><i class="fas fa-user-clock"></i></div>
            </div>
            <div class="kpi-value">{{ $todayAttendances }}</div>
            <div class="kpi-footer"><i class="fas fa-bolt" style="color:#10B981;"></i> Pointages</div>
        </div>
        <div class="kpi-card animate-in delay-4">
            <div class="kpi-header">
                <span class="kpi-label">Contrats expirants</span>
                <div class="kpi-icon"><i class="fas fa-file-contract"></i></div>
            </div>
            <div class="kpi-value">{{ $expiringContracts }}</div>
            <div class="kpi-footer"><i class="fas fa-hourglass-half" style="color:#EF4444;"></i> Dans 30 jours</div>
        </div>
    </div>

    {{-- Activité + Jauges --}}
    <div class="main-row animate-in delay-4">
        {{-- Activité récente --}}
        <div class="card-panel">
            <div class="card-title"><i class="fas fa-stream"></i> Activité récente</div>
            <div class="tabs-nav">
                <button class="tab-btn active" onclick="switchTab('members', this)">Membres</button>
                <button class="tab-btn" onclick="switchTab('leaves', this)">Congés</button>
                <button class="tab-btn" onclick="switchTab('evaluations', this)">Évaluations</button>
            </div>
            <div class="tab-content active" id="tab-members">
                @forelse($recentUsers->take(4) as $user)
                    <div class="activity-item">
                        <div class="act-icon"><i class="fas fa-user-plus"></i></div>
                        <div class="act-text">
                            <strong>{{ $user->name }}</strong>
                            <span>{{ $user->getRoleNames()->first() }} · {{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p style="color:var(--gray-600);">Aucun membre récent.</p>
                @endforelse
            </div>
            <div class="tab-content" id="tab-leaves">
                @forelse($recentLeaveRequests->take(4) as $lr)
                    <div class="activity-item">
                        <div class="act-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="act-text">
                            <strong>{{ $lr->employee->user->name }}</strong>
                            <span>{{ $lr->leaveType->name }} · {{ $lr->status }}</span>
                        </div>
                    </div>
                @empty
                    <p style="color:var(--gray-600);">Aucune demande récente.</p>
                @endforelse
            </div>
            <div class="tab-content" id="tab-evaluations">
                @forelse($recentEvaluations->take(4) as $eval)
                    <div class="activity-item">
                        <div class="act-icon"><i class="fas fa-star"></i></div>
                        <div class="act-text">
                            <strong>{{ $eval->employee->user->name }}</strong>
                            <span>{{ $eval->period }} · {{ $eval->score }}/5</span>
                        </div>
                    </div>
                @empty
                    <p style="color:var(--gray-600);">Aucune évaluation récente.</p>
                @endforelse
            </div>
        </div>

        {{-- Jauges de répartition par département --}}
        <div class="card-panel">
            <div class="card-title"><i class="fas fa-chart-pie"></i> Répartition par département</div>
            @php $totalDept = $departmentsStats->sum('employees_count'); @endphp
            <div class="gauge-list">
                @forelse($departmentsStats as $dept)
                    @php $percent = $totalDept > 0 ? round(($dept->employees_count / $totalDept) * 100) : 0; @endphp
                    <div class="gauge-item">
                        <div class="gauge-label">
                            <strong>{{ $dept->name }}</strong>
                            <span>{{ $dept->employees_count }} employé(s)</span>
                        </div>
                        <div class="gauge-bar">
                            <div class="gauge-fill" style="width: {{ $percent }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p style="color:var(--gray-600);">Aucun département.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Liens rapides --}}
    <h3 class="card-title" style="margin-bottom: -1rem;"><i class="fas fa-bolt"></i> Action Rapide</h3>
    <div class="quick-links animate-in delay-4">
        <a href="{{ route('admin.employees.index') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-users"></i></div>
            <div class="ql-text"><strong>Employés</strong><span>Gestion</span></div>
        </a>
        <a href="{{ route('admin.departments.index') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-sitemap"></i></div>
            <div class="ql-text"><strong>Départements</strong><span>Structure</span></div>
        </a>
        <a href="{{ route('leave-requests.pending') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="ql-text"><strong>Congés</strong><span>Validation</span></div>
        </a>
        <a href="{{ route('admin.contracts.index') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-file-contract"></i></div>
            <div class="ql-text"><strong>Contrats</strong><span>Échéances</span></div>
        </a>
        <a href="{{ route('admin.evaluations.index') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-star"></i></div>
            <div class="ql-text"><strong>Évaluations</strong><span>Suivi</span></div>
        </a>
        <a href="{{ route('admin.payslips.index') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-file-invoice"></i></div>
            <div class="ql-text"><strong>Paie</strong><span>Bulletins</span></div>
        </a>
    </div>
</div>

<script>
    function switchTab(tabName, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tabName).classList.add('active');
    }
</script>
@endsection