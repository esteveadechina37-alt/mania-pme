@extends('layouts.admin')

@section('title', 'Paramètres du compte')

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
        --shadow-sm: 0 2px 6px rgba(10,10,10,0.05);
        --radius-sm: 6px;
        --radius-md: 12px;
        --radius-full: 9999px;
    }

    @keyframes fadeSlideUp {
        0%   { opacity: 0; transform: translateY(8px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.4s ease both; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 12px; flex-wrap: wrap; gap: 8px;
    }
    .page-title {
        font-size: 20px; font-weight: 700; color: var(--dark);
        margin: 0; display: flex; align-items: center; gap: 6px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .alert-success, .alert-error {
        border-left: 4px solid;
        border-radius: 6px; padding: 8px 12px;
        margin-bottom: 12px; font-size: 12px;
        display: flex; align-items: center; gap: 6px;
    }
    .alert-success { background: #ECFDF5; border-color: #10B981; color: #065F46; }
    .alert-error   { background: #FEF2F2; border-color: #EF4444; color: #991B1B; }

    .content-grid {
        display: grid; grid-template-columns: 1fr 220px;
        gap: 12px; align-items: start;
    }
    @media (max-width: 800px) { .content-grid { grid-template-columns: 1fr; } }

    .settings-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px 16px; box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200); margin-bottom: 10px;
    }
    .section-title {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--gray-600);
        margin: 0 0 10px; padding-bottom: 6px;
        border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; gap: 5px;
    }
    .section-title i { color: var(--primary); font-size: 12px; }

    .form-group { margin-bottom: 10px; }
    .form-label { font-size: 11px; font-weight: 600; color: var(--dark); margin-bottom: 3px; display: block; }
    .form-label i { color: var(--primary); margin-right: 3px; font-size: 12px; }
    .form-input {
        width: 100%; padding: 6px 10px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 12px;
        background: var(--white); color: var(--dark);
        transition: 0.2s; outline: none;
    }
    .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 2px var(--primary-light); }
    .is-invalid { border-color: #EF4444 !important; }
    .invalid-feedback { font-size: 10px; color: #EF4444; margin-top: 2px; }

    .divider { margin: 10px 0; border-top: 1px solid var(--gray-100); }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 8px 16px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 12px; border: none; cursor: pointer;
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px;
        box-shadow: 0 3px 8px rgba(255,98,0,0.2);
        transition: 0.2s;
    }
    .btn-primary:hover { transform: translateY(-1px); }

    .login-log-table {
        width: 100%; border-collapse: collapse; font-size: 11px;
    }
    .login-log-table th {
        text-align: left; padding: 5px 0; font-size: 10px;
        color: var(--gray-600); text-transform: uppercase;
        border-bottom: 1px solid var(--gray-100);
    }
    .login-log-table td { padding: 6px 0; border-bottom: 1px solid var(--gray-50); }
    .login-log-table tr:last-child td { border-bottom: none; }
    .empty-text { font-size: 11px; color: var(--gray-300); text-align: center; padding: 12px; }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px; box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        position: sticky; top: 60px;
    }
    .guide-card h3 {
        font-size: 13px; font-weight: 700; color: var(--dark);
        margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h3 i { color: var(--primary); font-size: 14px; }
    .guide-item { display: flex; gap: 6px; margin-bottom: 8px; font-size: 11px; }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 24px; height: 24px; border-radius: 5px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 12px; display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-user-cog" style="color:var(--primary)"></i>
        <span>Paramètres du compte</span>
    </h1>
</div>

@if(session('success'))
    <div class="alert-success animate-in">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="alert-error animate-in">
        <i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs ci-dessous.
    </div>
@endif

<div class="content-grid">
    <div>
        {{-- Formulaire --}}
        <div class="settings-card animate-in delay-1">
            <form method="POST" action="{{ route('user.settings.update') }}">
                @csrf @method('PUT')
                <div class="section-title"><i class="fas fa-user"></i> Informations</div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user"></i> Nom complet</label>
                    <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="divider"></div>
                <div class="section-title">
                    <i class="fas fa-lock"></i> Mot de passe
                    <span style="font-size:10px;color:var(--gray-300);">(laisser vide)</span>
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-lock"></i> Actuel</label>
                    <input type="password" name="current_password" class="form-input @error('current_password') is-invalid @enderror"
                           placeholder="Mot de passe actuel">
                    @error('current_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-key"></i> Nouveau</label>
                    <input type="password" name="password" class="form-input @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 caractères">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-check-circle"></i> Confirmer</label>
                    <input type="password" name="password_confirmation" class="form-input"
                           placeholder="Répéter le nouveau mot de passe">
                </div>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
            </form>
        </div>

        {{-- Historique --}}
        <div class="settings-card animate-in delay-2">
            <div class="section-title"><i class="fas fa-history"></i> Dernières connexions</div>
            @if(isset($loginLogs) && $loginLogs->count())
                <table class="login-log-table">
                    <thead><tr><th>Date</th><th>IP</th><th>Navigateur</th></tr></thead>
                    <tbody>
                        @foreach($loginLogs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $log->ip_address ?? '—' }}</td>
                            <td style="max-width:140px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $log->user_agent ? \Illuminate\Support\Str::limit($log->user_agent, 40) : '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-text"><i class="fas fa-info-circle"></i> Aucune donnée</div>
            @endif
        </div>
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-2">
        <h3><i class="fas fa-lightbulb"></i> Guide</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user"></i></div>
            <div class="guide-text"><strong>Nom</strong><p>Affiché dans l'application.</p></div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-envelope"></i></div>
            <div class="guide-text"><strong>Email</strong><p>Connexion et notifications.</p></div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-lock"></i></div>
            <div class="guide-text"><strong>Mot de passe</strong><p>8 caractères minimum.</p></div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-history"></i></div>
            <div class="guide-text"><strong>Connexions</strong><p>5 derniers accès.</p></div>
        </div>
    </div>
</div>
@endsection