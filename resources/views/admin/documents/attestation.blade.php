@extends('layouts.admin')

@section('title', 'Générer une attestation')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
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
        color: var(--dark); margin: 0;
    }
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
    @media (max-width: 750px) {
        .content-layout { flex-direction: column; }
    }

    .form-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 20px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        flex: 1 1 auto; max-width: 520px;
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
    .guide-item {
        display: flex; gap: 8px; margin-bottom: 10px; font-size: 12px;
    }
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
    .form-input, .form-select {
        width: 100%; padding: 8px 12px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 13px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
        transition: var(--transition-smooth);
    }
    .form-input:focus, .form-select:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,98,0,0.35); }

    .alert-error {
        background: #FEF2F2; border-left: 3px solid #EF4444; color: #991B1B;
        padding: 8px 12px; border-radius: var(--radius-sm); font-size: 12px;
        margin-bottom: 12px; display: flex; align-items: center; gap: 6px;
    }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-certificate" style="color:var(--primary); margin-right:6px;"></i>
        <span>Générer une attestation</span>
    </h1>
    <a href="{{ route('admin.documents.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

@if ($errors->any())
    <div class="alert-error animate-in delay-1">
        <i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs ci-dessous.
    </div>
@endif

<div class="content-layout">
    <!-- Formulaire -->
    <div class="form-card animate-in delay-1">
        <form method="POST" action="{{ route('admin.documents.attestation.store') }}">
            @csrf

            <!-- Employé -->
            <div class="form-group">
                <label class="form-label"><i class="fas fa-user"></i> Employé <span style="color:var(--primary);">*</span></label>
                <select name="employee_id" required class="form-select @error('employee_id') is-invalid @enderror">
                    <option value="">-- Sélectionnez --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->user->name }} ({{ $emp->position ?? 'Sans poste' }})
                        </option>
                    @endforeach
                </select>
                @error('employee_id') <span style="color:#EF4444; font-size:11px;">{{ $message }}</span> @enderror
            </div>

            <!-- Type d'attestation -->
            <div class="form-group">
                <label class="form-label"><i class="fas fa-briefcase"></i> Type <span style="color:var(--primary);">*</span></label>
                <select name="type" required class="form-select @error('type') is-invalid @enderror">
                    <option value="work" {{ old('type') == 'work' ? 'selected' : '' }}>Attestation de travail</option>
                    <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Attestation de stage</option>
                </select>
                @error('type') <span style="color:#EF4444; font-size:11px;">{{ $message }}</span> @enderror
            </div>

            <!-- Date de délivrance -->
            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Date de délivrance</label>
                <input type="date" name="date_delivrance" class="form-input @error('date_delivrance') is-invalid @enderror" 
                       value="{{ old('date_delivrance', now()->format('Y-m-d')) }}">
                @error('date_delivrance') <span style="color:#EF4444; font-size:11px;">{{ $message }}</span> @enderror
            </div>

            <!-- Bouton -->
            <button type="submit" class="btn-primary">
                <i class="fas fa-file-pdf"></i> Générer le PDF
            </button>
        </form>
    </div>

    <!-- Guide -->
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Guide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user"></i></div>
            <div class="guide-text">
                <strong>Sélectionnez l'employé</strong>
                <p>Attestation destinée à un employé actif de l'entreprise.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-briefcase"></i></div>
            <div class="guide-text">
                <strong>Type d'attestation</strong>
                <p>Travail (CDI, CDD) ou stage (conventionné).</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="guide-text">
                <strong>Date de délivrance</strong>
                <p>Par défaut aujourd'hui, modifiable.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-file-pdf"></i></div>
            <div class="guide-text">
                <strong>PDF généré</strong>
                <p>Attestation avec QR code de vérification.</p>
            </div>
        </div>
    </div>
</div>
@endsection