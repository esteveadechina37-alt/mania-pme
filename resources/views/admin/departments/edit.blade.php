@extends('layouts.admin')

@section('title', 'Modifier ' . $department->name)

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
        --shadow-sm: 0 2px 4px rgba(10,10,10,0.02);
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,0.08);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @@keyframes fadeSlideUp {
        0%   { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @@keyframes glassShine {
        0%   { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }

    .animate-in { animation: fadeSlideUp 0.55s ease both; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 24px; flex-wrap: wrap; gap: 16px; position: relative;
    }
    .page-header::after {
        content: ''; position: absolute; top: -20px; left: 0;
        width: 150px; height: 150px; background: var(--primary-glow);
        filter: blur(80px); z-index: -1; pointer-events: none;
    }
    .page-title {
        font-size: clamp(20px, 4vw, 28px); font-weight: 700; color: var(--dark);
        display: flex; align-items: center; gap: 10px; line-height: 1.2;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 14px; margin: 4px 0 0; }

    .btn-outline {
        background: rgba(255,255,255,0.8); backdrop-filter: blur(12px);
        color: var(--dark); padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; border: 1px solid rgba(255,255,255,0.6);
        display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        transition: var(--transition-smooth); box-shadow: var(--shadow-sm); white-space: nowrap;
    }
    .btn-outline:hover { background: white; border-color: var(--primary); transform: translateY(-1px); }

    /* LAYOUT */
    .form-guide-layout {
        display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 24px; align-items: start;
    }
    @media (max-width: 900px) { .form-guide-layout { grid-template-columns: 1fr; } }

    /* FORM CARD */
    .form-card {
        background: rgba(255,255,255,0.9); backdrop-filter: blur(16px);
        border-radius: var(--radius-md); padding: 28px;
        box-shadow: var(--shadow-md); border: 1px solid rgba(255,255,255,0.6);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
    }
    .form-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth);
        pointer-events: none; /* ✅ ne bloque pas les clics */
    }
    .form-card::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.2) 30%, transparent 60%);
        background-size: 200% 100%; animation: glassShine 5s infinite;
        opacity: 0; transition: opacity 0.4s;
        pointer-events: none; /* ✅ ne bloque pas les clics */
    }
    .form-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .form-card:hover::before { opacity: 1; }
    .form-card:hover::after  { opacity: 1; }

    /* ✅ Le form au-dessus des pseudo-éléments */
    .form-card form { position: relative; z-index: 1; }

    .form-row {
        display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;
    }
    @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

    .form-group { margin-bottom: 20px; }

    .form-label {
        display: block; font-size: 12px; font-weight: 600;
        color: var(--gray-800); margin-bottom: 6px;
    }
    .form-label i { color: var(--primary); margin-right: 5px; }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%; padding: 10px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        font-size: 14px; background: white; color: var(--dark);
        font-family: 'Cabinet Grotesk', sans-serif;
        transition: all 0.2s ease; outline: none;
        position: relative; z-index: 2; /* ✅ au-dessus des pseudo-éléments */
    }
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    .form-input.is-invalid,
    .form-select.is-invalid,
    .form-textarea.is-invalid { border-color: #EF4444; }

    .form-select {
        appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6 8L0 2h12z' fill='%236B7280'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
        background-size: 12px; padding-right: 36px;
    }
    .form-textarea { resize: vertical; min-height: 100px; }

    .error-text { font-size: 12px; color: #EF4444; margin-top: 4px; display: block; }

    .form-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 28px; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 11px 26px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25); transition: var(--transition-smooth);
        position: relative; z-index: 2;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }

    .btn-cancel {
        background: white; color: var(--dark); padding: 11px 26px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 14px;
        border: 1px solid var(--gray-200); text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: var(--transition-smooth); position: relative; z-index: 2;
    }
    .btn-cancel:hover { background: var(--gray-50); border-color: var(--gray-300); }

    /* GUIDE CARD */
    .guide-card {
        background: rgba(255,255,255,0.9); backdrop-filter: blur(16px);
        border-radius: var(--radius-md); padding: 24px;
        box-shadow: var(--shadow-md); border: 1px solid rgba(255,255,255,0.6);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 60%);
        opacity: 0; transition: var(--transition-smooth); pointer-events: none;
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
        display: flex; gap: 12px; margin-bottom: 18px; position: relative; z-index: 1;
    }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 36px; height: 36px; border-radius: var(--radius-sm); flex-shrink: 0;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 15px;
    }
    .guide-text strong { font-size: 14px; font-weight: 700; color: var(--dark); display: block; margin-bottom: 3px; }
    .guide-text p { color: var(--gray-600); font-size: 12px; margin: 0; line-height: 1.5; }
</style>

{{-- Header --}}
<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-building" style="color:var(--primary)"></i>
            Modifier <span>{{ $department->name }}</span>
        </h1>
        <p class="page-subtitle">Mettez à jour les informations du département</p>
    </div>
    <a href="{{ route('admin.departments.show', $department) }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour au département
    </a>
</div>

<div class="form-guide-layout">

    {{-- Formulaire --}}
    <div class="form-card animate-in delay-1">
        <form method="POST" action="{{ route('admin.departments.update', $department) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                {{-- Nom --}}
                <div>
                    <label class="form-label">
                        <i class="fas fa-tag"></i> Nom du département <span style="color:#EF4444">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        value="{{ old('name', $department->name) }}"
                        placeholder="Ex : Ressources Humaines"
                        required
                    >
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Manager --}}
                <div>
                    <label class="form-label">
                        <i class="fas fa-user-tie"></i> Manager
                    </label>
                    <select name="manager_id" class="form-select {{ $errors->has('manager_id') ? 'is-invalid' : '' }}">
                        <option value="">— Aucun —</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}"
                                {{ old('manager_id', $department->manager_id) == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('manager_id')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i> Description
                </label>
                <textarea
                    name="description"
                    rows="4"
                    class="form-textarea {{ $errors->has('description') ? 'is-invalid' : '' }}"
                    placeholder="Décrivez les missions et le périmètre de ce département..."
                >{{ old('description', $department->description) }}</textarea>
                @error('description')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('admin.departments.show', $department) }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>

        </form>
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-2" style="position:sticky; top:90px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide de modification</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-tag"></i></div>
            <div class="guide-text">
                <strong>Nom du département</strong>
                <p>Vous pouvez renommer le département à tout moment. Ce nom est visible par tous les employés.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user-tie"></i></div>
            <div class="guide-text">
                <strong>Manager</strong>
                <p>Changez le responsable du département. Seuls les managers actifs sont proposés dans la liste.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-align-left"></i></div>
            <div class="guide-text">
                <strong>Description</strong>
                <p>Mettez à jour la description pour refléter les missions actuelles du département.</p>
            </div>
        </div>
    </div>

</div>
@endsection