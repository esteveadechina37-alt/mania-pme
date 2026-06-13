@extends('layouts.admin')

@section('title', 'Abonnement')

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 20px rgba(10,10,10,0.05);
        --radius-sm: 6px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s ease;
    }
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 24px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981; border-radius: 8px;
        padding: 10px 14px; margin-bottom: 16px; color: #065F46;
        display: flex; align-items: center; gap: 8px; font-size: 13px;
    }
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .plan-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 20px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        display: flex; flex-direction: column; gap: 16px;
        position: relative; overflow: hidden;
        transition: var(--transition-smooth);
    }
    .plan-card:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(255,98,0,0.08); }
    .plan-card.current {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--primary-light) 0%, var(--white) 50%);
    }
    .plan-name {
        font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700;
        color: var(--dark);
    }
    .plan-price {
        font-family: 'Clash Display', sans-serif; font-size: 28px; font-weight: 700;
        color: var(--primary);
    }
    .plan-price small { font-size: 14px; color: var(--gray-600); }
    .plan-modules { display: flex; flex-wrap: wrap; gap: 4px; }
    .module-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px;
        background: var(--primary-light); color: var(--primary);
        font-size: 11px; font-weight: 600;
    }
    .btn-subscribe {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; border: none; padding: 10px 20px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: var(--transition-smooth);
        margin-top: auto;
    }
    .btn-subscribe:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(255,98,0,0.35); }
    .current-badge {
        position: absolute; top: 12px; right: 12px;
        background: #10B981; color: white;
        padding: 4px 12px; border-radius: 20px;
        font-size: 11px; font-weight: 600;
    }
</style>

<div class="page-header">
    <h1 class="page-title"><i class="fas fa-crown"></i> Abonnement</h1>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="plans-grid">
    @foreach($plans as $plan)
        @php
            $isCurrent = $currentSubscription && $currentSubscription->plan_id == $plan->id;
        @endphp
        <div class="plan-card {{ $isCurrent ? 'current' : '' }}">
            @if($isCurrent)
                <span class="current-badge"><i class="fas fa-check"></i> Actuel</span>
            @endif
            <div>
                <div class="plan-name">{{ $plan->name }}</div>
                @if($plan->description)
                    <p style="font-size:13px; color:var(--gray-600); margin:4px 0 0;">{{ $plan->description }}</p>
                @endif
            </div>
            <div class="plan-price">
                @if($plan->price == 0)
                    Gratuit
                @else
                    {{ number_format($plan->price, 0, ',', ' ') }} <small>FCFA</small>
                    <div style="font-size:12px; color:var(--gray-600);">
                        {{ $plan->billing_period == 'monthly' ? '/mois' : '/an' }}
                    </div>
                @endif
            </div>
            @if($plan->modules->isNotEmpty())
                <div class="plan-modules">
                    @foreach($plan->modules as $mod)
                        <span class="module-badge">{{ $mod->name }}</span>
                    @endforeach
                </div>
            @endif
            @if(!$isCurrent)
                <form method="POST" action="{{ route('admin.company.subscription.subscribe') }}">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <button type="submit" class="btn-subscribe">
                        <i class="fas fa-check-circle"></i> Souscrire
                    </button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection