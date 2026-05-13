@extends('layouts.admin')

@section('title', 'Demandes de congé en attente')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <h1 style="font-family:'Clash Display', sans-serif; font-size:28px;">⏳ Demandes en attente</h1>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#065F46;">
        {{ session('success') }}
    </div>
@endif

<div style="background:#fff; border-radius:12px; padding:24px;">
    @if(isset($requests) && $requests->count())
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #E5E7EB; text-align:left;">
                    <th style="padding:12px;">Employé</th>
                    <th style="padding:12px;">Type de congé</th>
                    <th style="padding:12px;">Dates</th>
                    <th style="padding:12px;">Motif</th>
                    <th style="padding:12px; text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr style="border-bottom:1px solid #F9FAFB;">
                    <td style="padding:12px; font-weight:600;">{{ $req->employee->user->name }}</td>
                    <td style="padding:12px;">{{ $req->leaveType->name }}</td>
                    <td style="padding:12px;">{{ $req->start_date->format('d/m/Y') }} - {{ $req->end_date->format('d/m/Y') }}</td>
                    <td style="padding:12px;">{{ Str::limit($req->reason, 40) ?: '—' }}</td>
                    <td style="padding:12px; text-align:right;">
                        <a href="{{ route('leave-requests.show', $req) }}" style="color:#FF6200; text-decoration:none; margin-right:12px;">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:20px;">
            {{ $requests->links() }}
        </div>
    @else
        <div style="text-align:center; padding:40px; color:#6B6B6B;">
            <i class="fas fa-check-circle" style="font-size:48px; display:block; margin-bottom:16px; color:#10B981;"></i>
            <p style="font-size:16px;">Aucune demande en attente pour le moment.</p>
        </div>
    @endif
</div>
@endsection