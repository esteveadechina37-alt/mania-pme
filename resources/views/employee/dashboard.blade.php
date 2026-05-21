@extends('layouts.admin')

@section('title', 'Mon Espace')

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
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .animate-in {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* Header */
    .dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
    }
    .dashboard-header::after {
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
    .welcome-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 6px 0;
        line-height: 1.2;
    }
    .welcome-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .welcome-subtitle {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        margin: 0;
    }
    .user-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--dark);
        color: var(--white);
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 20px rgba(10, 10, 10, 0.15);
        white-space: nowrap;
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }

    /* Bento grid */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .bento-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .bento-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0;
        transition: var(--transition-smooth);
    }
    .bento-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .bento-card:hover::before { opacity: 1; }
    .bento-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        position: relative;
        z-index: 1;
    }
    .bento-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .bento-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        background: var(--gray-50);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: var(--transition-smooth);
        border: 1px solid var(--gray-200);
    }
    .bento-card:hover .bento-icon {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        animation: float 2s ease-in-out infinite;
    }
    .bento-body {
        position: relative;
        z-index: 1;
    }
    .bento-value {
        font-family: 'Clash Display', sans-serif;
        font-size: 34px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
        margin: 0 0 8px 0;
    }
    .bento-footer {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 500;
        padding-top: 12px;
        border-top: 1px solid var(--gray-100);
    }
    .trend-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 11px;
    }
    .trend-success { background: rgba(16, 185, 129, 0.1); color: #10B981; }
    .trend-warning { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
    .trend-info { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }

    /* Deux colonnes */
    .info-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }
    @media (max-width: 900px) {
        .info-grid { grid-template-columns: 1fr; }
    }

    /* Carte info */
    .info-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
    }
    .info-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .info-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .info-card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
    }
    .info-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid var(--gray-100);
    }
    .info-row:last-child { border-bottom: none; }
    .info-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .info-label { font-size: 11px; color: var(--gray-600); text-transform: uppercase; }
    .info-value { font-weight: 600; color: var(--dark); font-size: 14px; }

    /* Guide */
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

    /* Demandes récentes */
    .requests-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .request-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200);
    }
    .badge-pending {
        background: #fef3c7;
        color: #92400e;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
    }
    .badge-approved {
        background: #dcfce7;
        color: #166534;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
    }
    .badge-rejected {
        background: #fee2e2;
        color: #991b1b;
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
    }
    .empty-state {
        text-align: center;
        padding: 30px 0;
        color: var(--gray-600);
    }
</style>

<div class="dashboard-header animate-in">
    <div>
        <h1 class="welcome-title">
            Bienvenue, <span>{{ auth()->user()->name }}</span>
        </h1>
        <p class="welcome-subtitle">Retrouvez vos informations personnelles</p>
    </div>
    <div class="user-badge">
        <div class="avatar-sm">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        {{ auth()->user()->company->name ?? 'Mania-PME' }} · {{ auth()->user()->getRoleNames()->first() ?? 'N/A' }}
    </div>
</div>

{{-- Bento Grid Statistiques --}}
<div class="bento-grid">
    <div class="bento-card animate-in delay-1">
    <div>
        <div class="bento-header">
            <span class="bento-label">Congé en cours</span>
            <div class="bento-icon"><i class="fas fa-umbrella-beach"></i></div>
        </div>
        <div class="bento-body">
            @if($currentLeave)
                <h2 class="bento-value">{{ $joursRestants }} jour(s)</h2>
                <p style="font-size:12px; color:var(--gray-600);">restant(s)</p>
            @else
                <h2 class="bento-value" style="font-size: 28px;">Aucun</h2>
            @endif
        </div>
    </div>
    <div class="bento-footer">
        @if($currentLeave)
            <span class="trend-pill trend-warning"><i class="fas fa-clock"></i> Retour le {{ \Carbon\Carbon::parse($currentLeave->end_date)->format('d/m/Y') }}</span>
        @else
            <span class="trend-pill trend-success"><i class="fas fa-check"></i> Pas de congé en cours</span>
        @endif
    </div>
