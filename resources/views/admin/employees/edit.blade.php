@extends('layouts.admin')

@section('title', 'Modifier employé')

@section('content')
<h1 style="font-family: 'Clash Display', sans-serif; font-size: 28px; margin-bottom: 24px;">✏️ Modifier : {{ $employee->user->name }}</h1>

<form method="POST" action="{{ route('admin.employees.update', $employee) }}" style="background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        {{-- Informations utilisateur --}}
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Nom complet *</label>
            <input type="text" name="name" value="{{ old('name', $employee->user->name) }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
            @error('name') <small style="color: red;">{{ $message }}</small> @enderror
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Email *</label>
            <input type="email" name="email" value="{{ old('email', $employee->user->email) }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
            @error('email') <small style="color: red;">{{ $message }}</small> @enderror
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
            @error('password') <small style="color: red;">{{ $message }}</small> @enderror
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Rôle *</label>
            <select name="role" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
                <option value="manager" {{ $employee->user->hasRole('manager') ? 'selected' : '' }}>Manager</option>
                <option value="employe" {{ $employee->user->hasRole('employe') ? 'selected' : '' }}>Employé</option>
                <option value="stagiaire" {{ $employee->user->hasRole('stagiaire') ? 'selected' : '' }}>Stagiaire</option>
            </select>
            @error('role') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        {{-- Informations employé --}}
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Département</label>
            <select name="department_id" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
                <option value="">Aucun</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Poste</label>
            <input type="text" name="position" value="{{ old('position', $employee->position) }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Type de contrat</label>
            <select name="contract_type" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
                <option value="">Sélectionner</option>
                <option value="CDI" {{ old('contract_type', $employee->contract_type) === 'CDI' ? 'selected' : '' }}>CDI</option>
                <option value="CDD" {{ old('contract_type', $employee->contract_type) === 'CDD' ? 'selected' : '' }}>CDD</option>
                <option value="Stage" {{ old('contract_type', $employee->contract_type) === 'Stage' ? 'selected' : '' }}>Stage</option>
            </select>
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Salaire mensuel</label>
            <input type="number" name="salary" value="{{ old('salary', $employee->salary) }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Date d'embauche</label>
            <input type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
        </div>
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Statut employé</label>
            <select name="status" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 12px;">
                <option value="active" {{ old('status', $employee->status) === 'active' ? 'selected' : '' }}>Actif</option>
                <option value="suspended" {{ old('status', $employee->status) === 'suspended' ? 'selected' : '' }}>Suspendu</option>
                <option value="terminated" {{ old('status', $employee->status) === 'terminated' ? 'selected' : '' }}>Terminé</option>
            </select>
        </div>
    </div>

    <div style="margin-top: 24px; display: flex; gap: 12px;">
        <button type="submit" style="background: #FF6200; color: #fff; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600;">
            Mettre à jour
        </button>
        <a href="{{ route('admin.employees.show', $employee) }}" style="background: #ddd; color: #333; padding: 12px 24px; border-radius: 8px; text-decoration: none;">
            Annuler
        </a>
    </div>
</form>
@endsection