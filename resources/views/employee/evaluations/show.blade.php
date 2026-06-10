@extends('layouts.admin')

@section('title', 'Détail de l\'évaluation')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@700;800&display=swap');

    :root {
        --primary:       #FF6200;
        --primary-dim:   #FF8C42;
        --primary-glow:  rgba(255,98,0,0.18);
        --primary-light: rgba(255,98,0,0.07);
        --dark:          #0D0D0D;
        --surface:       #FFFFFF;
        --surface-2:     #F7F7F8;
        --border:        rgba(0,0,0,0.07);
        --muted:         #7A7A8A;
        --radius-sm:     8px;
        --radius-md:     16px;
        --radius-lg:     22px;
        --shadow-card:   0 2px 0 rgba(0,0,0,0.05), 0 12px 32px rgba(0,0,0,0.06);
        --shadow-badge:  0 2px 8px rgba(0,0,0,0.10);
        --transition:    0.28s cubic-bezier(0.4,0,0.2,1);
    }

    /* ── Reset scoped ── */
    .ev-wrap *, .ev-wrap *::before, .ev-wrap *::after { box-sizing: border-box; }
    .ev-wrap { font-family: 'Inter', system-ui, sans-serif; color: var(--dark); }

    /* ── Animations ── */
    @keyframes ev-rise {
        from { opacity:0; transform: translateY(16px); }
        to   { opacity:1; transform: translateY(0); }
    }
    .ev-a  { animation: ev-rise 0.5s ease both; }
    .ev-a1 { animation-delay: 0.06s; }
    .ev-a2 { animation-delay: 0.14s; }
    .ev-a3 { animation-delay: 0.22s; }

    /* ── Page header ── */
    .ev-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 12px; flex-wrap: wrap; margin-bottom: 24px;
    }
    .ev-header-left { display: flex; align-items: center; gap: 14px; }
    .ev-header-icon {
        width: 46px; height: 46px; border-radius: 13px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dim));
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 18px;
        box-shadow: 0 4px 14px var(--primary-glow);
        flex-shrink: 0;
    }
    .ev-title {
        font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 800;
        color: var(--dark); margin: 0 0 3px; line-height: 1.2;
    }
    .ev-subtitle { font-size: 12.5px; color: var(--muted); margin: 0; }
    .ev-subtitle strong { color: var(--dark); font-weight: 600; }

    .ev-back {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: 99px;
        background: var(--surface); color: var(--dark);
        border: 1px solid var(--border); font-size: 12.5px; font-weight: 600;
        text-decoration: none; transition: var(--transition);
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        white-space: nowrap;
    }
    .ev-back:hover {
        background: var(--primary); color: #fff; border-color: var(--primary);
        box-shadow: 0 4px 14px var(--primary-glow);
    }
    .ev-back i { font-size: 11px; }

    /* ── Layout ── */
    .ev-grid {
        display: grid;
        grid-template-columns: 1fr 230px;
        gap: 16px;
        align-items: start;
    }
    @media (max-width: 860px) {
        .ev-grid { grid-template-columns: 1fr; }
    }

    /* ── Main card ── */
    .ev-card {
        background: var(--surface); border-radius: var(--radius-lg);
        border: 1px solid var(--border); box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .ev-card-header {
        padding: 16px 20px 0;
        display: flex; align-items: center; gap: 8px;
        font-size: 11px; font-weight: 700; letter-spacing: 0.08em;
        text-transform: uppercase; color: var(--muted);
    }
    .ev-card-header::after {
        content: ''; flex: 1; height: 1px; background: var(--border);
    }

    /* ── Rows ── */
    .ev-row {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        transition: background var(--transition);
    }
    .ev-row:last-of-type { border-bottom: none; }
    .ev-row:hover { background: var(--surface-2); }

    .ev-row-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; flex-shrink: 0;
        transition: var(--transition);
    }
    .ev-row:hover .ev-row-icon {
        background: var(--primary); color: #fff;
        box-shadow: 0 4px 12px var(--primary-glow);
    }

    .ev-row-body { flex: 1; min-width: 0; }
    .ev-row-label {
        font-size: 11px; font-weight: 600; color: var(--muted);
        text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 3px;
    }
    .ev-row-value { font-size: 14px; font-weight: 600; color: var(--dark); }

    /* ── Score badge ── */
    .ev-score-wrap { display: flex; align-items: center; gap: 10px; }
    .ev-score-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 13px; border-radius: 99px;
        font-size: 13px; font-weight: 700; box-shadow: var(--shadow-badge);
    }
    .ev-score-high   { background: #D1FAE5; color: #065F46; }
    .ev-score-medium { background: #FEF3C7; color: #92400E; }
    .ev-score-low    { background: #FEE2E2; color: #991B1B; }

    .ev-score-bar-wrap {
        flex: 1; max-width: 120px; height: 5px;
        background: var(--border); border-radius: 99px; overflow: hidden;
    }
    .ev-score-bar {
        height: 100%; border-radius: 99px;
        transition: width 1s cubic-bezier(0.4,0,0.2,1);
    }
    .ev-score-bar-high   { background: linear-gradient(90deg, #10B981, #34D399); }
    .ev-score-bar-medium { background: linear-gradient(90deg, #F59E0B, #FCD34D); }
    .ev-score-bar-low    { background: linear-gradient(90deg, #EF4444, #FCA5A5); }

    /* ── Comment block ── */
    .ev-comment {
        margin: 0 20px 20px; padding: 14px 16px;
        background: var(--surface-2); border-radius: var(--radius-md);
        border: 1px solid var(--border);
    }
    .ev-comment-head {
        display: flex; align-items: center; gap: 7px;
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.07em; color: var(--muted); margin-bottom: 8px;
    }
    .ev-comment-head i { color: var(--primary); }
    .ev-comment-text {
        font-size: 13.5px; color: #3A3A4A; line-height: 1.65; margin: 0;
    }

    /* ── Sidebar ── */
    .ev-sidebar {
        background: var(--surface); border-radius: var(--radius-lg);
        border: 1px solid var(--border); box-shadow: var(--shadow-card);
        overflow: hidden; position: sticky; top: 80px;
    }
    .ev-sidebar-banner {
        height: 5px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dim));
    }
    .ev-sidebar-body { padding: 16px; }
    .ev-sidebar-title {
        font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800;
        color: var(--dark); margin: 0 0 14px;
        display: flex; align-items: center; gap: 7px;
    }
    .ev-sidebar-title i { color: var(--primary); }

    .ev-tip {
        display: flex; gap: 10px; margin-bottom: 12px;
        padding-bottom: 12px; border-bottom: 1px solid var(--border);
    }
    .ev-tip:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
    .ev-tip-icon {
        width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 12px;
    }
    .ev-tip-title { font-size: 12.5px; font-weight: 700; color: var(--dark); margin-bottom: 2px; }
    .ev-tip-desc  { font-size: 11.5px; color: var(--muted); line-height: 1.4; margin: 0; }

    /* ── Scale key ── */
    .ev-scale {
        margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border);
    }
    .ev-scale-title {
        font-size: 10.5px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.07em; color: var(--muted); margin-bottom: 8px;
    }
    .ev-scale-item {
        display: flex; align-items: center; gap: 6px;
        font-size: 11.5px; color: var(--muted); margin-bottom: 5px;
    }
    .ev-scale-dot {
        width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    }
</style>

<div class="ev-wrap">
    {{-- Header --}}
    <div class="ev-header ev-a">
        <div class="ev-header-left">
            <div class="ev-header-icon"><i class="fas fa-star"></i></div>
            <div>
                <h1 class="ev-title">Détail de l'évaluation</h1>
                <p class="ev-subtitle">Période&nbsp;: <strong>{{ $evaluation->period }}</strong></p>
            </div>
        </div>
        <a href="{{ route('employee.evaluations.index') }}" class="ev-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="ev-grid">
        {{-- Main card --}}
        <div class="ev-card ev-a ev-a1">
            <div class="ev-card-header">Informations</div>

            @php
                $score = $evaluation->score;
                $pct   = ($score / 5) * 100;
                if ($score >= 4)      { $cls = 'high';   }
                elseif ($score >= 3)  { $cls = 'medium'; }
                else                  { $cls = 'low';    }
            @endphp

            {{-- Score --}}
            <div class="ev-row">
                <div class="ev-row-icon"><i class="fas fa-star"></i></div>
                <div class="ev-row-body">
                    <div class="ev-row-label">Note globale</div>
                    <div class="ev-score-wrap">
                        <span class="ev-score-badge ev-score-{{ $cls }}">
                            <i class="fas fa-star" style="font-size:10px;"></i>
                            {{ number_format($score, 1) }}&thinsp;/&thinsp;5
                        </span>
                        <div class="ev-score-bar-wrap">
                            <div class="ev-score-bar ev-score-bar-{{ $cls }}"
                                 style="width:{{ $pct }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Évaluateur --}}
            <div class="ev-row">
                <div class="ev-row-icon"><i class="fas fa-user-check"></i></div>
                <div class="ev-row-body">
                    <div class="ev-row-label">Évaluateur</div>
                    <div class="ev-row-value">{{ $evaluation->evaluator->name }}</div>
                </div>
            </div>

            {{-- Date --}}
            <div class="ev-row">
                <div class="ev-row-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="ev-row-body">
                    <div class="ev-row-label">Date d'évaluation</div>
                    <div class="ev-row-value">{{ $evaluation->evaluated_at->format('d/m/Y') }}</div>
                </div>
            </div>

            {{-- Commentaires --}}
            @if($evaluation->comments)
            <div class="ev-comment">
                <div class="ev-comment-head">
                    <i class="fas fa-comment-dots"></i> Commentaires
                </div>
                <p class="ev-comment-text">{{ $evaluation->comments }}</p>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="ev-sidebar ev-a ev-a2">
            <div class="ev-sidebar-banner"></div>
            <div class="ev-sidebar-body">
                <p class="ev-sidebar-title">
                    <i class="fas fa-lightbulb"></i> Comprendre
                </p>

                <div class="ev-tip">
                    <div class="ev-tip-icon"><i class="fas fa-star"></i></div>
                    <div>
                        <div class="ev-tip-title">Votre note</div>
                        <p class="ev-tip-desc">Échelle de 0 à 5. Reflète votre performance sur la période.</p>
                    </div>
                </div>

                <div class="ev-tip">
                    <div class="ev-tip-icon"><i class="fas fa-user-check"></i></div>
                    <div>
                        <div class="ev-tip-title">Évaluateur</div>
                        <p class="ev-tip-desc">Manager ou administrateur responsable de l'évaluation.</p>
                    </div>
                </div>

                <div class="ev-tip">
                    <div class="ev-tip-icon"><i class="fas fa-comment-dots"></i></div>
                    <div>
                        <div class="ev-tip-title">Commentaires</div>
                        <p class="ev-tip-desc">Points forts identifiés et pistes de progression.</p>
                    </div>
                </div>

                <div class="ev-scale">
                    <div class="ev-scale-title">Barème</div>
                    <div class="ev-scale-item">
                        <span class="ev-scale-dot" style="background:#10B981;"></span>
                        4 – 5 &nbsp;·&nbsp; Excellent
                    </div>
                    <div class="ev-scale-item">
                        <span class="ev-scale-dot" style="background:#F59E0B;"></span>
                        3 – 3.9 &nbsp;·&nbsp; Satisfaisant
                    </div>
                    <div class="ev-scale-item">
                        <span class="ev-scale-dot" style="background:#EF4444;"></span>
                        0 – 2.9 &nbsp;·&nbsp; À améliorer
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection