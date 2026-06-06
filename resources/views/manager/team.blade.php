@extends('layouts.admin')

@section('title', 'Mon équipe')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,.10);
        --primary-glow: rgba(255,98,0,.25);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-500: #6B7280;
        --gray-600: #4B5563;
        --white: #FFFFFF;
        --shadow-sm: 0 1px 3px rgba(10,10,10,.06);
        --shadow-md: 0 8px 24px rgba(10,10,10,.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,.08);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-full: 9999px;
        --transition-fast: .15s ease;
        --transition-smooth: .4s cubic-bezier(.16,1,.3,1);
    }

    @keyframes fadeSlideUp {
        0% { opacity:0; transform:translateY(20px); }
        100% { opacity:1; transform:translateY(0); }
    }
    @keyframes float {
        0%,100% { transform:translateY(0); }
        50% { transform:translateY(-4px); }
    }
    .animate-in {
        animation: fadeSlideUp .6s cubic-bezier(.16,1,.3,1) forwards;
        opacity:0;
    }
    .delay-1 { animation-delay:.1s; }
    .delay-2 { animation-delay:.2s; }
    .delay-3 { animation-delay:.3s; }
    .delay-4 { animation-delay:.4s; }

    .team-page { padding-bottom:40px; }

    .page-header {
        display:flex; align-items:flex-start; justify-content:space-between;
        margin-bottom:30px; flex-wrap:wrap; gap:20px; position:relative;
    }
    .page-header::after {
        content:''; position:absolute; top:-20px; left:0;
        width:150px; height:150px; background:var(--primary-glow);
        filter:blur(80px); z-index:-1; pointer-events:none;
    }
    .page-title {
        font-family:'Clash Display',sans-serif; font-size:30px; font-weight:700; color:var(--dark);
        margin:0 0 6px 0; line-height:1.2; letter-spacing:-.02em;
    }
    .page-title i { color:var(--primary); }
    .page-subtitle { color:var(--gray-600); font-family:'Cabinet Grotesk',sans-serif; font-size:15px; margin:0; }
    .page-subtitle strong { color:var(--dark); }

    .bento-grid {
        display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap:20px; margin-bottom:30px;
    }
    .stat-card {
        background:var(--white); border-radius:var(--radius-md); padding:24px;
        box-shadow:var(--shadow-md); border:1px solid var(--gray-200);
        position:relative; overflow:hidden; transition:var(--transition-smooth);
        display:flex; align-items:center; gap:14px;
    }
    .stat-card::before {
        content:''; position:absolute; inset:0;
        background:radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity:0; transition:var(--transition-smooth);
    }
    .stat-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-lg); border-color:var(--primary); }
    .stat-card:hover::before { opacity:1; }
    .stat-icon {
        width:44px; height:44px; border-radius:var(--radius-sm);
        background:var(--gray-50); color:var(--dark);
        display:flex; align-items:center; justify-content:center;
        font-size:20px; transition:var(--transition-smooth);
        border:1px solid var(--gray-200); flex-shrink:0;
    }
    .stat-card:hover .stat-icon {
        background:var(--primary); color:var(--white); border-color:var(--primary);
        animation:float 2s ease-in-out infinite;
    }
    .stat-label { font-size:13px; font-weight:600; color:var(--gray-600); text-transform:uppercase; letter-spacing:.04em; }
    .stat-value { font-family:'Clash Display',sans-serif; font-size:34px; font-weight:700; color:var(--dark); line-height:1; }

    .chart-cal-row {
        display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:30px;
    }
    @media (max-width:900px) { .chart-cal-row { grid-template-columns:1fr; } }

    .t-card {
        background:var(--white); border-radius:var(--radius-md); padding:24px;
        box-shadow:var(--shadow-md); border:1px solid var(--gray-200);
        transition:var(--transition-smooth); position:relative; overflow:hidden;
    }
    .t-card::before {
        content:''; position:absolute; inset:0;
        background:radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity:0; transition:var(--transition-smooth);
    }
    .t-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-lg); border-color:var(--primary); }
    .t-card:hover::before { opacity:1; }
    .t-card-title {
        font-family:'Clash Display',sans-serif; font-size:22px; font-weight:700; color:var(--dark);
        margin-bottom:16px; display:flex; align-items:center; gap:10px; position:relative; z-index:1;
    }
    .t-card-title i { color:var(--primary); }

    .chart-tabs { display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap; position:relative; z-index:1; }
    .tab-btn {
        padding:5px 16px; border-radius:var(--radius-full); font-size:12px; font-weight:600;
        border:1.5px solid var(--gray-200); background:var(--white); color:var(--gray-500);
        cursor:pointer; transition:all var(--transition-fast);
    }
    .tab-btn:hover { border-color:var(--primary); color:var(--primary); }
    .tab-btn.active { background:var(--primary); color:#fff; border-color:var(--primary); box-shadow:0 2px 8px rgba(255,98,0,.3); }
    .chart-wrap { position:relative; width:100%; height:240px; z-index:1; }
    @media (max-width:500px) { .chart-wrap { height:190px; } }
    .chart-legend { display:flex; gap:16px; margin-top:10px; flex-wrap:wrap; position:relative; z-index:1; }
    .legend-item { display:flex; align-items:center; gap:6px; font-size:12px; color:var(--gray-600); }
    .legend-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }

    .cal-scroll { display:flex; flex-direction:column; gap:4px; max-height:320px; overflow-y:auto; position:relative; z-index:1; }
    .cal-scroll::-webkit-scrollbar { width:4px; }
    .cal-scroll::-webkit-scrollbar-thumb { background:var(--gray-300); border-radius:4px; }
    .day-card {
        background:var(--gray-50); border-radius:var(--radius-sm); padding:8px 12px;
        border:1px solid var(--gray-200); display:flex; justify-content:space-between;
        align-items:center; gap:10px;
    }
    .day-card.today { border-color:var(--primary); background:var(--primary-light); }
    .day-label { font-size:11px; font-weight:700; color:var(--gray-500); white-space:nowrap; }
    .day-card.today .day-label { color:var(--primary); }
    .absent-chip {
        background:rgba(255,98,0,.12); color:var(--primary);
        padding:2px 6px; border-radius:4px; font-size:9px; font-weight:600;
    }
    .no-abs { color:var(--gray-300); font-size:10px; }

    .section-grid {
        display:grid; grid-template-columns:2fr 1fr; gap:24px; margin-bottom:30px;
    }
    @media (max-width:720px) { .section-grid { grid-template-columns:1fr; } }
    .section-grid .t-card { margin-bottom:0; }

    .member-row {
        display:flex; align-items:center; gap:12px; padding:14px 0;
        border-bottom:1px solid var(--gray-100);
    }
    .member-row:last-child { border-bottom:none; }
    .avatar-sm {
        width:36px; height:36px; border-radius:10px;
        background:linear-gradient(135deg,var(--primary),var(--primary-hover));
        color:#fff; display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:13px; flex-shrink:0; text-transform:uppercase;
    }
    .member-info strong { font-size:14px; font-weight:700; color:var(--dark); display:block; }
    .member-info span { font-size:12px; color:var(--gray-500); }

    .leave-list { display:flex; flex-direction:column; gap:8px; max-height:320px; overflow-y:auto; }
    .leave-list::-webkit-scrollbar { width:4px; }
    .leave-list::-webkit-scrollbar-thumb { background:var(--gray-300); border-radius:4px; }
    .leave-item {
        display:flex; align-items:center; gap:10px; padding:10px;
        background:var(--gray-50); border-radius:var(--radius-sm); border:1px solid var(--gray-200);
    }
    .cal-icon {
        min-width:36px; height:36px; border-radius:8px;
        background:var(--primary-light); color:var(--primary);
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        font-size:13px; font-weight:800; line-height:1;
    }
    .cal-icon small { font-size:8px; font-weight:600; text-transform:uppercase; opacity:.8; }
    .leave-details strong { font-size:13px; color:var(--dark); display:block; }
    .leave-details span { font-size:11px; color:var(--gray-500); }

    .empty-state { text-align:center; padding:32px 16px; color:var(--gray-500); font-size:13px; }
    .empty-state i { font-size:28px; color:var(--gray-300); display:block; margin-bottom:8px; }
