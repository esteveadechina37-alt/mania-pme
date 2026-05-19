@extends('layouts.admin')

@section('title', 'Départements')

@section('content')
<style>
    /* ========== DESIGN SYSTEM (identique dashboard) ========== */
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
        --gray-800: #1F2937;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 4px rgba(10, 10, 10, 0.02);
        --shadow-md: 0 8px 24px rgba(10, 10, 10, 0.05);
        --shadow-lg: 0 16px 40px rgba(255, 98, 0, 0.08);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* ========== HEADER ========== */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
    }
    .page-header::after {
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 150px;
        height: 150px;
        background: var(--primary-glow);
        filter: blur(80px);
        z-index: -1;
        pointer-events: none;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 6px 0;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .page-subtitle {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        margin: 0;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(10, 10, 10, 0.12), 0 2px 8px var(--primary-glow);
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--primary-glow);
    }

    .alert-success {
        background: #ECFDF5;
        border-left: 4px solid #10B981;
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        margin-bottom: 24px;
        color: #065F46;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    /* ========== GRID ========== */
    .dept-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    /* ========== CARTE DÉPARTEMENT ========== */
    .dept-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }
    .dept-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .dept-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .dept-card:hover::before { opacity: 1; }

    .dept-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
        transition: var(--transition-smooth);
        border: 1px solid rgba(255,98,0,0.15);
    }
    .dept-card:hover .dept-icon {
        background: var(--primary);
        color: white;
        transform: scale(1.05);
    }

    .dept-name {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 4px 0;
    }
    .dept-meta {
        color: var(--gray-600);
        font-size: 13px;
        margin-bottom: 16px;
    }

    .dept-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }
    .dept-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gray-600);
        font-size: 14px;
    }
    .dept-info-item i {
        color: var(--primary);
        width: 16px;
        text-align: center;
    }

    .dept-actions {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    border-top: 1px solid var(--gray-100);
    padding-top: 16px;
    position: relative;   /* ← ajoutez ceci */
    z-index: 2;           /* ← et ceci */
    }

    .action-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: transparent;
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        cursor: pointer;
        transition: var(--transition-smooth);
        text-decoration: none;
        font-size: 14px;
        position: relative;   /* ← ajoutez ceci */
        z-index: 2;           /* ← et ceci */
    }
    .action-btn:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
        transform: translateY(-1px);
    }
    .action-btn.delete:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        grid-column: 1 / -1;
        padding: 80px 20px;
        text-align: center;
        color: var(--gray-600);
    }
    .empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: var(--gray-400);
    }

    /* ========== PAGINATION ========== */
    .pagination-wrap {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }
    .pagination-wrap nav { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
    .pagination-wrap a, .pagination-wrap span {
        padding: 7px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        transition: var(--transition-smooth);
        background: var(--white);
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .pagination-wrap a:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-light);
    }
    .pagination-wrap span[aria-current="page"] {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .pagination-wrap span[aria-disabled="true"] { opacity: 0.4; pointer-events: none; }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; }
        .dept-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-sitemap" style="color:var(--primary);"></i> <span>Départements</span></h1>
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
                    <span>{{ Str::limit($department->description ?? 'Aucune description', 70) }}</span>
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