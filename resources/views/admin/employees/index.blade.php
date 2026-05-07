@extends('layouts.admin')

@section('title', 'Employés')

@section('content')

<style>
    /* ----- Styles communs (issus du dashboard) ----- */
    .premium-table tr:hover td {
        background-color: #FFF8F2;
        transition: background-color 0.2s ease;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .badge-status.actif {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }
    .badge-status.conge {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }
    .badge-status.suspendu {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }
    .badge-status.inactif {
        background: #f3f4f6;
        color: #1f2937;
        border-color: #e5e7eb;
    }
    .badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        display: inline-block;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        color: #FF6200;
        background: transparent;
        transition: all 0.15s ease;
        text-decoration: none;
        margin: 0 2px;
        font-size: 14px;
    }
    .action-btn:hover {
        background: #FFF0E5;
    }
    .action-btn.delete:hover {
        background: #FEE2E2;
        color: #DC2626;
    }
    .initial-avatar {
        width: 36px;  /* aligné sur le dashboard */
        height: 36px;
        border-radius: 50%;
        background: #FF6200;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        margin-right: 10px;
    }

    /* ----- Cartes KPI (calquées sur les stats du dashboard) ----- */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px; /* espace identique au dashboard */
    }
    .kpi-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        gap: 12px;
        transition: none; /* on garde la simplicité du dashboard, sans hover ↑ */
    }
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        background: rgba(255,98,0,0.1);
        color: #FF6200;
    }
    .kpi-info h4 {
        margin: 0;
        font-size: 24px;  /* identique au dashboard */
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }
    .kpi-info span {
        font-size: 13px;
        color: #6B6B6B;
        font-weight: 400;
    }
</style>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; margin:0;">
            Employés
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Gérez votre effectif</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" 
       style="background:#FF6200; color:#fff; padding:10px 22px; border-radius:100px; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(255,98,0,0.2);">
        <i class="fas fa-plus-circle"></i> Nouvel employé
    </a>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#065F46; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Cartes KPI au style dashboard --}}
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon">
            <i class="fas fa-user-friends"></i>
        </div>
        <div class="kpi-info">
            <h4>{{ $totalEmployees ?? $employees->total() }}</h4>
            <span>Employés total</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="kpi-info">
            <h4>{{ $activeCount ?? 0 }}</h4>
            <span>Actifs</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">
            <i class="fas fa-umbrella-beach"></i>
        </div>
        <div class="kpi-info">
            <h4>{{ $onLeaveCount ?? 0 }}</h4>
            <span>En congé</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">
            <i class="fas fa-building"></i>
        </div>
        <div class="kpi-info">
            <h4>{{ $departmentsCount ?? 0 }}</h4>
            <span>Départements</span>
        </div>
    </div>
</div>

{{-- Liste des employés dans une carte style dashboard --}}
<div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
    <h3 style="font-family:'Clash Display', sans-serif; font-size:20px; margin-bottom:20px;"><i style="color: #FF6200;
" class="fas fa-user-friends"></i> Membres de l'équipe</h3>
    
    <table style="width:100%; border-collapse:collapse;" class="premium-table">
        <thead>
            <tr style="text-align:left; border-bottom:1px solid #E5E7EB;">
                <th style="padding:12px 16px; font-weight:600; font-size:12px; color:#6B7280; text-transform:uppercase;">Nom</th>
                <th style="padding:12px 16px; font-weight:600; font-size:12px; color:#6B7280; text-transform:uppercase;">Email</th>
                <th style="padding:12px 16px; font-weight:600; font-size:12px; color:#6B7280; text-transform:uppercase;">Rôle</th>
                <th style="padding:12px 16px; font-weight:600; font-size:12px; color:#6B7280; text-transform:uppercase;">Département</th>
                <th style="padding:12px 16px; font-weight:600; font-size:12px; color:#6B7280; text-transform:uppercase;">Poste</th>
                <th style="padding:12px 16px; font-weight:600; font-size:12px; color:#6B7280; text-transform:uppercase;">Statut</th>
                <th style="padding:12px 16px; font-weight:600; font-size:12px; color:#6B7280; text-transform:uppercase; text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
            <tr style="border-bottom:1px solid #F9FAFB;">
                <td style="padding:12px 16px; display:flex; align-items:center; gap:8px;">
                    <div class="initial-avatar">
                        {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                    </div>
                    <span style="font-weight:600;">{{ $employee->user->name }}</span>
                </td>
                <td style="padding:12px 16px; color:#4B5563;">{{ $employee->user->email }}</td>
                <td style="padding:12px 16px;">
                    <span style="display:inline-block; padding:4px 12px; background:#EFF6FF; color:#1E40AF; border-radius:100px; font-size:12px; font-weight:500;">
                        {{ $employee->user->getRoleNames()->first() ?? 'Aucun' }}
                    </span>
                </td>
                <td style="padding:12px 16px;">{{ $employee->department->name ?? '—' }}</td>
                <td style="padding:12px 16px;">{{ $employee->position ?? '—' }}</td>
                <td style="padding:12px 16px;">
                    @php
                        $status = strtolower($employee->status ?? '');
                        $badgeClass = 'inactif';
                        if ($status === 'actif' || $status === 'active') $badgeClass = 'actif';
                        elseif (str_contains($status, 'congé') || $status === 'leave') $badgeClass = 'conge';
                        elseif ($status === 'suspendu' || $status === 'suspended') $badgeClass = 'suspendu';
                    @endphp
                    <span class="badge-status {{ $badgeClass }}">
                        <span class="badge-dot"></span>
                        {{ ucfirst($employee->status) }}
                    </span>
                </td>
                <td style="padding:12px 16px; text-align:right;">
                    <div style="display:flex; justify-content:flex-end; gap:4px;">
                        <a href="{{ route('admin.employees.show', $employee) }}" class="action-btn" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.employees.edit', $employee) }}" class="action-btn" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="openConfirmModal('{{ route('admin.employees.destroy', $employee) }}')"
                                    class="action-btn delete" style="border:none; cursor:pointer;" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <!-- <button type="submit" onclick="return confirm('Supprimer cet employé ?')" 
                                    class="action-btn delete" style="border:none; cursor:pointer;" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button> -->
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:40px 16px; text-align:center; color:#9CA3AF;">
                    <i class="fas fa-user-slash" style="font-size:32px; display:block; margin-bottom:12px; opacity:0.5;"></i>
                    Aucun employé pour le moment.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div style="margin-top:24px;">
    {{ $employees->links() }}
</div>

@endsection