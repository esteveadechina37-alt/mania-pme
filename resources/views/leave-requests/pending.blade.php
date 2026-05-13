@extends('layouts.admin')

@section('title', 'Demandes de congé en attente')

@section('content')
<style>
    .premium-table tr:hover td {
        background-color: #FFF8F2;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        color: #FF6200;
        background: transparent;
        transition: all 0.15s ease;
        text-decoration: none;
        font-size: 14px;
    }
    .action-btn:hover {
        background: #FFF0E5;
    }
</style>

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; display:flex; align-items:center; gap:12px;">
            <span style="background:#FFF0E5; color:#FF6200; width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; font-size:20px;">
                <i class="fas fa-hourglass-half"></i>
            </span>
            Demandes en attente
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Consultez et traitez les demandes de congé soumises par les employés</p>
    </div>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#065F46; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

<div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.04); border:1px solid #F3F4F6;">
    @if(isset($requests) && $requests->count())
        <table style="width:100%; border-collapse:collapse;" class="premium-table">
            <thead>
                <tr style="background:#F9FAFB; text-align:left; border-bottom:1px solid #E5E7EB;">
                    <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase;">
                        <i class="fas fa-user" style="margin-right:6px;"></i> Employé
                    </th>
                    <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase;">
                        <i class="fas fa-umbrella-beach" style="margin-right:6px;"></i> Type de congé
                    </th>
                    <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase;">
                        <i class="fas fa-calendar-alt" style="margin-right:6px;"></i> Dates
                    </th>
                    <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase;">
                        <i class="fas fa-pen" style="margin-right:6px;"></i> Motif
                    </th>
                    <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase; text-align:right;">
                        <i class="fas fa-cog" style="margin-right:6px;"></i> Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr style="border-bottom:1px solid #F9FAFB;">
                    <td style="padding:14px 20px; font-weight:600;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:28px; height:28px; border-radius:8px; background:#FF6200; color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:12px;">
                                {{ strtoupper(substr($req->employee->user->name, 0, 1)) }}
                            </span>
                            {{ $req->employee->user->name }}
                        </div>
                    </td>
                    <td style="padding:14px 20px;">{{ $req->leaveType->name }}</td>
                    <td style="padding:14px 20px;">{{ $req->start_date->format('d/m/Y') }} - {{ $req->end_date->format('d/m/Y') }}</td>
                    <td style="padding:14px 20px;">{{ Str::limit($req->reason, 40) ?: '—' }}</td>
                    <td style="padding:14px 20px; text-align:right;">
                        <a href="{{ route('leave-requests.show', $req) }}" class="action-btn" title="Voir et traiter">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:0 20px 20px;">
            {{ $requests->links() }}
        </div>
    @else
        <div style="text-align:center; padding:60px 20px; color:#9CA3AF;">
            <i class="fas fa-check-circle" style="font-size:48px; display:block; margin-bottom:16px; color:#10B981;"></i>
            <p style="font-size:16px;">Aucune demande en attente pour le moment.</p>
        </div>
    @endif
</div>
@endsection