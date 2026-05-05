@extends('layouts.admin')

@section('title', 'Dashboard Manager')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">Dashboard Manager</h1>
        <p style="color:#6B6B6B; margin-top:6px;">Gérez votre équipe et les demandes.</p>
    </div>
    <span style="background:#FF6200; color:#fff; padding:6px 16px; border-radius:100px; font-size:13px; font-weight:600;">
        {{ auth()->user()->company->name ?? 'Mania-PME' }}
    </span>
</div>

{{-- Cartes --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-user-friends fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Membres de l'équipe</p>
                <strong style="font-size:24px;">{{ $teamMembersCount }}</strong>
            </div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-calendar-check fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Demandes en attente</p>
                <strong style="font-size:24px;">{{ $pendingRequests }}</strong>
            </div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:rgba(255,98,0,0.1); color:#FF6200; padding:12px; border-radius:12px;">
                <i class="fas fa-clock fa-lg"></i>
            </div>
            <div>
                <p style="font-size:13px; color:#6B6B6B;">Présents aujourd'hui</p>
                <strong style="font-size:24px;">{{ $presentToday }}</strong>
            </div>
        </div>
    </div>
</div>

{{-- Liste des employés (basée sur les utilisateurs de la boîte) --}}
<div style="margin-top:32px; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <h3 style="font-family:'Clash Display', sans-serif; margin-bottom:16px;">👥 Mon équipe</h3>
    @php
        $teamUsers = \App\Models\User::where('company_id', auth()->user()->company_id)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['employe','stagiaire']))
            ->limit(5)->get();
    @endphp
    @if($teamUsers->isEmpty())
        <p style="color:#6B6B6B;">Aucun membre d'équipe pour le moment.</p>
    @else
        <ul style="list-style:none; padding:0;">
            @foreach($teamUsers as $user)
                <li style="display:flex; align-items:center; gap:12px; padding:8px 0; border-bottom:1px solid #F0F0F0;">
                    <div style="width:36px; height:36px; border-radius:50%; background:#FF6200; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <strong>{{ $user->name }}</strong>
                        <p style="font-size:13px; color:#6B6B6B;">{{ $user->email }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection