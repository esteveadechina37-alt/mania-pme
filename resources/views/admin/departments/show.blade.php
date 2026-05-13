@extends('layouts.admin')

@section('title', $department->name)

@section('content')
<style>
    .card-premium {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }
    .icon-circle-lg {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: linear-gradient(135deg, #FF6200, #FF8C42);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        box-shadow: 0 12px 20px -8px rgba(255,98,0,0.3);
    }
    .info-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .info-row:last-child { border-bottom: none; }
    .info-icon {
        width: 38px;
        height: 38px;
        background: rgba(255,98,0,0.08);
        color: #FF6200;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
        background: #eff6ff;
        color: #2563eb;
    }
    .member-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .member-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .member-item:last-child { border-bottom: none; }
    .avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #FF6200, #FF8C42);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }
    .btn-primary {
        background: #FF6200;
        color: #fff;
        padding: 10px 24px;
        border-radius: 100px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: all 0.2s;
    }
    .btn-primary:hover { background: #e55800; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(255,98,0,0.35); }
    .btn-outline {
        background: #fff;
        color: #374151;
        padding: 10px 24px;
        border-radius: 100px;
        border: 1px solid #e5e7eb;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-outline:hover { background: #f9fafb; border-color: #d1d5db; }
    .empty-state {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 20px 0;
        color: #6B6B6B;
        font-size: 14px;
    }
</style>

{{-- En-tête avec icône et actions --}}
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; flex-wrap: wrap; gap: 20px;">
    <div style="display: flex; align-items: center; gap: 16px;">
        <div class="icon-circle-lg">
            <i class="fas fa-building"></i>
        </div>
        <div>
            <h1 style="font-family:'Clash Display', sans-serif; font-size: 30px; margin: 0; letter-spacing: -0.5px;">
                {{ $department->name }}
            </h1>
            <p style="color: #6B6B6B; margin-top: 4px;">{{ $department->employees->count() }} employé(s)</p>
        </div>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.departments.edit', $department) }}" class="btn-primary">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <a href="{{ route('admin.departments.index') }}" class="btn-outline">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

{{-- Grille des cartes --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">

    {{-- Carte informations principales --}}
    <div class="card-premium">
        <h3 style="font-family:'Clash Display', sans-serif; font-size: 20px; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
            <span style="background: rgba(255,98,0,0.1); color: #FF6200; padding: 8px 12px; border-radius: 10px;">
                <i class="fas fa-clipboard-list"></i>
            </span>
            Informations
        </h3>

        <div class="info-row">
            <div class="info-icon"><i class="fas fa-align-left"></i></div>
            <div>
                <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Description</div>
                <div style="font-weight: 600;">{{ $department->description ?? 'Aucune description' }}</div>
            </div>
        </div>

        <div class="info-row">
            <div class="info-icon"><i class="fas fa-user-tie"></i></div>
            <div>
                <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Manager</div>
                <div style="font-weight: 600;">
                    @if($department->manager && $department->manager->is_active)
                        <span class="badge-pill"><i class="fas fa-user-check"></i> {{ $department->manager->name }}</span>
                    @else
                        <span style="color: #9ca3af;">Non assigné</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="info-row">
            <div class="info-icon"><i class="fas fa-users"></i></div>
            <div>
                <div style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Effectif</div>
                <div style="font-weight: 600;">{{ $department->employees->count() }} personne(s)</div>
            </div>
        </div>
    </div>

    {{-- Carte liste des membres --}}
    <div class="card-premium">
        <h3 style="font-family:'Clash Display', sans-serif; font-size: 20px; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
            <span style="background: rgba(255,98,0,0.1); color: #FF6200; padding: 8px 12px; border-radius: 10px;">
                <i class="fas fa-user-friends"></i>
            </span>
            Membres
        </h3>

        @if($department->employees->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user-slash" style="color: #9ca3af; font-size: 24px;"></i>
                <span>Aucun employé dans ce département.</span>
            </div>
        @else
            <ul class="member-list">
                @foreach($department->employees as $employee)
                    <li class="member-item">
                        <div class="avatar-sm">
                            {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                        </div>
                        <div style="flex: 1; font-weight: 600;">{{ $employee->user->name }}</div>
                        <span style="font-size: 12px; color: #64748b;">{{ $employee->position ?? '' }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection