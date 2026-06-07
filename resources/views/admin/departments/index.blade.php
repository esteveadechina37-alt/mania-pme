@extends('layouts.admin')

@section('title', 'Départements')

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
        padding:14px 18px;
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
    .kpi-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-lg); border-color:var(--primary); }
    .kpi-card:hover::before { opacity:1; }
    .kpi-card:hover::after { opacity:1; }
    .kpi-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; z-index:1; }
    .kpi-label { font-size:11px; font-weight:600; color:var(--gray-600); text-transform:uppercase; letter-spacing:0.4px; }
    .kpi-icon {
        width:36px; height:36px; border-radius:8px;
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
        display:flex; align-items:center; gap:6px; font-size:10px;
        color:var(--gray-600); padding-top:6px; border-top:1px solid var(--gray-100); z-index:1;
    }
    .trend-pill {
        display:inline-flex; align-items:center; gap:4px; padding:4px 10px;
        border-radius:var(--radius-full); font-weight:600; font-size:11px;
    }
    .trend-success { background:rgba(16,185,129,0.1); color:#10B981; }
    .trend-info { background:rgba(59,130,246,0.1); color:#3B82F6; }

    /* ===== CARTES DÉPARTEMENT COMPACTES ===== */
    .dept-grid {
        display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap:16px; margin-bottom:24px;
    }
    @media (max-width:600px) { .dept-grid { grid-template-columns:1fr; } }

    .dept-card {
        background:rgba(255,255,255,0.8);
        backdrop-filter:blur(12px);
        -webkit-backdrop-filter:blur(12px);
        border-radius:var(--radius-md);
        padding:16px 18px;
        box-shadow:var(--shadow-md);
        border:1px solid rgba(255,255,255,0.6);
        position:relative;
        overflow:hidden;
        transition:var(--transition-smooth);
        display:flex;
        flex-direction:column;
        justify-content:space-between;
    }
    .dept-card::before {
        content:''; position:absolute; inset:0;
        background:radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity:0; transition:var(--transition-smooth);
    }
    .dept-card::after {
        content:''; position:absolute; inset:0;
        background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.2) 30%, transparent 60%);
        background-size:200% 100%;
        animation:glassShine 5s infinite;
        opacity:0; transition:opacity 0.4s;
        pointer-events:none;
    }
    .dept-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-lg); border-color:var(--primary); }
    .dept-card:hover::before { opacity:1; }
    .dept-card:hover::after { opacity:1; }

    .dept-icon {
        width:40px; height:40px; border-radius:10px;
        background:var(--primary-light); color:var(--primary);
        display:flex; align-items:center; justify-content:center;
        font-size:18px; margin-bottom:10px; transition:var(--transition-smooth);
        border:1px solid rgba(255,98,0,0.15);
    }
    .dept-card:hover .dept-icon {
        background:var(--primary); color:white; transform:scale(1.05);
    }

    .dept-name {
        font-family:'Clash Display',sans-serif; font-size:18px; font-weight:700;
        color:var(--dark); margin:0 0 4px 0;
    }
    .dept-meta {
        color:var(--gray-600); font-size:12px; margin-bottom:10px;
    }

    .dept-info {
        display:flex; flex-direction:column; gap:6px; margin-bottom:12px;
    }
    .dept-info-item {
        display:flex; align-items:center; gap:6px; color:var(--gray-600); font-size:13px;
    }
    .dept-info-item i { color:var(--primary); width:14px; text-align:center; }

    .dept-actions {
        display:flex; gap:8px; justify-content:flex-end;
        border-top:1px solid var(--gray-100); padding-top:10px;
        position:relative; z-index:2;
    }
    .action-btn {
        width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center;
        border-radius:8px; background:transparent; color:var(--gray-600);
        border:1px solid var(--gray-200); cursor:pointer; transition:var(--transition-fast);
        text-decoration:none; font-size:13px;
    }
    .action-btn:hover { border-color:var(--primary); background:var(--primary-light); color:var(--primary); }
    .action-btn.delete:hover { background:#FEE2E2; color:#DC2626; border-color:#FEE2E2; }

    .empty-state {
        grid-column:1 / -1; padding:60px 20px; text-align:center; color:var(--gray-600);
    }
    .pagination-wrap { margin-top:20px; display:flex; justify-content:center; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-sitemap" style="color:var(--primary);"></i>Gestion <span>Départements</span></h1>
        <p class="page-subtitle">Gérez les structures de votre entreprise</p>
    </div>
    <a href="{{ route('admin.departments.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i> Nouveau département
    </a>
</div>

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
            <span class="kpi-label">Total départements</span>
            <div class="kpi-icon"><i class="fas fa-sitemap"></i></div>
        </div>
        <div class="kpi-value">{{ $totalDepartments }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-info"><i class="fas fa-building"></i> Structures</span></div>
    </div>
    <div class="kpi-card animate-in delay-2">
        <div class="kpi-header">
            <span class="kpi-label">Total employés</span>
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
        </div>
        <div class="kpi-value">{{ $totalEmployees }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-success"><i class="fas fa-user-plus"></i> Collaborateurs</span></div>
    </div>
    <div class="kpi-card animate-in delay-3">
        <div class="kpi-header">
            <span class="kpi-label">Employés actifs</span>
            <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
        </div>
        <div class="kpi-value">{{ $activeEmployees }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-success"><i class="fas fa-check"></i> Actifs</span></div>
    </div>
    <div class="kpi-card animate-in delay-4">
        <div class="kpi-header">
            <span class="kpi-label">Départements managés</span>
            <div class="kpi-icon"><i class="fas fa-user-tie"></i></div>
        </div>
        <div class="kpi-value">{{ $managedDepts }}</div>
        <div class="kpi-footer"><span class="trend-pill trend-info"><i class="fas fa-check-circle"></i> Avec manager</span></div>
    </div>
</div>


{{-- Actions rapides --}}
<h3 class="section-title"><i class="fas fa-bolt"></i>Actions rapides</h3>
<div class="quick-actions animate-in delay-2" style="margin-bottom: 20px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px;">
        <a href="{{ route('admin.departments.create') }}"
           style="background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
                  border-radius: var(--radius-md); padding: 14px 18px; box-shadow: var(--shadow-sm);
                  border: 1px solid rgba(255,255,255,0.6); text-decoration: none;
                  display: flex; align-items: center; gap: 10px; transition: var(--transition-smooth);">
            <span style="width: 36px; height: 36px; border-radius: 8px; background: var(--primary-light);
                         color: var(--primary); display: flex; align-items: center; justify-content: center;
                         font-size: 16px;"><i class="fas fa-plus-circle"></i></span>
            <div>
                <div style="font-weight: 600; font-size: 13px; color: var(--dark);">Nouveau département</div>
                <div style="font-size: 11px; color: var(--gray-600);">Créer une entité</div>
            </div>
        </a>
        <a href="{{ route('admin.employees.index') }}"
           style="background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
                  border-radius: var(--radius-md); padding: 14px 18px; box-shadow: var(--shadow-sm);
                  border: 1px solid rgba(255,255,255,0.6); text-decoration: none;
                  display: flex; align-items: center; gap: 10px; transition: var(--transition-smooth);">
            <span style="width: 36px; height: 36px; border-radius: 8px; background: var(--primary-light);
                         color: var(--primary); display: flex; align-items: center; justify-content: center;
                         font-size: 16px;"><i class="fas fa-users"></i></span>
            <div>
                <div style="font-weight: 600; font-size: 13px; color: var(--dark);">Gérer les employés</div>
                <div style="font-size: 11px; color: var(--gray-600);">Effectif global</div>
            </div>
        </a>
        <a href="{{ route('admin.contracts.index') }}"
           style="background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
                  border-radius: var(--radius-md); padding: 14px 18px; box-shadow: var(--shadow-sm);
                  border: 1px solid rgba(255,255,255,0.6); text-decoration: none;
                  display: flex; align-items: center; gap: 10px; transition: var(--transition-smooth);">
            <span style="width: 36px; height: 36px; border-radius: 8px; background: var(--primary-light);
                         color: var(--primary); display: flex; align-items: center; justify-content: center;
                         font-size: 16px;"><i class="fas fa-file-contract"></i></span>
            <div>
                <div style="font-weight: 600; font-size: 13px; color: var(--dark);">Contrats</div>
                <div style="font-size: 11px; color: var(--gray-600);">Suivi des échéances</div>
            </div>
        </a>
        <a href="{{ route('admin.payslips.index') }}"
           style="background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
                  border-radius: var(--radius-md); padding: 14px 18px; box-shadow: var(--shadow-sm);
                  border: 1px solid rgba(255,255,255,0.6); text-decoration: none;
                  display: flex; align-items: center; gap: 10px; transition: var(--transition-smooth);">
            <span style="width: 36px; height: 36px; border-radius: 8px; background: var(--primary-light);
                         color: var(--primary); display: flex; align-items: center; justify-content: center;
                         font-size: 16px;"><i class="fas fa-file-invoice"></i></span>
            <div>
                <div style="font-weight: 600; font-size: 13px; color: var(--dark);">Bulletins de paie</div>
                <div style="font-size: 11px; color: var(--gray-600);">Générer et consulter</div>
            </div>
        </a>
    </div>
</div>

{{-- Liste des départements --}}
<div class="dept-grid">
    @forelse($departments as $department)
        <div class="dept-card animate-in delay-{{ $loop->index % 4 + 1 }}">
            <div class="dept-icon"><i class="fas fa-building"></i></div>
            <h3 class="dept-name">{{ $department->name }}</h3>
            <p class="dept-meta">{{ $department->employees_count ?? 0 }} employé(s)</p>

            <div class="dept-info">
                <div class="dept-info-item">
                    <i class="fas fa-user-tie"></i>
                    <span>{{ $department->manager && $department->manager->is_active ? $department->manager->name : 'Manager non assigné' }}</span>
                </div>
                <div class="dept-info-item">
                    <i class="fas fa-align-left"></i>
                    <span>{{ Str::limit($department->description ?? 'Aucune description', 60) }}</span>
                </div>
            </div>

            <div class="dept-actions">
                <a href="{{ route('admin.departments.show', $department) }}" class="action-btn" title="Voir">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.departments.edit', $department) }}" class="action-btn" title="Modifier">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" onclick="openConfirmModal('{{ route('admin.departments.destroy', $department) }}')"
                        class="action-btn delete" title="Supprimer">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
            <p style="font-size:16px; font-weight:500;">Aucun département créé pour le moment.</p>
        </div>
    @endforelse
</div>

<div class="pagination-wrap animate-in delay-2">
    {{ $departments->links() }}
</div>
@endsection