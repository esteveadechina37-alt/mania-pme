@extends('layouts.admin')

@section('title', 'Demande de congé')

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

    /* ========== MAIN LAYOUT ========== */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ========== CARTE DÉTAIL ========== */
    .detail-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 32px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 18px;
        border-radius: var(--radius-full);
        font-size: 13px;
        font-weight: 600;
    }
    .badge-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-approved { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    .info-label {
        color: var(--gray-600);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }
    .info-value {
        font-weight: 600;
        color: var(--dark);
        font-size: 15px;
    }

    .btn-approve {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 10px 24px;
        border-radius: var(--radius-full);
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
        font-family: 'Cabinet Grotesk', sans-serif;
    }
    .btn-approve:hover {
        background: #bbf7d0;
        box-shadow: 0 4px 12px rgba(22, 101, 52, 0.15);
    }
    .btn-reject {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 10px 24px;
        border-radius: var(--radius-full);
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
        font-family: 'Cabinet Grotesk', sans-serif;
    }
    .btn-reject:hover {
        background: #fecaca;
        box-shadow: 0 4px 12px rgba(153, 27, 27, 0.15);
    }

    /* ========== CARTE GUIDE ========== */
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
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-file-alt" style="color:var(--primary);"></i> <span>Demande de congé</span></h1>
        <p class="page-subtitle">Détail de la demande de <strong>{{ $leaveRequest->employee->user->name }}</strong></p>
    </div>
    <a href="{{ auth()->user()->hasAnyRole(['manager', 'admin']) ? route('leave-requests.pending') : route('leave-requests.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

<div class="content-grid">
    {{-- Colonne gauche : Détail de la demande --}}
    <div class="detail-card animate-in delay-1">
        {{-- En-tête avec statut --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
            <h2 style="font-family:'Clash Display', sans-serif; font-size:22px; margin:0; display:flex; align-items:center; gap:8px;">
                <i class="fas fa-umbrella-beach" style="color:var(--primary);"></i>
                {{ $leaveRequest->leaveType->name }}
            </h2>
            @php
                $statusClass = match($leaveRequest->status) {
                    'pending' => 'badge-pending',
                    'approved' => 'badge-approved',
                    'rejected' => 'badge-rejected',
                    default => ''
                };
            @endphp
            <span class="badge-status {{ $statusClass }}">
                @if($leaveRequest->status == 'pending')
                    <i class="fas fa-clock"></i> En attente
                @elseif($leaveRequest->status == 'approved')
                    <i class="fas fa-check-circle"></i> Approuvé
                @else
                    <i class="fas fa-times-circle"></i> Refusé
                @endif
            </span>
        </div>

        {{-- Détails --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 20px; margin-bottom:28px;">
            <div>
                <div class="info-label"><i class="fas fa-calendar-alt" style="color:var(--primary);"></i> Date de début</div>
                <div class="info-value">{{ $leaveRequest->start_date->format('d/m/Y') }}</div>
            </div>
            <div>
                <div class="info-label"><i class="fas fa-calendar-check" style="color:var(--primary);"></i> Date de fin</div>
                <div class="info-value">{{ $leaveRequest->end_date->format('d/m/Y') }}</div>
            </div>
            <div>
                <div class="info-label"><i class="fas fa-hourglass-half" style="color:var(--primary);"></i> Durée</div>
                <div class="info-value">{{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} jour(s)</div>
            </div>
            <div>
                <div class="info-label"><i class="fas fa-user" style="color:var(--primary);"></i> Demandeur</div>
                <div class="info-value">{{ $leaveRequest->employee->user->name }}</div>
            </div>
        </div>

        {{-- Motif --}}
        <div style="margin-bottom:28px; padding:16px; background:var(--gray-50); border-radius:var(--radius-sm); border:1px solid var(--gray-200);">
            <div class="info-label"><i class="fas fa-pen" style="color:var(--primary);"></i> Motif</div>
            <p style="font-weight:600; color:var(--dark); margin:4px 0 0;">{{ $leaveRequest->reason ?: 'Aucun motif fourni' }}</p>
        </div>

        {{-- Approbateur --}}
        @if($leaveRequest->approved_by)
        <div style="margin-bottom:28px;">
            <div class="info-label"><i class="fas fa-user-check" style="color:var(--primary);"></i> Décision prise par</div>
            <div class="info-value">
                {{ $leaveRequest->approver->name }} 
                <span style="font-weight:400; color:var(--gray-600);">({{ $leaveRequest->approver->getRoleNames()->first() }})</span>
            </div>
        </div>
        @endif

        {{-- Boutons de validation (admin/manager) --}}
        @if($leaveRequest->status == 'pending' && auth()->user()->hasAnyRole(['admin', 'manager']))
        <div style="display:flex; gap:12px; justify-content:flex-end; border-top:1px solid var(--gray-100); padding-top:24px;">
            <form method="POST" action="{{ route('leave-requests.decide', $leaveRequest) }}" style="display:inline;">
                @csrf
                <input type="hidden" name="decision" value="rejected">
                <button type="submit" class="btn-reject">
                    <i class="fas fa-times-circle"></i> Refuser
                </button>
            </form>
            <form method="POST" action="{{ route('leave-requests.decide', $leaveRequest) }}" style="display:inline;">
                @csrf
                <input type="hidden" name="decision" value="approved">
                <button type="submit" class="btn-approve">
                    <i class="fas fa-check-circle"></i> Approuver
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Colonne droite : Guide pour le manager --}}
    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-clipboard-check"></i> Avant de valider</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user-check"></i></div>
            <div class="guide-text">
                <strong>Effectif présent</strong>
                <p>Assurez-vous qu'au moins un autre employé peut couvrir les tâches pendant l'absence.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-week"></i></div>
            <div class="guide-text">
                <strong>Période d'essai</strong>
                <p>Vérifiez que l'employé a bien acquis les droits à congé (ancienneté suffisante).</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-balance-scale"></i></div>
            <div class="guide-text">
                <strong>Solde de congés</strong>
                <p>L'employé dispose-t-il encore de jours de congé ce mois-ci/année ?</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-file-alt"></i></div>
            <div class="guide-text">
                <strong>Motif valable</strong>
                <p>Un congé doit avoir un motif légitime (maladie, maternité, repos, etc.).</p>
            </div>
        </div>
    </div>
</div>
@endsection