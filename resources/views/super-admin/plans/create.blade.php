@extends('layouts.admin')

@section('title', 'Nouveau plan')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
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
    .animate-in { animation: fadeSlideUp 0.45s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 12px; flex-wrap: wrap; gap: 10px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 6px;
    }
    .page-title i { color: var(--primary); }
    .btn-outline-sm {
        background: var(--white); color: var(--dark); padding: 5px 12px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 11px;
        border: 1px solid var(--gray-200); display: inline-flex; align-items: center;
        gap: 4px; text-decoration: none; transition: var(--transition-smooth);
    }
    .btn-outline-sm:hover { background: var(--gray-50); border-color: var(--primary); }

    .content-layout {
        display: flex; gap: 12px; align-items: flex-start;
    }
    @media (max-width: 750px) { .content-layout { flex-direction: column; } }

    .form-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px 16px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        flex: 1 1 auto; max-width: 520px;
    }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        flex: 0 0 210px; position: sticky; top: 80px;
    }
    .guide-card h4 {
        font-family: 'Clash Display', sans-serif; font-size: 14px; font-weight: 700;
        color: var(--dark); margin: 0 0 8px; display: flex; align-items: center; gap: 5px;
    }
    .guide-card h4 i { color: var(--primary); }
    .guide-item { display: flex; gap: 6px; margin-bottom: 8px; font-size: 11px; }
    .guide-icon {
        width: 22px; height: 22px; border-radius: 5px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 10px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 12px; color: var(--dark); display: block; margin-bottom: 1px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }

    .form-group { margin-bottom: 8px; }
    .form-label {
        display: flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 600; color: var(--dark); margin-bottom: 3px;
    }
    .form-label i { color: var(--primary); font-size: 12px; }
    .form-input, .form-select {
        width: 100%; padding: 6px 10px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 12px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
        transition: var(--transition-smooth);
    }
    .form-input:focus, .form-select:focus {
        border-color: var(--primary); box-shadow: 0 0 0 2px var(--primary-light);
        outline: none;
    }
    textarea.form-input { resize: vertical; min-height: 50px; }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 8px 16px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; border: none; cursor: pointer;
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 5px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,98,0,0.35); }

    /* Période */
    .period-grid { display: flex; gap: 8px; }
    .period-card {
        flex: 1; border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        padding: 6px 10px; cursor: pointer; text-align: center; transition: var(--transition-smooth);
    }
    .period-card.active { border-color: var(--primary); background: var(--primary-light); }
    .period-title { font-size: 12px; font-weight: 600; }
    .period-sub { font-size: 10px; color: var(--gray-600); }
    .modules-grid { display: flex; flex-wrap: wrap; gap: 4px; }
    .module-badge {
        display: inline-flex; align-items: center; gap: 3px; padding: 3px 8px;
        border-radius: 15px; border: 1px solid var(--gray-200);
        font-size: 11px; cursor: pointer; transition: var(--transition-smooth);
    }
    .module-badge.active { border-color: var(--primary); background: var(--primary-light); }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-plus-circle" style="color:var(--primary);"></i> Nouveau plan
    </h1>
    <a href="{{ route('super-admin.plans.index') }}" class="btn-outline-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="content-layout">
    <!-- Formulaire compact -->
    <div class="form-card animate-in delay-1">
        <form action="{{ route('super-admin.plans.store') }}" method="POST" id="planForm">
            @csrf
            <input type="hidden" name="billing_period" id="billing_period_input" value="{{ old('billing_period', 'monthly') }}">

            <div class="form-group">
                <label class="form-label"><i class="fas fa-tag"></i> Nom</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Ex : Plan Pro" required>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-link"></i> Slug</label>
                <input type="text" name="slug" class="form-input" value="{{ old('slug') }}" placeholder="plan-pro" required>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-align-left"></i> Description</label>
                <textarea name="description" class="form-input" rows="2" placeholder="Brève description">{{ old('description') }}</textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="flex:1;">
                    <label class="form-label"><i class="fas fa-money-bill-wave"></i> Prix (FCFA)</label>
                    <input type="number" name="price" class="form-input" value="{{ old('price') }}" placeholder="0" step="1" min="0" required>
                </div>
                <div class="form-group" style="flex:1;">
                    <label class="form-label"><i class="fas fa-clock"></i> Périodicité</label>
                    <div class="period-grid">
                        <div class="period-card {{ old('billing_period', 'monthly') == 'monthly' ? 'active' : '' }}" onclick="selectPeriod(this, 'monthly')">
                            <div class="period-title">Mensuel</div>
                            <div class="period-sub">/mois</div>
                        </div>
                        <div class="period-card {{ old('billing_period') == 'yearly' ? 'active' : '' }}" onclick="selectPeriod(this, 'yearly')">
                            <div class="period-title">Annuel</div>
                            <div class="period-sub">/an</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-puzzle-piece"></i> Modules inclus</label>
                <div class="modules-grid">
                    {{-- Modules gratuits : verrouillés, toujours inclus --}}
                    @foreach($modules->where('is_free', true) as $module)
                        <span class="module-badge active" style="opacity:0.8; cursor:default;" title="Inclus automatiquement">
                            <i class="fas fa-lock" style="font-size:10px;"></i> {{ $module->name }}
                        </span>
                    @endforeach

                    {{-- Modules payants : sélectionnables --}}
                    @foreach($modules->where('is_free', false) as $module)
                        @php
                            $checked = is_array(old('modules')) && in_array($module->id, old('modules'));
                        @endphp
                        <label class="module-badge {{ $checked ? 'active' : '' }}">
                            <input type="checkbox" name="modules[]" value="{{ $module->id }}" style="display:none"
                                {{ $checked ? 'checked' : '' }}>
                            {{ $module->name }}
                        </label>
                    @endforeach
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="form-label"><i class="fas fa-puzzle-piece"></i> Modules inclus</label>
                <div class="modules-grid">
                    @foreach($modules as $module)
                        <label class="module-badge {{ is_array(old('modules')) && in_array($module->id, old('modules')) ? 'active' : '' }}">
                            <input type="checkbox" name="modules[]" value="{{ $module->id }}" style="display:none"
                                   {{ is_array(old('modules')) && in_array($module->id, old('modules')) ? 'checked' : '' }}>
                            {{ $module->name }}
                        </label>
                    @endforeach
                </div>
            </div> -->
            <button type="submit" class="btn-primary" style="margin-top:4px;">
                <i class="fas fa-check"></i> Créer le plan
            </button>
        </form>
    </div>

    <!-- Guide compact -->
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Guide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-tag"></i></div>
            <div class="guide-text"><strong>Nom & Slug</strong><p>Identifiant unique du plan.</p></div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="guide-text"><strong>Prix</strong><p>0 = gratuit. En FCFA.</p></div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-clock"></i></div>
            <div class="guide-text"><strong>Périodicité</strong><p>Mensuel ou annuel.</p></div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-puzzle-piece"></i></div>
            <div class="guide-text"><strong>Modules</strong><p>Accessibles avec ce plan.</p></div>
        </div>
    </div>
</div>

<script>
    // Gestion des périodes
function selectPeriod(el, value) {
    document.querySelectorAll('.period-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('billing_period_input').value = value;
}

// Gestion des modules (uniquement les modules payants)
document.querySelectorAll('.module-badge:not([style*="cursor:default"])').forEach(badge => {
    badge.addEventListener('click', function (e) {
        e.preventDefault(); // Empêche le double toggle à cause du label
        const cb = this.querySelector('input[type="checkbox"]');
        if (cb) {
            cb.checked = !cb.checked;
            this.classList.toggle('active', cb.checked);
        }
    });
});

// Auto-génération du slug
document.getElementById('name').addEventListener('input', function () {
    const slugField = document.getElementById('slug');
    if (!slugField.dataset.manual) {
        slugField.value = this.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9-]/g, '');
    }
});

document.getElementById('slug').addEventListener('input', function () {
    this.dataset.manual = 'true';
});
</script>
@endsection