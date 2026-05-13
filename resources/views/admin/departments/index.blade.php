@extends('layouts.admin')

@section('title', 'Départements')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
    <div>
        <h1 style="font-family:'Clash Display', sans-serif; font-size:28px;">
            <i class="fas fa-sitemap" style="color:#FF6200; margin-right:8px;"></i> Départements
        </h1>
        <p style="color:#6B6B6B; margin-top:6px;">Gérez les structures de votre entreprise</p>
    </div>
    <a href="{{ route('admin.departments.create') }}" class="btn-primary" style="background:#FF6200; color:#fff; padding:10px 22px; border-radius:100px; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(255,98,0,0.2);">
        <i class="fas fa-plus-circle"></i> Nouveau département
    </a>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#065F46; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
    @forelse($departments as $department)
        <div style="background:#fff; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f1f5f9;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                <div style="width:48px; height:48px; border-radius:14px; background:rgba(255,98,0,0.1); color:#FF6200; display:flex; align-items:center; justify-content:center; font-size:20px;">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h3 style="font-family:'Clash Display', sans-serif; font-size:18px; margin:0;">{{ $department->name }}</h3>
                    <p style="color:#6B6B6B; font-size:13px; margin-top:2px;">{{ $department->employees_count ?? 0 }} employé(s)</p>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:16px;">
                <div style="display:flex; align-items:center; gap:8px; color:#4b5563; font-size:14px;">
                    <i class="fas fa-user-tie" style="color:#FF6200; width:16px; text-align:center;"></i>
                    <span>{{$department->manager && $department->manager->is_active ? $department->manager->name : 'Manager non assigné' }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:8px; color:#4b5563; font-size:14px;">
                    <i class="fas fa-align-left" style="color:#FF6200; width:16px; text-align:center;"></i>
                    <span>{{ Str::limit($department->description ?? 'Aucune description', 60) }}</span>
                </div>
            </div>

            <div style="display:flex; gap:8px; justify-content:flex-end;">
                <a href="{{ route('admin.departments.show', $department) }}" class="icon-btn" title="Voir" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; background:transparent; color:#FF6200; transition:0.2s;">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.departments.edit', $department) }}" class="icon-btn" title="Modifier" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; background:transparent; color:#FF6200; transition:0.2s;">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="button" onclick="openConfirmModal('{{ route('admin.departments.destroy', $department) }}')"
                            style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; background:transparent; color:#dc2626; border:none; cursor:pointer; transition:0.2s;" title="Supprimer">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <!-- <button type="submit" onclick="openConfirmModal('{{ route('admin.departments.destroy', $department) }}')" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; background:transparent; color:#dc2626; border:none; cursor:pointer; transition:0.2s;" title="Supprimer">
                        <i class="fas fa-trash-alt"></i>
                    </button> -->
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1; padding:60px 20px; text-align:center; color:#9CA3AF;">
            <i class="fas fa-folder-open" style="font-size:48px; display:block; margin-bottom:16px;"></i>
            <p style="font-size:16px;">Aucun département créé pour le moment.</p>
        </div>
    @endforelse
</div>

<div style="margin-top:24px;">
    {{ $departments->links() }}
</div>
@endsection