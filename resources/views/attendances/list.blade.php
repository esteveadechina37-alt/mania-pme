@extends('layouts.admin')

@section('title', 'Présences du jour')

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

    /* ========== FILTRE DATE ========== */
    .date-filter {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }
    .date-input {
        padding: 10px 14px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        font-size: 14px;
        background: var(--white);
        color: var(--dark);
        font-family: 'Cabinet Grotesk', sans-serif;
    }
    .date-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .btn-outline {
        background: var(--white);
        color: var(--dark);
        padding: 10px 22px;
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

    /* ========== TABLE (desktop) ========== */
    .table-card {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        display: block;
    }
    .premium-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
        display: table;
    }
    .premium-table th,
    .premium-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--gray-100);
        font-size: 14px;
        color: var(--dark);
    }
    .premium-table th {
        background: var(--gray-50);
        font-weight: 600;
        font-size: 11px;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
    }
    .premium-table tr:last-child td { border-bottom: none; }
    .premium-table tr:hover td { background: var(--gray-50); }

    /* ========== CARTES MOBILES ========== */
    .mobile-cards {
        display: none;
        flex-direction: column;
        gap: 12px;
    }
    .mobile-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }
    .mobile-card .card-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--gray-100);
        font-size: 14px;
    }
    .mobile-card .card-line:last-child { border-bottom: none; }
    .card-label { color: var(--gray-600); font-weight: 500; }
    .card-value { font-weight: 600; color: var(--dark); }

    /* ========== BADGES ========== */
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
    .badge-absent {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
        background: #f3f4f6;
        color: #1f2937;
        border: 1px solid #e5e7eb;
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
        margin-top: 24px;
    }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
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
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }
    .guide-text p { font-size: 13px; color: var(--gray-600); margin: 0; }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; }
        .date-filter { flex-direction: column; align-items: stretch; }
        .date-filter form { flex-direction: column; align-items: stretch; gap: 8px; }
        .btn-outline { justify-content: center; width: 100%; }
        .table-card { display: none; }  /* cache le tableau */
        .mobile-cards { display: flex; } /* affiche les cartes */
        .guide-item { flex-direction: column; align-items: flex-start; gap: 8px; }
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-clock" style="color:var(--primary);"></i> <span>Présences</span></h1>
        <p class="page-subtitle">Suivi des pointages pour le {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    </div>
</div>

{{-- Filtre par date --}}
<div class="date-filter animate-in delay-1">
    <form method="GET" action="{{ route('attendances.list') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <input type="date" name="date" value="{{ $date }}" class="date-input" onchange="this.form.submit()">
        <button type="submit" class="btn-outline"><i class="fas fa-search"></i> Voir</button>
        <a href="{{ route('attendances.list') }}" class="btn-outline"><i class="fas fa-sync-alt"></i> Aujourd'hui</a>
    </form>
    <a href="{{ route('attendances.export-list-pdf', ['date' => $date]) }}" class="btn-outline" style="margin-left:auto;">
        <i class="fas fa-download"></i> Exporter PDF
    </a>
</div>

{{-- Tableau (desktop) --}}
<div class="table-card animate-in delay-1">
    <table class="premium-table">
        <thead>
            <tr>
                <th><i class="fas fa-user" style="margin-right:6px;"></i> Employé</th>
                <th><i class="fas fa-sign-in-alt" style="margin-right:6px;"></i> Arrivée</th>
                <th><i class="fas fa-sign-out-alt" style="margin-right:6px;"></i> Départ</th>
                <th><i class="fas fa-circle" style="margin-right:6px;"></i> Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $att)
            <tr>
                <td style="font-weight:600;">{{ $att->employee->user->name }}</td>
                <td>{{ $att->check_in }}</td>
                <td>{{ $att->check_out ?? '—' }}</td>
                <td>
                    @if($att->status == 'late')
                        <span class="badge-late"><i class="fas fa-exclamation-triangle"></i> Retard</span>
                    @elseif($att->status == 'present')
                        <span class="badge-present"><i class="fas fa-check-circle"></i> Présent</span>
                    @else
                        <span class="badge-absent"><i class="fas fa-times-circle"></i> Absent</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:40px; text-align:center; color:var(--gray-600);">
                    <i class="fas fa-inbox" style="font-size:32px; display:block; margin-bottom:12px; opacity:0.4;"></i>
                    Aucun pointage pour cette date.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Cartes (mobile) --}}
<div class="mobile-cards animate-in delay-1">
    @forelse($attendances as $att)
        <div class="mobile-card">
            <div class="card-line">
                <span class="card-label"><i class="fas fa-user"></i> Employé</span>
                <span class="card-value">{{ $att->employee->user->name }}</span>
            </div>
            <div class="card-line">
                <span class="card-label"><i class="fas fa-sign-in-alt"></i> Arrivée</span>
                <span class="card-value">{{ $att->check_in }}</span>
            </div>
            <div class="card-line">
                <span class="card-label"><i class="fas fa-sign-out-alt"></i> Départ</span>
                <span class="card-value">{{ $att->check_out ?? '—' }}</span>
            </div>
            <div class="card-line">
                <span class="card-label"><i class="fas fa-circle"></i> Statut</span>
                <span class="card-value">
                    @if($att->status == 'late')
                        <span class="badge-late"><i class="fas fa-exclamation-triangle"></i> Retard</span>
                    @elseif($att->status == 'present')
                        <span class="badge-present"><i class="fas fa-check-circle"></i> Présent</span>
                    @else
                        <span class="badge-absent"><i class="fas fa-times-circle"></i> Absent</span>
                    @endif
                </span>
            </div>
        </div>
    @empty
        <div style="text-align:center; padding:20px; color:var(--gray-600);">
            <i class="fas fa-inbox" style="font-size:32px; display:block; margin-bottom:12px; opacity:0.4;"></i>
            Aucun pointage pour cette date.
        </div>
    @endforelse
</div>

<div class="pagination-wrap animate-in delay-1">
    {{ $attendances->links() }}
</div>

{{-- Guide rapide --}}
<div class="guide-card animate-in delay-2">
    <h3 class="card-title"><i class="fas fa-lightbulb"></i> Comprendre les présences</h3>
    <div class="guide-item">
        <div class="guide-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="guide-text">
            <strong>Choisissez une date</strong>
            <p>Utilisez le sélecteur ci‑dessus pour remonter dans l'historique.</p>
        </div>
    </div>
    <div class="guide-item">
        <div class="guide-icon"><i class="fas fa-download"></i></div>
        <div class="guide-text">
            <strong>Export PDF</strong>
            <p>Téléchargez la liste des pointages au format PDF pour archivage.</p>
        </div>
    </div>
    <div class="guide-item">
        <div class="guide-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="guide-text">
            <strong>Statuts</strong>
            <p>Retard = arrivée après 08:30. Absent = aucun pointage d'arrivée enregistré.</p>
        </div>
    </div>
</div>
@endsection