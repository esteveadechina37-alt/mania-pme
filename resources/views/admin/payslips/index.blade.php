@extends('layouts.admin')

@section('title', 'Bulletins de paie')

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

    /* ===== PAGE WRAPPER ===== */
    .page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* ===== HEADER ===== */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }
    .page-title {
        font-size: clamp(20px, 4vw, 28px);
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 4px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 14px; margin: 0; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        padding: 10px 22px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: var(--transition-smooth);
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--primary-glow);
        color: white;
    }

    /* ===== ALERT ===== */
    .alert-success {
        background: #ECFDF5;
        border-left: 4px solid #10B981;
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        color: #065F46;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }

    /* ===== KPI ===== */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }
    @media (max-width: 900px) { .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 480px) { .kpi-grid { grid-template-columns: 1fr; } }

    .kpi-card {
        background: white;
        border-radius: var(--radius-md);
        padding: 14px 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0;
        transition: var(--transition-smooth);
        pointer-events: none;
    }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .kpi-card:hover::before { opacity: 1; }

    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }
    .kpi-label {
        font-size: 10px;
        font-weight: 700;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .kpi-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        flex-shrink: 0;
        background: var(--gray-50);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }
    .kpi-card:hover .kpi-icon {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }
    .kpi-value {
        font-size: clamp(18px, 3vw, 26px);
        font-weight: 700;
        color: var(--dark);
        line-height: 1.2;
        margin-bottom: 6px;
        position: relative;
        z-index: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .kpi-footer {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        color: var(--gray-600);
        padding-top: 6px;
        border-top: 1px solid var(--gray-100);
        position: relative;
        z-index: 1;
    }
    .trend-pill {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 3px 8px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 10px;
        white-space: nowrap;
    }
    .trend-success { background: rgba(16,185,129,.1); color: #10B981; }
    .trend-warning { background: rgba(245,158,11,.1);  color: #F59E0B; }
    .trend-info    { background: rgba(59,130,246,.1);  color: #3B82F6; }
    .trend-purple  { background: rgba(139,92,246,.1);  color: #7C3AED; }

    /* ===== FILTRE ===== */
    .filter-card {
        background: white;
        border-radius: var(--radius-md);
        padding: 14px 16px;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
    }
    .filter-card form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filter-icon { color: var(--primary); font-size: 13px; flex-shrink: 0; }

    .filter-select,
    .filter-input {
        padding: 8px 12px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-full);
        font-size: 13px;
        background: var(--gray-50);
        color: var(--dark);
        outline: none;
        transition: all 0.2s;
        cursor: pointer;
    }
    .filter-select:focus,
    .filter-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    .filter-select { min-width: 180px; }
    .filter-input  { min-width: 160px; }

    .btn-filter {
        padding: 8px 18px;
        border-radius: var(--radius-full);
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white;
        box-shadow: 0 4px 10px rgba(255,98,0,0.2);
        transition: var(--transition-smooth);
        white-space: nowrap;
    }
    .btn-filter:hover { transform: translateY(-1px); box-shadow: 0 6px 16px var(--primary-glow); }

    .reset-link {
        font-size: 12px;
        color: var(--gray-600);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        border-radius: var(--radius-full);
        border: 1px solid var(--gray-200);
        transition: var(--transition-fast);
        white-space: nowrap;
    }
    .reset-link:hover { color: var(--primary); border-color: var(--primary); background: var(--primary-light); }

    .filter-spacer { flex: 1; min-width: 10px; }

    /* ===== LAYOUT PRINCIPAL ===== */
    .layout-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 18px;
        align-items: start;
    }
    @media (max-width: 900px) { .layout-grid { grid-template-columns: 1fr; } }

    /* ===== TABLE ===== */
    .table-card {
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        overflow: hidden;
    }
    .table-header {
        padding: 14px 18px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .table-header-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-header-title i { color: var(--primary); }
    .table-count {
        background: var(--primary-light);
        color: var(--primary);
        padding: 3px 10px;
        border-radius: var(--radius-full);
        font-size: 11px;
        font-weight: 700;
    }
    .table-wrap { overflow-x: auto; }
    .premium-table { width: 100%; border-collapse: collapse; min-width: 420px; }
    .premium-table th {
        background: var(--gray-50);
        padding: 10px 16px;
        font-size: 10px;
        font-weight: 700;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: .05em;
        border-bottom: 1px solid var(--gray-200);
        text-align: left;
        white-space: nowrap;
    }
    .premium-table td {
        padding: 11px 16px;
        border-bottom: 1px solid var(--gray-100);
        font-size: 13px;
        color: var(--dark);
        vertical-align: middle;
    }
    .premium-table tr:last-child td { border-bottom: none; }
    .premium-table tbody tr:hover td { background: var(--gray-50); }

    .emp-cell { display: flex; align-items: center; gap: 9px; }
    .emp-avatar {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 11px;
    }
    .emp-name { font-weight: 600; font-size: 13px; }

    .period-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 12px;
        font-weight: 600;
    }
    .period-chip i { color: var(--primary); font-size: 10px; }

    .salary-val { font-weight: 700; color: var(--dark); font-size: 13px; }

    .action-btn {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        background: transparent;
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        cursor: pointer;
        transition: var(--transition-fast);
        text-decoration: none;
        font-size: 12px;
    }
    .action-btn:hover        { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }
    .action-btn.delete:hover { background: #fee2e2; color: #dc2626; border-color: #fecaca; }

    .empty-state { text-align: center; padding: 48px 20px; color: var(--gray-600); }
    .empty-state i { font-size: 40px; display: block; margin-bottom: 10px; opacity: .3; }
    .empty-state p { margin: 0; font-size: 14px; }

    .pagination-wrap { padding: 12px 16px; display: flex; justify-content: center; }

    /* ===== GUIDE ===== */
    .guide-card {
        background: white;
        border-radius: var(--radius-md);
        padding: 18px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: sticky;
        top: 80px;
        overflow: hidden;
        transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0;
        transition: var(--transition-smooth);
        pointer-events: none;
    }
    .guide-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .guide-card:hover::before { opacity: 1; }
    .guide-card h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        z-index: 1;
    }
    .guide-card h3 i { color: var(--primary); }
    .guide-item {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        flex-shrink: 0;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }
    .guide-text strong { font-size: 13px; font-weight: 700; color: var(--dark); display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); font-size: 11px; margin: 0; line-height: 1.5; }
</style>

<div class="page-wrapper">

    {{-- 1. HEADER --}}
    <div class="page-header animate-in">
        <div>
            <h1 class="page-title">
                <i class="fas fa-file-invoice" style="color:var(--primary)"></i> Générez des
                <span>Bulletins de paie</span>
            </h1>
            <p class="page-subtitle">Gérez et consultez les bulletins de vos employés</p>
        </div>
        <a href="{{ route('admin.payslips.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i> Nouveau bulletin
        </a>
    </div>

    {{-- 2. ALERT (si présente) --}}
    @if(session('success'))
        <div class="alert-success animate-in">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- 3. KPI --}}
    <div class="kpi-grid animate-in delay-1">
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Total bulletins</span>
                <div class="kpi-icon"><i class="fas fa-file-invoice"></i></div>
            </div>
            <div class="kpi-value">{{ $totalPayslips ?? 0 }}</div>
            <div class="kpi-footer">
                <span class="trend-pill trend-info"><i class="fas fa-database"></i> Générés</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Masse salariale</span>
                <div class="kpi-icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($totalNetSalary ?? 0, 0, ',', ' ') }} F</div>
            <div class="kpi-footer">
                <span class="trend-pill trend-success"><i class="fas fa-chart-bar"></i> Cumul net</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Dernier bulletin</span>
                <div class="kpi-icon"><i class="fas fa-clock"></i></div>
            </div>
            <div class="kpi-value" style="font-size:15px;">
                {{ $lastPayslip?->employee->user->name ?? '—' }}
            </div>
            <div class="kpi-footer">
                @if($lastPayslip)
                    <span class="trend-pill trend-warning">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $lastPayslip->month }} {{ $lastPayslip->year }}
                    </span>
                @else
                    <span class="trend-pill" style="background:var(--gray-100);color:var(--gray-600);">Aucun</span>
                @endif
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Employés concernés</span>
                <div class="kpi-icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="kpi-value">{{ $filteredEmployeesCount ?? 0 }}</div>
            <div class="kpi-footer">
                <span class="trend-pill trend-purple"><i class="fas fa-filter"></i> Selon filtres</span>
            </div>
        </div>
    </div>

    {{-- 4. FILTRES --}}
    <div class="filter-card animate-in delay-1">
        <form method="GET" action="{{ route('admin.payslips.index') }}">
            <i class="fas fa-filter filter-icon"></i>

            <select name="employee_id" class="filter-select">
                <option value="">Tous les employés</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}"
                        {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->user->name }}
                    </option>
                @endforeach
            </select>

            <input
                type="month"
                name="period"
                class="filter-input"
                value="{{ request('period') }}"
            >

            <button type="submit" class="btn-filter">
                <i class="fas fa-search"></i> Filtrer
            </button>

            @if(request()->hasAny(['employee_id', 'period']))
                <a href="{{ route('admin.payslips.index') }}" class="reset-link">
                    <i class="fas fa-times-circle"></i> Réinitialiser
                </a>
            @endif

            <div class="filter-spacer"></div>
        </form>
    </div>

    {{-- 5. TABLEAU + GUIDE --}}
    <div class="layout-grid">

        {{-- Tableau --}}
        <div class="table-card animate-in delay-2">
            <div class="table-header">
                <div class="table-header-title">
                    <i class="fas fa-list"></i> Liste des bulletins
                </div>
                <span class="table-count">{{ $payslips->total() }} bulletin(s)</span>
            </div>

            @if($payslips->count())
                <div class="table-wrap">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Période</th>
                                <th>Salaire net</th>
                                <th style="text-align:right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payslips as $p)
                            <tr>
                                <td>
                                    <div class="emp-cell">
                                        <div class="emp-avatar">
                                            {{ strtoupper(substr($p->employee->user->name, 0, 1)) }}
                                        </div>
                                        <span class="emp-name">{{ $p->employee->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="period-chip">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $p->month }} {{ $p->year }}
                                    </span>
                                </td>
                                <td>
                                    <span class="salary-val">
                                        {{ number_format($p->net_salary, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                <td style="text-align:right">
                                    <a href="{{ route('admin.payslips.download', $p) }}"
                                       class="action-btn" title="Télécharger">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button
                                        type="button"
                                        onclick="openConfirmModal('{{ route('admin.payslips.destroy', $p) }}')"
                                        class="action-btn delete"
                                        title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrap">
                    {{ $payslips->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Aucun bulletin trouvé pour ces critères.</p>
                </div>
            @endif
        </div>

        {{-- Guide --}}
        <div class="guide-card animate-in delay-2">
            <h3><i class="fas fa-lightbulb"></i> Guide</h3>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-plus-circle"></i></div>
                <div class="guide-text">
                    <strong>Nouveau bulletin</strong>
                    <p>Générez un bulletin pour un employé et une période donnée.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-filter"></i></div>
                <div class="guide-text">
                    <strong>Filtres</strong>
                    <p>Filtrez par employé ou par mois pour retrouver rapidement un bulletin.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-download"></i></div>
                <div class="guide-text">
                    <strong>Téléchargement PDF</strong>
                    <p>Chaque bulletin est sécurisé par un QR code de vérification d'authenticité.</p>
                </div>
            </div>
            <div class="guide-item">
                <div class="guide-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="guide-text">
                    <strong>Sécurité</strong>
                    <p>Les bulletins sont cloisonnés par entreprise. Chaque employé ne voit que les siens.</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection