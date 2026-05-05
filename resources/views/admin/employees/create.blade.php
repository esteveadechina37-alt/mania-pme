@extends('layouts.admin')

@section('title', 'Nouvel employé')

@section('content')
<style>
    /* Styles des champs (identiques à ceux du formulaire de modification) */
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-input, .form-select {
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
    .form-input:focus, .form-select:focus {
        border-color: #FF6200;
        box-shadow: 0 0 0 3px rgba(255,98,0,0.1);
    }
    .form-input.is-invalid, .form-select.is-invalid {
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

    /* Barre d'étapes */
    .steps-bar {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 28px;
    }
    .step-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e5e7eb;
        transition: background 0.3s, box-shadow 0.3s;
    }
    .step-dot.active {
        background: #FF6200;
        box-shadow: 0 0 0 4px rgba(255,98,0,0.2);
    }

    /* Contenu des étapes */
    .step-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    .step-content.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Boutons de navigation */
    .btn-prev {
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #374151;
        padding: 10px 20px;
        border-radius: 100px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-prev:hover { background: #f9fafb; }
    .btn-next {
        background: #FF6200;
        color: #fff;
        padding: 10px 24px;
        border-radius: 100px;
        border: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s;
    }
    .btn-next:hover {
        background: #e55800;
        box-shadow: 0 6px 16px rgba(255,98,0,0.35);
    }
    .btn-submit {
        background: #FF6200;
        color: #fff;
        padding: 12px 28px;
        border-radius: 100px;
        border: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s;
    }
    .btn-submit:hover {
        background: #e55800;
    }
    .btn-outline {
        background: #fff;
        color: #374151;
        padding: 12px 28px;
        border-radius: 100px;
        border: 1px solid #e5e7eb;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
</style>

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">
            <i class="fas fa-user-plus" style="color:#FF6200; margin-right:8px;"></i> Nouvel employé
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Remplissez les informations en 3 étapes</p>
    </div>
    <a href="{{ route('admin.employees.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

<form method="POST" action="{{ route('admin.employees.store') }}" style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    @csrf

    {{-- Indicateur d'étapes --}}
    <div class="steps-bar">
        <span class="step-dot active" data-step="1"></span>
        <span class="step-dot" data-step="2"></span>
        <span class="step-dot" data-step="3"></span>
    </div>

    {{-- ÉTAPE 1 : Identité --}}
    <div class="step-content active" id="step-1">
        <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin-bottom:20px;">
            <i class="fas fa-id-card" style="color:#FF6200;"></i> Identité
        </h3>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 20px;">
            <div>
                <label class="form-label"><i class="fas fa-user" style="color:#FF6200;"></i> Nom complet *</label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="form-label"><i class="fas fa-envelope" style="color:#FF6200;"></i> Email *</label>
                <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="form-label"><i class="fas fa-lock" style="color:#FF6200;"></i> Mot de passe *</label>
                <input type="password" name="password" class="form-input @error('password') is-invalid @enderror" required>
                @error('password') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="form-label"><i class="fas fa-user-tag" style="color:#FF6200;"></i> Rôle *</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">Choisir un rôle...</option>
                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="employe" {{ old('role') == 'employe' ? 'selected' : '' }}>Employé</option>
                    <option value="stagiaire" {{ old('role') == 'stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                </select>
                @error('role') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- ÉTAPE 2 : Poste & contrat --}}
    <div class="step-content" id="step-2">
        <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin-bottom:20px;">
            <i class="fas fa-briefcase" style="color:#FF6200;"></i> Poste & contrat
        </h3>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 20px;">
            <div>
                <label class="form-label"><i class="fas fa-building" style="color:#FF6200;"></i> Département</label>
                <select name="department_id" class="form-select">
                    <option value="">Aucun</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label"><i class="fas fa-user-tie" style="color:#FF6200;"></i> Poste</label>
                <input type="text" name="position" class="form-input" value="{{ old('position') }}" placeholder="Ex : Développeur">
            </div>
            <div>
                <label class="form-label"><i class="fas fa-file-contract" style="color:#FF6200;"></i> Type de contrat</label>
                <select name="contract_type" class="form-select">
                    <option value="">Sélectionner</option>
                    <option value="CDI" {{ old('contract_type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                    <option value="CDD" {{ old('contract_type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                    <option value="Stage" {{ old('contract_type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                </select>
            </div>
            <div>
                <label class="form-label"><i class="fas fa-money-bill-wave" style="color:#FF6200;"></i> Salaire mensuel</label>
                <input type="number" name="salary" class="form-input" value="{{ old('salary') }}" placeholder="0" step="0.01">
            </div>
            <div>
                <label class="form-label"><i class="fas fa-calendar-alt" style="color:#FF6200;"></i> Date d'embauche</label>
                <input type="date" name="hire_date" class="form-input" value="{{ old('hire_date') }}">
            </div>
        </div>
    </div>

    {{-- ÉTAPE 3 : Confirmation --}}
    <div class="step-content" id="step-3">
        <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin-bottom:20px;">
            <i class="fas fa-check-circle" style="color:#FF6200;"></i> Confirmation
        </h3>
        <p style="color: #6B6B6B; margin-bottom: 24px;">Vérifiez les informations saisies dans les étapes précédentes avant de créer l'employé.</p>
        {{-- Vous pouvez éventuellement afficher un résumé ici (optionnel) --}}
        <div style="background: #f8fafc; border-radius: 8px; padding: 16px; color: #475569;">
            <i class="fas fa-info-circle" style="color:#FF6200;"></i> L'employé sera enregistré avec le statut <strong>Actif</strong> par défaut.
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
            <i class="fas fa-save"></i> Créer l'employé
        </button>
    </div>
</form>

{{-- Script de gestion des étapes --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.step-content');
        const dots = document.querySelectorAll('.step-dot');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.toggle('active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            // Affichage des bons boutons
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

        prevBtn.addEventListener('click', function() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        nextBtn.addEventListener('click', function() {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        // Navigation par les points
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