@extends('layouts.admin')

@section('title', 'Paramètres du compte')

@section('content')
<style>
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
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,0.08);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-full: 9999px;
        --transition-smooth: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @@keyframes fadeSlideUp {
        0%   { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 30px; flex-wrap: wrap; gap: 20px; position: relative;
    }
    .page-header::after {
        content: ''; position: absolute; top: -20px; left: 0;
        width: 150px; height: 150px; background: var(--primary-glow);
        filter: blur(80px); z-index: -1; pointer-events: none;
    }
    .page-title {
        font-size: clamp(22px, 4vw, 30px); font-weight: 700;
        color: var(--dark); margin: 0 0 6px; line-height: 1.2;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 15px; margin: 0; }

    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981;
        border-radius: var(--radius-sm); padding: 14px 18px;
        margin-bottom: 24px; color: #065F46;
        display: flex; align-items: center; gap: 10px; font-size: 14px;
    }
    .alert-error {
        background: #FEF2F2; border-left: 4px solid #EF4444;
        border-radius: var(--radius-sm); padding: 14px 18px;
        margin-bottom: 24px; color: #991B1B;
        display: flex; align-items: center; gap: 10px; font-size: 14px;
    }

    .content-grid {
        display: grid; grid-template-columns: 2fr 1fr;
        gap: 24px; align-items: start;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }

    .settings-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 28px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        transition: var(--transition-smooth); position: relative; overflow: hidden;
    }
    .settings-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0; transition: var(--transition-smooth);
    }
    .settings-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .settings-card:hover::before { opacity: 1; }

    .section-title {
        font-size: 13px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--gray-600);
        margin: 0 0 16px; padding-bottom: 10px;
        border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; gap: 7px;
    }
    .section-title i { color: var(--primary); }

    .form-group { margin-bottom: 18px; position: relative; z-index: 1; }
    .form-label {
        display: block; font-size: 13px; font-weight: 600;
        color: var(--gray-800); margin-bottom: 6px;
    }
    .form-label i { color: var(--primary); margin-right: 5px; }
    .form-input {
        width: 100%; padding: 10px 14px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 14px;
        background: var(--white); color: var(--dark);
        transition: all 0.2s ease; outline: none;
    }
    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    .form-input.is-invalid { border-color: #EF4444; }
    .invalid-feedback {
        display: block; color: #EF4444;
        font-size: 12px; margin-top: 4px;
    }

    .divider { border: none; border-top: 1px solid var(--gray-100); margin: 20px 0; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 12px 28px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25); transition: var(--transition-smooth);
        width: 100%; position: relative; z-index: 1;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--primary-glow);
    }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 24px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0; transition: var(--transition-smooth);
    }
    .guide-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .guide-card:hover::before { opacity: 1; }
    .guide-card .card-title {
        font-size: 18px; font-weight: 700; color: var(--dark);
        margin-bottom: 16px; display: flex; align-items: center; gap: 10px;
        position: relative; z-index: 1;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item {
        display: flex; gap: 12px; margin-bottom: 18px;
        position: relative; z-index: 1;
    }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 36px; height: 36px; border-radius: var(--radius-sm);
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 14px; font-weight: 700; color: var(--dark); display: block; margin-bottom: 3px; }
    .guide-text p { color: var(--gray-600); font-size: 12px; margin: 0; line-height: 1.5; }
</style>

{{-- Header --}}
<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-user-cog" style="color:var(--primary)"></i>
            <span>Paramètres du compte</span>
        </h1>
        <p class="page-subtitle">Modifiez vos informations personnelles et votre mot de passe</p>
    </div>
</div>

{{-- Alertes --}}
@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981;font-size:18px"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert-error animate-in delay-1">
        <i class="fas fa-exclamation-circle" style="color:#EF4444;font-size:18px"></i>
        Veuillez corriger les erreurs ci-dessous.
    </div>
@endif

<div class="content-grid">

    {{-- Formulaire --}}
    <div class="settings-card animate-in delay-1">

        {{-- ✅ action et method corrects, pas de JS qui bloque --}}
        <form method="POST" action="{{ route('user.settings.update') }}">
            @csrf
            @method('PUT')

            {{-- Section : Informations --}}
            <div class="section-title">
                <i class="fas fa-user"></i> Informations personnelles
            </div>

            {{-- ✅ Champ name ajouté (manquait dans l'ancienne vue) --}}
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i> Nom complet
                </label>
                <input
                    type="text"
                    name="name"
                    class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Votre nom complet"
                    required
                >
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-envelope"></i> Adresse email
                </label>
                <input
                    type="email"
                    name="email"
                    class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email', $user->email) }}"
                    placeholder="votre@email.com"
                    required
                >
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <hr class="divider">

            {{-- Section : Mot de passe --}}
            <div class="section-title">
                <i class="fas fa-lock"></i> Changer le mot de passe
                <span style="font-size:11px;color:var(--gray-300);font-weight:400;text-transform:none;">(laisser vide pour ne pas changer)</span>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-lock"></i> Mot de passe actuel
                </label>
                <input
                    type="password"
                    name="current_password"
                    class="form-input {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                    placeholder="Votre mot de passe actuel"
                    autocomplete="current-password"
                >
                @error('current_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-key"></i> Nouveau mot de passe
                </label>
                <input
                    type="password"
                    name="password"
                    class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Minimum 8 caractères"
                    autocomplete="new-password"
                >
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-check-circle"></i> Confirmer le nouveau mot de passe
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-input"
                    placeholder="Répétez le nouveau mot de passe"
                    autocomplete="new-password"
                >
            </div>

            {{-- ✅ Bouton submit simple, sans JS --}}
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>

        </form>
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-2" style="position:sticky;top:100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user"></i></div>
            <div class="guide-text">
                <strong>Nom</strong>
                <p>Votre nom affiché dans l'application et sur vos documents.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-envelope"></i></div>
            <div class="guide-text">
                <strong>Email</strong>
                <p>Utilisé pour la connexion et les notifications. Doit être unique.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-lock"></i></div>
            <div class="guide-text">
                <strong>Mot de passe</strong>
                <p>Laissez vide pour conserver l'actuel. Minimum 8 caractères.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-shield-alt"></i></div>
            <div class="guide-text">
                <strong>Sécurité</strong>
                <p>Ne partagez jamais vos identifiants. Changez régulièrement votre mot de passe.</p>
            </div>
        </div>
    </div>

</div>
@endsection