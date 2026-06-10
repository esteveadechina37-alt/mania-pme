@extends('layouts.admin')

@section('title', 'Mon Espace')

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
        0% { opacity:0; transform:translateY(12px); }
        100% { opacity:1; transform:translateY(0); }
    }
    @keyframes float {
        0%,100% { transform:translateY(0); }
        50% { transform:translateY(-4px); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.08s; }
    .delay-2 { animation-delay:0.16s; }
    .delay-3 { animation-delay:0.24s; }
    .delay-4 { animation-delay:0.32s; }

    .dashboard {
        display: flex; flex-direction: column; gap: 16px;
    }

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

    /* ===== KPI ===== */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
    }
    @media (max-width: 700px) { .kpi-grid { grid-template-columns: 1fr; } }

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

    /* ===== MAIN CONTENT ===== */
    .content-grid {
        display: grid; grid-template-columns: 1fr 300px; gap: 16px;
    }
    @media (max-width: 800px) { .content-grid { grid-template-columns: 1fr; } }

    .card-panel {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
    }
    .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 700;
        color: var(--dark); margin-bottom: 10px; display: flex; align-items: center; gap: 8px;
    }
    .card-title i { color: var(--primary); }

    .request-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 8px 12px; background: var(--gray-50);
        border-radius: var(--radius-sm); border: 1px solid var(--gray-200);
        margin-bottom: 6px; font-size: 13px;
    }
    .request-item:last-child { margin-bottom: 0; }
    .badge-pending, .badge-approved, .badge-rejected {
        padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;
    }
    .badge-pending { background: #FEF3C7; color: #92400E; }
    .badge-approved { background: #DCFCE7; color: #166534; }
    .badge-rejected { background: #FEE2E2; color: #991B1B; }

    .objective-item {
        display: flex; align-items: center; gap: 8px;
        padding: 6px 0; border-bottom: 1px solid var(--gray-100); font-size: 12px;
    }
    .objective-item:last-child { border-bottom: none; }
    .objective-status {
        padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600;
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
    .small-text { font-size: 11px; color: var(--gray-600); margin-top: 4px; display: block; }

    .empty-state { text-align: center; padding: 16px; color: var(--gray-600); font-size: 12px; }
    .empty-state i { font-size: 20px; opacity: 0.4; margin-bottom: 4px; display: block; }
    .hidden-item { display: none !important; }
    .btn-outline-sm {
        background: var(--white);
        color: var(--dark);
        padding: 6px 14px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 12px;
        border: 1px solid var(--gray-200);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition-smooth);
        text-decoration: none;
    }
    .btn-outline-sm:hover {
        background: var(--gray-50);
        border-color: var(--primary);
    }

    /* ===== ÉVALUATIONS RÉCENTES ===== */
    .eval-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200);
        margin-bottom: 6px;
        font-size: 13px;
    }
    .eval-item:last-child { margin-bottom: 0; }
    .eval-score {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
    }
    .score-high { background: #DCFCE7; color: #166534; }
    .score-medium { background: #FEF3C7; color: #92400E; }
    .score-low { background: #FEE2E2; color: #991B1B; }
</style>

<div class="dashboard">
    {{-- HEADER --}}
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
                    · {{ auth()->user()->getRoleNames()->first() ?? 'N/A' }}
                    · {{ now()->isoFormat('dddd D MMMM YYYY') }}
                </p>
            </div>
        </div>
    </div>

    {{-- KPI --}}
    <div class="kpi-grid">
        <div class="kpi-card animate-in delay-1">
            <div class="kpi-header">
                <span class="kpi-label">Congé en cours</span>
                <div class="kpi-icon"><i class="fas fa-umbrella-beach"></i></div>
            </div>
            <div class="kpi-value">
                @if($currentLeave)
                    {{ $joursRestants }} j
                @else
                    —
                @endif
            </div>
            <div class="kpi-footer">
                @if($currentLeave)
                    <span style="color:#F59E0B;"><i class="fas fa-calendar-check"></i> Retour {{ \Carbon\Carbon::parse($currentLeave->end_date)->format('d/m') }}</span>
                @else
                    <span style="color:#10B981;"><i class="fas fa-check"></i> Pas de congé</span>
                @endif
            </div>
        </div>
        <div class="kpi-card animate-in delay-2">
            <div class="kpi-header">
                <span class="kpi-label">Heures pointées</span>
                <div class="kpi-icon"><i class="fas fa-user-clock"></i></div>
            </div>
            <div class="kpi-value">{{ $heuresPointees }}h</div>
            <div class="kpi-footer"><i class="fas fa-calendar-week" style="color:var(--primary);"></i> Cette semaine</div>
        </div>
        <div class="kpi-card animate-in delay-3">
            <div class="kpi-header">
                <span class="kpi-label">Dernière paie</span>
                <div class="kpi-icon"><i class="fas fa-file-invoice"></i></div>
            </div>
            <div class="kpi-value" style="font-size:22px;">{{ $derniereFicheDate }}</div>
            <div class="kpi-footer"><i class="fas fa-file-alt" style="color:#3B82F6;"></i> Bulletin</div>
        </div>
    </div>

    {{-- CONTENU PRINCIPAL --}}
    <div class="content-grid animate-in delay-4">
        {{-- Colonne gauche : Programme de la semaine --}}
        <div class="card-panel">
            <div class="card-title"><i class="fas fa-calendar-week"></i> Programme de la semaine</div>
            @if($currentWeekProgram)
                <p style="font-weight:600; margin-bottom:8px;">{{ $currentWeekProgram->title }}</p>
                @if($currentWeekProgram->description)
                    <p style="font-size:12px; color:var(--gray-600); margin-bottom:8px;">{{ $currentWeekProgram->description }}</p>
                @endif
                <div>
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

                            {{-- Si la tâche est assignée à l'employé connecté, permettre la mise à jour --}}
                            @if($obj->employee_id === $employee->id)
                                <form method="POST" action="{{ route('employee.objective.update', $obj) }}" style="display:flex; gap:6px;">
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
                            @else
                                {{-- Sinon, afficher simplement le nom de l'employé assigné si présent --}}
                                @if($obj->employee)
                                    <span style="font-size:12px; color:var(--gray-600); margin-left:auto;">{{ $obj->employee->user->name }}</span>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $currentWeekProgram->progressPercentage() }}%;"></div>
                </div>
                <span class="small-text">{{ $currentWeekProgram->progressPercentage() }}% des objectifs atteints</span>
            @else
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i> Aucun programme cette semaine.
                </div>
            @endif
        </div>

        {{-- Colonne droite : Évaluations récentes + Demandes récentes + Infos --}}
        <div style="display:flex; flex-direction:column; gap:16px;">

            {{-- 🆕 Évaluations récentes --}}
            <div class="card-panel">
                <div class="card-title"><i class="fas fa-star"></i> Évaluations récentes</div>
                @if(isset($recentEvaluations) && $recentEvaluations->isNotEmpty())
                    @foreach($recentEvaluations as $eval)
                        <div class="eval-item">
                            <div style="flex:1;">
                                <strong>{{ $eval->period }}</strong>
                                <div style="font-size:11px; color:var(--gray-600);">
                                    {{ $eval->evaluator->name ?? 'N/A' }} · {{ $eval->evaluated_at->format('d/m/Y') }}
                                </div>
                            </div>
                            @php
                                $score = $eval->score;
                                if ($score >= 4) {
                                    $scoreClass = 'score-high';
                                } elseif ($score >= 3) {
                                    $scoreClass = 'score-medium';
                                } else {
                                    $scoreClass = 'score-low';
                                }
                            @endphp
                            <span class="eval-score {{ $scoreClass }}">
                                <i class="fas fa-star"></i> {{ number_format($score, 1) }}/5
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-star-half-alt"></i> Aucune évaluation récente.
                    </div>
                @endif
            </div>

            {{-- Demandes récentes --}}
            <div class="card-panel">
                <div class="card-title"><i class="fas fa-history"></i> Demandes récentes</div>
                @if($demandesRecentes->isEmpty())
                    <div class="empty-state"><i class="fas fa-inbox"></i> Aucune demande.</div>
                @else
                    <div id="recentRequests">
                        @foreach($demandesRecentes as $index => $demande)
                            <div class="request-item {{ $index >= 3 ? 'hidden-item' : '' }}">
                                <div>
                                    <strong>{{ $demande->leaveType->name }}</strong>
                                    <div style="font-size:11px; color:var(--gray-600);">
                                        {{ $demande->start_date->format('d/m') }} - {{ $demande->end_date->format('d/m') }}
                                    </div>
                                </div>
                                <span class="badge-{{ $demande->status }}">
                                    @if($demande->status == 'pending') En attente
                                    @elseif($demande->status == 'approved') Approuvé
                                    @else Refusé
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                    @if($demandesRecentes->count() > 3)
                        <div style="text-align:center; margin-top:10px;">
                            <button id="toggleRequestsBtn" class="btn-outline-sm" onclick="toggleRequests()" data-expanded="false">
                                <i class="fas fa-chevron-down"></i> Voir plus ({{ $demandesRecentes->count() - 3 }})
                            </button>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Mes infos --}}
            <div class="card-panel">
                <div class="card-title"><i class="fas fa-id-card"></i> Mes infos</div>
                <div style="font-size:12px; line-height:1.8;">
                    <div><strong>{{ auth()->user()->name }}</strong></div>
                    <div>{{ auth()->user()->email }}</div>
                    <div>{{ auth()->user()->company->name ?? 'N/A' }}</div>
                    <div style="text-transform: capitalize;">{{ auth()->user()->getRoleNames()->first() ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleRequests() {
        const items = document.querySelectorAll('#recentRequests .request-item');
        const btn = document.getElementById('toggleRequestsBtn');
        const isExpanded = btn.dataset.expanded === 'true';

        items.forEach((item, index) => {
            if (index >= 3) {
                if (isExpanded) {
                    item.classList.add('hidden-item');
                } else {
                    item.classList.remove('hidden-item');
                }
            }
        });

        btn.dataset.expanded = (!isExpanded).toString();
        const icon = btn.querySelector('i');
        if (isExpanded) {
            btn.innerHTML = '<i class="fas fa-chevron-down"></i> Voir plus ({{ $demandesRecentes->count() - 3 }})';
        } else {
            btn.innerHTML = '<i class="fas fa-chevron-up"></i> Voir moins';
        }
    }
</script>
@endsection