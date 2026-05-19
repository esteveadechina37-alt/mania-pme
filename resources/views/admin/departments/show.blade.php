@extends('layouts.admin')

@section('title', $department->name)

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

    .btn-outline {
        background: var(--white);
        color: var(--dark);
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 13px;
        border: 1px solid var(--gray-200);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: var(--transition-smooth);
        white-space: nowrap;
    }
    .btn-outline:hover {
        background: var(--gray-50);
        border-color: var(--primary-glow);
    }

    /* ========== BENTO CARD ========== */
    .bento-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 28px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }
    .bento-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .bento-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .bento-card:hover::before { opacity: 1; }

    .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 24px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
    }
    .card-title i { color: var(--primary); }

    .info-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid var(--gray-100);
        position: relative;
        z-index: 1;
    }
    .info-row:last-child { border-bottom: none; }

    .icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        transition: var(--transition-smooth);
    }

    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: 13px;
        font-weight: 600;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
    }

    /* Membres */
    .member-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: relative;
        z-index: 1;
    }
    .member-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }
    .member-item:hover {
        background: var(--white);
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
        transform: translateX(2px);
    }
    .avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(255,98,0,0.2);
    }

    .empty-state {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 32px 0;
        color: var(--gray-600);
        font-size: 15px;
        position: relative;
        z-index: 1;
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-building" style="color:var(--primary);"></i> <span>{{ $department->name }}</span></h1>
        <p class="page-subtitle">{{ $department->employees->count() }} employé(s) dans ce département</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.departments.edit', $department) }}" class="btn-primary">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <a href="{{ route('admin.departments.index') }}" class="btn-outline">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
    {{-- Carte Informations --}}
    <div class="bento-card animate-in delay-1">
        <h3 class="card-title">
            <span style="background: var(--primary-light); color: var(--primary); padding: 8px 12px; border-radius: 10px;">
                <i class="fas fa-clipboard-list"></i>
            </span>
            Informations
        </h3>

        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-align-left"></i></div>
            <div>
                <div style="font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Description</div>
                <div style="font-weight: 600; font-size: 14px;">{{ $department->description ?? 'Aucune description' }}</div>
            </div>
        </div>

        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-user-tie"></i></div>
            <div>
                <div style="font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Manager</div>
                <div style="font-weight: 600;">
                    @if($department->manager && $department->manager->is_active)
                        <span class="badge-pill"><i class="fas fa-user-check"></i> {{ $department->manager->name }}</span>
                    @else
                        <span style="color: var(--gray-600);">Non assigné</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-users"></i></div>
            <div>
                <div style="font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;">Effectif total</div>
                <div style="font-weight: 600; font-size: 14px;">{{ $department->employees->count() }} personne(s)</div>
            </div>
        </div>
    </div>

    {{-- Carte Membres --}}
    <div class="bento-card animate-in delay-2">
        <h3 class="card-title">
            <span style="background: var(--primary-light); color: var(--primary); padding: 8px 12px; border-radius: 10px;">
                <i class="fas fa-user-friends"></i>
            </span>
            Membres de l'équipe
        </h3>

        @if($department->employees->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user-slash" style="font-size: 28px; opacity: 0.4;"></i>
                <span>Aucun employé dans ce département.</span>
            </div>
        @else
            <ul class="member-list">
                @foreach($department->employees as $employee)
                    <li class="member-item">
                        <div class="avatar-sm">
                            {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                        </div>
                        <div style="flex: 1; font-weight: 600;">{{ $employee->user->name }}</div>
                        <span style="font-size: 12px; color: var(--gray-600);">{{ $employee->position ?? '' }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection