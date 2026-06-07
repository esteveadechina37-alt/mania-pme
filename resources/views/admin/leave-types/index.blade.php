@extends('layouts.admin')

@section('title', 'Types de congés')

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
        0%   { opacity: 0; transform: translateY(16px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @@keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-4px); }
    }
    @@keyframes progressBar {
        from { width: 0; }
    }

    .animate-in { animation: fadeSlideUp 0.55s ease both; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* ===== HEADER ===== */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 20px; flex-wrap: wrap; gap: 16px;
    }
    .page-title {
        font-size: clamp(20px, 4vw, 28px); font-weight: 700; color: var(--dark);
        display: flex; align-items: center; gap: 10px; margin: 0 0 4px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 14px; margin: 0; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 10px 22px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.2);
        text-decoration: none; transition: var(--transition-smooth); white-space: nowrap;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }

    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981; border-radius: 8px;
        padding: 12px 18px; margin-bottom: 20px; color: #065F46;
        display: flex; align-items: center; gap: 8px; font-size: 14px;
    }

    /* ===== KPI ===== */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px; margin-bottom: 20px;
    }
    @media (max-width: 1000px) { .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 500px)  { .kpi-grid { grid-template-columns: 1fr; } }

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
        font-size: clamp(22px, 4vw, 28px); font-weight: 700; color: var(--dark);
        line-height: 1; margin-bottom: 6px; position: relative; z-index: 1;
    }
    .kpi-footer {
        display: flex; align-items: center; gap: 6px; font-size: 10px;
        color: var(--gray-600); padding-top: 6px; border-top: 1px solid var(--gray-100);
        position: relative; z-index: 1;
    }
    .trend-pill {
        display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 10px; white-space: nowrap;
    }
    .trend-success { background: rgba(16,185,129,.1); color: #10B981; }
    .trend-info    { background: rgba(59,130,246,.1);  color: #3B82F6; }

    /* ===== BLOC CÔTE À CÔTE : jours fériés + actions rapides ===== */
    .mid-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 16px; margin-bottom: 20px; align-items: start;
    }
    @media (max-width: 768px) { .mid-grid { grid-template-columns: 1fr; } }

    /* ===== CARD GÉNÉRIQUE ===== */
    .info-card {
        background: white; border-radius: var(--radius-md); padding: 16px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
        height: 100%;
    }
    .info-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth); pointer-events: none;
    }
    .info-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .info-card:hover::before { opacity: 1; }
    .info-card-title {
        font-size: 14px; font-weight: 700; color: var(--dark);
        margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
        position: relative; z-index: 1;
    }
    .info-card-title i { color: var(--primary); }

    /* Jours fériés */
    .holiday-row {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 0; border-bottom: 1px solid var(--gray-100);
        position: relative; z-index: 1;
    }
    .holiday-row:last-child { border-bottom: none; }
    .holiday-date-badge {
        width: 38px; height: 38px; border-radius: 8px; flex-shrink: 0;
        background: var(--primary-light); color: var(--primary);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        font-weight: 700; font-size: 13px; line-height: 1;
    }
    .holiday-date-badge small { font-size: 8px; text-transform: uppercase; font-weight: 600; }
    .holiday-info strong { font-size: 13px; font-weight: 600; color: var(--dark); display: block; }
    .holiday-info span { font-size: 11px; color: var(--gray-600); }

    /* Actions rapides */
    .quick-list {
        display: flex; flex-direction: column; gap: 8px;
        position: relative; z-index: 1;
    }
    .quick-link {
        background: var(--gray-50); border-radius: var(--radius-sm); padding: 10px 12px;
        border: 1px solid var(--gray-200); text-decoration: none;
        display: flex; align-items: center; gap: 10px;
        transition: var(--transition-smooth); min-width: 0;
    }
    .quick-link:hover { background: white; border-color: var(--primary); transform: translateX(3px); }
    .ql-icon {
        width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 14px;
    }
    .ql-text { min-width: 0; }
    .ql-text strong {
        font-size: 12px; color: var(--dark); display: block;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ql-text span { font-size: 11px; color: var(--gray-600); }

    /* ===== CONTENU PRINCIPAL ===== */
    .content-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 20px; align-items: start;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }

    /* ===== CARTES TYPES ===== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 14px;
    }
    @media (max-width: 600px) { .cards-grid { grid-template-columns: 1fr; } }

    .type-card {
        background: white; border-radius: var(--radius-md); padding: 16px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
        display: flex; flex-direction: column; min-width: 0;
    }
    .type-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth); pointer-events: none;
    }
    .type-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .type-card:hover::before { opacity: 1; }
    .type-card-body { position: relative; z-index: 1; flex: 1; }

    .type-name {
        font-size: 15px; font-weight: 700; color: var(--dark);
        margin-bottom: 10px; display: flex; align-items: center;
        justify-content: space-between; gap: 8px; flex-wrap: wrap;
    }
    .type-badge {
        padding: 3px 10px; border-radius: var(--radius-full); font-size: 10px; font-weight: 700;
        white-space: nowrap; flex-shrink: 0;
    }
    .type-badge.paid   { background: #DCFCE7; color: #166534; }
    .type-badge.unpaid { background: #FEE2E2; color: #991B1B; }

    .gauge-item { margin-bottom: 10px; }
    .gauge-header { display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 4px; color: var(--gray-600); }
    .gauge-bar { height: 6px; background: var(--gray-100); border-radius: 3px; overflow: hidden; }
    .gauge-fill {
        height: 100%; background: linear-gradient(90deg, #FF8C42, #FF6200);
        border-radius: 3px; width: 0%;
        animation: progressBar 0.8s ease forwards;
        box-shadow: 0 0 8px rgba(255,98,0,0.3);
    }
    .type-meta { font-size: 11px; color: var(--gray-600); margin-bottom: 4px; }

    .type-actions {
        display: flex; gap: 8px; justify-content: flex-end;
        margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--gray-100);
        position: relative; z-index: 1;
    }
    .action-btn {
        width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; background: transparent; color: var(--gray-600);
        border: 1px solid var(--gray-200); cursor: pointer; transition: var(--transition-fast);
        text-decoration: none; font-size: 13px;
    }
    .action-btn:hover        { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }
    .action-btn.delete:hover { background: #FEE2E2; color: #DC2626; border-color: #FEE2E2; }

    /* ===== GUIDE ===== */
    .guide-card {
        background: white; border-radius: var(--radius-md); padding: 20px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth); pointer-events: none;
    }
    .guide-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .guide-card:hover::before { opacity: 1; }
    .guide-card .card-title {
        font-size: 15px; font-weight: 700; color: var(--dark);
        margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
        position: relative; z-index: 1;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item { display: flex; gap: 10px; margin-bottom: 14px; position: relative; z-index: 1; }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 34px; height: 34px; border-radius: var(--radius-sm); flex-shrink: 0;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 14px;
    }
    .guide-text strong { font-size: 13px; font-weight: 700; color: var(--dark); display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); font-size: 12px; margin: 0; line-height: 1.5; }

    .empty-state { grid-column: 1/-1; text-align: center; padding: 48px 20px; color: var(--gray-600); }
    .empty-state i { font-size: 40px; display: block; margin-bottom: 12px; opacity: .3; }
    .empty-state p { margin: 0; font-size: 14px; }
</style>

{{-- Header --}}
<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-umbrella-beach" style="color:var(--primary)"></i>
            <span>Types de congés</span>
        </h1>
        <p class="page-subtitle">Gérez les différents motifs d'absence</p>
    </div>
    <a href="{{ route('admin.leave-types.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i> Nouveau type
    </a>
</div>

@if(session('success'))
    <div class="alert-success animate-in">
        <i class="fas fa-check-circle" style="color:#10B981;font-size:18px"></i>
        {{ session('success') }}
    </div>
@endif

{{-- KPI --}}
<div class="kpi-grid animate-in delay-1">
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Types configurés</span>
            <div class="kpi-icon"><i class="fas fa-tag"></i></div>
        </div>
        <div class="kpi-value">{{ $totalTypes }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-info"><i class="fas fa-list"></i> Total</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Jours cumulés</span>
            <div class="kpi-icon"><i class="fas fa-calendar-day"></i></div>
        </div>
        <div class="kpi-value">{{ $totalDaysConfigured }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-info"><i class="fas fa-calendar"></i> Configurés</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Congés payés</span>
            <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="kpi-value">{{ $paidCount }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-success"><i class="fas fa-check"></i> Rémunérés</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <span class="kpi-label">Non payés</span>
            <div class="kpi-icon"><i class="fas fa-times-circle"></i></div>
        </div>
        <div class="kpi-value">{{ $unpaidCount }}</div>
        <div class="kpi-footer">
            <span class="trend-pill trend-info"><i class="fas fa-info"></i> Sans solde</span>
        </div>
    </div>
</div>

{{-- ✅ Jours fériés + Actions rapides CÔTE À CÔTE --}}
<div class="mid-grid animate-in delay-2">

    {{-- Jours fériés --}}
    <div class="info-card">
        <div class="info-card-title">
            <i class="fas fa-calendar-alt"></i> Prochains jours fériés
        </div>
        @if(count($upcomingHolidays) > 0)
            @foreach($upcomingHolidays as $holiday)
                <div class="holiday-row">
                    <div class="holiday-date-badge">
                        {{ $holiday['date']->format('d') }}
                        <small>{{ $holiday['date']->isoFormat('MMM') }}</small>
                    </div>
                    <div class="holiday-info">
                        <strong>{{ $holiday['name'] }}</strong>
                        <span>{{ $holiday['date']->isoFormat('dddd D MMMM YYYY') }}</span>
                    </div>
                </div>
            @endforeach
        @else
            <p style="color:var(--gray-600);font-size:13px;margin:0;">Aucun jour férié à venir.</p>
        @endif
    </div>

    {{-- Actions rapides --}}
    <div class="info-card">
        <div class="info-card-title">
            <i class="fas fa-bolt"></i> Actions rapides
        </div>
        <div class="quick-list">
            <a href="{{ route('admin.leave-types.create') }}" class="quick-link">
                <div class="ql-icon"><i class="fas fa-plus-circle"></i></div>
                <div class="ql-text"><strong>Créer un type</strong><span>Ajouter un motif</span></div>
            </a>
            <a href="{{ route('leave-requests.pending') }}" class="quick-link">
                <div class="ql-icon"><i class="fas fa-clock"></i></div>
                <div class="ql-text"><strong>En attente</strong><span>Validation congés</span></div>
            </a>
            <!-- <a href="{{ route('admin.employees.index') }}" class="quick-link">
                <div class="ql-icon"><i class="fas fa-users"></i></div>
                <div class="ql-text"><strong>Employés</strong><span>Gérer les effectifs</span></div>
            </a>
            <a href="{{ route('admin.payslips.index') }}" class="quick-link">
                <div class="ql-icon"><i class="fas fa-file-invoice"></i></div>
                <div class="ql-text"><strong>Paie</strong><span>Bulletins de salaire</span></div>
            </a> -->
        </div>
    </div>

</div>

{{-- Grille types + guide --}}
<div class="content-grid">

    {{-- Cartes types --}}
    <div class="cards-grid">
        @forelse($types as $type)
            <div class="type-card animate-in delay-{{ ($loop->index % 4) + 1 }}">
                <div class="type-card-body">
                    <div class="type-name">
                        {{ $type->name }}
                        <span class="type-badge {{ $type->paid ? 'paid' : 'unpaid' }}">
                            {{ $type->paid ? 'Payé' : 'Non payé' }}
                        </span>
                    </div>
                    <div class="gauge-item">
                        <div class="gauge-header">
                            <span>{{ $type->used_days }}/{{ $type->days_allowed }} j. utilisés</span>
                            <span>{{ $type->percentage }}%</span>
                        </div>
                        <div class="gauge-bar">
                            <div class="gauge-fill" style="width:{{ $type->percentage }}%"></div>
                        </div>
                    </div>
                    <p class="type-meta">
                        <i class="fas fa-calendar-day"></i>
                        {{ $type->days_allowed }} jours autorisés par an
                    </p>
                </div>
                <div class="type-actions">
                    <a href="{{ route('admin.leave-types.edit', $type) }}" class="action-btn" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button"
                        onclick="openConfirmModal('{{ route('admin.leave-types.destroy', $type) }}')"
                        class="action-btn delete" title="Supprimer">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p>Aucun type de congé pour le moment.<br>
                <a href="{{ route('admin.leave-types.create') }}" style="color:var(--primary);font-weight:600;">
                    Créer le premier type →
                </a></p>
            </div>
        @endforelse
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-4" style="position:sticky; top:90px;">
        <div class="card-title"><i class="fas fa-lightbulb"></i> Guide des congés</div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-tag"></i></div>
            <div class="guide-text">
                <strong>Types de congés</strong>
                <p>Définissez les motifs d'absence utilisables par vos employés.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-chart-pie"></i></div>
            <div class="guide-text">
                <strong>Jauge d'utilisation</strong>
                <p>La barre orange indique les jours déjà approuvés sur l'année en cours.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-check-circle"></i></div>
            <div class="guide-text">
                <strong>Congé payé ?</strong>
                <p>Les congés "Payé" sont rémunérés. Les autres sont sans solde.</p>
            </div>
        </div>
    </div>

</div>
@endsection