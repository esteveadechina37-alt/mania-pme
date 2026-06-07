@extends('layouts.admin')

@section('title', 'Évaluations')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --primary-glow: rgba(255,98,0,0.15);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --shadow-card: 0 10px 30px -10px rgba(0,0,0,0.05);
        --radius-lg: 24px;
        --radius-md: 16px;
        --radius-full: 9999px;
    }
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 30px; flex-wrap: wrap; gap: 20px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--dark);
        margin: 0 0 6px 0; letter-spacing: -0.5px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 15px; }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 12px 28px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; display: inline-flex; align-items: center;
        gap: 8px; text-decoration: none; box-shadow: 0 6px 16px rgba(255,98,0,0.3);
        transition: all 0.2s ease; white-space: nowrap;
    }
    .btn-primary:hover {
        box-shadow: 0 8px 24px rgba(255,98,0,0.4);
        transform: translateY(-1px);
    }
    .btn-outline-sm {
        background: var(--white); color: var(--dark); padding: 8px 18px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 13px;
        border: 1px solid var(--gray-200); cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        transition: all 0.2s ease; margin-top: 16px;
    }
    .btn-outline-sm:hover { background: var(--gray-50); border-color: var(--primary); }
    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981; border-radius: 12px;
        padding: 14px 18px; margin-bottom: 24px; color: #065F46;
        display: flex; align-items: center; gap: 10px; font-size: 14px;
        box-shadow: 0 2px 8px rgba(16,185,129,0.1);
    }
    /* Highlights section */
    .highlights-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    @media (max-width: 600px) {
        .highlights-row { grid-template-columns: 1fr; }
    }
    .highlight-card {
        background: var(--white);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
        padding: 20px 24px;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .highlight-card:hover {
        box-shadow: var(--shadow-card);
        transform: translateY(-2px);
        border-color: var(--primary-light);
    }
    .highlight-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .highlight-icon.recent { background: linear-gradient(135deg, #3B82F6, #2563EB); color: white; }
    .highlight-icon.top { background: linear-gradient(135deg, #F59E0B, #D97706); color: white; }
    .highlight-content { flex: 1; }
    .highlight-label {
        font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
        color: var(--gray-600); margin-bottom: 6px;
    }
    .highlight-main {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 17px; font-weight: 700; color: var(--dark);
        margin-bottom: 4px;
    }
    .highlight-sub {
        font-size: 13px; color: var(--gray-600);
        display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    }
    .highlight-score {
        display: inline-flex; align-items: center; gap: 4px;
        background: var(--gray-50); border-radius: 8px; padding: 2px 10px;
        font-weight: 700; font-size: 14px;
    }
    /* Evaluations grid */
    .evaluations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .eval-card {
        background: var(--white);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }
    .eval-card:hover {
        box-shadow: var(--shadow-card);
        transform: translateY(-4px);
        border-color: var(--primary-light);
    }
    .eval-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: var(--primary-glow);
        border-radius: 50%;
        filter: blur(40px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .eval-card:hover::before {
        opacity: 0.5;
    }
    .card-header {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .employee-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        text-transform: uppercase;
        flex-shrink: 0;
    }
    .employee-info h4 {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 2px 0;
    }
    .employee-info .period {
        font-size: 13px;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .score-area {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--gray-50);
        border-radius: 12px;
        padding: 14px 16px;
    }
    .score-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: 15px;
    }
    .star-rating {
        color: #FBBF24;
        font-size: 16px;
        letter-spacing: 2px;
    }
    .score-value {
        background: var(--white);
        border-radius: 8px;
        padding: 4px 12px;
        font-weight: 800;
        font-size: 16px;
        margin-left: 8px;
    }
    .evaluator {
        font-size: 13px;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .card-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        border-top: 1px solid var(--gray-100);
        padding-top: 12px;
        margin-top: auto;
    }
    .btn-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        font-size: 15px;
    }
    .btn-icon:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
    }
    .btn-icon.delete:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
    }
    .empty-state i {
        font-size: 56px;
        color: var(--gray-300);
        display: block;
        margin-bottom: 16px;
    }
    .pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    /* Guide card */
    .guide-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 28px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: sticky;
        top: 100px;
    }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .guide-item {
        display: flex;
        gap: 14px;
        margin-bottom: 22px;
    }
    .guide-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .guide-text strong {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        display: block;
        margin-bottom: 4px;
    }
    .guide-text p {
        font-size: 14px;
        color: var(--gray-600);
        margin: 0;
        line-height: 1.4;
    }
    /* Layout */
    .layout-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .layout-grid {
            grid-template-columns: 1fr;
        }
        .guide-card {
            position: static;
        }
    }
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

