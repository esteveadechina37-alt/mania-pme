@extends('layouts.admin')

@section('title', 'Importer des employés')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255, 98, 0, 0.08);
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
    .animate-in { animation: fadeSlideUp 0.45s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 10px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
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
    @media (max-width: 750px) { .content-layout { flex-direction: column; } }

    .form-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 20px 18px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        flex: 1 1 auto; max-width: 560px;
    }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px 14px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        flex: 0 0 260px; position: sticky; top: 80px;
    }
    .guide-card h4 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h4 i { color: var(--primary); }
    .guide-item { display: flex; gap: 8px; margin-bottom: 10px; font-size: 12px; }
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
    .form-input {
        width: 100%; padding: 8px 12px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 13px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
        transition: var(--transition-smooth);
    }
    .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); outline: none; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,98,0,0.35); }

    .csv-example {
        background: var(--gray-50); border-radius: var(--radius-sm);
        padding: 10px 12px; margin-top: 8px; font-size: 11px;
        color: var(--gray-600); font-family: monospace;
        border: 1px solid var(--gray-200); max-height: 150px; overflow: auto;
    }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-upload" style="color:var(--primary); margin-right:6px;"></i>
        Importer des employés
    </h1>
    <a href="{{ route('admin.employees.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="content-layout">
    <!-- Formulaire -->
    <div class="form-card animate-in delay-1">
        <h3 class="card-title" style="margin-bottom: 16px;"><i class="fas fa-file-csv"></i> Fichier CSV</h3>
        <form action="{{ route('admin.employees.import.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label"><i class="fas fa-file"></i> Sélectionnez un fichier CSV</label>
                <input type="file" name="csv_file" accept=".csv" class="form-input" required>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-cloud-upload-alt"></i> Importer
            </button>
        </form>
    </div>

    <!-- Guide -->
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Guide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-columns"></i></div>
            <div class="guide-text">
                <strong>Colonnes acceptées</strong>
                <p>Nom, Email, Mot de passe, Rôle, Date d'embauche, Date de fin, Salaire.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-language"></i></div>
            <div class="guide-text">
                <strong>En-têtes en français ou anglais</strong>
                <p>Ex: "nom" ou "name", "date d'embauche" ou "hire_date".</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="guide-text">
                <strong>Obligatoires</strong>
                <p>Seuls le nom et l'email sont requis. Les autres champs sont facultatifs.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-info-circle"></i></div>
            <div class="guide-text">
                <strong>Statut automatique</strong>
                <p>Si la date d'embauche est future, le compte sera inactif jusqu'à cette date.</p>
            </div>
        </div>
        <div style="margin-top: 12px; border-top: 1px solid var(--gray-100); padding-top: 12px;">
            <p style="font-size: 12px; color: var(--gray-600); margin: 0 0 6px;"><strong>Exemple CSV :</strong></p>
            <div class="csv-example">
                nom,email,mot de passe,rôle,date d'embauche,date de fin,salaire<br>
                Jean Dupont,jean@example.com,azerty123,employe,2026-07-01,2027-06-30,500000<br>
                Marie Martin,marie@example.com,,employe,2026-06-15,,450000
            </div>
        </div>
    </div>
</div>
@endsection