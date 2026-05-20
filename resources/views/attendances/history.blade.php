@extends('layouts.admin')

@section('title', 'Historique des pointages')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
    <h1 style="font-family:'Clash Display', sans-serif; font-size:28px;"><i class="fas fa-history" style="color:#FF6200;"></i> Historique</h1>
</div>

<div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.04);">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#F9FAFB; text-align:left;">
                <th style="padding:14px 20px;">Date</th>
                <th style="padding:14px 20px;">Arrivée</th>
                <th style="padding:14px 20px;">Départ</th>
                <th style="padding:14px 20px;">Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $att)
            <tr style="border-bottom:1px solid #F9FAFB;">
                <td style="padding:14px 20px;">{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                <td style="padding:14px 20px;">{{ $att->check_in }}</td>
                <td style="padding:14px 20px;">{{ $att->check_out ?? '—' }}</td>
                <td style="padding:14px 20px;">{{ $att->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $attendances->links() }}
@endsection