<div class="layout-grid">
    <!-- Colonne principale -->
    <div>
        @if($evaluations->count())
            <!-- Highlights : Dernière évaluation & Meilleur employé -->
            <div class="highlights-row animate-in delay-1">
                @if($recentEvaluation)
                <div class="highlight-card">
                    <div class="highlight-icon recent">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="highlight-content">
                        <div class="highlight-label">Dernière évaluation</div>
                        <div class="highlight-main">{{ $recentEvaluation->employee->user->name }}</div>
                        <div class="highlight-sub">
                            <span><i class="fas fa-calendar-alt"></i> {{ $recentEvaluation->period }}</span>
                            <span class="highlight-score" style="background:{{ $recentEvaluation->score >= 4 ? '#dcfce7' : ($recentEvaluation->score >= 3 ? '#fef3c7' : '#fee2e2') }}; color:{{ $recentEvaluation->score >= 4 ? '#166534' : ($recentEvaluation->score >= 3 ? '#92400e' : '#991b1b') }};">
                                <i class="fas fa-star"></i> {{ number_format($recentEvaluation->score, 1) }}/5
                            </span>
                        </div>
                    </div>
                </div>
                @endif

                @if($topEmployee)
                <div class="highlight-card">
                    <div class="highlight-icon top">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="highlight-content">
                        <div class="highlight-label">Employé le mieux évalué</div>
                        <div class="highlight-main">{{ $topEmployee['name'] }}</div>
                        <div class="highlight-sub">
                            <span><i class="fas fa-chart-line"></i> Moy. {{ number_format($topEmployee['average_score'], 1) }}/5</span>
                            @if($topEmployee['department'] ?? false)
                                <span><i class="fas fa-building"></i> {{ $topEmployee['department'] }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Grille des évaluations -->
            <div class="evaluations-grid animate-in delay-2" id="evaluations-container">
                @foreach($evaluations as $index => $eval)
                <div class="eval-card" data-eval-index="{{ $index }}">
                    <div class="card-header">
                        <div class="employee-avatar">
                            {{ substr($eval->employee->user->name, 0, 2) }}
                        </div>
                        <div class="employee-info">
                            <h4>{{ $eval->employee->user->name }}</h4>
                            <div class="period">
                                <i class="fas fa-calendar-alt" style="opacity:0.7;"></i> {{ $eval->period }}
                            </div>
                        </div>
                    </div>
                    <div class="score-area">
                        <div class="score-badge">
                            @php
                                $score = $eval->score;
                                $colorClass = $score >= 4 ? 'rgba(16,185,129,0.1)' : ($score >= 3 ? 'rgba(251,191,36,0.15)' : 'rgba(239,68,68,0.1)');
                                $textColor = $score >= 4 ? '#065F46' : ($score >= 3 ? '#92400E' : '#991B1B');
                                $starColor = $score >= 4 ? '#10B981' : ($score >= 3 ? '#F59E0B' : '#EF4444');
                            @endphp
                            <div class="star-rating" style="color:{{ $starColor }};">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= floor($score))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $score)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="score-value" style="background:{{ $colorClass }}; color:{{ $textColor }};">
                                {{ number_format($score, 1) }}/5
                            </span>
                        </div>
                        <div class="evaluator">
                            <i class="fas fa-user-check" style="opacity:0.6;"></i>
                            {{ $eval->evaluator->name }}
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('admin.evaluations.show', $eval) }}" class="btn-icon" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" onclick="openConfirmModal('{{ route('admin.evaluations.destroy', $eval) }}')" class="btn-icon delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Bouton Voir plus / Voir moins -->
            @if($evaluations->count() > 2)
            <div style="text-align:center;">
                <button type="button" id="toggle-evals-btn" class="btn-outline-sm">
                    <i class="fas fa-chevron-down"></i> Voir plus ({{ $evaluations->count() - 2 }})
                </button>
            </div>
            @endif

            <div class="pagination-wrap">
                {{ $evaluations->links() }}
            </div>
        @else
            <div class="empty-state animate-in delay-1">
                <i class="fas fa-star-half-alt"></i>
                <p style="font-size:18px; font-weight:600; color:var(--dark);">Aucune évaluation pour le moment.</p>
                <p style="color:var(--gray-600); margin-top:8px;">Créez votre première évaluation en cliquant sur le bouton ci-dessus.</p>
            </div>
        @endif
    </div>

    <!-- Guide -->
    <div class="guide-card animate-in delay-2">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-plus-circle"></i></div>
            <div class="guide-text">
                <strong>Créer une évaluation</strong>
                <p>Attribuez une note à un employé sur une période donnée.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-star"></i></div>
            <div class="guide-text">
                <strong>Notation 0-5</strong>
                <p>5 = excellent, 0 = très insuffisant. Soyez juste et constructif.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-eye"></i></div>
            <div class="guide-text">
                <strong>Consultation</strong>
                <p>L'employé peut voir ses évaluations depuis son espace.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-evals-btn');
        if (!toggleBtn) return;

        const allCards = document.querySelectorAll('.eval-card');
        // Les cartes à partir de la 3ème (index 2)
        const hiddenCards = Array.from(allCards).slice(2);
        let expanded = false;

        // Masquer initialement
        hiddenCards.forEach(card => { card.style.display = 'none'; });

        toggleBtn.addEventListener('click', function() {
            expanded = !expanded;
            hiddenCards.forEach(card => {
                card.style.display = expanded ? '' : 'none';
            });
            if (expanded) {
                toggleBtn.innerHTML = '<i class="fas fa-chevron-up"></i> Voir moins';
            } else {
                toggleBtn.innerHTML = '<i class="fas fa-chevron-down"></i> Voir plus ({{ $evaluations->count() - 2 }})';
            }
        });
    });
</script>
@endsection