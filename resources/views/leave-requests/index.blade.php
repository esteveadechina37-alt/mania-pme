@extends('layouts.admin')

@section('title', 'Mes demandes de congés')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <h1>📋 Mes demandes</h1>
    <a href="{{ route('leave-requests.create') }}" class="btn-primary">Nouvelle demande</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Dates</th>
                <th>Statut</th>
                <th>Approbateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
            <tr>
                <td>{{ $req->leaveType->name }}</td>
                <td>{{ $req->start_date->format('d/m/Y') }} - {{ $req->end_date->format('d/m/Y') }}</td>
                <td><span class="badge-status {{ $req->status }}">{{ $req->status }}</span></td>
                <td>{{ $req->approver?->name ?? '-' }}</td>
                <td><a href="{{ route('leave-requests.show', $req) }}"><i class="fas fa-eye"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $requests->links() }}
@endsection