@extends('layouts.admin')

@section('title', 'Nouveau type de congé')

@section('content')
<h1>➕ Nouveau type</h1>
<form method="POST" action="{{ route('admin.leave-types.store') }}" style="background:#fff; padding:32px; border-radius:12px; max-width:600px;">
    @csrf
    <div style="margin-bottom:16px;">
        <label>Nom *</label>
        <input type="text" name="name" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
    </div>
    <div style="margin-bottom:16px;">
        <label>Jours autorisés *</label>
        <input type="number" name="days_allowed" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
    </div>
    <div style="margin-bottom:16px;">
        <label><input type="checkbox" name="paid" value="1" checked> Congé payé</label>
    </div>
    <button type="submit" style="background:#FF6200; color:#fff; padding:12px 24px; border-radius:8px; border:none;">Créer</button>
</form>
@endsection