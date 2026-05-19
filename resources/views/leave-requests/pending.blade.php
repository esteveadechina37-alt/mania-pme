@extends('layouts.admin')

@section('title', 'Demandes de congé en attente')

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

    /* ========== MAIN LAYOUT ========== */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    /* ========== TABLE CARD ========== */
    .table-card {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        overflow: hidden;
    }
    .premium-table {
        width: 100%;
        border-collapse: collapse;
    }
    .premium-table th {
        background: var(--gray-50);
        padding: 14px 20px;
        font-weight: 600;
        font-size: 11px;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--gray-200);
        text-align: left;
    }
    .premium-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--gray-100);
        font-size: 14px;
        color: var(--dark);
    }
    .premium-table tr:last-child td {
        border-bottom: none;
    }
    .premium-table tr:hover td {
        background: var(--gray-50);
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: transparent;
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        cursor: pointer;
        transition: var(--transition-smooth);
        text-decoration: none;
        font-size: 14px;
    }
    .action-btn:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-600);
    }

    /* ========== GUIDE CARD ========== */
    .guide-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .guide-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .guide-card:hover::before { opacity: 1; }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    .guide-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .guide-text strong {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        display: block;
        margin-bottom: 4px;
    }
    .guide-text p {
        color: var(--gray-600);
        font-size: 13px;
        margin: 0;
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
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-hourglass-half" style="color:var(--primary);"></i> <span>Demandes en attente</span></h1>
        <p class="page-subtitle">Consultez et traitez les demandes de congé soumises par les employés</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

<div class="content-grid">
    {{-- Tableau des demandes en attente --}}
    <div class="table-card animate-in delay-1" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        @if(isset($requests) && $requests->count())
            <table class="premium-table" style="min-width: 700px;">
                <thead>
                    <tr>
                        <th><i class="fas fa-user" style="margin-right:6px;"></i> Employé</th>
                        <th><i class="fas fa-umbrella-beach" style="margin-right:6px;"></i> Type</th>
                        <th><i class="fas fa-calendar-alt" style="margin-right:6px;"></i> Dates</th>
                        <th><i class="fas fa-pen" style="margin-right:6px;"></i> Motif</th>
                        <th style="text-align:right;"><i class="fas fa-cog" style="margin-right:6px;"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr>
                        <td style="font-weight:600;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="width:28px; height:28px; border-radius:8px; background:var(--primary); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:12px;">
                                    {{ strtoupper(substr($req->employee->user->name, 0, 1)) }}
                                </span>
                                {{ $req->employee->user->name }}
                            </div>
                        </td>
                        <td>{{ $req->leaveType->name }}</td>
                        <td>{{ $req->start_date->format('d/m/Y') }} - {{ $req->end_date->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($req->reason, 40) ?: '—' }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('leave-requests.show', $req) }}" class="action-btn" title="Voir et traiter">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 0 20px 20px;">
                {{ $requests->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-check-circle" style="font-size:48px; display:block; margin-bottom:16px; color:#10B981; opacity:0.6;"></i>
                <p style="font-size:16px; font-weight:500;">Aucune demande en attente pour le moment.</p>
            </div>
        @endif
    </div>

    {{-- Guide rapide --}}
    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide de validation</h3>
        
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-eye"></i></div>
            <div class="guide-text">
                <strong>Consultez les détails</strong>
                <p>Cliquez sur l'icône <i class="fas fa-eye" style="color:var(--primary);"></i> pour voir la demande complète, les dates et le motif.</p>
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-check-circle"></i></div>
            <div class="guide-text">
                <strong>Approuvez ou refusez</strong>
                <p>Depuis la fiche de la demande, utilisez les boutons pour valider ou rejeter la demande.</p>
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-bell"></i></div>
            <div class="guide-text">
                <strong>Notification automatique</strong>
                <p>L'employé sera informé de votre décision. Les soldes de congés seront mis à jour automatiquement.</p>
            </div>
        </div>
    </div>
</div>
@endsection