@extends('layouts.admin')

@section('title', 'Nouvelle demande de congé')

@section('content')
<style>
    /* ========== DESIGN SYSTEM (identique dashboard) ========== */
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255, 98, 0, 0.08);
        --primary-glow: rgba(255, 98, 0, 0.25);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-600: #6B7280;
        --gray-800: #1F2937;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 4px rgba(10, 10, 10, 0.02);
        --shadow-md: 0 8px 24px rgba(10, 10, 10, 0.05);
        --shadow-lg: 0 16px 40px rgba(255, 98, 0, 0.08);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    /* ========== HEADER ========== */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
    }
    .page-header::after {
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 150px;
        height: 150px;
        background: var(--primary-glow);
        filter: blur(80px);
        z-index: -1;
        pointer-events: none;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 6px 0;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .page-subtitle {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        margin: 0;
    }

    .btn-outline {
        background: var(--white);
        color: var(--dark);
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 13px;
        border: 1px solid var(--gray-200);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: var(--transition-smooth);
        white-space: nowrap;
    }
    .btn-outline:hover {
        background: var(--gray-50);
        border-color: var(--primary-glow);
    }

    /* ========== MAIN LAYOUT ========== */
    .form-guide-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .form-guide-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ========== FORM CARD ========== */
    .form-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 32px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 6px;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        font-size: 14px;
        background: var(--white);
        transition: all 0.2s ease;
        outline: none;
        color: var(--dark);
        font-family: 'Cabinet Grotesk', sans-serif;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
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
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        padding: 12px 28px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(10, 10, 10, 0.12), 0 2px 8px var(--primary-glow);
        text-decoration: none;
    }
    .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--primary-glow);
    }

    .btn-cancel {
        background: var(--white);
        color: var(--dark);
        padding: 12px 28px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 14px;
        border: 1px solid var(--gray-200);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
    }
    .btn-cancel:hover {
        background: var(--gray-50);
        border-color: var(--gray-300);
    }

    /* ========== GUIDE CARD ========== */
    .guide-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .guide-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .guide-card:hover::before { opacity: 1; }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    .guide-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .guide-text strong {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        display: block;
        margin-bottom: 4px;
    }
    .guide-text p {
        color: var(--gray-600);
        font-size: 13px;
        margin: 0;
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-calendar-plus" style="color:var(--primary);"></i> <span>Nouvelle demande de congé</span></h1>
        <p class="page-subtitle">Remplissez les informations pour soumettre votre demande</p>
    </div>
    <a href="{{ route('leave-requests.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

<div class="form-guide-layout">
    {{-- Colonne gauche : formulaire --}}
    <div class="form-card animate-in delay-1">
        <form method="POST" action="{{ route('leave-requests.store') }}">
            @csrf

            {{-- Type de congé --}}
            <div style="margin-bottom:20px;">
                <label class="form-label" for="leave_type_id">
                    <i class="fas fa-umbrella-beach" style="color:var(--primary); margin-right:6px;"></i> Type de congé *
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
                        <i class="fas fa-calendar-alt" style="color:var(--primary); margin-right:6px;"></i> Date de début *
                    </label>
                    <input type="date" name="start_date" id="start_date" class="form-input @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                    @error('start_date')
                        <span class="error-text">{{ $message }}</span>
                @enderror
                </div>
                <div>
                    <label class="form-label" for="end_date">
                        <i class="fas fa-calendar-check" style="color:var(--primary); margin-right:6px;"></i> Date de fin *
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
                    <i class="fas fa-pen" style="color:var(--primary); margin-right:6px;"></i> Motif (optionnel)
                </label>
                <textarea name="reason" id="reason" rows="4" class="form-textarea @error('reason') is-invalid @enderror" placeholder="Raison de l'absence...">{{ old('reason') }}</textarea>
                @error('reason')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Boutons --}}
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('leave-requests.index') }}" class="btn-cancel">
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-paper-plane"></i> Soumettre
                </button>
            </div>
        </form>
    </div>

    {{-- Colonne droite : Guide rapide --}}
    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Bien préparer votre demande</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="guide-text">
                <strong>Choisissez les dates</strong>
                <p>Sélectionnez une période qui ne pénalise pas l'équipe. Évitez les jours de forte activité.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-pen"></i></div>
            <div class="guide-text">
                <strong>Détaillez le motif</strong>
                <p>Un motif clair aide votre manager à prendre une décision rapide.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-check-circle"></i></div>
            <div class="guide-text">
                <strong>Après soumission</strong>
                <p>Votre demande passera en validation. Vous serez notifié de la décision.</p>
            </div>
        </div>
    </div>
</div>
@endsection