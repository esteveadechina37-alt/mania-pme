@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    /* On garde le design existant, on ajoute juste cette règle pour cacher les éléments supplémentaires */
    .hidden-item {
        display: none !important;
    }
</style>

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
{{-- Liste des derniers utilisateurs ajoutés --}}
<div style="margin-top:32px; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <h3 style="font-family:'Clash Display', sans-serif; margin-bottom:16px;">Derniers membres</h3>
    @if($recentUsers->isEmpty())
        <p style="color:#6B6B6B;">Aucun utilisateur pour le moment.</p>
    @else
        <ul id="recentUsersList" style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
            @foreach($recentUsers as $index => $user)
                <li class="recent-user {{ $index >= 2 ? 'hidden-item' : '' }}" 
                    style="display:flex; align-items:center; gap:12px; padding:8px 0; border-bottom:1px solid #F0F0F0;">
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

        @if($recentUsers->count() > 2)
            <div style="text-align:center; margin-top:12px;" id="buttonsContainer">
                <button id="showMoreBtn" 
                        onclick="toggleUsers('more')"
                        style="background: transparent; border: 1px solid #e5e7eb; color: #374151; padding: 8px 24px; border-radius: 100px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-chevron-down"></i> Voir plus
                </button>
                <button id="showLessBtn" 
                        onclick="toggleUsers('less')"
                        style="background: transparent; border: 1px solid #e5e7eb; color: #374151; padding: 8px 24px; border-radius: 100px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: none; align-items: center; gap: 8px;">
                    <i class="fas fa-chevron-up"></i> Voir moins
                </button>
            </div>
        @endif
    @endif
</div>

<script>
    // Fonction pour basculer entre voir plus et voir moins
    function toggleUsers(action) {
        const items = document.querySelectorAll('.recent-user');
        const showMoreBtn = document.getElementById('showMoreBtn');
        const showLessBtn = document.getElementById('showLessBtn');

        if (action === 'more') {
            // Afficher tous les éléments
            items.forEach((item, index) => {
                if (index >= 2) {
                    item.classList.remove('hidden-item');
                }
            });
            showMoreBtn.style.display = 'none';
            showLessBtn.style.display = 'inline-flex';
        } else {
            // Masquer à partir du 3ème élément
            items.forEach((item, index) => {
                if (index >= 2) {
                    item.classList.add('hidden-item');
                }
            });
            showLessBtn.style.display = 'none';
            showMoreBtn.style.display = 'inline-flex';
        }
    }
</script>
<!-- <div style="margin-top:32px; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <h3 style="font-family:'Clash Display', sans-serif; margin-bottom:16px;">Derniers membres</h3>
    @if($recentUsers->isEmpty())
        <p style="color:#6B6B6B;">Aucun utilisateur pour le moment.</p>
    @else
        <ul id="recentUsersList" style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
            @foreach($recentUsers as $index => $user)
                <li class="recent-user {{ $index >= 2 ? 'hidden-item' : '' }}" style="display:flex; align-items:center; gap:12px; padding:8px 0; border-bottom:1px solid #F0F0F0;">
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

        @if($recentUsers->count() > 2)
            <div style="text-align:center; margin-top:12px;">
                <button id="showMoreBtn" 
                        onclick="document.querySelectorAll('.hidden-item').forEach(el => el.style.display = 'flex'); this.style.display = 'none';" 
                        style="background: transparent; border: 1px solid #e5e7eb; color: #374151; padding: 8px 24px; border-radius: 100px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-chevron-down"></i> Voir plus
                </button>
            </div>
        @endif
    @endif
</div> -->

{{-- Section modules (liens rapides) --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px; margin-top:32px;">
    <a href="{{ route('admin.employees.index') }}" style="text-decoration:none; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04); display:flex; align-items:center; gap:14px; color:inherit;">
        <i class="fas fa-users" style="color:#FF6200; font-size:20px;"></i>
        <div>
            <strong>Employés</strong>
            <p style="color:#6B6B6B; font-size:13px; margin-top:4px;">Gérer vos équipes</p>
        </div>
    </a>
    <a href="{{ route('admin.departments.index') }}" style="text-decoration:none; background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04); display:flex; align-items:center; gap:14px; color:inherit;">
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