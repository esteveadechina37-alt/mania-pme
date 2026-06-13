@extends('layouts.admin')

@section('title', "Plans d'abonnement")

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255,98,0,0.08);
        --primary-glow: rgba(255,98,0,0.25);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --shadow-md: 0 8px 20px rgba(10,10,10,0.05);
        --shadow-lg: 0 16px 40px rgba(255,98,0,0.08);
        --radius-sm: 6px;
        --radius-md: 14px;
        --radius-full: 9999px;
        --transition-smooth: 0.3s ease;
    }
    @keyframes fadeSlideUp {
        0% { opacity:0; transform:translateY(12px); }
        100% { opacity:1; transform:translateY(0); }
    }
    @keyframes float {
        0%,100% { transform:translateY(0); }
        50% { transform:translateY(-4px); }
    }
    .animate-in { animation: fadeSlideUp 0.45s ease both; opacity:0; }
    .delay-1 { animation-delay:0.08s; }
    .delay-2 { animation-delay:0.16s; }
    .delay-3 { animation-delay:0.24s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap; gap: 12px;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 24px; font-weight: 700;
        color: var(--dark); margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .page-title i { color: var(--primary); }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 8px 18px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 13px; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; box-shadow: 0 4px 12px rgba(255,98,0,0.25);
        transition: var(--transition-smooth); white-space: nowrap; border: none; cursor: pointer;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }

    .btn-outline-sm {
        background: var(--white); color: var(--dark); padding: 6px 14px;
        border-radius: var(--radius-full); font-weight: 600; font-size: 12px;
        border: 1px solid var(--gray-200); display: inline-flex; align-items: center;
        gap: 4px; text-decoration: none; transition: var(--transition-smooth);
    }
    .btn-outline-sm:hover { background: var(--gray-50); border-color: var(--primary); }

    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .plan-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 18px 20px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        transition: var(--transition-smooth); display: flex; flex-direction: column;
        gap: 14px; position: relative; overflow: hidden;
    }
    .plan-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-3px); border-color: var(--primary); }
    .plan-card::before {
        content:''; position:absolute; inset:0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity:0; transition: var(--transition-smooth);
    }
    .plan-card:hover::before { opacity:1; }
    .plan-header {
        display: flex; align-items: center; justify-content: space-between;
        position: relative; z-index: 1;
    }
    .plan-name {
        font-family: 'Clash Display', sans-serif; font-size: 18px; font-weight: 700;
        color: var(--dark);
    }
    .plan-price {
        font-family: 'Clash Display', sans-serif; font-size: 28px; font-weight: 700;
        color: var(--primary); line-height: 1;
    }
    .plan-price small {
        font-size: 14px; font-weight: 500; color: var(--gray-600);
    }
    .plan-period {
        font-size: 11px; color: var(--gray-600);
    }
    .plan-modules {
        display: flex; flex-wrap: wrap; gap: 6px; position: relative; z-index: 1;
    }
    .module-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px;
        background: var(--primary-light); color: var(--primary);
        font-size: 11px; font-weight: 600;
    }
    .plan-footer {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: auto; position: relative; z-index: 1;
        padding-top: 12px; border-top: 1px solid var(--gray-100);
    }
    .plan-status {
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
    }
    .status-active { background: #DCFCE7; color: #166534; }
    .status-inactive { background: #F3F4F6; color: #4B5563; }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-layer-group"></i> Plans d'abonnement
    </h1>
    <a href="{{ route('super-admin.plans.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nouveau plan
    </a>
</div>

<div class="plans-grid">
    @foreach($plans as $plan)
    <div class="plan-card animate-in delay-1">
        <div class="plan-header">
            <div>
                <div class="plan-name">{{ $plan->name }}</div>
                <div class="plan-period">{{ $plan->billing_period ? ($plan->billing_period == 'monthly' ? 'Mensuel' : 'Annuel') : 'Gratuit' }}</div>
            </div>
            <div class="plan-price">
                @if($plan->price == 0)
                    Gratuit
                @else
                    {{ number_format($plan->price, 0, ',', ' ') }} <small>FCFA</small>
                @endif
            </div>
        </div>
        @if($plan->modules->isNotEmpty())
        <div class="plan-modules">
            @foreach($plan->modules as $module)
                <span class="module-badge"><i class="fas fa-check-circle"></i> {{ $module->name }}</span>
            @endforeach
        </div>
        @else
        <div style="font-size:12px; color:var(--gray-600); position:relative;z-index:1;">Aucun module inclus</div>
        @endif
        <div class="plan-footer">
            <span class="plan-status {{ $plan->is_active ? 'status-active' : 'status-inactive' }}">
                {{ $plan->is_active ? 'Actif' : 'Inactif' }}
            </span>
            <a href="{{ route('super-admin.plans.edit', $plan) }}" class="btn-outline-sm">
                <i class="fas fa-edit"></i> Modifier
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection