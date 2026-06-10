@extends('layouts.admin')

@section('title', 'Nouvelle demande de congé')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255, 98, 0, 0.08);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 20px rgba(10,10,10,0.05);
        --radius-sm: 6px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s ease;
    }
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.4s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 10px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .btn-outline {
        background: var(--white); color: var(--dark); padding: 6px 14px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 12px;
        border: 1px solid var(--gray-200); display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none; transition: var(--transition-smooth);
    }
    .btn-outline:hover { background: var(--gray-50); border-color: var(--primary); }

    .content-layout {
        display: flex; gap: 16px; align-items: flex-start;
    }
    @media (max-width: 750px) { .content-layout { flex-direction: column; } }

    .form-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 20px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        flex: 1 1 auto;
        max-width: 700px; /* ✅ élargi de 560px à 700px */
    }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px 14px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        flex: 0 0 230px; position: sticky; top: 80px;
    }
    .guide-card h4 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h4 i { color: var(--primary); }
    .guide-item { display: flex; gap: 8px; margin-bottom: 10px; font-size: 12px; }
    .guide-icon {
        width: 26px; height: 26px; border-radius: 6px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 11px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 13px; color: var(--dark); display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }

    .form-group { margin-bottom: 14px; }
    .form-label {
        display: flex; align-items: center; gap: 5px;
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 12px; font-weight: 600; color: var(--dark); margin-bottom: 5px;
    }
    .form-label i { color: var(--primary); font-size: 13px; }
    .form-input, .form-select, .form-textarea {
        width: 100%; padding: 8px 12px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 13px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
        transition: var(--transition-smooth);
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
    }
    .form-textarea { resize: vertical; min-height: 70px; }
    .is-invalid { border-color: #EF4444 !important; }
    .invalid-feedback { font-size: 11px; color: #EF4444; margin-top: 3px; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,98,0,0.35); }
    .btn-cancel {
        background: var(--white); color: var(--dark); padding: 10px 20px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 14px;
        border: 1px solid var(--gray-200); text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px; transition: var(--transition-smooth);
    }
    .btn-cancel:hover { background: var(--gray-50); border-color: var(--primary); }

    /* Jours fériés */
    .holiday-list {
        display: flex; flex-direction: column; gap: 6px;
        margin-top: 8px;
    }
    .holiday-item {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; padding: 6px 8px;
        background: var(--gray-50); border-radius: var(--radius-sm);
        border: 0.5px solid var(--gray-200);
    }
    .holiday-date {
        font-weight: 700; color: var(--primary);
        min-width: 45px; text-align: center;
        padding: 2px 6px; background: var(--primary-light);
        border-radius: 4px;
    }
    .holiday-name { color: var(--dark); font-weight: 600; }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-calendar-plus" style="color:var(--primary); margin-right:6px;"></i>
        Nouvelle demande de congé
    </h1>
    <a href="{{ route('leave-requests.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="content-layout">
    <!-- Formulaire (élargi) -->
    <div class="form-card animate-in delay-1">
        <form method="POST" action="{{ route('leave-requests.store') }}">
            @csrf

            <!-- Type de congé -->
            <div class="form-group">
                <label class="form-label"><i class="fas fa-umbrella-beach"></i> Type de congé <span style="color:var(--primary);">*</span></label>
                <select name="leave_type_id" class="form-select @error('leave_type_id') is-invalid @enderror" required>
                    <option value="">-- Sélectionnez --</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} ({{ $type->days_allowed }} jours)
                        </option>
                    @endforeach
                </select>
                @error('leave_type_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <!-- Dates -->
            <div class="form-group" style="display:flex; gap:12px;">
                <div style="flex:1;">
                    <label class="form-label"><i class="fas fa-calendar-alt"></i> Début <span style="color:var(--primary);">*</span></label>
                    <input type="date" name="start_date" class="form-input @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                    @error('start_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div style="flex:1;">
                    <label class="form-label"><i class="fas fa-calendar-check"></i> Fin <span style="color:var(--primary);">*</span></label>
                    <input type="date" name="end_date" class="form-input @error('end_date') is-invalid @enderror"
                           value="{{ old('end_date') }}" required min="{{ date('Y-m-d') }}">
                    @error('end_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Motif -->
            <div class="form-group">
                <label class="form-label"><i class="fas fa-pen"></i> Motif</label>
                <textarea name="reason" class="form-textarea @error('reason') is-invalid @enderror" 
                          placeholder="Raison de l'absence...">{{ old('reason') }}</textarea>
                @error('reason') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <!-- Boutons -->
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:8px;">
                <a href="{{ route('leave-requests.index') }}" class="btn-cancel">Annuler</a>
                <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i> Soumettre</button>
            </div>
        </form>
    </div>

    <!-- Guide -->
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Guide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="guide-text">
                <strong>Choisissez les dates</strong>
                <p>Évitez les jours de forte activité.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-pen"></i></div>
            <div class="guide-text">
                <strong>Détaillez le motif</strong>
                <p>Un motif clair accélère la validation.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-check-circle"></i></div>
            <div class="guide-text">
                <strong>Après soumission</strong>
                <p>Vous serez notifié de la décision.</p>
            </div>
        </div>

        {{-- Jours fériés à venir --}}
        @if(isset($upcomingHolidays) && $upcomingHolidays->isNotEmpty())
            <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--gray-100);">
                <h4 style="font-size:13px; margin-bottom: 8px;">
                    <i class="fas fa-calendar-times" style="color:var(--primary);"></i> Jours fériés à venir
                </h4>
                <div class="holiday-list">
                    @foreach($upcomingHolidays as $holiday)
                        <div class="holiday-item">
                            <span class="holiday-date">
                                {{ $holiday->date->format('d/m') }}
                            </span>
                            <span class="holiday-name">{{ $holiday->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection