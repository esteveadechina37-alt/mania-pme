@extends('layouts.admin')

@section('title', 'Profil de ' . $employee->user->name)

@section('content')
<style>
    /* ========== DESIGN SYSTEM ========== */
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
        --shadow-md: 0 6px 16px rgba(10, 10, 10, 0.04);
        --shadow-lg: 0 10px 24px rgba(255, 98, 0, 0.08);
        --radius-sm: 6px;
        --radius-md: 12px;
        --radius-lg: 18px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    body { overflow-y: auto; } /* garde le scroll global si nécessaire */

    /* Bannière plus compacte */
    .banner {
        background: linear-gradient(135deg, #FFF3EC 0%, #FFFFFF 100%);
        border-radius: var(--radius-lg);
        padding: 20px 24px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        box-shadow: var(--shadow-md);
        border: 1px solid #ffe8d6;
        position: relative;
        overflow: hidden;
    }
    .banner::after {
        content: '';
        position: absolute;
        right: -40px;
        bottom: -40px;
        width: 160px;
        height: 160px;
        background: rgba(255,98,0,0.06);
        border-radius: 50%;
    }
    .avatar-xl {
        width: 64px;
        height: 64px;
        border-radius: 20px;
        background: linear-gradient(135deg, #FF6200, #FF8C42);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        box-shadow: 0 10px 16px -6px rgba(255,98,0,0.3);
        flex-shrink: 0;
    }

    /* Cartes */
    .card-elegant {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 18px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: var(--transition-smooth);
    }
    .card-elegant:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-1px);
    }
    .info-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--gray-100);
    }
    .info-row:last-child { border-bottom: none; }
    .icon-circle {
        width: 32px;
        height: 32px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    /* Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
    }
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-danger { background: #fee2e2; color: #991b1b; }

    /* Boutons */
    .btn-soft {
        background: var(--white);
        border: 1px solid var(--gray-200);
        color: var(--dark);
        padding: 7px 14px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition-smooth);
    }
    .btn-soft:hover { background: var(--gray-50); border-color: var(--gray-300); }
    .btn-soft.primary {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 10px rgba(255,98,0,0.2);
    }
    .btn-soft.primary:hover { background: var(--primary-hover); }
    .btn-soft.danger { border-color: #fecaca; color: #dc2626; }
    .btn-soft.danger:hover { background: #fef2f2; }

    /* Disposition grille */
    .detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }
    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    /* Carte congé */
    .leave-card {
        background: #fff;
        border-radius: var(--radius-md);
        padding: 16px;
        box-shadow: var(--shadow-md);
        border-left: 3px solid var(--primary);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .leave-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .leave-details strong {
        font-family: 'Clash Display', sans-serif;
        font-size: 16px;
        color: var(--dark);
    }
    .leave-details p { margin: 2px 0; font-size: 12px; }

    /* Synthèse en bas à droite */
    .synthesis {
        margin-top: 16px;
    }
</style>

{{-- Bannière --}}
<div class="banner animate-in">
    <div class="avatar-xl">
        {{ strtoupper(substr($employee->user->name, 0, 1)) }}
    </div>
    <div style="flex:1;">
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0; letter-spacing:-0.5px; color:var(--dark);">
            {{ $employee->user->name }}
        </h1>
        <div style="display:flex; align-items:center; gap:12px; margin-top:4px; flex-wrap:wrap;">
            <span style="display:flex; align-items:center; gap:4px; color:var(--gray-600); font-size:13px;">
                <i class="fas fa-briefcase" style="color:var(--primary);"></i> {{ $employee->position ?? '—' }}
            </span>
            <span style="color:var(--gray-300);">|</span>
            <span style="display:flex; align-items:center; gap:4px; color:var(--gray-600); font-size:13px;">
                <i class="fas fa-building" style="color:var(--primary);"></i> {{ $employee->department->name ?? 'Non assigné' }}
            </span>
            <span style="color:var(--gray-300);">|</span>
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
    <div style="display:flex; gap:6px; align-items:center;">
        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn-soft primary">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <a href="{{ route('admin.employees.index') }}" class="btn-soft">
            <i class="fas fa-list"></i> Liste
        </a>
        <button type="button" onclick="openConfirmModal('{{ route('admin.employees.destroy', $employee) }}')"
                style="background: #DC2626; color: #fff; padding: 7px 14px; border-radius: 10px; border: none;
                       font-weight: 600; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center;
                       gap: 6px; box-shadow: 0 4px 10px rgba(220,38,38,0.2); transition: all 0.2s ease;">
            <i class="fas fa-trash-alt"></i> Supprimer
        </button>
    </div>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:10px 14px; margin-bottom:16px; color:#065F46; display:flex; align-items:center; gap:8px; font-size:13px;" class="animate-in">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:16px;"></i>
        {{ session('success') }}
    </div>
@endif

<div class="detail-grid">
    {{-- Colonne gauche : Identité + Professionnel (compact) --}}
    <div class="card-elegant animate-in delay-1">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            {{-- Identité --}}
            <div>
                <h3 style="font-family:'Clash Display', sans-serif; font-size:16px; margin:0 0 10px 0; display:flex; align-items:center; gap:6px;">
                    <span style="background: var(--primary-light); color: var(--primary); padding: 4px 8px; border-radius: 6px;">
                        <i class="fas fa-id-card"></i>
                    </span>
                    Identité
                </h3>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-user"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Nom complet</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->user->name }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Email</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->user->email }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Téléphone</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->user->phone ?? '—' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-user-shield"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Rôle</div>
                        <span class="badge-status" style="background:#eff6ff;color:#2563eb; font-size:11px;">
                            <i class="fas fa-user-tag"></i> {{ $employee->user->getRoleNames()->first() ?? 'Aucun' }}
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-toggle-on"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Statut compte</div>
                        @if($employee->user->is_active)
                            <span class="badge-status badge-success" style="font-size:11px;"><i class="fas fa-check-circle"></i> Actif</span>
                        @else
                            <span class="badge-status badge-danger" style="font-size:11px;"><i class="fas fa-times-circle"></i> Inactif</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Professionnel --}}
            <div>
                <h3 style="font-family:'Clash Display', sans-serif; font-size:16px; margin:0 0 10px 0; display:flex; align-items:center; gap:6px;">
                    <span style="background: var(--primary-light); color: var(--primary); padding: 4px 8px; border-radius: 6px;">
                        <i class="fas fa-briefcase"></i>
                    </span>
                    Professionnel
                </h3>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-sitemap"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Département</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->department->name ?? 'Non assigné' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-user-tie"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Poste</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->position ?? '—' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-file-signature"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Contrat</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->contract_type ?? '—' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-money-bill-wave"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Salaire</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->salary ? number_format($employee->salary, 0, ',', ' ') . ' FCFA' : '—' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Embauche</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-circle"><i class="fas fa-calendar-times"></i></div>
                    <div>
                        <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Fin contrat</div>
                        <div style="font-weight:600; font-size:13px;">{{ $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') : '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Colonne droite : Statut congé + Synthèse --}}
    <div class="animate-in delay-1" style="display:flex; flex-direction:column; gap:16px;">
        @if($currentLeave)
            @php
                $daysLeft = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($currentLeave->end_date)->startOfDay(), false) + 1;
            @endphp
            <div class="leave-card">
                <div class="leave-icon">
                    <i class="fas fa-umbrella-beach"></i>
                </div>
                <div class="leave-details">
                    <strong>En congé actuellement</strong>
                    <p style="margin: 4px 0 0; color: var(--gray-600); font-size:12px;">
                        Du {{ \Carbon\Carbon::parse($currentLeave->start_date)->format('d/m/Y') }}
                        au {{ \Carbon\Carbon::parse($currentLeave->end_date)->format('d/m/Y') }}
                        ({{ $currentLeave->start_date->diffInDays($currentLeave->end_date) + 1 }} jours)
                    </p>
                    <p style="margin: 2px 0 0; font-size:11px; color: var(--gray-600);">
                        <i class="fas fa-tag" style="color:var(--primary);"></i> {{ $currentLeave->leaveType->name }}
                    </p>
                    <p style="margin: 8px 0 0;">
                        <span style="background: var(--primary-light); color: var(--primary); padding: 4px 12px; border-radius: var(--radius-full); font-weight:600; font-size:12px;">
                            @if($daysLeft > 0)
                                <i class="fas fa-clock"></i> Retour dans {{ $daysLeft }} jour(s)
                            @else
                                <i class="fas fa-check"></i> Dernier jour de congé
                            @endif
                        </span>
                    </p>
                </div>
            </div>
        @else
            <div class="card-elegant" style="display: flex; align-items: center; gap: 12px;">
                <div class="icon-circle" style="width: 40px; height: 40px; background: var(--primary-light);">
                    <i class="fas fa-briefcase" style="font-size: 18px;"></i>
                </div>
                <div>
                    <strong style="font-family:'Clash Display', sans-serif; font-size: 16px;">Aucun congé en cours</strong>
                    <p style="color: var(--gray-600); margin: 2px 0 0; font-size:12px;">L'employé est en poste.</p>
                </div>
            </div>
        @endif

        {{-- Synthèse --}}
        <div class="card-elegant">
            <h3 style="font-family:'Clash Display', sans-serif; font-size:16px; margin:0 0 12px 0; display:flex; align-items:center; gap:6px;">
                <span style="background: var(--primary-light); color: var(--primary); padding: 4px 8px; border-radius: 6px;">
                    <i class="fas fa-chart-pie"></i>
                </span>
                Synthèse
            </h3>
            <div class="info-row">
                <div class="icon-circle"><i class="fas fa-hourglass-half"></i></div>
                <div>
                    <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Ancienneté</div>
                    <div style="font-weight:600; font-size:13px;">
                        @if($employee->hire_date)
                            @php
                                $hire = \Carbon\Carbon::parse($employee->hire_date);
                                $now = \Carbon\Carbon::now();
                                $diff = $hire->diff($now);
                                echo $diff->y . ' an' . ($diff->y > 1 ? 's' : '') . ' ' . $diff->m . ' mois';
                            @endphp
                        @else — @endif
                    </div>
                </div>
            </div>
            <div class="info-row">
                <div class="icon-circle"><i class="fas fa-calendar-week"></i></div>
                <div>
                    <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Solde congés</div>
                    <div style="font-weight:600; font-size:13px;">{{ $employee->leave_balance ?? '—' }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="icon-circle"><i class="fas fa-clock"></i></div>
                <div>
                    <div style="font-size:10px; color:var(--gray-600); text-transform:uppercase;">Dernier pointage</div>
                    <div style="font-weight:600; font-size:13px;">{{ $employee->last_attendance ?? 'Aucun' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection