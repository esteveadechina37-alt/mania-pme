@extends('layouts.admin')

@section('title', 'Mon équipe')

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
        0% { opacity:0; transform:translateY(10px); }
        100% { opacity:1; transform:translateY(0); }
    }
    @keyframes float {
        0%,100% { transform:translateY(0); }
        50% { transform:translateY(-4px); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.1s; }
    .delay-2 { animation-delay:0.2s; }
    .delay-3 { animation-delay:0.3s; }
    .delay-4 { animation-delay:0.4s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 24px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
    .page-subtitle { color: var(--gray-600); font-size: 13px; margin: 0; }

    /* KPI */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 16px;
    }
    @media (max-width: 1000px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .kpi-grid { grid-template-columns: 1fr; } }

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

    /* Cards */
    .card-panel {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        transition: var(--transition-smooth); overflow: hidden;
        display: flex; flex-direction: column;
    }
    .card-panel:hover { box-shadow: var(--shadow-lg); }
    .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 700;
        color: var(--dark); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
    }
    .card-title i { color: var(--primary); }

    .badge {
        display: inline-flex; align-items: center; padding: 3px 10px; border-radius: var(--radius-full);
        font-size: 11px; font-weight: 600; gap: 4px;
    }
    .badge-active { background: #DCFCE7; color: #166534; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 8px 18px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none; border: none; cursor: pointer;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25); transition: var(--transition-smooth);
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }

    .btn-outline-sm {
        background: var(--white); color: var(--dark); padding: 6px 12px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 12px;
        border: 1px solid var(--gray-200); display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none; transition: var(--transition-smooth);
    }
    .btn-outline-sm:hover { background: var(--gray-50); border-color: var(--primary); }

    /* Objectives */
    .objective-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 0; border-bottom: 1px solid var(--gray-100);
        font-size: 13px;
    }
    .objective-item:last-child { border-bottom: none; }
    .objective-status {
        padding: 3px 10px; border-radius: 12px;
        font-size: 11px; font-weight: 600;
    }
    .status-achieved { background: #DCFCE7; color: #166534; }
    .status-in_progress { background: #FEF3C7; color: #92400E; }
    .status-pending { background: #F3F4F6; color: #4B5563; }
    .status-not_achieved { background: #FEE2E2; color: #991B1B; }
    .progress-bar {
        width: 100%; height: 6px; background: var(--gray-200);
        border-radius: 3px; overflow: hidden; margin-top: 8px;
    }
    .progress-fill {
        height: 100%; background: var(--primary);
        border-radius: 3px; transition: width 0.4s ease;
    }
    .small-text { font-size: 12px; color: var(--gray-600); margin-top: 4px; display: block; }

    /* Members */
    .member-item {
        display: flex; align-items: center; gap: 10px; padding: 10px 0;
        border-bottom: 1px solid var(--gray-100);
    }
    .member-item:last-child { border-bottom: none; }
    .avatar-sm {
        width: 32px; height: 32px; border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 12px; flex-shrink: 0; text-transform: uppercase;
    }
    .member-info strong { font-size: 13px; font-weight: 700; color: var(--dark); display: block; }
    .member-info span { font-size: 11px; color: var(--gray-600); }
    .status-dot {
        width: 8px; height: 8px; border-radius: 50%; margin-left: auto;
    }
    .status-present { background: #10B981; }
    .status-late { background: #F59E0B; }
    .status-absent { background: #EF4444; }

    /* Leaves */
    .leave-list { display: flex; flex-direction: column; gap: 6px; }
    .leave-item {
        display: flex; align-items: center; gap: 8px; padding: 8px;
        background: var(--gray-50); border-radius: var(--radius-sm); border: 1px solid var(--gray-200);
        font-size: 12px;
    }
    .cal-icon {
        min-width: 30px; height: 30px; border-radius: 6px;
        background: var(--primary-light); color: var(--primary);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 800; line-height: 1;
    }
    .cal-icon small { font-size: 7px; font-weight: 600; text-transform: uppercase; opacity: .8; }
    .leave-details strong { font-size: 12px; color: var(--dark); display: block; }
    .leave-details span { font-size: 10px; color: var(--gray-600); }

    .empty-state { text-align: center; padding: 20px; color: var(--gray-600); font-size: 12px; }
    .empty-state i { font-size: 20px; color: var(--gray-300); display: block; margin-bottom: 6px; }

    /* Bottom grid */
    .bottom-row {
        display: grid; grid-template-columns: 2fr 1fr; gap: 14px;
    }
    @media (max-width: 800px) { .bottom-row { grid-template-columns: 1fr; } }

    /* Modals */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.5);
        display: none; align-items: center; justify-content: center;
        z-index: 1000; backdrop-filter: blur(4px);
    }
    .modal-content {
        background: white; border-radius: var(--radius-md); padding: 24px;
        width: 90%; max-width: 560px; max-height: 85vh; overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .modal-content h3 { margin-bottom: 16px; font-size: 18px; }
    .form-input {
        width: 100%; padding: 8px 12px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 13px; margin-bottom: 10px;
    }
    .form-input:focus { border-color: var(--primary); outline: none; }
    .form-label { font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 4px; }
    .flex-row { display: flex; gap: 8px; align-items: center; }
    .flex-end { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .leave-current {
        background: #FFF8E7;
        border-color: #FDE68A;
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-users"></i> Mon équipe</h1>
        <p class="page-subtitle">
            @if($department)
                Département <strong>{{ $department->name }}</strong>
            @else
                Aucun département assigné
            @endif
        </p>
    </div>
</div>

{{-- KPIs --}}
<div class="kpi-grid">
    <div class="kpi-card animate-in delay-1">
        <div class="kpi-header">
            <span class="kpi-label">Membres</span>
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
        </div>
        <div class="kpi-value">{{ $totalMembers }}</div>
        <div class="kpi-footer"><i class="fas fa-user-friends" style="color:var(--primary);"></i> Actifs</div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">Présents aujourd'hui</span>
            <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
        </div>
        <div class="kpi-value">{{ $presentToday }}</div>
        <div class="kpi-footer"><i class="fas fa-bolt" style="color:#10B981;"></i> Pointages</div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">Retards (7j)</span>
            <div class="kpi-icon"><i class="fas fa-clock"></i></div>
        </div>
        <div class="kpi-value">{{ $lateThisWeek }}</div>
        <div class="kpi-footer"><i class="fas fa-exclamation-triangle" style="color:#F59E0B;"></i> Retards</div>
    </div>
    <div class="kpi-card animate-in delay-4">
        <div class="kpi-header">
            <span class="kpi-label">Taux de présence</span>
            <div class="kpi-icon"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="kpi-value">{{ $attendanceRate }}%</div>
        <div class="kpi-footer"><i class="fas fa-check-circle" style="color:#10B981;"></i> 7 jours</div>
    </div>
</div>

{{-- SECTION PROGRAMME DE LA SEMAINE --}}
<div class="card-panel animate-in delay-4" style="margin-bottom:16px;">
    <div class="card-title">
        <i class="fas fa-calendar-week"></i> Programme de la semaine
        @if($currentWeekProgram)
            <span class="badge badge-active" style="margin-left:auto;">{{ $currentWeekProgram->title }}</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('editProgramModal').style.display='flex';" class="btn-outline-sm"><i class="fas fa-edit"></i> Modifier</a>
        @else
            <button onclick="event.preventDefault(); document.getElementById('createProgramModal').style.display='flex';" class="btn-primary" style="margin-left:auto; padding:6px 14px; font-size:12px;">
                <i class="fas fa-plus"></i> Créer le programme
            </button>
        @endif
    </div>

    @if($currentWeekProgram)
        <div class="objective-list">
            @foreach($currentWeekProgram->objectives as $obj)
            <div class="objective-item">
                <span class="objective-status status-{{ $obj->status }}">
                    @switch($obj->status)
                        @case('pending') En attente @break
                        @case('in_progress') En cours @break
                        @case('achieved') Atteint @break
                        @case('not_achieved') Non atteint @break
                        @default {{ $obj->status }}
                    @endswitch
                </span>
                <span style="flex:1;">{{ $obj->description }}</span>
                @if($obj->target)
                    <span style="font-size:12px; color:var(--gray-600); margin-right:10px;">{{ $obj->progress }}/{{ $obj->target }}</span>
                @endif

                {{-- Assignation / employé assigné --}}
                @if(!$obj->employee_id)
                    <form method="POST" action="{{ route('manager.team.objective.assign', $obj) }}" style="display:flex; gap:6px;">
                        @csrf
                        <select name="employee_id" style="padding:2px 8px; font-size:11px; border-radius:4px; border:1px solid var(--gray-200); background:white;" onchange="this.form.submit()">
                            <option value="">Assigner à...</option>
                            @foreach($members->filter(fn($m) => $m->presence_status !== 'on_leave') as $member)
                                <option value="{{ $member->id }}">{{ $member->user->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @else
                    {{-- Badge indiquant clairement l'employé assigné --}}
                    <span style="
                        display:inline-flex; align-items:center; gap:6px;
                        background: var(--primary-light);
                        color: var(--primary);
                        padding: 4px 12px;
                        border-radius: 20px;
                        font-size: 11px;
                        font-weight: 600;
                        white-space: nowrap;
                    ">
                        <i class="fas fa-user-check" style="font-size:11px;"></i>
                        {{ $obj->employee->user->name ?? 'Employé inconnu' }}
                    </span>
                @endif

                {{-- Formulaire de mise à jour du statut par le manager (conservé) --}}
                <form method="POST" action="{{ route('manager.team.objective.update', $obj) }}" style="display:flex; gap:6px;">
                    @csrf
                    <select name="status" onchange="this.form.submit()" style="padding:2px 8px; font-size:11px; border-radius:4px; border:1px solid var(--gray-200); background:white;">
                        <option value="pending" {{ $obj->status=='pending'?'selected':'' }}>En attente</option>
                        <option value="in_progress" {{ $obj->status=='in_progress'?'selected':'' }}>En cours</option>
                        <option value="achieved" {{ $obj->status=='achieved'?'selected':'' }}>Atteint</option>
                        <option value="not_achieved" {{ $obj->status=='not_achieved'?'selected':'' }}>Non atteint</option>
                    </select>
                    @if($obj->target)
                        <input type="number" name="progress" value="{{ $obj->progress }}" min="0" max="{{ $obj->target }}" step="0.1" style="width:55px; padding:2px 6px; font-size:11px; border-radius:4px; border:1px solid var(--gray-200);">
                    @endif
                    <button type="submit" style="display:none;"></button>
                </form>
            </div>
            @endforeach
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width:{{ $currentWeekProgram->progressPercentage() }}%;"></div>
        </div>
        <span class="small-text">{{ $currentWeekProgram->progressPercentage() }}% des objectifs atteints</span>
    @else
        <div class="empty-state"><i class="fas fa-clipboard-list"></i> Aucun programme défini pour cette semaine.</div>
    @endif
</div>

{{-- MEMBRES + CONGÉS À VENIR --}}
<div class="bottom-row">
    <div class="card-panel animate-in delay-4">
        <div class="card-title"><i class="fas fa-id-badge"></i> Membres de l'équipe</div>
        @if($members->isEmpty())
            <div class="empty-state"><i class="fas fa-user-slash"></i> Aucun employé trouvé.</div>
        @else
            @foreach($members as $emp)
                <div class="member-item">
                    <div class="avatar-sm">{{ mb_strtoupper(mb_substr($emp->user->name, 0, 1)) }}</div>
                    <div class="member-info">
                        <strong>{{ $emp->user->name }}</strong>
                        <span>{{ $emp->position ?? 'Sans poste' }}{{ $emp->contract_type ? ' · '.$emp->contract_type : '' }}</span>
                    </div>
                    <span class="status-dot {{ $emp->presence_status === 'present' ? 'status-present' : ($emp->presence_status === 'late' ? 'status-late' : 'status-absent') }}"></span>
                    @if($emp->check_in)
                        <small style="font-size:11px; color:var(--gray-600); margin-left:6px;">{{ $emp->check_in }}</small>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <div class="card-panel animate-in delay-4">
        <div class="card-title"><i class="fas fa-calendar-alt"></i> Congés</div>
        @if($upcomingLeaves->isEmpty())
            <div class="empty-state"><i class="fas fa-check-circle"></i> Aucun congé programmé.</div>
        @else
            <div class="leave-list">
                @foreach($upcomingLeaves as $leave)
                    @php
                        $today = now()->toDateString();
                        $isCurrent = $leave->start_date <= $today && $leave->end_date >= $today;
                    @endphp
                    <div class="leave-item {{ $isCurrent ? 'leave-current' : '' }}">
                        <div class="cal-icon">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('d') }}
                            <small>{{ \Carbon\Carbon::parse($leave->start_date)->isoFormat('MMM') }}</small>
                        </div>
                        <div class="leave-details">
                            <strong>{{ $leave->employee->user->name }}</strong>
                            <span>
                                {{ $leave->leaveType->name }} ·
                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m') }} →
                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m') }}
                                @if($isCurrent)
                                    <span class="badge" style="background:#FEF3C7;color:#92400E;margin-left:6px;font-size:10px;">En cours</span>
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- MODALS --}}
@include('manager.partials.program-modal')
@endsection