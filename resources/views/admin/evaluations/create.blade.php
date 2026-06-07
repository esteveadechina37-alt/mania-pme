@extends('layouts.admin')

@section('title', 'Nouvelle évaluation')

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
        --radius-md: 12px;
        --radius-full: 9999px;
        --transition-smooth: 0.25s ease;
    }
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(8px); }
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
        flex: 1 1 auto; max-width: 560px;
    }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px 14px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        flex: 0 0 240px; position: sticky; top: 80px;
    }
    .guide-card h4 {
        font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 700;
        color: var(--dark); margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h4 i { color: var(--primary); }
    .guide-item {
        display: flex; gap: 8px; margin-bottom: 12px; font-size: 12px;
    }
    .guide-icon {
        width: 26px; height: 26px; border-radius: 6px; background: var(--primary-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
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
    .form-input, .form-select, .form-textarea {
        width: 100%; padding: 8px 12px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 13px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
        transition: var(--transition-smooth);
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
    }
    .form-textarea { resize: vertical; min-height: 60px; }

    .star-rating {
        display: flex; align-items: center; gap: 2px; margin-bottom: 4px;
        font-size: 20px; color: #E5E7EB; cursor: pointer;
    }
    .star-rating .star { transition: color 0.15s; }
    .star-rating .star.active { color: #F59E0B; }
    .score-display { font-size: 11px; color: var(--gray-600); margin-top: 2px; }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s ease;
    }
    .btn-primary:hover { box-shadow: 0 6px 18px rgba(255,98,0,0.35); transform: translateY(-1px); }

    .alert-error {
        background: #FEF2F2; border-left: 3px solid #EF4444; color: #991B1B;
        padding: 8px 12px; border-radius: var(--radius-sm); font-size: 12px;
        margin-bottom: 12px; display: flex; align-items: center; gap: 6px;
    }
</style>

<div class="page-header animate-in">
    <h1 class="page-title"><i class="fas fa-star" style="color:var(--primary);"></i> <span>Nouvelle évaluation</span></h1>
    <a href="{{ route('admin.evaluations.index') }}" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

@if ($errors->any())
    <div class="alert-error animate-in">
        <i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs ci-dessous.
    </div>
@endif

<div class="content-layout">
    <!-- Formulaire -->
    <div class="form-card animate-in delay-1">
        <form method="POST" action="{{ route('admin.evaluations.store') }}" id="evaluation-form">
            @csrf
            <div class="form-group">
                <label class="form-label"><i class="fas fa-user"></i> Employé <span style="color:var(--primary);">*</span></label>
                <select name="employee_id" required class="form-select @error('employee_id') is-invalid @enderror">
                    <option value="">-- Sélectionnez --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->user->name }} ({{ $emp->position ?? 'Sans poste' }})
                        </option>
                    @endforeach
                </select>
                @error('employee_id') <span style="color:#EF4444;font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Période <span style="color:var(--primary);">*</span></label>
                <input type="text" name="period" class="form-input @error('period') is-invalid @enderror" 
                       required placeholder="Ex : 2ème trimestre 2026" value="{{ old('period') }}">
                @error('period') <span style="color:#EF4444;font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-star"></i> Note <span style="color:var(--primary);">*</span></label>
                <div class="star-rating" id="star-rating">
                    <span class="star" data-value="1"><i class="far fa-star"></i></span>
                    <span class="star" data-value="2"><i class="far fa-star"></i></span>
                    <span class="star" data-value="3"><i class="far fa-star"></i></span>
                    <span class="star" data-value="4"><i class="far fa-star"></i></span>
                    <span class="star" data-value="5"><i class="far fa-star"></i></span>
                </div>
                <div class="score-display">Note : <strong id="score-text">0.0</strong>/5</div>
                <input type="number" name="score" id="score-input" required min="0" max="5" step="0.5" 
                       value="{{ old('score', '') }}" style="display:none;">
                @error('score') <span style="color:#EF4444;font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-comment-dots"></i> Commentaires</label>
                <textarea name="comments" class="form-textarea @error('comments') is-invalid @enderror" 
                          placeholder="Points forts, axes d'amélioration...">{{ old('comments') }}</textarea>
                @error('comments') <span style="color:#EF4444;font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-clock"></i> Date & heure</label>
                <input type="datetime-local" name="evaluated_at" class="form-input @error('evaluated_at') is-invalid @enderror" 
                       value="{{ old('evaluated_at', now()->format('Y-m-d\TH:i')) }}">
                @error('evaluated_at') <span style="color:#EF4444;font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-check-circle"></i> Enregistrer
            </button>
        </form>
    </div>

    <!-- Guide -->
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Guide rapide</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user"></i></div>
            <div class="guide-text">
                <strong>Sélectionnez un employé</strong>
                <p>Seuls les employés actifs de votre périmètre apparaissent.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar"></i></div>
            <div class="guide-text">
                <strong>Indiquez la période</strong>
                <p>Exemple : T1 2026, 2ème trimestre, bilan annuel.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-star"></i></div>
            <div class="guide-text">
                <strong>Notez sur 5</strong>
                <p>Cliquez sur une étoile. Demi-étoile : moitié gauche.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-comment"></i></div>
            <div class="guide-text">
                <strong>Ajoutez un commentaire</strong>
                <p>Points forts, axes de progrès, objectifs.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-clock"></i></div>
            <div class="guide-text">
                <strong>Date et heure</strong>
                <p>Par défaut, la date du jour. Vous pouvez la modifier.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#star-rating .star');
        const scoreInput = document.getElementById('score-input');
        const scoreText = document.getElementById('score-text');

        if (scoreInput.value) updateStars(parseFloat(scoreInput.value));

        function updateStars(value) {
            stars.forEach(star => {
                const starValue = parseInt(star.getAttribute('data-value'));
                const icon = star.querySelector('i');
                icon.className = 'far fa-star';
                star.classList.remove('half');
                if (starValue <= Math.floor(value)) {
                    icon.className = 'fas fa-star';
                    star.classList.add('active');
                } else if (starValue - 0.5 === value) {
                    icon.className = 'fas fa-star-half-alt';
                    star.classList.add('active');
                }
            });
            scoreInput.value = value;
            scoreText.textContent = value.toFixed(1);
        }

        stars.forEach(star => {
            star.addEventListener('click', function(e) {
                const starRect = this.getBoundingClientRect();
                const clickX = e.clientX - starRect.left;
                const starWidth = starRect.width;
                const starValue = parseInt(this.getAttribute('data-value'));
                let newScore = (clickX < starWidth / 2) ? starValue - 0.5 : starValue;
                if (newScore < 0) newScore = 0.5;
                updateStars(newScore);
            });
            star.addEventListener('mouseenter', function() {
                const val = parseInt(this.getAttribute('data-value'));
                stars.forEach(s => {
                    const sVal = parseInt(s.getAttribute('data-value'));
                    s.querySelector('i').className = sVal <= val ? 'fas fa-star' : 'far fa-star';
                });
            });
            star.addEventListener('mouseleave', function() {
                if (scoreInput.value) updateStars(parseFloat(scoreInput.value));
                else stars.forEach(s => s.querySelector('i').className = 'far fa-star');
            });
        });
    });
</script>
@endsection