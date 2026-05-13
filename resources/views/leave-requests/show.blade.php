@extends('layouts.admin')

@section('title', 'Détail de la demande')

@section('content')
<style>
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
    }
    .badge-status.pending {
        background: #FEF3C7;
        color: #92400E;
    }
    .badge-status.approved {
        background: #DCFCE7;
        color: #166534;
    }
    .badge-status.rejected {
        background: #FEE2E2;
        color: #991B1B;
    }
    .info-row {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .info-label {
        color: #6B6B6B;
        font-size: 13px;
    }
    .info-value {
        font-weight: 600;
        color: #111827;
    }
    .btn-approve {
        background: #DCFCE7;
        color: #166534;
        border: none;
        padding: 10px 20px;
        border-radius: 100px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-approve:hover {
        background: #BBF7D0;
    }
    .btn-reject {
        background: #FEE2E2;
        color: #991B1B;
        border: none;
        padding: 10px 20px;
        border-radius: 100px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-reject:hover {
        background: #FECACA;
    }
    .btn-outline {
        background: #fff;
        color: #374151;
        padding: 10px 20px;
        border-radius: 100px;
        border: 1px solid #e5e7eb;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-outline:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
</style>

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; display:flex; align-items:center; gap:12px;">
            <span style="background:#FFF0E5; color:#FF6200; width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; font-size:20px;">
                <i class="fas fa-file-alt"></i>
            </span>
            Demande de congé
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Détail de la demande de <strong>{{ $leaveRequest->employee->user->name }}</strong></p>
    </div>
    <a href="{{ route('leave-requests.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.03); max-width: 700px; margin: 0 auto;">
    {{-- En-tête avec statut --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
        <h2 style="font-family:'Clash Display', sans-serif; font-size:22px; margin:0;">
            <i class="fas fa-umbrella-beach" style="color:#FF6200; margin-right:8px;"></i>
            {{ $leaveRequest->leaveType->name }}
        </h2>
        @php
            $statusClass = match($leaveRequest->status) {
                'pending' => 'pending',
                'approved' => 'approved',
                'rejected' => 'rejected',
                default => ''
            };
        @endphp
        <span class="badge-status {{ $statusClass }}">
            @if($leaveRequest->status == 'pending')
                <span style="width:6px; height:6px; border-radius:50%; background:#92400E;"></span>
                <i class="fas fa-clock"></i> En attente
            @elseif($leaveRequest->status == 'approved')
                <span style="width:6px; height:6px; border-radius:50%; background:#166534;"></span>
                <i class="fas fa-check-circle"></i> Approuvé
            @else
                <span style="width:6px; height:6px; border-radius:50%; background:#991B1B;"></span>
                <i class="fas fa-times-circle"></i> Refusé
            @endif
        </span>
    </div>

    {{-- Détails --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 20px; margin-bottom:28px;">
        <div class="info-row">
            <span class="info-label">
                <i class="fas fa-calendar-alt" style="color:#FF6200; margin-right:6px;"></i> Date de début
            </span>
            <span class="info-value">{{ $leaveRequest->start_date->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">
                <i class="fas fa-calendar-check" style="color:#FF6200; margin-right:6px;"></i> Date de fin
            </span>
            <span class="info-value">{{ $leaveRequest->end_date->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">
                <i class="fas fa-hourglass-half" style="color:#FF6200; margin-right:6px;"></i> Durée
            </span>
            <span class="info-value">{{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} jour(s)</span>
        </div>
        <div class="info-row">
            <span class="info-label">
                <i class="fas fa-user" style="color:#FF6200; margin-right:6px;"></i> Demandeur
            </span>
            <span class="info-value">{{ $leaveRequest->employee->user->name }}</span>
        </div>
    </div>

    {{-- Motif --}}
    <div style="margin-bottom:28px; padding:16px; background:#F9FAFB; border-radius:10px;">
        <span style="color:#6B6B6B; font-size:13px; display:block; margin-bottom:4px;">
            <i class="fas fa-pen" style="color:#FF6200; margin-right:6px;"></i> Motif
        </span>
        <p style="font-weight:600; color:#111827;">{{ $leaveRequest->reason ?: 'Aucun motif fourni' }}</p>
    </div>

    {{-- Approbateur --}}
    @if($leaveRequest->approved_by)
    <div style="margin-bottom:28px;">
        <span style="color:#6B6B6B; font-size:13px; display:block; margin-bottom:4px;">
            <i class="fas fa-user-check" style="color:#FF6200; margin-right:6px;"></i> Décision prise par
        </span>
        <p style="font-weight:600; color:#111827;">
            {{ $leaveRequest->approver->name }} 
            <span style="font-weight:400; color:#6B6B6B;">({{ $leaveRequest->approver->getRoleNames()->first() }})</span>
        </p>
    </div>
    @endif

    {{-- Boutons de validation (admin/manager) --}}
    @if($leaveRequest->status == 'pending' && auth()->user()->hasAnyRole(['admin', 'manager']))
    <div style="display:flex; gap:12px; justify-content:flex-end; border-top:1px solid #F3F4F6; padding-top:24px;">
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
@endsection