@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-md: 0 8px 24px rgba(10,10,10,0.05);
        --radius-md: 16px;
        --radius-full: 9999px;
    }
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 30px; flex-wrap: wrap; gap: 20px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 30px; font-weight: 700; color: var(--dark);
    }
    .page-subtitle { color: var(--gray-600); font-size: 15px; }
    .notification-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 20px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;
    }
    .notification-card.unread { border-left: 4px solid var(--primary); background: var(--primary-light); }
    .notification-content { flex: 1; }
    .notification-title { font-weight: 700; color: var(--dark); margin-bottom: 4px; }
    .notification-message { color: var(--gray-600); font-size: 14px; }
    .notification-time { font-size: 12px; color: var(--gray-400); margin-top: 6px; }
    .mark-read-btn {
        background: var(--white); color: var(--primary); border: 1px solid var(--primary);
        padding: 6px 14px; border-radius: var(--radius-full); font-size: 12px; font-weight: 600;
        cursor: pointer; transition: all 0.2s;
    }
    .mark-read-btn:hover { background: var(--primary); color: white; }
    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981; border-radius: 8px;
        padding: 14px 18px; margin-bottom: 24px; color: #065F46;
        display: flex; align-items: center; gap: 10px; font-size: 14px;
    }
    .empty-state { text-align: center; padding: 60px 20px; color: var(--gray-600); }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-bell" style="color:var(--primary);"></i> Notifications</h1>
        <p class="page-subtitle">Retrouvez toutes vos notifications</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

@forelse($notifications as $notif)
    <div class="notification-card animate-in delay-1 {{ is_null($notif->read_at) ? 'unread' : '' }}">
        <div class="notification-content">
            <div class="notification-title">{{ $notif->title }}</div>
            <div class="notification-message">{{ $notif->message }}</div>
            <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
        </div>
        @if(is_null($notif->read_at))
            <form method="POST" action="{{ route('notifications.mark-read', $notif) }}">
                @csrf
                <button type="submit" class="mark-read-btn"><i class="fas fa-check"></i> Marquer lue</button>
            </form>
        @endif
    </div>
@empty
    <div class="empty-state">
        <i class="fas fa-bell-slash" style="font-size:48px; display:block; margin-bottom:16px; opacity:0.4;"></i>
        <p>Aucune notification pour le moment.</p>
    </div>
@endforelse

<div style="margin-top: 24px;">
    {{ $notifications->links() }}
</div>
@endsection