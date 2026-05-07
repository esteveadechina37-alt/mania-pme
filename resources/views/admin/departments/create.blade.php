@extends('layouts.admin')

@section('title', 'Nouveau département')

@section('content')
<style>
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        background: #fff;
        transition: all 0.2s ease;
        outline: none;
        color: #111827;
        font-family: 'Cabinet Grotesk', sans-serif;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #FF6200;
        box-shadow: 0 0 0 3px rgba(255,98,0,0.1);
    }
    .form-input.is-invalid, .form-select.is-invalid, .form-textarea.is-invalid {
        border-color: #EF4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
    }
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L0 2h12z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 12px;
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
</style>

{{-- En-tête --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">
            <i class="fas fa-building" style="color:#FF6200; margin-right:8px;"></i> Nouveau département
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Ajoutez une nouvelle structure à votre entreprise</p>
    </div>
    <a href="{{ route('admin.departments.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

{{-- Formulaire --}}
<form method="POST" action="{{ route('admin.departments.store') }}" style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    @csrf

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 20px;">
        <div>
            <label class="form-label"><i class="fas fa-tag" style="color:#FF6200; margin-right:6px;"></i> Nom du département *</label>
            <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="form-label"><i class="fas fa-user-tie" style="color:#FF6200; margin-right:6px;"></i> Manager</label>
            <select name="manager_id" class="form-select">
                <option value="">Aucun</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}
                    </option>
                @endforeach
            </select>
            @error('manager_id')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div style="margin-top:24px;">
        <label class="form-label"><i class="fas fa-align-left" style="color:#FF6200; margin-right:6px;"></i> Description</label>
        <textarea name="description" rows="4" class="form-textarea @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
        @error('description') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div style="margin-top:32px; display:flex; gap:12px;">
        <button type="submit" class="btn-primary">
            <i class="fas fa-save"></i> Créer le département
        </button>
        <a href="{{ route('admin.departments.index') }}" class="btn-outline">
            Annuler
        </a>
    </div>
</form>
@endsection