</div>

    <div class="bento-card animate-in delay-2">
        <div>
            <div class="bento-header">
                <span class="bento-label">Dernière fiche de paie</span>
                <div class="bento-icon"><i class="fas fa-file-invoice"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value" style="font-size: 28px;">{{ $derniereFicheDate }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-info"><i class="fas fa-file-alt"></i> Disponible</span>
            <span>Bulletin de paie</span>
        </div>
    </div>

    <div class="bento-card animate-in delay-3">
        <div>
            <div class="bento-header">
                <span class="bento-label">Heures pointées</span>
                <div class="bento-icon"><i class="fas fa-user-check"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $heuresPointees }}h</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-warning"><i class="fas fa-clock"></i> Cette semaine</span>
            <span>Pointages</span>
        </div>
    </div>
</div>

{{-- Informations + Guide --}}
<div class="info-grid">
    {{-- Colonne gauche : Informations personnelles + Demandes récentes --}}
    <div class="animate-in delay-4" style="display: flex; flex-direction: column; gap: 24px;">
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon"><i class="fas fa-id-card"></i></div>
                <h3 class="info-card-title">Mes informations</h3>
            </div>
            <div class="info-row">
                <div class="info-icon-circle"><i class="fas fa-user"></i></div>
                <div>
                    <div class="info-label">Nom complet</div>
                    <div class="info-value">{{ auth()->user()->name }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon-circle"><i class="fas fa-envelope"></i></div>
                <div>
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon-circle"><i class="fas fa-user-tag"></i></div>
                <div>
                    <div class="info-label">Rôle</div>
                    <div class="info-value" style="text-transform: capitalize;">{{ auth()->user()->getRoleNames()->first() ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon-circle"><i class="fas fa-building"></i></div>
                <div>
                    <div class="info-label">Entreprise</div>
                    <div class="info-value">{{ auth()->user()->company->name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        {{-- Demandes récentes --}}
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon"><i class="fas fa-history"></i></div>
                <h3 class="info-card-title">Demandes récentes</h3>
            </div>
           @if($demandesRecentes->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.4; margin-bottom: 8px;"></i>
                    <p>Aucune demande pour le moment.</p>
                </div>
            @else
                <div class="requests-list">
                    @foreach($demandesRecentes as $demande)
                        <div class="request-item">
                            <div>
                                <strong>{{ $demande->leaveType->name }}</strong>
                                <div style="font-size: 12px; color: var(--gray-600);">
                                    {{ $demande->start_date->format('d/m/Y') }} - {{ $demande->end_date->format('d/m/Y') }}
                                </div>
                            </div>
                            <span class="badge-{{ $demande->status }}">
                                @if($demande->status == 'pending') En attente
                                @elseif($demande->status == 'approved') Approuvé
                                @else Refusé
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
            <!-- @if(empty($demandesRecentes) || count($demandesRecentes) == 0)
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.4; margin-bottom: 8px;"></i>
                    <p>Aucune demande pour le moment.</p>
                </div>
            @else
                <div class="requests-list">
                    @foreach($demandesRecentes as $demande)
                        <div class="request-item">
                            <div>
                                <strong>{{ $demande->leaveType->name }}</strong>
                                <div style="font-size: 12px; color: var(--gray-600);">
                                    {{ $demande->start_date->format('d/m/Y') }} - {{ $demande->end_date->format('d/m/Y') }}
                                </div>
                            </div>
                            <span class="badge-{{ $demande->status }}">
                                @if($demande->status == 'pending') En attente
                                @elseif($demande->status == 'approved') Approuvé
                                @else Refusé
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif -->
        </div>
    </div>

    {{-- Colonne droite : Guide employé --}}
    <div class="guide-card animate-in delay-4" style="position: sticky; top: 100px; align-self: start;">
        <h3 class="card-title"><i class="fas fa-compass"></i> Votre espace</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-plus"></i></div>
            <div class="guide-text">
                <strong>Demandez un congé</strong>
                <p>Utilisez la section congés pour poser vos absences.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-file-invoice"></i></div>
            <div class="guide-text">
                <strong>Consultez vos fiches de paie</strong>
                <p>Vos bulletins sont accessibles depuis la section Paie.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-user-check"></i></div>
            <div class="guide-text">
                <strong>Pointez vos heures</strong>
                <p>Enregistrez vos arrivées et départs chaque jour.</p>
            </div>
        </div>
    </div>
</div>
@endsection