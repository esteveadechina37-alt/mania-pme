@extends('layouts.admin')

@section('title', 'Évaluations')

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
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
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
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 11px 24px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; display: inline-flex; align-items: center;
        gap: 8px; text-decoration: none; box-shadow: 0 4px 12px rgba(255,98,0,0.25);
    }
    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981; border-radius: 8px;
        padding: 14px 18px; margin-bottom: 24px; color: #065F46;
        display: flex; align-items: center; gap: 10px; font-size: 14px;
    }
    .content-grid {
        display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }
    .table-card {
        background: var(--white); border-radius: var(--radius-md);
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        overflow-x: auto;
    }
    .premium-table { width: 100%; border-collapse: collapse; min-width: 600px; }
    .premium-table th {
        background: var(--gray-50); padding: 14px 20px; font-size: 11px;
        color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .premium-table td {
        padding: 14px 20px; border-bottom: 1px solid var(--gray-100);
        font-size: 14px; color: var(--dark);
    }
    .premium-table tr:last-child td { border-bottom: none; }
    .premium-table tr:hover td { background: var(--gray-50); }
    .action-btn {
        width: 36px; height: 36px; display: inline-flex; align-items: center;
        justify-content: center; border-radius: 8px; background: transparent;
        color: var(--gray-600); border: 1px solid var(--gray-200);
        cursor: pointer; transition: all 0.2s; text-decoration: none; font-size: 14px;
    }
    .action-btn:hover { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }
    .action-btn.delete:hover { background: #fee2e2; color: #dc2626; border-color: #fecaca; }
    .guide-card {
        background: var(--white); border-radius: var(--radius-md); padding: 24px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
    }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700;
        color: var(--dark); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;
    }
    .guide-item { display: flex; gap: 12px; margin-bottom: 20px; }
    .guide-icon {
        width: 36px; height: 36px; border-radius: 8px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 15px; font-weight: 700; color: var(--dark); display: block; margin-bottom: 4px; }
    .guide-text p { font-size: 13px; color: var(--gray-600); margin: 0; }
    .pagination-wrap { margin-top: 24px; display: flex; justify-content: center; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-star" style="color:var(--primary);"></i> <span>Évaluations</span></h1>
        <p class="page-subtitle">Suivez les performances de vos employés</p>
    </div>
    <a href="{{ route('admin.evaluations.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i> Nouvelle évaluation
    </a>
</div>

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

<div class="content-grid">
    <div class="table-card animate-in delay-1">
        @if($evaluations->count())
            <table class="premium-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Employé</th>
                        <th><i class="fas fa-calendar"></i> Période</th>
                        <th><i class="fas fa-star"></i> Score</th>
                        <th><i class="fas fa-user-check"></i> Évaluateur</th>
                        <th style="text-align:right;"><i class="fas fa-cog"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluations as $eval)
                    <tr>
                        <td style="font-weight:600;">{{ $eval->employee->user->name }}</td>
                        <td>{{ $eval->period }}</td>
                        <td>
                            <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:100px; font-size:12px; font-weight:600; background:{{ $eval->score >= 4 ? '#dcfce7' : ($eval->score >= 3 ? '#fef3c7' : '#fee2e2') }}; color:{{ $eval->score >= 4 ? '#166534' : ($eval->score >= 3 ? '#92400e' : '#991b1b') }};">
                                <i class="fas fa-star"></i> {{ number_format($eval->score, 1) }}/5
                            </span>
                        </td>
                        <td>{{ $eval->evaluator->name }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('admin.evaluations.show', $eval) }}" class="action-btn" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.evaluations.destroy', $eval) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="button" onclick="openConfirmModal('{{ route('admin.evaluations.destroy', $eval) }}')" class="action-btn delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 0 20px 20px;">
                {{ $evaluations->links() }}
            </div>
        @else
            <div style="text-align:center; padding:60px 20px; color:var(--gray-600);">
                <i class="fas fa-folder-open" style="font-size:48px; display:block; margin-bottom:16px; opacity:0.4;"></i>
                <p style="font-size:16px; font-weight:500;">Aucune évaluation pour le moment.</p>
            </div>
        @endif
    </div>

    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide des évaluations</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-plus-circle"></i></div>
            <div class="guide-text">
                <strong>Créer une évaluation</strong>
                <p>Remplissez le formulaire pour noter un employé sur une période donnée.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-star"></i></div>
            <div class="guide-text">
                <strong>Notation</strong>
                <p>Attribuez une note de 0 à 5. 5 étant excellent, 0 très insuffisant.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-eye"></i></div>
            <div class="guide-text">
                <strong>Consultation</strong>
                <p>L'employé peut consulter ses évaluations depuis son espace personnel.</p>
            </div>
        </div>
    </div>
</div>
@endsection