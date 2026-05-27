@extends('layouts.admin')

@section('title', 'Nouveau bulletin de paie')

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

    /* ========== FORM CARD ========== */
    .form-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 32px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
        max-width: 700px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
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
    .form-input[readonly] {
        background: var(--gray-100);
        color: var(--gray-600);
        cursor: not-allowed;
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
        width: 100%;
        justify-content: center;
    }
    .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--primary-glow);
    }

    .alert-error {
        background: #FEF2F2;
        border-left: 4px solid #EF4444;
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        margin-bottom: 24px;
        color: #991B1B;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-file-invoice" style="color:var(--primary);"></i> <span>Nouveau bulletin</span></h1>
        <p class="page-subtitle">Générez un bulletin de paie pour un employé</p>
    </div>
    <a href="{{ route('admin.payslips.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

@if(session('error'))
    <div class="alert-error animate-in delay-1">
        <i class="fas fa-exclamation-circle" style="color:#EF4444; font-size:18px;"></i>
        {{ session('error') }}
    </div>
@endif

<div class="form-card animate-in delay-1">
    <form method="POST" action="{{ route('admin.payslips.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="employee_id">
                <i class="fas fa-user" style="color:var(--primary); margin-right:6px;"></i> Employé *
            </label>
            <select name="employee_id" id="employee_id" required class="form-select">
                <option value="">Sélectionnez un employé</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" data-salary="{{ $emp->salary }}">
                        {{ $emp->user->name }} ({{ $emp->position ?? 'Sans poste' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-money-bill-wave" style="color:var(--primary); margin-right:6px;"></i> Salaire de base
            </label>
            <input type="text" id="base_salary" class="form-input" readonly value="0">
            <small style="color: var(--gray-600); font-size: 12px;">Ce champ est automatiquement rempli depuis la fiche employé.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="month">
                <i class="fas fa-calendar-alt" style="color:var(--primary); margin-right:6px;"></i> Mois *
            </label>
            <select name="month" id="month" required class="form-select">
                @foreach(range(1,12) as $m)
                    <option value="{{ str_pad($m,2,'0',STR_PAD_LEFT) }}" {{ $m == date('m') ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="year">
                <i class="fas fa-calendar" style="color:var(--primary); margin-right:6px;"></i> Année *
            </label>
            <input type="number" name="year" id="year" value="{{ date('Y') }}" required class="form-input" min="2000" max="2100">
        </div>

        <div class="form-group">
            <label class="form-label" for="bonuses">
                <i class="fas fa-plus-circle" style="color:var(--primary); margin-right:6px;"></i> Primes
            </label>
            <input type="number" name="bonuses" id="bonuses" value="0" step="0.01" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="deductions">
                <i class="fas fa-minus-circle" style="color:var(--primary); margin-right:6px;"></i> Retenues
            </label>
            <input type="number" name="deductions" id="deductions" value="0" step="0.01" class="form-input">
        </div>

        <div style="margin-top: 32px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Générer le bulletin
            </button>
        </div>
    </form>
</div>

<script>
    // Met à jour le salaire de base quand l'employé sélectionné change
    const employeeSelect = document.getElementById('employee_id');
    const baseSalaryInput = document.getElementById('base_salary');

    function updateSalary() {
        const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
        const salary = selectedOption.getAttribute('data-salary');
        baseSalaryInput.value = salary ? Number(salary).toFixed(2) : '0.00';
    }

    employeeSelect.addEventListener('change', updateSalary);

    // Initialise le salaire au chargement si un employé est déjà sélectionné (cas d'erreur avec old('employee_id'))
    document.addEventListener('DOMContentLoaded', function() {
        if (employeeSelect.value) {
            updateSalary();
        }
    });
</script>
@endsection