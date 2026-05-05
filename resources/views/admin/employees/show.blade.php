@extends('layouts.admin')

@section('title', 'Fiche employé')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1 style="font-family: 'Clash Display', sans-serif; font-size: 28px;">👤 {{ $employee->user->name }}</h1>
    <div>
        <a href="{{ route('admin.employees.edit', $employee) }}" style="background: #FF6200; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-right: 8px;">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="{{ route('admin.employees.index') }}" style="background: #ddd; color: #333; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: #d4edda; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #155724;">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    {{-- Informations personnelles --}}
    <div style="background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
        <h3 style="font-family: 'Clash Display', sans-serif; margin-bottom: 16px;">📋 Informations personnelles</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Nom complet</span>
                <p style="font-weight: 600;">{{ $employee->user->name }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Email</span>
                <p style="font-weight: 600;">{{ $employee->user->email }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Téléphone</span>
                <p style="font-weight: 600;">{{ $employee->user->phone ?? '-' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Rôle</span>
                <p style="font-weight: 600; text-transform: capitalize;">{{ $employee->user->getRoleNames()->first() ?? 'N/A' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Statut du compte</span>
                @if($employee->user->is_active)
                    <span style="background: #e8f5e9; color: #2e7d32; padding: 2px 12px; border-radius: 100px; font-size: 12px;">Actif</span>
                @else
                    <span style="background: #ffebee; color: #c62828; padding: 2px 12px; border-radius: 100px; font-size: 12px;">Inactif</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Informations professionnelles --}}
    <div style="background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
        <h3 style="font-family: 'Clash Display', sans-serif; margin-bottom: 16px;">💼 Informations professionnelles</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Département</span>
                <p style="font-weight: 600;">{{ $employee->department->name ?? 'Non assigné' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Poste</span>
                <p style="font-weight: 600;">{{ $employee->position ?? '-' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Type de contrat</span>
                <p style="font-weight: 600;">{{ $employee->contract_type ?? '-' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Salaire mensuel</span>
                <p style="font-weight: 600;">{{ $employee->salary ? number_format($employee->salary, 0, ',', ' ') . ' FCFA' : '-' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Date d'embauche</span>
                <p style="font-weight: 600;">{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '-' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Fin de contrat</span>
                <p style="font-weight: 600;">{{ $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') : '-' }}</p>
            </div>
            <div>
                <span style="color: #6B6B6B; font-size: 13px;">Statut employé</span>
                @if($employee->status === 'active')
                    <span style="background: #e8f5e9; color: #2e7d32; padding: 2px 12px; border-radius: 100px; font-size: 12px;">Actif</span>
                @elseif($employee->status === 'suspended')
                    <span style="background: #fff3e0; color: #e65100; padding: 2px 12px; border-radius: 100px; font-size: 12px;">Suspendu</span>
                @else
                    <span style="background: #ffebee; color: #c62828; padding: 2px 12px; border-radius: 100px; font-size: 12px;">Terminé</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Actions supplémentaires --}}
<div style="margin-top: 24px; display: flex; gap: 12px;">
    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet employé ?');">
        @csrf
        @method('DELETE')
        <button type="submit" style="background: #dc2626; color: #fff; padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600;">
            <i class="fas fa-trash"></i> Supprimer l'employé
        </button>
    </form>
</div>
@endsection