</style>

<div class="team-page">

    {{-- Header --}}
    <div class="page-header animate-in">
        <div>
            <h1 class="page-title"><i class="fas fa-users"></i> Mon équipe</h1>
            <p class="page-subtitle">
                @if($department)
                    Département : <strong>{{ $department->name }}</strong>
                @else
                    Aucun département assigné.
                @endif
            </p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="bento-grid">
        <div class="stat-card animate-in delay-1">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-label">Membres</div>
                <div class="stat-value">{{ $totalMembers }}</div>
            </div>
        </div>
        <div class="stat-card animate-in delay-2">
            <div class="stat-icon"><i class="fas fa-umbrella-beach"></i></div>
            <div>
                <div class="stat-label">En congé aujourd'hui</div>
                <div class="stat-value">{{ $onLeaveToday }}</div>
            </div>
        </div>
        <div class="stat-card animate-in delay-3">
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
            <div>
                <div class="stat-label">Présents aujourd'hui</div>
                <div class="stat-value">{{ $presentToday }}</div>
            </div>
        </div>
    </div>

    {{-- Graphique + Calendrier côte à côte --}}
    <div class="chart-cal-row">
        <div class="t-card animate-in delay-4" style="margin-bottom:0;">
            <div class="t-card-title"><i class="fas fa-chart-bar"></i> Activité des 7 derniers jours</div>
            <div class="chart-tabs" id="chartTabs">
                <button class="tab-btn active" data-mode="presences">Présences</button>
                <button class="tab-btn"        data-mode="conges">Congés</button>
                <button class="tab-btn"        data-mode="heures">Heures</button>
            </div>
            <div class="chart-wrap"><canvas id="teamChart"></canvas></div>
            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-dot" style="background:#E5E7EB;"></div> Semaine passée
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:#FF6200;"></div> Cette semaine
                </div>
            </div>
        </div>

        <div class="t-card animate-in delay-4" style="margin-bottom:0;">
            <div class="t-card-title"><i class="fas fa-calendar-week"></i> Absences sur 14 jours</div>
            @if($calendarData->isEmpty())
                <div class="empty-state"><i class="fas fa-calendar-check"></i>Aucune absence planifiée.</div>
            @else
                <div class="cal-scroll">
                    @foreach($calendarData as $idx => $day)
                        <div class="day-card {{ $idx === 0 ? 'today' : '' }}">
                            <div class="day-label">{{ $day['dayLabel'] }}</div>
                            <div style="display:flex; flex-wrap:wrap; gap:3px; justify-content:flex-end;">
                                @forelse($day['names'] as $name)
                                    <span class="absent-chip" title="{{ $name }}">{{ $name }}</span>
                                @empty
                                    <span class="no-abs">—</span>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Membres + Congés à venir --}}
    <div class="section-grid">
        <div class="t-card animate-in delay-4" style="margin-bottom:0;">
            <div class="t-card-title"><i class="fas fa-id-badge"></i> Membres de l'équipe</div>
            @if($employees->isEmpty())
                <div class="empty-state"><i class="fas fa-user-slash"></i>Aucun employé trouvé.</div>
            @else
                @foreach($employees as $emp)
                    <div class="member-row">
                        <div class="avatar-sm">{{ mb_strtoupper(mb_substr($emp->user->name, 0, 1)) }}</div>
                        <div class="member-info">
                            <strong>{{ $emp->user->name }}</strong>
                            <span>{{ $emp->position ?? 'Sans poste' }}{{ $emp->contract_type ? ' · '.$emp->contract_type : '' }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="t-card animate-in delay-4" style="margin-bottom:0;">
            <div class="t-card-title"><i class="fas fa-calendar-alt"></i> Congés à venir</div>
            @if($upcomingLeaves->isEmpty())
                <div class="empty-state"><i class="fas fa-check-circle"></i>Aucun congé programmé.</div>
            @else
                <div class="leave-list">
                    @foreach($upcomingLeaves as $leave)
                        <div class="leave-item">
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
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Chart.js + logique --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    'use strict';
    var allData = {
        presences: {
            current: @json($chartData['presences']['current']),
            prev:    @json($chartData['presences']['prev'])
        },
        conges: {
            current: @json($chartData['conges']['current']),
            prev:    @json($chartData['conges']['prev'])
        },
        heures: {
            current: @json($chartData['heures']['current']),
            prev:    @json($chartData['heures']['prev'])
        }
    };
    var labels   = @json($chartData['labels']);
    var instance = null;
    var curMode  = 'presences';

    function initChart() {
        var canvas = document.getElementById('teamChart');
        if (!canvas) return;
        var d = allData[curMode];
        instance = new Chart(canvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Semaine passée',
                        data: d.prev,
                        backgroundColor: '#E5E7EB',
                        borderRadius: 5,
                        borderSkipped: false
                    },
                    {
                        label: 'Cette semaine',
                        data: d.current,
                        backgroundColor: '#FF6200',
                        borderRadius: 5,
                        borderSkipped: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 350, easing: 'easeInOutQuart' },
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#6B7280', font: { size: 12 } } },
                    y: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { precision: 0, color: '#6B7280', font: { size: 12 } } }
                }
            }
        });
    }

    function switchMode(mode) {
        curMode = mode;
        if (!instance) return;
        instance.data.datasets[0].data = allData[mode].prev;
        instance.data.datasets[1].data = allData[mode].current;
        instance.update('active');
    }

    document.querySelectorAll('#chartTabs .tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('#chartTabs .tab-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            switchMode(btn.getAttribute('data-mode'));
        });
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChart);
    } else {
        initChart();
    }
}());
</script>
@endsection