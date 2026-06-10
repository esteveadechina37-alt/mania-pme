@extends('layouts.admin')

@section('title', 'Demande de congé')

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
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 20px rgba(10,10,10,0.05);
        --radius-sm: 6px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s ease;
    }
    @keyframes fadeSlideUp {
        0% { opacity:0; transform:translateY(12px); }
        100% { opacity:1; transform:translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.08s; }
    .delay-2 { animation-delay:0.16s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 10px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
    .page-subtitle { color: var(--gray-600); font-size: 13px; margin: 0; }

    .btn-outline-sm {
        background: var(--white); color: var(--dark); padding: 6px 14px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 12px;
        border: 1px solid var(--gray-200); display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none; transition: var(--transition-smooth);
    }
    .btn-outline-sm:hover { background: var(--gray-50); border-color: var(--primary); }

    .content-grid {
        display: grid; grid-template-columns: 1fr 240px; gap: 16px; align-items: start;
    }
    @media (max-width: 850px) { .content-grid { grid-template-columns: 1fr; } }

    .detail-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
    }
    .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 700;
        color: var(--dark); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
    }
    .card-title i { color: var(--primary); }

    .badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600;
    }
    .badge-pending { background: #FEF3C7; color: #92400E; }
    .badge-approved { background: #DCFCE7; color: #166534; }
    .badge-rejected { background: #FEE2E2; color: #991B1B; }

    .info-row {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 0; border-bottom: 1px solid var(--gray-100);
        font-size: 13px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; flex-shrink: 0;
    }
    .info-text strong { font-size: 14px; color: var(--dark); display: block; }
    .info-text span { font-size: 12px; color: var(--gray-600); }

    .btn-approve, .btn-reject {
        padding: 8px 20px; border-radius: var(--radius-full); font-weight: 600;
        font-size: 13px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
        transition: 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .btn-approve { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
    .btn-approve:hover { background: #BBF7D0; transform: translateY(-1px); }
    .btn-reject { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }
    .btn-reject:hover { background: #FECACA; transform: translateY(-1px); }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        position: sticky; top: 80px;
    }
    .guide-card h4 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h4 i { color: var(--primary); }
    .guide-item { display: flex; gap: 8px; margin-bottom: 10px; font-size: 12px; }
    .guide-icon {
        width: 24px; height: 24px; border-radius: 6px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 11px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 12px; display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-file-alt" style="color:var(--primary); margin-right:6px;"></i>
            Demande de congé
        </h1>
        <p class="page-subtitle">
            {{ $leaveRequest->employee->user->name }} · 
            <strong>{{ $leaveRequest->leaveType->name }}</strong>
        </p>
    </div>
    <a href="{{ auth()->user()->hasAnyRole(['manager', 'admin']) ? route('leave-requests.pending') : route('leave-requests.index') }}" 
       class="btn-outline-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="content-grid">
    <div class="detail-card animate-in delay-1">
        {{-- En-tête avec statut --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <span class="card-title" style="margin-bottom:0;">
                <i class="fas fa-umbrella-beach"></i> {{ $leaveRequest->leaveType->name }}
            </span>
            @php
                $statusClass = match($leaveRequest->status) {
                    'pending' => 'badge-pending',
                    'approved' => 'badge-approved',
                    'rejected' => 'badge-rejected',
                    default => ''
                };
            @endphp
            <span class="badge {{ $statusClass }}">
                @if($leaveRequest->status == 'pending')
                    <i class="fas fa-clock"></i> En attente
                @elseif($leaveRequest->status == 'approved')
                    <i class="fas fa-check-circle"></i> Approuvé
                @else
                    <i class="fas fa-times-circle"></i> Refusé
                @endif
            </span>
        </div>

        {{-- Infos --}}
        <div class="info-row">
            <div class="info-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="info-text">
                <strong>Dates</strong>
                <span>{{ $leaveRequest->start_date->format('d/m/Y') }} → {{ $leaveRequest->end_date->format('d/m/Y') }} 
                ({{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} jour(s))</span>
            </div>
        </div>
        <div class="info-row">
            <div class="info-icon"><i class="fas fa-user"></i></div>
            <div class="info-text">
                <strong>Demandeur</strong>
                <span>{{ $leaveRequest->employee->user->name }}</span>
            </div>
        </div>
        @if($leaveRequest->reason)
        <div class="info-row">
            <div class="info-icon"><i class="fas fa-pen"></i></div>
            <div class="info-text">
                <strong>Motif</strong>
                <span>{{ $leaveRequest->reason }}</span>
            </div>
        </div>
        @endif
        @if($leaveRequest->approved_by)
        <div class="info-row">
            <div class="info-icon"><i class="fas fa-user-check"></i></div>
            <div class="info-text">
                <strong>Décision par</strong>
                <span>{{ $leaveRequest->approver->name }} ({{ $leaveRequest->approver->getRoleNames()->first() }})</span>
            </div>
        </div>
        @endif

        {{-- Actions (manager/admin) --}}
        @if($leaveRequest->status == 'pending' && auth()->user()->hasAnyRole(['admin', 'manager']))
        <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:16px; padding-top:12px; border-top:1px solid var(--gray-100);">
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

    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Guide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user-check"></i></div>
            <div class="guide-text">
                <strong>Effectif</strong>
                <p>Assurez-vous qu'un collègue peut couvrir les tâches.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-week"></i></div>
            <div class="guide-text">
                <strong>Droits</strong>
                <p>Vérifiez l'ancienneté et le solde de congés.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-balance-scale"></i></div>
            <div class="guide-text">
                <strong>Solde</strong>
                <p>L'employé a-t-il encore assez de jours ?</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-file-alt"></i></div>
            <div class="guide-text">
                <strong>Motif</strong>
                <p>Le motif est-il légitime ?</p>
            </div>
        </div>
    </div>
</div>
@endsection