@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">
            Bienvenue, {{ auth()->user()->name }} 
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Voici un aperçu de votre entreprise.</p>
    </div>
    <span style="background:#FF6200; color:#fff; padding:6px 16px; border-radius:100px; font-size:13px; font-weight:600;">
        {{ auth()->user()->company->name ?? 'Mania-PME' }}
    </span>
</div>

{{-- Cartes statistiques dynamiques --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-top:8px;">
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Total utilisateurs</p>
                <strong style="font-size:24px;">{{ $totalEmployees }}</strong>
            </div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-calendar-alt fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Congés en attente</p>
                <strong style="font-size:24px;">{{ $pendingLeaves }}</strong>
            </div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-user-check fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Présents aujourd'hui</p>
                <strong style="font-size:24px;">{{ $todayAttendances }}</strong>
            </div>
        </div>
    </div>
</div>

{{-- Liste des derniers utilisateurs ajoutés --}}
<div style="margin-top:32px; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <h3 style="font-family:'Clash Display', sans-serif; margin-bottom:16px;">Derniers membres</h3>
    @if($recentUsers->isEmpty())
        <p style="color:#6B6B6B;">Aucun utilisateur pour le moment.</p>
    @else
        <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
            @foreach($recentUsers as $user)
                <li style="display:flex; align-items:center; gap:12px; padding:8px 0; border-bottom:1px solid #F0F0F0;">
                    <div style="width:36px; height:36px; border-radius:50%; background:#FF6200; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <strong>{{ $user->name }}</strong>
                        <p style="font-size:13px; color:#6B6B6B;">{{ $user->email }} · {{ $user->getRoleNames()->first() ?? 'N/A' }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

{{-- Section modules (liens rapides) --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px; margin-top:32px;">
    <a href="#" style="text-decoration:none; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04); display:flex; align-items:center; gap:14px; color:inherit;">
        <i class="fas fa-users" style="color:#FF6200; font-size:20px;"></i>
        <div>
            <strong>Employés</strong>
            <p style="color:#6B6B6B; font-size:13px; margin-top:4px;">Gérer vos équipes</p>
        </div>
    </a>
    <a href="#" style="text-decoration:none; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04); display:flex; align-items:center; gap:14px; color:inherit;">
        <i class="fas fa-sitemap" style="color:#FF6200; font-size:20px;"></i>
        <div>
            <strong>Départements</strong>
            <p style="color:#6B6B6B; font-size:13px; margin-top:4px;">Structurer l'organisation</p>
        </div>
    </a>
    <a href="#" style="text-decoration:none; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04); display:flex; align-items:center; gap:14px; color:inherit;">
        <i class="fas fa-calendar-alt" style="color:#FF6200; font-size:20px;"></i>
        <div>
            <strong>Congés</strong>
            <p style="color:#6B6B6B; font-size:13px; margin-top:4px;">Suivre les absences</p>
        </div>
    </a>
</div>
@endsection