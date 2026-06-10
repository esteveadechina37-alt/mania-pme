@extends('layouts.admin')

@section('title', 'Présences')

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
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @@keyframes fadeSlideUp {
        0%   { opacity: 0; transform: translateY(14px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @@keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-4px); }
    }

    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity: 0; }
    .delay-1 { animation-delay: 0.08s; }
    .delay-2 { animation-delay: 0.16s; }
    .delay-3 { animation-delay: 0.24s; }

    /* ===== HEADER ===== */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 18px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-size: clamp(18px, 4vw, 24px); font-weight: 700; color: var(--dark);
        display: flex; align-items: center; gap: 8px; margin: 0 0 4px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .date-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: white; border: 1px solid var(--gray-200); border-radius: var(--radius-full);
        padding: 5px 14px; font-size: 13px; color: var(--gray-600);
        box-shadow: var(--shadow-sm);
    }
    .date-badge i { color: var(--primary); }

    /* ===== FILTRE ===== */
    .filter-card {
        background: white; border-radius: var(--radius-md); padding: 14px 16px;
        border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm);
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        margin-bottom: 18px;
    }
    .filter-card input[type="date"] {
        padding: 8px 12px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-full); font-size: 13px;
        background: var(--gray-50); color: var(--dark); outline: none;
        transition: all 0.2s;
    }
    .filter-card input[type="date"]:focus {
        border-color: var(--primary); background: white;
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    .btn-filter {
        padding: 8px 18px; border-radius: var(--radius-full); font-size: 13px;
        font-weight: 600; border: 1px solid var(--gray-200); background: white;
        color: var(--dark); cursor: pointer; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; transition: var(--transition-fast);
        white-space: nowrap;
    }
    .btn-filter:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
    .btn-filter.primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(255,98,0,0.2);
    }
    .btn-filter.primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px var(--primary-glow); }
    .filter-spacer { flex: 1; }

    /* ===== KPI (style unifié) ===== */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px; margin-bottom: 18px;
    }
    @media (max-width: 900px) { .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 480px) { .kpi-grid { grid-template-columns: 1fr; } }

    .kpi-card {
        background: white; border-radius: var(--radius-md); padding: 14px 16px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
        display: flex; flex-direction: column; justify-content: space-between; min-width: 0;
    }
    .kpi-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth); pointer-events: none;
    }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .kpi-card:hover::before { opacity: 1; }
    .kpi-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 8px; position: relative; z-index: 1;
    }
    .kpi-label { font-size: 10px; font-weight: 700; color: var(--gray-600); text-transform: uppercase; letter-spacing: .05em; }
    .kpi-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        background: var(--gray-50); color: var(--dark);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; border: 1px solid var(--gray-200); transition: var(--transition-smooth);
    }
    .kpi-card:hover .kpi-icon {
        background: var(--primary); color: white; border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }
    .kpi-value {
        font-size: clamp(22px, 4vw, 30px); font-weight: 700; color: var(--dark);
        line-height: 1; margin-bottom: 6px; position: relative; z-index: 1;
    }
    .kpi-footer {
        display: flex; align-items: center; gap: 6px; font-size: 10px;
        color: var(--gray-600); padding-top: 6px; border-top: 1px solid var(--gray-100);
        position: relative; z-index: 1;
    }
    .trend-pill {
        display: inline-flex; align-items: center; gap: 3px; padding: 3px 8px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 10px; white-space: nowrap;
    }
    .trend-success { background: rgba(16,185,129,.1); color: #10B981; }
    .trend-warning { background: rgba(245,158,11,.1);  color: #F59E0B; }
    .trend-danger  { background: rgba(239,68,68,.1);   color: #EF4444; }
    .trend-info    { background: rgba(59,130,246,.1);   color: #3B82F6; }

    /* ===== LAYOUT PRINCIPAL ===== */
    .content-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 16px; align-items: start;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }

    /* ===== TABLE ===== */
    .table-card {
        background: white; border-radius: var(--radius-md);
        border: 1px solid var(--gray-200); box-shadow: var(--shadow-md); overflow: hidden;
    }
    .table-header {
        padding: 14px 18px; border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
    }
    .table-header-title {
        font-size: 14px; font-weight: 700; color: var(--dark);
        display: flex; align-items: center; gap: 8px;
    }
    .table-header-title i { color: var(--primary); }
    .table-count {
        background: var(--primary-light); color: var(--primary);
        padding: 3px 10px; border-radius: var(--radius-full);
        font-size: 11px; font-weight: 700;
    }
    .table-wrap { overflow-x: auto; }
    .premium-table { width: 100%; border-collapse: collapse; min-width: 420px; }
    .premium-table th {
        background: var(--gray-50); padding: 10px 16px;
        font-size: 10px; font-weight: 700; color: var(--gray-600);
        text-transform: uppercase; letter-spacing: .05em;
        border-bottom: 1px solid var(--gray-200); text-align: left; white-space: nowrap;
    }
    .premium-table td {
        padding: 11px 16px; border-bottom: 1px solid var(--gray-100);
        font-size: 13px; color: var(--dark); vertical-align: middle;
    }
    .premium-table tr:last-child td { border-bottom: none; }
    .premium-table tbody tr:hover td { background: var(--gray-50); }

    .emp-cell { display: flex; align-items: center; gap: 9px; }
    .emp-avatar {
        width: 28px; height: 28px; border-radius: 7px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 11px;
    }
    .emp-name { font-weight: 600; font-size: 13px; color: var(--dark); }

    .badge {
        display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px;
        border-radius: var(--radius-full); font-size: 11px; font-weight: 600; white-space: nowrap;
    }
    .badge-present { background: #DCFCE7; color: #166534; }
    .badge-late    { background: #FEF3C7; color: #92400E; }
    .badge-absent  { background: #F3F4F6; color: #4B5563; }

    .time-chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--gray-50); border: 1px solid var(--gray-200);
        border-radius: 6px; padding: 3px 9px; font-size: 12px; font-weight: 600; color: var(--dark);
    }
    .time-chip i { color: var(--primary); font-size: 10px; }
    .time-empty { color: var(--gray-300); font-size: 13px; }

    /* ===== MOBILE CARDS ===== */
    .mobile-cards { display: none; flex-direction: column; gap: 8px; }
    @media (max-width: 640px) {
        .table-card .table-wrap { display: none; }
        .mobile-cards { display: flex; }
    }
    .m-card {
        background: white; border-radius: var(--radius-md); padding: 12px 14px;
        border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm);
    }
    .m-card-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid var(--gray-100);
    }
    .m-card-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 5px 0; font-size: 13px;
    }
    .m-card-row span:first-child { color: var(--gray-600); font-size: 12px; }

    /* ===== GUIDE + RÉSUMÉ ===== */
    .side-col { display: flex; flex-direction: column; gap: 14px; }

    .guide-card {
        background: white; border-radius: var(--radius-md); padding: 16px;
        border: 1px solid var(--gray-200); box-shadow: var(--shadow-md);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth); pointer-events: none;
    }
    .guide-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .guide-card:hover::before { opacity: 1; }
    .card-title {
        font-size: 14px; font-weight: 700; color: var(--dark);
        margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
        position: relative; z-index: 1;
    }
    .card-title i { color: var(--primary); }
    .guide-item { display: flex; gap: 10px; margin-bottom: 12px; position: relative; z-index: 1; }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 32px; height: 32px; border-radius: var(--radius-sm); flex-shrink: 0;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 13px;
    }
    .guide-text strong { font-size: 12px; font-weight: 700; color: var(--dark); display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); font-size: 11px; margin: 0; line-height: 1.5; }

    /* Résumé statuts */
    .summary-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 8px 0; border-bottom: 1px solid var(--gray-100);
        position: relative; z-index: 1;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-left { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--dark); font-weight: 500; }
    .summary-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .summary-val { font-size: 18px; font-weight: 700; color: var(--dark); }

    /* Pagination */
    .pagination-wrap { margin-top: 14px; display: flex; justify-content: center; }

    /* Empty */
    .empty-row td { text-align: center; padding: 32px !important; color: var(--gray-600); }
    .empty-row i { font-size: 28px; display: block; margin-bottom: 8px; opacity: .3; }
</style>

{{-- Header --}}
<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-clock" style="color:var(--primary)"></i> Gestion
            <span>Présences</span>
        </h1>
        <span class="date-badge">
            <i class="fas fa-calendar-day"></i>
            {{ \Carbon\Carbon::parse($date)->isoFormat('dddd D MMMM YYYY') }}
        </span>
    </div>
</div>

{{-- Filtre --}}
<div class="filter-card animate-in delay-1">
    <form method="GET" action="{{ route('attendances.list') }}"
          style="display:flex; gap:8px; align-items:center; flex-wrap:wrap; width:100%;">
        <i class="fas fa-filter" style="color:var(--primary); font-size:13px;"></i>
        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()">
        <button type="submit" class="btn-filter primary">
            <i class="fas fa-search"></i> Filtrer
        </button>
        <a href="{{ route('attendances.list') }}" class="btn-filter">
            <i class="fas fa-sync-alt"></i> Aujourd'hui
        </a>
        <div class="filter-spacer"></div>
        <a href="{{ route('attendances.export-list-pdf', ['date' => $date]) }}" class="btn-filter">
            <i class="fas fa-file-pdf" style="color:#EF4444"></i> Exporter PDF
        </a>
    </form>
</div>

{{-- KPI --}}
<div class="kpi-grid animate-in delay-1">
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Présents</span>
            <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
        </div>
        <div class="kpi-value">{{ $present }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-success"><i class="fas fa-check"></i> Pointés</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Retards</span>
            <div class="kpi-icon"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
        <div class="kpi-value">{{ $late }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-warning"><i class="fas fa-clock"></i> Après 08h30</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Absents</span>
            <div class="kpi-icon"><i class="fas fa-user-times"></i></div>
        </div>
        <div class="kpi-value">{{ $absent }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-danger"><i class="fas fa-times"></i> Non pointés</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Taux présence</span>
            <div class="kpi-icon"><i class="fas fa-chart-pie"></i></div>
        </div>
        <div class="kpi-value">{{ $rate }}%</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-info"><i class="fas fa-chart-bar"></i> Du jour</span>
        </div>
    </div>
</div>

{{-- Tableau + colonne droite --}}
<div class="content-grid animate-in delay-2">

    {{-- Table --}}
    <div class="table-card">
        <div class="table-header">
            <div class="table-header-title">
                <i class="fas fa-list"></i> Liste des pointages
            </div>
            <span class="table-count">{{ $attendances->total() }} entrées</span>
        </div>

        {{-- Desktop --}}
        <div class="table-wrap">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Arrivée</th>
                        <th>Départ</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $att)
                    <tr>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar">
                                    {{ strtoupper(substr($att->employee->user->name, 0, 1)) }}
                                </div>
                                <span class="emp-name">{{ $att->employee->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            @if($att->check_in)
                                <span class="time-chip"><i class="fas fa-sign-in-alt"></i> {{ $att->check_in }}</span>
                            @else
                                <span class="time-empty">—</span>
                            @endif
                        </td>
                        <td>
                            @if($att->check_out)
                                <span class="time-chip"><i class="fas fa-sign-out-alt"></i> {{ $att->check_out }}</span>
                            @else
                                <span class="time-empty">—</span>
                            @endif
                        </td>
                        <td>
                            @if($att->status == 'late')
                                <span class="badge badge-late"><i class="fas fa-exclamation-triangle"></i> Retard</span>
                            @elseif($att->status == 'present')
                                <span class="badge badge-present"><i class="fas fa-check-circle"></i> Présent</span>
                            @else
                                <span class="badge badge-absent"><i class="fas fa-times-circle"></i> Absent</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="4">
                            <i class="fas fa-calendar-times"></i>
                            Aucun pointage pour cette date.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="mobile-cards" style="padding:12px;">
            @forelse($attendances as $att)
                <div class="m-card">
                    <div class="m-card-header">
                        <div class="emp-cell">
                            <div class="emp-avatar">{{ strtoupper(substr($att->employee->user->name, 0, 1)) }}</div>
                            <span class="emp-name">{{ $att->employee->user->name }}</span>
                        </div>
                        @if($att->status == 'late')
                            <span class="badge badge-late">Retard</span>
                        @elseif($att->status == 'present')
                            <span class="badge badge-present">Présent</span>
                        @else
                            <span class="badge badge-absent">Absent</span>
                        @endif
                    </div>
                    <div class="m-card-row">
                        <span>Arrivée</span>
                        @if($att->check_in)
                            <span class="time-chip"><i class="fas fa-sign-in-alt"></i> {{ $att->check_in }}</span>
                        @else
                            <span class="time-empty">—</span>
                        @endif
                    </div>
                    <div class="m-card-row">
                        <span>Départ</span>
                        @if($att->check_out)
                            <span class="time-chip"><i class="fas fa-sign-out-alt"></i> {{ $att->check_out }}</span>
                        @else
                            <span class="time-empty">—</span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:20px; color:var(--gray-600);">
                    <i class="fas fa-calendar-times" style="font-size:24px; opacity:.3; display:block; margin-bottom:8px;"></i>
                    Aucun pointage.
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap" style="padding:12px 16px;">
            {{ $attendances->links() }}
        </div>
    </div>

    {{-- Colonne droite --}}
    <div class="side-col">

        {{-- Résumé --}}
        <div class="guide-card">
            <div class="card-title"><i class="fas fa-chart-pie"></i> Résumé du jour</div>
            <div class="summary-row">
                <div class="summary-left">
                    <span class="summary-dot" style="background:#10B981"></span> Présents
                </div>
                <span class="summary-val">{{ $present }}</span>
            </div>
            <div class="summary-row">
                <div class="summary-left">
                    <span class="summary-dot" style="background:#F59E0B"></span> Retards
                </div>
                <span class="summary-val">{{ $late }}</span>
            </div>
            <div class="summary-row">
                <div class="summary-left">
                    <span class="summary-dot" style="background:#EF4444"></span> Absents
                </div>
                <span class="summary-val">{{ $absent }}</span>
            </div>
            <div class="summary-row">
                <div class="summary-left">
                    <span class="summary-dot" style="background:#3B82F6"></span> Taux
                </div>
                <span class="summary-val">{{ $rate }}%</span>
            </div>
        </div>

        {{-- Guide --}}
        <div class="guide-card">
            <div class="card-title"><i class="fas fa-lightbulb"></i> Guide</div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="guide-text">
                    <strong>Filtrer par date</strong>
                    <p>Sélectionnez une date pour consulter les pointages du jour souhaité.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="guide-text">
                    <strong>Retard</strong>
                    <p>Un employé est marqué en retard s'il pointe après 08h30.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-file-pdf"></i></div>
                <div class="guide-text">
                    <strong>Export PDF</strong>
                    <p>Téléchargez la liste complète des présences pour archivage.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection