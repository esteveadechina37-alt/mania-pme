@extends('layouts.admin')

@section('title', 'Récapitulatif hebdomadaire')

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

    /* ========== BENTO CARDS (identiques dashboard admin) ========== */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
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
        gap: 8px;
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

    /* ========== CONTENT GRID (tableau + guide) ========== */
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
        min-width: 600px;
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

    .badge-present {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .badge-late {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
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

    /* ========== BOUTON ========== */
    .btn-outline {
        background: var(--white);
        color: var(--dark);
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 13px;
        border: 1px solid var(--gray-200);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: var(--transition-smooth);
    }
    .btn-outline:hover {
        background: var(--gray-50);
        border-color: var(--primary-glow);
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-calendar-week" style="color:var(--primary);"></i> <span>Récapitulatif</span></h1>
        <p class="page-subtitle">Semaine du {{ $startOfWeek->format('d/m') }} au {{ $endOfWeek->format('d/m/Y') }}</p>
    </div>
</div>

{{-- Statistiques rapides --}}
<div class="bento-grid animate-in delay-1">
    <div class="bento-card">
        <div>
            <div class="bento-header">
                <span class="bento-label">Jours pointés</span>
                <div class="bento-icon"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value">{{ $attendances->count() }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-success"><i class="fas fa-arrow-up"></i> Cette semaine</span>
            <span>Jours travaillés</span>
        </div>
    </div>

    <div class="bento-card">
        <div>
            <div class="bento-header">
                <span class="bento-label">À l'heure</span>
                <div class="bento-icon"><i class="fas fa-clock"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value" style="color:#10B981;">{{ $totalPresent }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            <span class="trend-pill trend-success"><i class="fas fa-check"></i> Sans retard</span>
            <span>Pointages avant 08:30</span>
        </div>
    </div>

    <div class="bento-card">
        <div>
            <div class="bento-header">
                <span class="bento-label">Retards</span>
                <div class="bento-icon"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
            <div class="bento-body">
                <h2 class="bento-value" style="color:{{ $totalLate > 0 ? '#DC2626' : '#10B981' }};">{{ $totalLate }}</h2>
            </div>
        </div>
        <div class="bento-footer">
            @if($totalLate > 0)
                <span class="trend-pill trend-warning"><i class="fas fa-exclamation"></i> Retard(s)</span>
                <span>Arrivée après 08:30</span>
            @else
                <span class="trend-pill trend-success"><i class="fas fa-check"></i> Aucun retard</span>
                <span>Tous à l'heure</span>
            @endif
        </div>
    </div>
</div>

<div class="content-grid">
    {{-- Tableau détaillé --}}
    <div class="table-card animate-in delay-1">
        <table class="premium-table">
            <thead>
                <tr>
                    <th><i class="fas fa-calendar-alt" style="margin-right:6px;"></i> Date</th>
                    <th><i class="fas fa-sign-in-alt" style="margin-right:6px;"></i> Arrivée</th>
                    <th><i class="fas fa-sign-out-alt" style="margin-right:6px;"></i> Départ</th>
                    <th><i class="fas fa-circle" style="margin-right:6px;"></i> Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                <tr>
                    <td style="font-weight:600;">{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                    <td>{{ $att->check_in }}</td>
                    <td>{{ $att->check_out ?? '—' }}</td>
                    <td>
                        @if($att->status == 'late')
                            <span class="badge-late"><i class="fas fa-exclamation-triangle"></i> Retard</span>
                        @else
                            <span class="badge-present"><i class="fas fa-check-circle"></i> Présent</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding:40px 20px; text-align:center; color:var(--gray-600);">
                        <i class="fas fa-inbox" style="font-size:32px; display:block; margin-bottom:12px; opacity:0.4;"></i>
                        <p>Aucun pointage cette semaine.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Résumé de la semaine</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="guide-text">
                <strong>Jours pointés</strong>
                <p>Nombre total de jours où vous avez enregistré une présence cette semaine.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-clock"></i></div>
            <div class="guide-text">
                <strong>À l'heure / Retards</strong>
                <p>Un pointage après 08:30 est considéré comme un retard. Les retards sont comptabilisés séparément.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-history"></i></div>
            <div class="guide-text">
                <strong>Historique complet</strong>
                <p>Pour voir tous vos pointages, utilisez le bouton ci-dessous.</p>
            </div>
        </div>
    </div>
</div>

<div style="margin-top: 24px;" class="animate-in delay-1">
    <a href="{{ route('attendances.history') }}" class="btn-outline">
        <i class="fas fa-history"></i> Voir tout l'historique
    </a>
</div>
@endsection