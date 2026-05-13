@extends('layouts.admin')

@section('title', 'Nouvelle demande de congé')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
        <a href="{{ route('leave-requests.index') }}" style="color:#6B6B6B; text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">
            ➕ Nouvelle demande de congé
        </h1>
    </div>

    <div style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.03);">
        <form method="POST" action="{{ route('leave-requests.store') }}">
            @csrf

            {{-- Type de congé --}}
            <div style="margin-bottom:20px;">
                <label style="font-weight:600; display:block; margin-bottom:6px;">Type de congé *</label>
                <select name="leave_type_id" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; font-family:'Cabinet Grotesk', sans-serif;">
                    <option value="">Sélectionnez un type</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} ({{ $type->days_allowed }} jours)
                        </option>
                    @endforeach
                </select>
                @error('leave_type_id') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            {{-- Dates --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label style="font-weight:600; display:block; margin-bottom:6px;">Date de début *</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                    @error('start_date') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
                <div>
                    <label style="font-weight:600; display:block; margin-bottom:6px;">Date de fin *</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" required min="{{ date('Y-m-d') }}" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                    @error('end_date') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Motif --}}
            <div style="margin-bottom:24px;">
                <label style="font-weight:600; display:block; margin-bottom:6px;">Motif (optionnel)</label>
                <textarea name="reason" rows="4" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; resize:vertical;">{{ old('reason') }}</textarea>
                @error('reason') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            {{-- Boutons --}}
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('leave-requests.index') }}" style="background:#eee; color:#333; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600;">Annuler</a>
                <button type="submit" style="background:#FF6200; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer; box-shadow:0 4px 12px rgba(255,98,0,0.2);">
                    <i class="fas fa-paper-plane"></i> Soumettre
                </button>
            </div>
        </form>
    </div>
</div>
@endsection