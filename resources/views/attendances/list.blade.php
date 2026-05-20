@extends('layouts.admin')

@section('title', 'Présences du jour')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
    <h1 style="font-family:'Clash Display', sans-serif; font-size:28px;"><i class="fas fa-clock" style="color:#FF6200;"></i> Présences du jour</h1>
</div>

<div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.04);">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#F9FAFB; text-align:left;">
                <th style="padding:14px 20px;">Employé</th>
                <th style="padding:14px 20px;">Arrivée</th>
                <th style="padding:14px 20px;">Départ</th>
                <th style="padding:14px 20px;">Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $att)
            <tr style="border-bottom:1px solid #F9FAFB;">
                <td style="padding:14px 20px;">{{ $att->employee->user->name }}</td>
                <td style="padding:14px 20px;">{{ $att->check_in }}</td>
                <td style="padding:14px 20px;">{{ $att->check_out ?? '—' }}</td>
                <td style="padding:14px 20px;">{{ $att->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:40px; text-align:center; color:#9CA3AF;">Aucun pointage aujourd'hui.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $attendances->links() }}
@endsection