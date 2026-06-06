@extends('layouts.admin')

@section('title', 'Mes évaluations')

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

    /* ========== MAIN LAYOUT ========== */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    /* ========== TABLE CARD ========== */
    .table-card {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .premium-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 500px;
    }
    .premium-table th {
        background: var(--gray-50);
        padding: 14px 20px;
        font-weight: 600;
        font-size: 11px;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--gray-200);
        text-align: left;
    }
    .premium-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--gray-100);
        font-size: 14px;
        color: var(--dark);
    }
    .premium-table tr:last-child td { border-bottom: none; }
    .premium-table tr:hover td { background: var(--gray-50); }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: var(--primary);
        color: white;
        border-radius: var(--radius-full);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255,98,0,0.2);
        transition: var(--transition-smooth);
    }
    .action-btn:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255,98,0,0.3);
    }

    /* ========== GUIDE CARD ========== */
    .guide-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .guide-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .guide-card:hover::before { opacity: 1; }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
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

    /* ========== PAGINATION ========== */
    .pagination-wrap {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }
    .pagination-wrap nav { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
    .pagination-wrap a, .pagination-wrap span {
        padding: 7px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        transition: var(--transition-smooth);
        background: var(--white);
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .pagination-wrap a:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-light);
    }
    .pagination-wrap span[aria-current="page"] {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .pagination-wrap span[aria-disabled="true"] { opacity: 0.4; pointer-events: none; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-star" style="color:var(--primary);"></i> <span>Mes évaluations</span></h1>
        <p class="page-subtitle">Consultez vos évaluations périodiques</p>
    </div>
</div>

<div class="content-grid">
    <div class="table-card animate-in delay-1">
        @if($evaluations->count())
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Période</th>
                        <th>Score</th>
                        <th>Évaluateur</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluations as $eval)
                    <tr>
                        <td style="font-weight:600;">{{ $eval->period }}</td>
                        <td>
                            <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:100px; font-size:12px; font-weight:600; background:{{ $eval->score >= 4 ? '#dcfce7' : ($eval->score >= 3 ? '#fef3c7' : '#fee2e2') }}; color:{{ $eval->score >= 4 ? '#166534' : ($eval->score >= 3 ? '#92400e' : '#991b1b') }};">
                                <i class="fas fa-star"></i> {{ number_format($eval->score, 1) }}/5
                            </span>
                        </td>
                        <td>{{ $eval->evaluator->name }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('employee.evaluations.show', $eval) }}" class="action-btn">
                                <i class="fas fa-eye"></i> Voir
                            </a>
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
                <p>Aucune évaluation pour le moment.</p>
            </div>
        @endif
    </div>

    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide des évaluations</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-star"></i></div>
            <div class="guide-text">
                <strong>Votre score</strong>
                <p>Chaque évaluation vous attribue une note de 0 à 5. Une couleur indique votre performance.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar"></i></div>
            <div class="guide-text">
                <strong>Périodicité</strong>
                <p>Les évaluations sont réalisées par votre manager ou l'administrateur à intervalles réguliers.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-comment"></i></div>
            <div class="guide-text">
                <strong>Commentaires</strong>
                <p>Consultez le détail pour lire les remarques et les axes d'amélioration.</p>
            </div>
        </div>
    </div>
</div>
@endsection