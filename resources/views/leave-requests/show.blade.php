@extends('layouts.admin')

@section('title', 'Détail de la demande')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
        <a href="{{ url()->previous() }}" style="color:#6B6B6B; text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">
            📄 Demande de congé
        </h1>
    </div>

    <div style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.03);">
        {{-- En-tête avec statut --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <h2 style="font-size:20px; margin:0;">{{ $leaveRequest->leaveType->name }}</h2>
            @php
                $statusClass = match($leaveRequest->status) {
                    'pending' => 'pending',
                    'approved' => 'actif',
                    'rejected' => 'suspendu',
                    default => ''
                };
            @endphp
            <span class="badge-status {{ $statusClass }}" style="font-size:14px; padding:6px 16px;">
                @if($leaveRequest->status == 'pending') En attente
                @elseif($leaveRequest->status == 'approved') Approuvé
                @else Refusé
                @endif
            </span>
        </div>

        {{-- Détails --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
            <div>
                <span style="color:#6B6B6B; font-size:13px;">Date de début</span>
                <p style="font-weight:600;">{{ $leaveRequest->start_date->format('d/m/Y') }}</p>
            </div>
            <div>
                <span style="color:#6B6B6B; font-size:13px;">Date de fin</span>
                <p style="font-weight:600;">{{ $leaveRequest->end_date->format('d/m/Y') }}</p>
            </div>
            <div>
                <span style="color:#6B6B6B; font-size:13px;">Durée</span>
                <p style="font-weight:600;">{{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} jour(s)</p>
            </div>
            <div>
                <span style="color:#6B6B6B; font-size:13px;">Demandeur</span>
                <p style="font-weight:600;">{{ $leaveRequest->employee->user->name }}</p>
            </div>
        </div>

        {{-- Motif --}}
        <div style="margin-bottom:24px;">
            <span style="color:#6B6B6B; font-size:13px;">Motif</span>
            <p style="font-weight:600;">{{ $leaveRequest->reason ?: 'Aucun motif fourni' }}</p>
        </div>

        {{-- Approbateur --}}
        @if($leaveRequest->approved_by)
        <div style="margin-bottom:24px;">
            <span style="color:#6B6B6B; font-size:13px;">Décision prise par</span>
            <p style="font-weight:600;">{{ $leaveRequest->approver->name }} ({{ $leaveRequest->approver->getRoleNames()->first() }})</p>
        </div>
        @endif

        {{-- Boutons de validation (admin/manager) --}}
        @if($leaveRequest->status == 'pending' && auth()->user()->hasAnyRole(['admin', 'manager']))
        <div style="display:flex; gap:12px; justify-content:flex-end; border-top:1px solid #eee; padding-top:24px;">
            <form method="POST" action="{{ route('leave-requests.decide', $leaveRequest) }}" style="display:inline;">
                @csrf
                <input type="hidden" name="decision" value="rejected">
                <button type="submit" style="background:#fee2e2; color:#991b1b; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">
                    <i class="fas fa-times-circle"></i> Refuser
                </button>
            </form>
            <form method="POST" action="{{ route('leave-requests.decide', $leaveRequest) }}" style="display:inline;">
                @csrf
                <input type="hidden" name="decision" value="approved">
                <button type="submit" style="background:#dcfce7; color:#166534; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">
                    <i class="fas fa-check-circle"></i> Approuver
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection