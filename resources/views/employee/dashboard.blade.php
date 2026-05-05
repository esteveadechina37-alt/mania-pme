@extends('layouts.admin')

@section('title', 'Mon Espace')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">
            Mon Espace
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Retrouvez vos informations personnelles.</p>
    </div>
    <div style="display:flex; align-items:center; gap:12px;">
        <div style="width:42px; height:42px; border-radius:50%; background:#FF6200; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:16px;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <span style="font-weight:600;">{{ auth()->user()->name }}</span>
    </div>
</div>

{{-- Cartes --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-calendar-plus fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Congés restants</p>
                <strong style="font-size:24px;">{{ $congesRestants }} jours</strong>
            </div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-file-invoice fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Dernière fiche de paie</p>
                <strong style="font-size:20px;">{{ $derniereFicheDate }}</strong>
            </div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-user-check fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Heures pointées (semaine)</p>
                <strong style="font-size:20px;">{{ $heuresPointees }}h</strong>
            </div>
        </div>
    </div>
</div>

{{-- Informations personnelles rapides --}}
<div style="margin-top:32px; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <h3 style="font-family:'Clash Display', sans-serif; margin-bottom:16px;">📋 Mes informations</h3>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div>
            <span style="color:#6B6B6B; font-size:13px;">Nom complet</span>
            <p style="font-weight:600;">{{ auth()->user()->name }}</p>
        </div>
        <div>
            <span style="color:#6B6B6B; font-size:13px;">Email</span>
            <p style="font-weight:600;">{{ auth()->user()->email }}</p>
        </div>
        <div>
            <span style="color:#6B6B6B; font-size:13px;">Rôle</span>
            <p style="font-weight:600; text-transform:capitalize;">{{ auth()->user()->getRoleNames()->first() ?? 'N/A' }}</p>
        </div>
        <div>
            <span style="color:#6B6B6B; font-size:13px;">Entreprise</span>
            <p style="font-weight:600;">{{ auth()->user()->company->name ?? 'N/A' }}</p>
        </div>
    </div>
</div>

{{-- Demandes récentes (vide pour l'instant) --}}
<div style="margin-top:20px; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <h3 style="font-family:'Clash Display', sans-serif; margin-bottom:16px;"> Demandes récentes</h3>
    @if(empty($demandesRecentes))
        <p style="color:#6B6B6B;">Aucune demande pour le moment.</p>
    @else
        {{-- Affichage futur --}}
    @endif
</div>
@endsection