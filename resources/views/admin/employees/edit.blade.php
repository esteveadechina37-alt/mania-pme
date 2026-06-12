@extends('layouts.admin')

@section('title', 'Modifier employé')

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
    .delay-3 { animation-delay: 0.3s; }

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
        padding: 10px 20px;
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

    /* ========== FORM + GUIDE LAYOUT ========== */
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

    /* ========== BENTO CARD (guide) ========== */
    .bento-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }
    .bento-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .bento-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .bento-card:hover::before { opacity: 1; }
    .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-title i { color: var(--primary); }

    .guide-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
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
        transition: var(--transition-smooth);
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

    /* ========== FORM CARD ========== */
    .form-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 32px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 6px;
    }
    .form-input, .form-select {
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
    .form-input:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
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

    /* Steps */
    .steps-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-bottom: 32px;
    }
    .step-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gray-100);
        color: var(--gray-600);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        border: 2px solid var(--gray-200);
        transition: all 0.3s;
        cursor: pointer;
    }
    .step-dot.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
    }
    .step-line {
        width: 60px;
        height: 2px;
        background: var(--gray-200);
        border-radius: 2px;
        transition: background 0.3s;
    }
    .step-line.done {
        background: var(--primary);
    }
    .step-content {
        display: none;
        animation: fadeSlideUp 0.3s ease;
    }
    .step-content.active {
        display: block;
    }

    /* Boutons navigation */
    .btn-prev {
        background: var(--white);
        border: 1px solid var(--gray-200);
        color: var(--dark);
        padding: 10px 20px;
        border-radius: var(--radius-full);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: var(--transition-smooth);
    }
    .btn-prev:hover { background: var(--gray-50); }
    .btn-next, .btn-submit {
        background: var(--primary);
        color: white;
        padding: 10px 24px;
        border-radius: var(--radius-full);
        border: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: var(--transition-smooth);
    }
    .btn-next:hover, .btn-submit:hover {
        background: var(--primary-hover);
        box-shadow: 0 6px 18px var(--primary-glow);
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-user-edit" style="color:var(--primary);"></i> Modifier <span>{{ $employee->user->name }}</span></h1>
        <p class="page-subtitle">Mise à jour des informations personnelles et professionnelles</p>
    </div>
    <a href="{{ route('admin.employees.show', $employee) }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour au profil
    </a>
</div>

<div class="form-guide-layout">
    {{-- Colonne gauche : formulaire --}}
    <div class="form-card animate-in delay-1">
        <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
            @csrf
            @method('PUT')

            {{-- Indicateur d'étapes --}}
            <div class="steps-bar">
                <span class="step-dot active" data-step="1">1</span>
                <span class="step-line" data-line="1"></span>
                <span class="step-dot" data-step="2">2</span>
                <span class="step-line" data-line="2"></span>
                <span class="step-dot" data-step="3">3</span>
            </div>

            {{-- ÉTAPE 1 : Identité --}}
            <div class="step-content active" id="step-1">
                <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin-bottom:20px;">
                    <i class="fas fa-id-card" style="color:var(--primary);"></i> Identité
                </h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 20px;">
                    <div>
                        <label class="form-label"><i class="fas fa-user" style="color:var(--primary);"></i> Nom complet *</label>
                        <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $employee->user->name) }}" required>
                        @error('name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-envelope" style="color:var(--primary);"></i> Email *</label>
                        <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email', $employee->user->email) }}" required>
                        @error('email') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-lock" style="color:var(--primary);"></i> Mot de passe</label>
                        <input type="password" name="password" class="form-input @error('password') is-invalid @enderror" placeholder="Laissez vide pour ne pas changer">
                        @error('password') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-user-tag" style="color:var(--primary);"></i> Rôle *</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="manager" {{ old('role', $employee->user->hasRole('manager') ? 'manager' : '') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="employe" {{ old('role', $employee->user->hasRole('employe') ? 'employe' : '') == 'employe' ? 'selected' : '' }}>Employé</option>
                            <option value="stagiaire" {{ old('role', $employee->user->hasRole('stagiaire') ? 'stagiaire' : '') == 'stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                        </select>
                        @error('role') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- ÉTAPE 2 : Poste & contrat --}}
            <div class="step-content" id="step-2">
                <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin-bottom:20px;">
                    <i class="fas fa-briefcase" style="color:var(--primary);"></i> Poste & contrat
                </h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 20px;">
                    <div>
                        <label class="form-label"><i class="fas fa-building" style="color:var(--primary);"></i> Département</label>
                        <select name="department_id" class="form-select">
                            <option value="">Aucun</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-user-tie" style="color:var(--primary);"></i> Poste</label>
                        <input type="text" name="position" class="form-input" value="{{ old('position', $employee->position) }}" placeholder="Ex : Développeur">
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-file-contract" style="color:var(--primary);"></i> Type de contrat</label>
                        <select name="contract_type" class="form-select">
                            <option value="">Sélectionner</option>
                            <option value="CDI" {{ old('contract_type', $employee->contract_type) == 'CDI' ? 'selected' : '' }}>CDI</option>
                            <option value="CDD" {{ old('contract_type', $employee->contract_type) == 'CDD' ? 'selected' : '' }}>CDD</option>
                            <option value="Stage" {{ old('contract_type', $employee->contract_type) == 'Stage' ? 'selected' : '' }}>Stage</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-money-bill-wave" style="color:var(--primary);"></i> Salaire mensuel</label>
                        <input type="number" name="salary" class="form-input" value="{{ old('salary', $employee->salary) }}" placeholder="0" step="0.01">
                    </div>
                    <!-- <div style="grid-column: span 2;">
                        <label class="form-label"><i class="fas fa-calendar-alt" style="color:var(--primary);"></i> Date d'embauche</label>
                        <input type="date" name="hire_date" class="form-input" value="{{ old('hire_date', $employee->hire_date) }}">
                    </div> -->
                    <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label class="form-label"><i class="fas fa-calendar-alt" style="color:var(--primary);"></i> Date d'embauche</label>
                            <input type="date" name="hire_date" class="form-input" value="{{ old('hire_date', $employee->hire_date) }}" disabled>
                        </div>
                        <div>
                            <label class="form-label"><i class="fas fa-calendar-times" style="color:var(--primary);"></i> Fin de contrat</label>
                            <input type="date" name="contract_end_date" class="form-input" value="{{ old('contract_end_date', $employee->contract_end_date) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ÉTAPE 3 : Statut & finalisation --}}
            <div class="step-content" id="step-3">
                <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin-bottom:20px;">
                    <i class="fas fa-circle" style="color:var(--primary);"></i> Statut & confirmation
                </h3>
                <div style="max-width: 400px; margin-bottom: 16px;">
                    <label class="form-label"><i class="fas fa-circle" style="color:var(--primary);"></i> Statut employé</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="suspended" {{ old('status', $employee->status) == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                        <option value="terminated" {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
                <div style="background: var(--gray-50); border-radius: var(--radius-sm); padding: 16px; color: var(--gray-800);">
                    <i class="fas fa-info-circle" style="color:var(--primary);"></i> La modification du statut peut entraîner le retrait du département (si suspendu ou terminé) et la désactivation du compte utilisateur.
                </div>
            </div>

            {{-- Navigation entre étapes --}}
            <div style="margin-top:32px; display:flex; justify-content:space-between; align-items:center;">
                <button type="button" id="prevBtn" class="btn-prev" style="visibility: hidden;">
                    <i class="fas fa-chevron-left"></i> Précédent
                </button>
                <button type="button" id="nextBtn" class="btn-next">
                    Suivant <i class="fas fa-chevron-right"></i>
                </button>
                <button type="submit" id="submitBtn" class="btn-submit" style="display: none;">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>

    {{-- Colonne droite : Guide rapide --}}
    <div class="bento-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide de modification</h3>
        
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-shield-alt"></i></div>
            <div class="guide-text">
                <strong>Statut de l'employé</strong>
                <p>Un employé suspendu ou terminé sera retiré de son département et son compte désactivé. Réactivez-le pour lui redonner l'accès.</p>
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-sitemap"></i></div>
            <div class="guide-text">
                <strong>Département</strong>
                <p>Vous pouvez réassigner l'employé à un autre département à tout moment. Le manager du département pourra alors gérer ses demandes.</p>
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-key"></i></div>
            <div class="guide-text">
                <strong>Mot de passe</strong>
                <p>Laissez le champ vide pour conserver le mot de passe actuel. Sinon, un nouveau mot de passe sera défini.</p>
            </div>
        </div>
    </div>
</div>

{{-- Script de navigation par étapes --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.step-content');
        const dots = document.querySelectorAll('.step-dot');
        const lines = document.querySelectorAll('.step-line');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((step, i) => step.classList.toggle('active', i === index));
            dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
            lines.forEach((line, i) => {
                if (i < index) line.classList.add('done');
                else line.classList.remove('done');
            });

            if (index === 0) {
                prevBtn.style.visibility = 'hidden';
                nextBtn.style.display = 'inline-flex';
                submitBtn.style.display = 'none';
            } else if (index === steps.length - 1) {
                prevBtn.style.visibility = 'visible';
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-flex';
            } else {
                prevBtn.style.visibility = 'visible';
                nextBtn.style.display = 'inline-flex';
                submitBtn.style.display = 'none';
            }
        }

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) { currentStep--; showStep(currentStep); }
        });

        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) { currentStep++; showStep(currentStep); }
        });

        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                const step = parseInt(this.getAttribute('data-step')) - 1;
                if (step >= 0 && step < steps.length) {
                    currentStep = step;
                    showStep(currentStep);
                }
            });
        });

        showStep(0);
    });
</script>
@endsection