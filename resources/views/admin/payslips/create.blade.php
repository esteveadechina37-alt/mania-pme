@extends('layouts.admin')

@section('title', 'Nouveau bulletin de paie')

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
        --transition-smooth: 0.25s ease;
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
    .form-input[readonly] {
        background: var(--gray-50); color: var(--gray-600); cursor: not-allowed;
    }

    .net-preview {
        background: var(--gray-50); border-radius: var(--radius-sm); padding: 10px 14px;
        margin-top: 12px; display: flex; align-items: center; justify-content: space-between;
        font-size: 14px; font-weight: 700;
    }
    .net-preview span:last-child { color: var(--primary); }

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
    <h1 class="page-title"><i class="fas fa-file-invoice" style="color:var(--primary); margin-right:6px;"></i> <span>Nouveau bulletin</span></h1>
    <a href="{{ route('admin.payslips.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

@if(session('error'))
    <div class="alert-error animate-in">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

<div class="content-layout">
    <!-- Formulaire -->
    <div class="form-card animate-in delay-1">
        <form method="POST" action="{{ route('admin.payslips.store') }}" id="payslip-form">
            @csrf

            <div class="form-group">
                <label class="form-label"><i class="fas fa-user"></i> Employé <span style="color:var(--primary);">*</span></label>
                <select name="employee_id" id="employee_id" required class="form-select">
                    <option value="">-- Sélectionnez --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" data-salary="{{ $emp->salary }}">
                            {{ $emp->user->name }} ({{ $emp->position ?? 'Sans poste' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fas fa-money-bill-wave"></i> Salaire de base</label>
                <input type="text" id="base_salary" class="form-input" readonly value="0">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Mois <span style="color:var(--primary);">*</span></label>
                <select name="month" id="month" required class="form-select">
                    @foreach(range(1,12) as $m)
                        @php $pad = str_pad($m,2,'0',STR_PAD_LEFT); @endphp
                        <option value="{{ $pad }}" {{ $pad == date('m') ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar"></i> Année <span style="color:var(--primary);">*</span></label>
                <input type="number" name="year" id="year" value="{{ date('Y') }}" required class="form-input" min="2000" max="2100">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fas fa-plus-circle"></i> Primes</label>
                <input type="number" name="bonuses" id="bonuses" value="0" step="0.01" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fas fa-minus-circle"></i> Retenues</label>
                <input type="number" name="deductions" id="deductions" value="0" step="0.01" class="form-input">
            </div>

            <!-- Aperçu du salaire net -->
            <div class="net-preview" id="net-preview">
                <span>Salaire net estimé</span>
                <span id="net-salary">0,00 FCFA</span>
            </div>

            <button type="submit" class="btn-primary" style="margin-top:12px;">
                <i class="fas fa-save"></i> Générer le bulletin
            </button>
        </form>
    </div>

    <!-- Guide -->
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Guide rapide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user"></i></div>
            <div class="guide-text">
                <strong>Choisissez un employé</strong>
                <p>Le salaire de base se remplit automatiquement.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar"></i></div>
            <div class="guide-text">
                <strong>Mois & année</strong>
                <p>Spécifiez la période du bulletin.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calculator"></i></div>
            <div class="guide-text">
                <strong>Primes & retenues</strong>
                <p>Modifiez-les, le salaire net se calcule en direct.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-save"></i></div>
            <div class="guide-text">
                <strong>Génération</strong>
                <p>Un PDF avec QR code est créé et stocké.</p>
            </div>
        </div>
    </div>
</div>

<script>
    const employeeSelect = document.getElementById('employee_id');
    const baseSalaryInput = document.getElementById('base_salary');
    const bonusesInput = document.getElementById('bonuses');
    const deductionsInput = document.getElementById('deductions');
    const netSalarySpan = document.getElementById('net-salary');

    function updateSalary() {
        const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
        const salary = selectedOption.getAttribute('data-salary');
        baseSalaryInput.value = salary ? Number(salary).toFixed(2) : '0.00';
        computeNet();
    }

    function computeNet() {
        const base = parseFloat(baseSalaryInput.value) || 0;
        const bonuses = parseFloat(bonusesInput.value) || 0;
        const deductions = parseFloat(deductionsInput.value) || 0;
        const net = base + bonuses - deductions;
        netSalarySpan.textContent = net.toFixed(2) + ' FCFA';
    }

    employeeSelect.addEventListener('change', updateSalary);
    bonusesInput.addEventListener('input', computeNet);
    deductionsInput.addEventListener('input', computeNet);

    // Init au chargement si un employé est déjà sélectionné (old value)
    document.addEventListener('DOMContentLoaded', function() {
        if (employeeSelect.value) updateSalary();
        else computeNet(); // au cas où les champs ont des valeurs par défaut
    });
</script>
@endsection