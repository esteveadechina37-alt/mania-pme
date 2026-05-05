@extends('layouts.admin')

@section('title', 'Nouvel employé')

@section('content')
<h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin-bottom:24px;">➕ Nouvel employé</h1>

<form method="POST" action="{{ route('admin.employees.store') }}" style="background:#fff; padding:32px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    @csrf
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div>
            <label>Nom complet *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
            @error('name') <small style="color:red;">{{ $message }}</small> @enderror
        </div>
        <div>
            <label>Email *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
            @error('email') <small style="color:red;">{{ $message }}</small> @enderror
        </div>
        <div>
            <label>Mot de passe *</label>
            <input type="password" name="password" class="form-control" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
            @error('password') <small style="color:red;">{{ $message }}</small> @enderror
        </div>
        <div>
            <label>Rôle *</label>
            <select name="role" class="form-control" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
                <option value="">Choisir...</option>
                <option value="manager">Manager</option>
                <option value="employe">Employé</option>
                <option value="stagiaire">Stagiaire</option>
            </select>
            @error('role') <small style="color:red;">{{ $message }}</small> @enderror
        </div>
        <div>
            <label>Département</label>
            <select name="department_id" class="form-control" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
                <option value="">Aucun</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Poste</label>
            <input type="text" name="position" class="form-control" value="{{ old('position') }}" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
        </div>
        <div>
            <label>Type de contrat</label>
            <select name="contract_type" class="form-control" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
                <option value="">Sélectionner</option>
                <option value="CDI">CDI</option>
                <option value="CDD">CDD</option>
                <option value="Stage">Stage</option>
            </select>
        </div>
        <div>
            <label>Salaire mensuel</label>
            <input type="number" name="salary" class="form-control" value="{{ old('salary') }}" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
        </div>
        <div>
            <label>Date d'embauche</label>
            <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date') }}" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-top:4px;">
        </div>
    </div>
    <div style="margin-top:20px; display:flex; gap:12px;">
        <button type="submit" style="background:#FF6200; color:#fff; padding:12px 24px; border-radius:8px; border:none; font-weight:600;">Créer</button>
        <a href="{{ route('admin.employees.index') }}" style="background:#ddd; color:#333; padding:12px 24px; border-radius:8px; text-decoration:none;">Annuler</a>
    </div>
</form>
@endsection