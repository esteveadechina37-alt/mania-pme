@extends('layouts.admin')

@section('title', 'Nouvelle demande de congé')

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

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; display:flex; align-items:center; gap:12px;">
            <span style="background:#FFF0E5; color:#FF6200; width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; font-size:20px;">
                <i class="fas fa-calendar-plus"></i>
            </span>
            Nouvelle demande de congé
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Remplissez les informations pour soumettre votre demande</p>
    </div>
    <a href="{{ route('leave-requests.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.03); max-width: 700px; margin: 0 auto;">
    <form method="POST" action="{{ route('leave-requests.store') }}">
        @csrf

        {{-- Type de congé --}}
        <div style="margin-bottom:20px;">
            <label class="form-label" for="leave_type_id">
                <i class="fas fa-umbrella-beach" style="color:#FF6200; margin-right:6px;"></i> Type de congé *
            </label>
            <select name="leave_type_id" id="leave_type_id" class="form-select @error('leave_type_id') is-invalid @enderror" required>
                <option value="">Sélectionnez un type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }} ({{ $type->days_allowed }} jours)
                    </option>
                @endforeach
            </select>
            @error('leave_type_id')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        {{-- Dates --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
            <div>
                <label class="form-label" for="start_date">
                    <i class="fas fa-calendar-alt" style="color:#FF6200; margin-right:6px;"></i> Date de début *
                </label>
                <input type="date" name="start_date" id="start_date" class="form-input @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                @error('start_date')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="form-label" for="end_date">
                    <i class="fas fa-calendar-check" style="color:#FF6200; margin-right:6px;"></i> Date de fin *
                </label>
                <input type="date" name="end_date" id="end_date" class="form-input @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required min="{{ date('Y-m-d') }}">
                @error('end_date')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Motif --}}
        <div style="margin-bottom:24px;">
            <label class="form-label" for="reason">
                <i class="fas fa-pen" style="color:#FF6200; margin-right:6px;"></i> Motif (optionnel)
            </label>
            <textarea name="reason" id="reason" rows="4" class="form-textarea @error('reason') is-invalid @enderror" placeholder="Raison de l'absence...">{{ old('reason') }}</textarea>
            @error('reason')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        {{-- Boutons --}}
        <div style="display:flex; gap:12px; justify-content:flex-end;">
            <a href="{{ route('leave-requests.index') }}" class="btn-outline">
                Annuler
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i> Soumettre
            </button>
        </div>
    </form>
</div>
@endsection