@extends('layouts.admin')

@section('title', 'Nouveau type de congé')

@section('content')
<style>
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        background: #fff;
        transition: all 0.2s ease;
        outline: none;
        color: #111827;
    }
    .form-input:focus {
        border-color: #FF6200;
        box-shadow: 0 0 0 3px rgba(255,98,0,0.1);
    }
    .form-input.is-invalid {
        border-color: #EF4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
    }
    .error-text {
        font-size: 12px;
        color: #EF4444;
        margin-top: 4px;
        display: block;
    }
    .btn-primary {
        background: #FF6200;
        color: #fff;
        padding: 12px 28px;
        border-radius: 100px;
        border: none;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-primary:hover {
        background: #e55800;
        box-shadow: 0 6px 16px rgba(255,98,0,0.35);
    }
    .btn-outline {
        background: #fff;
        color: #374151;
        padding: 12px 28px;
        border-radius: 100px;
        border: 1px solid #e5e7eb;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-outline:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }
    .checkbox-container input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #FF6200;
    }
</style>

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; display:flex; align-items:center; gap:12px;">
            <span style="background:#FFF0E5; color:#FF6200; width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; font-size:20px;">
                <i class="fas fa-umbrella-beach"></i>
            </span>
            Nouveau type de congé
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Ajoutez un motif d'absence et définissez ses règles</p>
    </div>
    <a href="{{ route('admin.leave-types.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

<form method="POST" action="{{ route('admin.leave-types.store') }}" style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 2px 8px rgba(0,0,0,0.04); max-width:640px;">
    @csrf

    <div style="margin-bottom:20px;">
        <label class="form-label" for="name">
            <i class="fas fa-tag" style="color:#FF6200; margin-right:6px;"></i> Nom du congé *
        </label>
        <input type="text" name="name" id="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')
            <span class="error-text">{{ $message }}</span>
        @enderror
    </div>

    <div style="margin-bottom:20px;">
        <label class="form-label" for="days_allowed">
            <i class="fas fa-calendar-day" style="color:#FF6200; margin-right:6px;"></i> Jours autorisés *
        </label>
        <input type="number" name="days_allowed" id="days_allowed" class="form-input @error('days_allowed') is-invalid @enderror" value="{{ old('days_allowed') }}" required min="1">
        @error('days_allowed')
            <span class="error-text">{{ $message }}</span>
        @enderror
    </div>

    <div class="checkbox-container">
        <input type="hidden" name="paid" value="0">
        <input type="checkbox" name="paid" id="paid" value="1" {{ old('paid', '1') == '1' ? 'checked' : '' }}>
        <label for="paid" style="font-weight:600; color:#374151; font-size:14px;">
            <i class="fas fa-check-circle" style="color:#FF6200; margin-right:6px;"></i> Congé payé
        </label>
    </div>

    <div style="display:flex; gap:12px; margin-top:32px;">
        <button type="submit" class="btn-primary">
            <i class="fas fa-save"></i> Créer le type
        </button>
        <a href="{{ route('admin.leave-types.index') }}" class="btn-outline">
            Annuler
        </a>
    </div>
</form>
@endsection