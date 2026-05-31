@extends('layouts.admin')

@section('title', 'Téléverser un document')

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
    .form-input, .form-select {
        width: 100%; padding: 10px 14px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 14px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
    }
    .form-input:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); }
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
        <h1 class="page-title"><i class="fas fa-upload" style="color:var(--primary);"></i> <span>Téléverser un document</span></h1>
        <p class="page-subtitle">Ajoutez un contrat, certificat ou autre document</p>
    </div>
    <a href="{{ route('admin.documents.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="form-card animate-in delay-1">
    <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data">
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
            <label class="form-label"><i class="fas fa-tag"></i> Type *</label>
            <select name="type" required class="form-select">
                <option value="contract">Contrat</option>
                <option value="certificate">Attestation</option>
                <option value="other">Autre</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label"><i class="fas fa-heading"></i> Titre *</label>
            <input type="text" name="title" class="form-input" required placeholder="Ex: Contrat de travail">
        </div>
        <div class="form-group">
            <label class="form-label"><i class="fas fa-file"></i> Fichier * (PDF, JPG, PNG, DOCX - max 5 Mo)</label>
            <input type="file" name="file" class="form-input" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
    </form>
</div>
@endsection