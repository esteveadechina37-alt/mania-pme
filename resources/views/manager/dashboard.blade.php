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
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.08s; }
    .delay-2 { animation-delay:0.16s; }
    .delay-3 { animation-delay:0.24s; }
    .delay-4 { animation-delay:0.32s; }

    .dashboard { display: flex; flex-direction: column; gap: 16px; }

    /* ===== HEADER ===== */
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

    /* ===== KPI BENTO ===== */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
    }
    @media (max-width: 900px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
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

    /* ===== LIENS RAPIDES ===== */
    .quick-links {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 10px; margin-top: 4px;
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

    /* ===== MAIN ROW ===== */
    .main-row {
        display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
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

    /* Onglets */
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

    /* Liste des membres */
    .member-item {
        display: flex; align-items: center; gap: 10px; padding: 8px 10px;
        background: var(--gray-50); border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200); transition: var(--transition-smooth);
        margin-bottom: 6px;
    }
    .member-item:hover { background: var(--white); border-color: var(--primary); transform: translateX(2px); }
    .member-avatar {
        width: 32px; height: 32px; border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 13px; flex-shrink: 0;
    }
    .member-info strong { font-size: 13px; font-weight: 700; color: var(--dark); display: block; }
    .member-info span { font-size: 11px; color: var(--gray-600); }
    .hidden-item { display: none !important; }
    .action-container { display: flex; justify-content: center; margin-top: 12px; }
    .btn-glow {
        background: var(--dark); color: var(--white); padding: 8px 20px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 13px;
        border: 1px solid rgba(255,255,255,0.1); cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(10,10,10,0.15);
    }
    .btn-glow:hover {
        background: var(--primary); border-color: var(--primary);
        box-shadow: 0 8px 20px var(--primary-glow); transform: translateY(-1px);
    }

    /* Présences du jour */
    .presence-list {
        display: flex; flex-direction: column; gap: 6px; overflow-y: auto; flex: 1;
    }
    .presence-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 6px 8px; background: var(--gray-50); border-radius: 6px; font-size: 12px;
    }
    .presence-item span:first-child { font-weight: 600; }
    .status-dot {
        width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px;
    }
    .status-present { background: #10B981; }
    .status-late { background: #F59E0B; }
</style>

<div class="dashboard">
    {{-- ===== HEADER ===== --}}
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
                    @if($department)
                        · <strong>{{ $department->name }}</strong>
                    @endif
                    · {{ now()->isoFormat('dddd D MMMM YYYY') }}
                </p>
            </div>
        </div>
        <div class="stats-inline">
            <div class="stat-mini">
                <i class="fas fa-user-friends"></i>
                <span>{{ $teamMembersCount }} membres</span>
            </div>
            <div class="stat-mini">
                <i class="fas fa-bell"></i>
                <span>{{ $pendingRequests }} demande(s)</span>
            </div>
        </div>
    </div>

    {{-- ===== KPI CARDS (3) ===== --}}
    <div class="kpi-grid">
        <div class="kpi-card animate-in delay-1">
            <div class="kpi-header">
                <span class="kpi-label">Équipe</span>
                <div class="kpi-icon"><i class="fas fa-user-friends"></i></div>
            </div>
            <div class="kpi-value">{{ $teamMembersCount }}</div>
            <div class="kpi-footer"><i class="fas fa-users" style="color:var(--primary);"></i> Actifs</div>
        </div>
        <div class="kpi-card animate-in delay-2">
            <div class="kpi-header">
                <span class="kpi-label">Demandes en attente</span>
                <div class="kpi-icon"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="kpi-value">{{ $pendingRequests }}</div>
            <div class="kpi-footer"><i class="fas fa-clock" style="color:#F59E0B;"></i> À traiter</div>
        </div>
        <div class="kpi-card animate-in delay-3">
            <div class="kpi-header">
                <span class="kpi-label">Présents aujourd'hui</span>
                <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
            </div>
            <div class="kpi-value">{{ $presentToday }}</div>
            <div class="kpi-footer"><i class="fas fa-bolt" style="color:#10B981;"></i> Pointages</div>
        </div>
    </div>

    {{-- ===== LIENS RAPIDES (avant l'activité) ===== --}}
    <div class="quick-links animate-in delay-4">
        <a href="{{ route('leave-requests.pending') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="ql-text"><strong>Congés</strong><span>Validation</span></div>
        </a>
        <a href="{{ route('attendances.list') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-clock"></i></div>
            <div class="ql-text"><strong>Présences</strong><span>Pointages</span></div>
        </a>
        <a href="{{ route('admin.evaluations.index') }}" class="quick-link">
            <div class="ql-icon"><i class="fas fa-star"></i></div>
            <div class="ql-text"><strong>Évaluations</strong><span>Suivi</span></div>
        </a>
    </div>

    {{-- ===== MAIN ROW (Activité + Présences du jour) ===== --}}
    <div class="main-row animate-in delay-4">
        {{-- Activité récente (onglets) --}}
        <div class="card-panel">
            <div class="card-title"><i class="fas fa-stream"></i> Activité récente</div>
            <div class="tabs-nav">
                <button class="tab-btn active" onclick="switchTab('members', this)">Équipe</button>
                <button class="tab-btn" onclick="switchTab('leaves', this)">Congés</button>
                <button class="tab-btn" onclick="switchTab('presences', this)">Présences</button>
            </div>

            {{-- Onglet Membres --}}
            <div class="tab-content active" id="tab-members">
                @if($teamUsers->isEmpty())
                    <p style="color:var(--gray-600);">Aucun membre dans votre équipe.</p>
                @else
                    <div class="member-list" id="teamList">
                        @foreach($teamUsers as $index => $employee)
                            <div class="member-item {{ $index >= 2 ? 'hidden-item' : '' }}">
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

            {{-- Onglet Congés --}}
            <div class="tab-content" id="tab-leaves">
                @forelse($recentLeaveRequests ?? [] as $lr)
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

            {{-- Onglet Présences --}}
            <div class="tab-content" id="tab-presences">
                @forelse($todayAttendances ?? [] as $att)
                    <div class="activity-item">
                        <div class="act-icon"><i class="fas fa-user-clock"></i></div>
                        <div class="act-text">
                            <strong>{{ $att->employee->user->name }}</strong>
                            <span>
                                Arrivée {{ $att->check_in }}
                                @if($att->status == 'late') <span style="color:#F59E0B;">(Retard)</span> @endif
                            </span>
                        </div>
                    </div>
                @empty
                    <p style="color:var(--gray-600);">Aucun pointage aujourd'hui.</p>
                @endforelse
            </div>
        </div>

        {{-- Carte de droite : Présences du jour --}}
        <div class="card-panel">
            <div class="card-title"><i class="fas fa-user-check"></i> Présences du jour</div>
            <div class="presence-list">
                @forelse($todayAttendances ?? [] as $att)
                    <div class="presence-item">
                        <span>
                            <span class="status-dot {{ $att->status == 'present' ? 'status-present' : ($att->status == 'late' ? 'status-late' : '') }}"></span>
                            {{ $att->employee->user->name }}
                        </span>
                        <span>{{ $att->check_in }}</span>
                    </div>
                @empty
                    <p style="color:var(--gray-600); font-size:13px;">Aucun pointage enregistré.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabName, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tabName).classList.add('active');
    }

    function toggleUsers(action) {
        const items = document.querySelectorAll('#teamList .member-item');
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