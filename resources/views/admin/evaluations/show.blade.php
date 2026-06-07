@extends('layouts.admin')

@section('title', 'Détail de l\'évaluation')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255, 98, 0, 0.08);
        --primary-glow: rgba(255, 98, 0, 0.15);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 20px rgba(10,10,10,0.05);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 18px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.5s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.15s; }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 20px; flex-wrap: wrap; gap: 15px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 26px; font-weight: 700;
        color: var(--dark); margin: 0 0 2px 0; letter-spacing: -0.3px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 13px; margin: 0; }
    .btn-outline {
        background: var(--white); color: var(--dark); padding: 8px 18px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 13px;
        border: 1px solid var(--gray-200); display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; transition: var(--transition-smooth);
        box-shadow: var(--shadow-sm);
    }
    .btn-outline:hover { background: var(--gray-50); border-color: var(--primary); }

    /* Layout compact : deux colonnes, mais on réduit l'écart */
    .content-grid {
        display: grid; grid-template-columns: 1.5fr 1fr; gap: 16px; align-items: start;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }

    /* Carte compacte générique */
    .card-compact {
        background: var(--white); border-radius: var(--radius-md); padding: 16px 18px;
        box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }
    .card-compact:hover { box-shadow: var(--shadow-md); }

    /* Jauge de score réduite */
    .score-mini {
        display: flex; align-items: center; gap: 16px; margin-bottom: 12px;
    }
    .circle-wrap {
        width: 70px; height: 70px; position: relative; flex-shrink: 0;
    }
    .circle-bg { fill: none; stroke: var(--gray-100); stroke-width: 6; }
    .circle-progress {
        fill: none; stroke-width: 6; stroke-linecap: round;
        transform: rotate(-90deg); transform-origin: 50% 50%;
        transition: stroke-dashoffset 1s ease-out;
    }
    .circle-text {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        font-family: 'Clash Display', sans-serif; font-size: 18px; font-weight: 700;
        color: var(--dark);
    }
    .circle-sub {
        position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%);
        font-size: 9px; font-weight: 600; color: var(--gray-600); text-transform: uppercase;
    }

    .info-line {
        display: flex; align-items: center; gap: 8px; padding: 8px 0;
        border-bottom: 1px solid var(--gray-100); font-size: 13px;
    }
    .info-line:last-child { border-bottom: none; }
    .info-icon {
        width: 28px; height: 28px; border-radius: 8px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }

    .badge-pill {
        display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px;
        border-radius: var(--radius-full); font-size: 12px; font-weight: 600;
    }

    .comment-box {
        background: var(--gray-50); border-radius: var(--radius-sm); padding: 12px 14px;
        border: 1px solid var(--gray-200); margin-top: 12px; font-size: 13px;
    }
    .comment-box h4 { font-size: 14px; margin: 0 0 4px; display: flex; align-items: center; gap: 6px; }

    /* Guide compact */
    .guide-mini {
        display: flex; flex-direction: column; gap: 10px;
    }
    .guide-item {
        display: flex; gap: 8px; align-items: center; font-size: 12px;
    }
    .guide-icon {
        width: 24px; height: 24px; border-radius: 6px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 11px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 13px; color: var(--dark); display: block; margin-bottom: 1px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }

    .history-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 6px 0; border-bottom: 1px solid var(--gray-100); font-size: 12px;
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-star" style="color:var(--primary);"></i> <span>Détail de l'évaluation</span></h1>
        <p class="page-subtitle">Période : <strong>{{ $evaluation->period }}</strong></p>
    </div>
    <a href="{{ route('admin.evaluations.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="content-grid">
    <!-- Colonne gauche : Score + détails + commentaires -->
    <div>
        <div class="card-compact animate-in delay-1">
            <!-- Mini jauge + nom employé -->
            <div class="score-mini">
                <div class="circle-wrap">
                    <svg viewBox="0 0 80 80" width="70" height="70">
                        <circle cx="40" cy="40" r="34" class="circle-bg" />
                        @php
                            $score = $evaluation->score;
                            $percent = ($score / 5) * 100;
                            $circumference = 2 * 3.1416 * 34;
                            $offset = $circumference - ($percent / 100) * $circumference;
                            $color = $score >= 4 ? '#10B981' : ($score >= 3 ? '#F59E0B' : '#EF4444');
                        @endphp
                        <circle cx="40" cy="40" r="34" class="circle-progress"
                                stroke-dasharray="{{ $circumference }}"
                                stroke-dashoffset="{{ $circumference }}"
                                style="stroke: {{ $color }}; transition-delay: 0.2s;" />
                    </svg>
                    <div class="circle-text">{{ number_format($score, 1) }}</div>
                    <div class="circle-sub">/5</div>
                </div>
                <div>
                    <h3 style="font-family:'Cabinet Grotesk',sans-serif; font-size:16px; font-weight:700; margin:0 0 2px; color:var(--dark);">
                        {{ $evaluation->employee->user->name }}
                    </h3>
                    <p style="margin:0; font-size:12px; color:var(--gray-600);">
                        <i class="fas fa-building" style="margin-right:4px;"></i>
                        {{ optional($evaluation->employee->department)->name ?? 'Département inconnu' }}
                    </p>
                </div>
            </div>

            <!-- Infos compactes -->
            <div class="info-line">
                <div class="info-icon"><i class="fas fa-user-check"></i></div>
                <div>
                    <span style="color:var(--gray-600); font-size:10px; text-transform:uppercase;">Évaluateur</span>
                    <strong>{{ $evaluation->evaluator->name }}</strong>
                </div>
            </div>
            <div class="info-line">
                <div class="info-icon"><i class="fas fa-calendar-alt"></i></div>
                <div>
                    <span style="color:var(--gray-600); font-size:10px; text-transform:uppercase;">Date</span>
                    <strong>{{ $evaluation->evaluated_at->format('d/m/Y H:i') }}</strong>
                </div>
            </div>
            <div class="info-line">
                <div class="info-icon"><i class="fas fa-star"></i></div>
                <div>
                    <span style="color:var(--gray-600); font-size:10px; text-transform:uppercase;">Note</span>
                    <span class="badge-pill" style="background:{{ $score >= 4 ? '#dcfce7' : ($score >= 3 ? '#fef3c7' : '#fee2e2') }}; color:{{ $score >= 4 ? '#166534' : ($score >= 3 ? '#92400e' : '#991b1b') }};">
                        <i class="fas fa-star"></i> {{ number_format($score, 1) }}/5
                    </span>
                </div>
            </div>
        </div>

        @if($evaluation->comments)
        <div class="card-compact animate-in delay-2" style="margin-top:12px;">
            <div class="comment-box">
                <h4><i class="fas fa-comment-dots"></i> Commentaires</h4>
                <p style="margin:0;">{{ $evaluation->comments }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Colonne droite : Guide + Historique (compact) -->
    <div>
        <div class="card-compact animate-in delay-1" style="margin-bottom:12px;">
            <h3 style="font-family:'Clash Display',sans-serif; font-size:16px; font-weight:700; color:var(--dark); margin:0 0 10px; display:flex; align-items:center; gap:6px;">
                <i class="fas fa-lightbulb" style="color:var(--primary);"></i> Résumé
            </h3>
            <div class="guide-mini">
                <div class="guide-item">
                    <div class="guide-icon"><i class="fas fa-user"></i></div>
                    <div class="guide-text">
                        <strong>Employé</strong>
                        <p>{{ $evaluation->employee->user->name }} ({{ $evaluation->employee->status }})</p>
                    </div>
                </div>
                <div class="guide-item">
                    <div class="guide-icon"><i class="fas fa-star"></i></div>
                    <div class="guide-text">
                        <strong>Appréciation</strong>
                        <p>
                            @if($score >= 4) Excellent @elseif($score >= 3) Moyen @else À améliorer @endif
                        </p>
                    </div>
                </div>
                <div class="guide-item">
                    <div class="guide-icon"><i class="fas fa-user-check"></i></div>
                    <div class="guide-text">
                        <strong>Évaluateur</strong>
                        <p>{{ $evaluation->evaluator->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $otherEvals = \App\Models\Evaluation::where('employee_id', $evaluation->employee_id)
                            ->where('id', '!=', $evaluation->id)
                            ->latest('evaluated_at')
                            ->limit(3)
                            ->get();
        @endphp
        @if($otherEvals->count())
        <div class="card-compact animate-in delay-2">
            <h3 style="font-family:'Clash Display',sans-serif; font-size:16px; font-weight:700; color:var(--dark); margin:0 0 10px; display:flex; align-items:center; gap:6px;">
                <i class="fas fa-history" style="color:var(--primary);"></i> Historique
            </h3>
            @foreach($otherEvals as $eval)
            <div class="history-item">
                <div>
                    <div style="font-weight:600;">{{ $eval->period }}</div>
                    <div style="color:var(--gray-600);">{{ $eval->evaluator->name }}</div>
                </div>
                <span class="badge-pill" style="background:{{ $eval->score >= 4 ? '#dcfce7' : ($eval->score >= 3 ? '#fef3c7' : '#fee2e2') }}; color:{{ $eval->score >= 4 ? '#166534' : ($eval->score >= 3 ? '#92400e' : '#991b1b') }};">
                    {{ number_format($eval->score,1) }}
                </span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const circle = document.querySelector('.circle-progress');
        if (circle) {
            setTimeout(() => {
                circle.style.strokeDashoffset = '{{ $offset }}';
            }, 200);
        }
    });
</script>
@endsection