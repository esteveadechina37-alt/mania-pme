@extends('layouts.admin')

@section('title', 'Employés')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h1 style="font-family:'Clash Display', sans-serif; font-size:28px;">👥 Employés</h1>
    <a href="{{ route('admin.employees.create') }}" style="background:#FF6200; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600;">
        <i class="fas fa-plus"></i> Nouvel employé
    </a>
</div>

@if(session('success'))
    <div style="background:#d4edda; border-radius:8px; padding:12px 16px; margin-bottom:20px; color:#155724;">
        {{ session('success') }}
    </div>
@endif

<div style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#F7F4F0; text-align:left;">
                <th style="padding:12px 20px;">Nom</th>
                <th style="padding:12px 20px;">Email</th>
                <th style="padding:12px 20px;">Rôle</th>
                <th style="padding:12px 20px;">Département</th>
                <th style="padding:12px 20px;">Poste</th>
                <th style="padding:12px 20px;">Statut</th>
                <th style="padding:12px 20px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:12px 20px; font-weight:600;">{{ $employee->user->name }}</td>
                <td style="padding:12px 20px;">{{ $employee->user->email }}</td>
                <td style="padding:12px 20px;">{{ $employee->user->getRoleNames()->first() }}</td>
                <td style="padding:12px 20px;">{{ $employee->department->name ?? '-' }}</td>
                <td style="padding:12px 20px;">{{ $employee->position ?? '-' }}</td>
                <td style="padding:12px 20px;">
                    <span style="background:#e8f5e9; color:#2e7d32; padding:4px 12px; border-radius:100px; font-size:12px;">
                        {{ $employee->status }}
                    </span>
                </td>
                <td style="padding:12px 20px;">
                    <a href="{{ route('admin.employees.show', $employee) }}" style="color:#FF6200; margin-right:8px;"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.employees.edit', $employee) }}" style="color:#FF6200; margin-right:8px;"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer cet employé ?')" style="background:none; border:none; color:#dc2626; cursor:pointer;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $employees->links() }}
@endsection