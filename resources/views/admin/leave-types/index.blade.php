@extends('layouts.admin')

@section('title', 'Types de congés')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <h1 style="font-family:'Clash Display', sans-serif; font-size:28px;">📅 Types de congés</h1>
    <a href="{{ route('admin.leave-types.create') }}" class="btn-primary" style="background:#FF6200; color:#fff; padding:10px 22px; border-radius:100px; text-decoration:none; font-weight:600;">
        <i class="fas fa-plus-circle"></i> Nouveau type
    </a>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#065F46;">
        {{ session('success') }}
    </div>
@endif

<div style="background:#fff; border-radius:12px; padding:24px;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:1px solid #E5E7EB; text-align:left;">
                <th style="padding:12px;">Nom</th>
                <th style="padding:12px;">Jours autorisés</th>
                <th style="padding:12px;">Payé</th>
                <th style="padding:12px; text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($types as $type)
            <tr style="border-bottom:1px solid #F9FAFB;">
                <td style="padding:12px;">{{ $type->name }}</td>
                <td style="padding:12px;">{{ $type->days_allowed }}</td>
                <td style="padding:12px;">{{ $type->paid ? 'Oui' : 'Non' }}</td>
                <td style="padding:12px; text-align:right;">
                    <a href="{{ route('admin.leave-types.edit', $type) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.leave-types.destroy', $type) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ?')" class="action-btn delete"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $types->links() }}
@endsection