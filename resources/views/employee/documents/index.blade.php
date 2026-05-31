@extends('layouts.admin')

@section('title', 'Mes documents')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --radius-md: 16px;
        --radius-full: 9999px;
    }
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 30px; flex-wrap: wrap; gap: 20px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 30px; font-weight: 700; color: var(--dark);
        margin: 0 0 6px 0;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-size: 15px; }
    .content-grid {
        display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }
    .table-card {
        background: var(--white); border-radius: var(--radius-md);
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        overflow-x: auto;
    }
    .premium-table { width: 100%; border-collapse: collapse; min-width: 500px; }
    .premium-table th {
        background: var(--gray-50); padding: 14px 20px; font-size: 11px;
        color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid var(--gray-200); text-align: left;
    }
    .premium-table td {
        padding: 14px 20px; border-bottom: 1px solid var(--gray-100);
        font-size: 14px; color: var(--dark);
    }
    .premium-table tr:hover td { background: var(--gray-50); }
    .btn-download {
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px;
        background: var(--primary); color: white; border-radius: var(--radius-full);
        font-size: 13px; font-weight: 600; text-decoration: none;
        box-shadow: 0 4px 12px rgba(255,98,0,0.2);
    }
    .guide-card {
        background: var(--white); border-radius: var(--radius-md); padding: 24px;
        box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
    }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700;
        color: var(--dark); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;
    }
    .guide-item { display: flex; gap: 12px; margin-bottom: 20px; }
    .guide-icon {
        width: 36px; height: 36px; border-radius: 8px; background: rgba(255,98,0,0.08);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 15px; font-weight: 700; color: var(--dark); display: block; margin-bottom: 4px; }
    .guide-text p { font-size: 13px; color: var(--gray-600); margin: 0; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-file-alt" style="color:var(--primary);"></i> <span>Mes documents</span></h1>
        <p class="page-subtitle">Retrouvez vos attestations, contrats et autres documents</p>
    </div>
</div>

@if(session('error'))
    <div style="background:#FEF2F2; border-left:4px solid #EF4444; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#991B1B;">
        {{ session('error') }}
    </div>
@endif

<div class="content-grid">
    <div class="table-card animate-in delay-1">
        @if($documents->count())
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr>
                        <td style="font-weight:600;">{{ $doc->title }}</td>
                        <td>
                            @if($doc->type == 'certificate') Attestation
                            @elseif($doc->type == 'contract') Contrat
                            @else Autre
                            @endif
                        </td>
                        <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('employee.documents.download', $doc) }}" class="btn-download">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 0 20px 20px;">
                {{ $documents->links() }}
            </div>
        @else
            <div style="text-align:center; padding:60px 20px; color:var(--gray-600);">
                <i class="fas fa-folder-open" style="font-size:48px; display:block; margin-bottom:16px; opacity:0.4;"></i>
                <p>Aucun document disponible.</p>
            </div>
        @endif
    </div>

    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-certificate"></i></div>
            <div class="guide-text">
                <strong>Attestations</strong>
                <p>Vos attestations de travail ou de stage sont générées par l'administration.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-file-contract"></i></div>
            <div class="guide-text">
                <strong>Contrats</strong>
                <p>Votre contrat de travail est accessible ici une fois téléversé.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-download"></i></div>
            <div class="guide-text">
                <strong>Téléchargement</strong>
                <p>Cliquez sur "Télécharger" pour obtenir une copie de votre document.</p>
            </div>
        </div>
    </div>
</div>
@endsection