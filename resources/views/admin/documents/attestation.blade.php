@extends('layouts.admin')

@section('title', 'Générer une attestation')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --dark: #0A0A0A;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-full: 9999px;
    }
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 30px; flex-wrap: wrap; gap: 20px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 30px; font-weight: 700; color: var(--dark);
        margin: 0 0 6px 0;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 15px; }
    .btn-outline {
        background: var(--white); color: var(--dark); padding: 10px 22px;
        border-radius: var(--radius-full); border: 1px solid var(--gray-200);
        font-weight: 600; font-size: 13px; display: inline-flex; align-items: center;
        gap: 8px; text-decoration: none;
    }
    .form-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 32px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        max-width: 700px; margin: 0 auto;
    }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px; }
    .form-select {
        width: 100%; padding: 10px 14px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 14px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
    }
    .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 12px 28px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer; width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-certificate" style="color:var(--primary);"></i> <span>Générer une attestation</span></h1>
        <p class="page-subtitle">Créez une attestation de travail ou de stage</p>
    </div>
    <a href="{{ route('admin.documents.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="form-card animate-in delay-1">
    <form method="POST" action="{{ route('admin.documents.attestation.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label"><i class="fas fa-user"></i> Employé *</label>
            <select name="employee_id" required class="form-select">
                <option value="">Sélectionnez...</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->user->name }} ({{ $emp->position ?? 'Sans poste' }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label"><i class="fas fa-briefcase"></i> Type d'attestation *</label>
            <select name="type" required class="form-select">
                <option value="work">Attestation de travail</option>
                <option value="internship">Attestation de stage</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label"><i class="fas fa-calendar"></i> Date de délivrance (optionnel)</label>
            <input type="date" name="date_delivrance" class="form-input" value="{{ now()->format('Y-m-d') }}">
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-file-pdf"></i> Générer le PDF</button>
    </form>
</div>
@endsection