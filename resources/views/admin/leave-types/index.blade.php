@extends('layouts.admin')

@section('title', 'Types de congés')

@section('content')
<style>
    .premium-table tr:hover td {
        background-color: #FFF8F2;
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
</style>

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px; display:flex; align-items:center; gap:12px;">
            <span style="background:#FFF0E5; color:#FF6200; width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; font-size:20px;">
                <i class="fas fa-umbrella-beach"></i>
            </span>
            Types de congés
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Gérez les différents motifs d'absence</p>
    </div>
    <a href="{{ route('admin.leave-types.create') }}" style="background:#FF6200; color:#fff; padding:10px 22px; border-radius:100px; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(255,98,0,0.2);">
        <i class="fas fa-plus-circle"></i> Nouveau type
    </a>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#065F46; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

<div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.04); border:1px solid #F3F4F6;">
    <table style="width:100%; border-collapse:collapse;" class="premium-table">
        <thead>
            <tr style="background:#F9FAFB; text-align:left; border-bottom:1px solid #E5E7EB;">
                <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase;">
                    <i class="fas fa-tag" style="margin-right:6px;"></i> Nom
                </th>
                <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase;">
                    <i class="fas fa-calendar-day" style="margin-right:6px;"></i> Jours autorisés
                </th>
                <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase;">
                    <i class="fas fa-check-circle" style="margin-right:6px;"></i> Payé
                </th>
                <th style="padding:14px 20px; font-weight:600; font-size:12px; color:#6B7280; letter-spacing:0.5px; text-transform:uppercase; text-align:right;">
                    <i class="fas fa-cog" style="margin-right:6px;"></i> Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($types as $type)
            <tr style="border-bottom:1px solid #F9FAFB;">
                <td style="padding:14px 20px; font-weight:600;">{{ $type->name }}</td>
                <td style="padding:14px 20px;">{{ $type->days_allowed }}</td>
                <td style="padding:14px 20px;">
                    @if($type->paid)
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#DCFCE7; color:#166534; padding:4px 12px; border-radius:100px; font-size:12px; font-weight:600;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#166534;"></span> Oui
                        </span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#FEE2E2; color:#991B1B; padding:4px 12px; border-radius:100px; font-size:12px; font-weight:600;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#991B1B;"></span> Non
                        </span>
                    @endif
                </td>
                <td style="padding:14px 20px; text-align:right;">
                    <div style="display:flex; justify-content:flex-end; gap:4px;">
                        <a href="{{ route('admin.leave-types.edit', $type) }}" class="action-btn" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.leave-types.destroy', $type) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ce type de congé ?')" class="action-btn delete" style="border:none; cursor:pointer;" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:40px 20px; text-align:center; color:#9CA3AF;">
                    <i class="fas fa-folder-open" style="font-size:32px; display:block; margin-bottom:12px;"></i>
                    Aucun type de congé pour le moment.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:24px;">
    {{ $types->links() }}
</div>
@endsection