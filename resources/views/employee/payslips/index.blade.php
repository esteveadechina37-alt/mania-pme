@extends('layouts.admin')

@section('title', 'Mes bulletins de paie')

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
        letter-spacing: 0.4px; border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .compact-table td {
        padding: 10px 14px; border-bottom: 1px solid var(--gray-100);
        font-size: 13px; color: var(--dark); vertical-align: middle;
    }
    .compact-table tr:last-child td { border-bottom: none; }
    .compact-table tbody tr:hover td { background: var(--gray-50); }

    .btn-download {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: var(--radius-full);
        background: var(--primary); color: white;
        font-size: 12px; font-weight: 600; text-decoration: none;
        transition: var(--transition-smooth);
        box-shadow: 0 3px 10px rgba(255,98,0,0.2);
    }
    .btn-download:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(255,98,0,0.3);
    }

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
            <i class="fas fa-file-invoice" style="color:var(--primary);"></i> Mes bulletins
        </h1>
        <p class="page-subtitle">Consultez et téléchargez vos bulletins de paie</p>
    </div>
</div>

@if(session('error'))
    <div class="alert-error" style="background:#FEF2F2;border-left:4px solid #EF4444;padding:10px 14px;border-radius:8px;margin-bottom:16px;color:#991B1B;display:flex;align-items:center;gap:8px;font-size:13px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

<div class="content-grid">
    <div class="table-card animate-in delay-1">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> Liste des bulletins</h3>
            <span class="table-count">{{ $payslips->total() }} bulletin(s)</span>
        </div>
        @if($payslips->count())
            <div style="overflow-x:auto;">
                <table class="compact-table">
                    <thead>
                        <tr>
                            <th>Période</th>
                            <th>Salaire net</th>
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payslips as $p)
                        <tr>
                            <td style="font-weight:600;">{{ $p->month }} {{ $p->year }}</td>
                            <td>{{ number_format($p->net_salary, 0, ',', ' ') }} FCFA</td>
                            <td style="text-align:right;">
                                <a href="{{ route('employee.payslips.download', $p) }}" class="btn-download">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p>Aucun bulletin pour le moment.</p>
            </div>
        @endif
    </div>

    <div class="guide-card animate-in delay-2">
        <h4><i class="fas fa-lightbulb"></i> À savoir</h4>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-download"></i></div>
            <div class="guide-text">
                <strong>Téléchargement</strong>
                <p>Cliquez sur « Télécharger » pour obtenir le PDF.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-lock"></i></div>
            <div class="guide-text">
                <strong>Accès sécurisé</strong>
                <p>Vous seul pouvez voir vos bulletins.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-history"></i></div>
            <div class="guide-text">
                <strong>Historique complet</strong>
                <p>Tous vos bulletins générés apparaissent ici.</p>
            </div>
        </div>
    </div>
</div>

<div class="pagination-wrap animate-in delay-1">
    {{ $payslips->links() }}
</div>
@endsection