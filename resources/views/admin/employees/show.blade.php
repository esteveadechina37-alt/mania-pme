@extends('layouts.admin')

@section('title', 'Profil de ' . $employee->user->name)

@section('content')
<style>
    /* ----- Styles PRO encore plus poussés ----- */
    .banner {
        background: linear-gradient(135deg, #FFF3EC 0%, #FFFFFF 100%);
        border-radius: 20px;
        padding: 36px 40px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 32px;
        flex-wrap: wrap;
        box-shadow: 0 12px 30px -10px rgba(0,0,0,0.05);
        border: 1px solid #ffe8d6;
        position: relative;
        overflow: hidden;
    }
    .banner::after {
        content: '';
        position: absolute;
        right: -40px;
        bottom: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255,98,0,0.06);
        border-radius: 50%;
    }
    .avatar-xl {
        width: 100px;
        height: 100px;
        border-radius: 28px;
        background: linear-gradient(135deg, #FF6200, #FF8C42);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 44px;
        font-weight: 700;
        box-shadow: 0 16px 24px -8px rgba(255,98,0,0.4);
    }
    .card-elegant {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }
    .card-elegant:hover {
        box-shadow: 0 16px 32px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .info-row {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .icon-circle {
        width: 42px;
        height: 42px;
        background: rgba(255,98,0,0.08);
        color: #FF6200;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 18px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
    }
    .badge-success {
        background: #ecfdf5;
        color: #059669;
    }
    .badge-warning {
        background: #fffbeb;
        color: #d97706;
    }
    .badge-danger {
        background: #fef2f2;
        color: #dc2626;
    }
    .btn-soft {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #334155;
        padding: 10px 20px;
        border-radius: 100px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-soft:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .btn-soft.primary {
        background: #FF6200;
        border-color: #FF6200;
        color: #fff;
        box-shadow: 0 6px 14px rgba(255,98,0,0.25);
    }
    .btn-soft.primary:hover {
        background: #e55800;
    }
    .btn-soft.danger {
        border-color: #fecaca;
        color: #dc2626;
    }
    .btn-soft.danger:hover {
        background: #fef2f2;
    }
</style>

{{-- Bannière en-tête --}}
<div class="banner">
    <div class="avatar-xl">
        {{ strtoupper(substr($employee->user->name, 0, 1)) }}
    </div>
    <div style="flex:1;">
        <h1 style="font-family:'Clash Display', sans-serif; font-size:36px; margin:0; letter-spacing:-0.5px; color:#1e293b;">
            {{ $employee->user->name }}
        </h1>
        <div style="display:flex; align-items:center; gap:16px; margin-top:8px; flex-wrap:wrap;">
            <span style="display:flex; align-items:center; gap:6px; color:#475569; font-size:15px;">
                <i class="fas fa-briefcase" style="color:#FF6200;"></i> {{ $employee->position ?? 'Poste non défini' }}
            </span>
            <span style="color:#cbd5e1;">|</span>
            <span style="display:flex; align-items:center; gap:6px; color:#475569; font-size:15px;">
                <i class="fas fa-building" style="color:#FF6200;"></i> {{ $employee->department->name ?? 'Non assigné' }}
            </span>
            <span style="color:#cbd5e1;">|</span>
            <span>
                @if($employee->status === 'active')
                    <span class="badge-status badge-success"><i class="fas fa-check-circle"></i> Actif</span>
                @elseif($employee->status === 'suspended')
                    <span class="badge-status badge-warning"><i class="fas fa-exclamation-triangle"></i> Suspendu</span>
                @else
                    <span class="badge-status badge-danger"><i class="fas fa-times-circle"></i> Terminé</span>
                @endif
            </span>
        </div>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn-soft primary">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <a href="{{ route('admin.employees.index') }}" class="btn-soft">
            <i class="fas fa-list"></i> Liste
        </a>
        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" 
              onsubmit="return confirm('Supprimer définitivement cet employé ?');" style="display:inline;">
            @csrf @method('DELETE')
            <button type="button"
                onclick="openConfirmModal('{{ route('admin.employees.destroy', $employee) }}')"
                style="background: #DC2626;
                    color: #fff;
                    padding: 10px 22px;
                    border-radius: 10px;
                    border: none;
                    font-weight: 600;
                    font-size: 14px;
                    cursor: pointer;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
                    transition: all 0.2s ease;">
            <i class="fas fa-trash-alt"></i> Supprimer l'employé
        </button>
            <!-- <button type="submit" class="btn-soft danger">
                <i class="fas fa-trash-alt"></i> Supprimer
            </button> -->
        </form>
    </div>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:12px; padding:14px 18px; margin-bottom:28px; color:#065F46; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Grille des cartes d'information --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
    
    {{-- Identité --}}
    <div class="card-elegant">
        <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin:0 0 20px 0; display:flex; align-items:center; gap:10px;">
            <span style="background: rgba(255,98,0,0.1); color: #FF6200; padding: 8px 12px; border-radius: 10px;">
                <i class="fas fa-id-card"></i>
            </span>
            Identité
        </h3>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-user"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">Nom complet</div>
                <div style="font-weight:600;">{{ $employee->user->name }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-envelope"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Email</div>
                <div style="font-weight:600;">{{ $employee->user->email }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-phone-alt"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Téléphone</div>
                <div style="font-weight:600;">{{ $employee->user->phone ?? '—' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-user-shield"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Rôle</div>
                <div>
                    <span class="badge-status" style="background:#eff6ff;color:#2563eb;">
                        <i class="fas fa-user-tag"></i> {{ $employee->user->getRoleNames()->first() ?? 'Aucun' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-toggle-on"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Statut compte</div>
                @if($employee->user->is_active)
                    <span class="badge-status badge-success"><i class="fas fa-check-circle"></i> Actif</span>
                @else
                    <span class="badge-status badge-danger"><i class="fas fa-times-circle"></i> Inactif</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Professionnel --}}
    <div class="card-elegant">
        <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin:0 0 20px 0; display:flex; align-items:center; gap:10px;">
            <span style="background: rgba(255,98,0,0.1); color: #FF6200; padding: 8px 12px; border-radius: 10px;">
                <i class="fas fa-briefcase"></i>
            </span>
            Professionnel
        </h3>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-sitemap"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Département</div>
                <div style="font-weight:600;">{{ $employee->department->name ?? 'Non assigné' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-user-tie"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Poste</div>
                <div style="font-weight:600;">{{ $employee->position ?? '—' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-file-signature"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Contrat</div>
                <div style="font-weight:600;">{{ $employee->contract_type ?? '—' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-money-bill-wave"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Salaire</div>
                <div style="font-weight:600;">{{ $employee->salary ? number_format($employee->salary, 0, ',', ' ') . ' FCFA' : '—' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Embauche</div>
                <div style="font-weight:600;">{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-calendar-times"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Fin contrat</div>
                <div style="font-weight:600;">{{ $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') : '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Synthèse & ancienneté --}}
    <div class="card-elegant">
        <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin:0 0 20px 0; display:flex; align-items:center; gap:10px;">
            <span style="background: rgba(255,98,0,0.1); color: #FF6200; padding: 8px 12px; border-radius: 10px;">
                <i class="fas fa-chart-pie"></i>
            </span>
            Synthèse
        </h3>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Ancienneté</div>
                <div style="font-weight:600;">
                    @if($employee->hire_date)
                        @php
                            $hire = \Carbon\Carbon::parse($employee->hire_date);
                            $now = \Carbon\Carbon::now();
                            $diff = $hire->diff($now);
                            echo $diff->y . ' an' . ($diff->y > 1 ? 's' : '') . ' ' . $diff->m . ' mois';
                        @endphp
                    @else
                        —
                    @endif
                </div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-calendar-week"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Solde congés</div>
                <div style="font-weight:600;">{{ $employee->leave_balance ?? '—' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="icon-circle"><i class="fas fa-clock"></i></div>
            <div>
                <div style="font-size:11px; color:#64748b; text-transform:uppercase;">Dernier pointage</div>
                <div style="font-weight:600;">{{ $employee->last_attendance ?? 'Aucun' }}</div>
            </div>
        </div>
        <!-- Ajoutez ici d'autres métriques si souhaité -->
    </div>
</div>
@endsection