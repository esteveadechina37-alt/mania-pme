@extends('layouts.admin')

@section('title', 'Historique des pointages')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --primary-glow: rgba(255,98,0,0.25);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 20px rgba(10,10,10,0.05);
        --radius-sm: 6px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s ease;
    }
    @keyframes fadeSlideUp {
        0% { opacity:0; transform:translateY(12px); }
        100% { opacity:1; transform:translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.08s; }
    .delay-2 { animation-delay:0.16s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
    .page-subtitle { color: var(--gray-600); font-size: 13px; margin: 0; }

    .content-grid {
        display: grid; grid-template-columns: 1fr 240px; gap: 16px; align-items: start;
    }
    @media (max-width: 850px) { .content-grid { grid-template-columns: 1fr; } }

    .table-card {
        background: var(--white); border-radius: var(--radius-md);
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        overflow: hidden;
    }
    .table-header {
        padding: 14px 18px; border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; justify-content: space-between;
    }
    .table-header h3 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .table-header h3 i { color: var(--primary); }
    .table-count {
        background: var(--primary-light); color: var(--primary);
        padding: 3px 10px; border-radius: var(--radius-full);
        font-size: 11px; font-weight: 700;
    }
    .compact-table {
        width: 100%; border-collapse: collapse; min-width: 400px;
    }
    .compact-table th {
        background: var(--gray-50); padding: 10px 14px; font-size: 10px;
        font-weight: 700; color: var(--gray-600); text-transform: uppercase;
        letter-spacing: 0.4px; border-bottom: 1px solid var(--gray-200);
        text-align: left; white-space: nowrap;
    }
    .compact-table td {
        padding: 10px 14px; border-bottom: 1px solid var(--gray-100);
        font-size: 13px; color: var(--dark); vertical-align: middle;
    }
    .compact-table tr:last-child td { border-bottom: none; }
    .compact-table tbody tr:hover td { background: var(--gray-50); }

    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 12px;
        font-size: 11px; font-weight: 600;
    }
    .badge-present { background: #DCFCE7; color: #166534; }
    .badge-late { background: #FEE2E2; color: #991B1B; }
    .badge-absent { background: #F3F4F6; color: #1F2937; }

    .empty-state { text-align: center; padding: 40px 20px; color: var(--gray-600); }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
        position: sticky; top: 80px;
    }
    .guide-card h4 {
        font-family: 'Clash Display', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h4 i { color: var(--primary); }
    .guide-item { display: flex; gap: 8px; margin-bottom: 10px; font-size: 12px; }
    .guide-icon {
        width: 28px; height: 28px; border-radius: 6px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 13px; display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }

    .pagination-wrap { margin-top: 16px; display: flex; justify-content: center; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">
            <i class="fas fa-history" style="color:var(--primary);"></i> Historique des pointages
        </h1>
        <p class="page-subtitle">Consultez vos enregistrements d'arrivée et de départ</p>
    </div>
</div>

<div class="content-grid">
    {{-- Tableau --}}
    <div class="table-card animate-in delay-1">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> Liste des pointages</h3>
            <span class="table-count">{{ $attendances->total() }} pointage(s)</span>
        </div>
        @if($attendances->count())
            <div style="overflow-x:auto;">
                <table class="compact-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Arrivée</th>
                            <th>Départ</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $att)
                        <tr>
                            <td style="font-weight:600;">{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                            <td>{{ $att->check_in }}</td>
                            <td>{{ $att->check_out ?? '—' }}</td>
                            <td>
                                @php
                                    $status = $att->status;
                                    if ($status === 'late') {
                                        $badgeClass = 'badge-late';
                                        $icon = 'fa-exclamation-triangle';
                                        $label = 'Retard';
                                    } elseif ($status === 'present') {
                                        $badgeClass = 'badge-present';
                                        $icon = 'fa-check-circle';
                                        $label = 'Présent';
                                    } elseif ($status === 'absent') {
                                        $badgeClass = 'badge-absent';
                                        $icon = 'fa-times-circle';
                                        $label = 'Absent';
                                    } else {
                                        $badgeClass = 'badge-absent';
                                        $icon = 'fa-question-circle';
                                        $label = $status;
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="fas {{ $icon }}"></i> {{ $label }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Aucun pointage trouvé.</p>
            </div>
        @endif
    </div>

    {{-- Guide --}}
    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> Comprendre vos pointages</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-check-circle"></i></div>
            <div class="guide-text">
                <strong>Présent</strong>
                <p>Pointage avant 08:30.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="guide-text">
                <strong>Retard</strong>
                <p>Arrivée après 08:30.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="guide-text">
                <strong>Jours sans pointage</strong>
                <p>Aucune ligne n'apparaît.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-sign-out-alt"></i></div>
            <div class="guide-text">
                <strong>Départ</strong>
                <p>Un tiret si non pointé.</p>
            </div>
        </div>
    </div>
</div>

<div class="pagination-wrap animate-in delay-2">
    {{ $attendances->links() }}
</div>
@endsection