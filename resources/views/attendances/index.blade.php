@extends('layouts.admin')

@section('title', 'Pointage')

@section('content')
<style>
    /* ========== DESIGN SYSTEM (identique dashboard) ========== */
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
        --shadow-md: 0 8px 24px rgba(10, 10, 10, 0.05);
        --shadow-lg: 0 16px 40px rgba(255, 98, 0, 0.08);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-full: 9999px;
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    /* ========== HEADER ========== */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
    }
    .page-header::after {
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 150px;
        height: 150px;
        background: var(--primary-glow);
        filter: blur(80px);
        z-index: -1;
        pointer-events: none;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 6px 0;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .page-subtitle {
        color: var(--gray-600);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 15px;
        margin: 0;
    }

    /* ========== ALERTES ========== */
    .alert-success {
        background: #ECFDF5;
        border-left: 4px solid #10B981;
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        margin-bottom: 24px;
        color: #065F46;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }
    .alert-error {
        background: #FEF2F2;
        border-left: 4px solid #EF4444;
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        margin-bottom: 24px;
        color: #991B1B;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    /* ========== BENTO GRID (actions) ========== */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .bento-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 28px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        text-align: center;
        transition: var(--transition-smooth);
    }
    .bento-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .bento-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: var(--primary-light);
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    .bento-card h3 {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        margin: 0 0 8px;
    }
    .bento-card p {
        color: var(--gray-600);
        font-size: 14px;
        margin-bottom: 20px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(10, 10, 10, 0.12), 0 2px 8px var(--primary-glow);
        text-decoration: none;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--primary-glow);
    }
    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-outline {
        background: var(--white);
        color: var(--dark);
        padding: 11px 24px;
        border-radius: var(--radius-full);
        font-family: 'Cabinet Grotesk', sans-serif;
        font-weight: 600;
        font-size: 13px;
        border: 1px solid var(--gray-200);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: var(--transition-smooth);
    }
    .btn-outline:hover {
        background: var(--gray-50);
        border-color: var(--primary-glow);
    }

    /* ========== RÉSUMÉ DU JOUR ========== */
    .summary-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        text-align: center;
        margin-top: 24px;
    }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-user-check" style="color:var(--primary);"></i> Pointage</h1>
        <p class="page-subtitle">Enregistrez votre arrivée et votre départ quotidiens</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert-error animate-in delay-1">
        <i class="fas fa-exclamation-circle" style="color:#EF4444; font-size:18px;"></i>
        {{ session('error') }}
    </div>
@endif

<div class="bento-grid animate-in delay-2">
    <div class="bento-card">
        <div class="bento-icon"><i class="fas fa-sign-in-alt"></i></div>
        <h3>Arrivée</h3>
        <p>Pointer votre heure d'arrivée</p>
        <form method="POST" action="{{ route('attendances.checkin') }}">
            @csrf
            <button type="submit" class="btn-primary" {{ $attendance ? 'disabled' : '' }}>
                <i class="fas fa-sign-in-alt"></i> Pointer l'arrivée
            </button>
        </form>
    </div>
    <div class="bento-card">
        <div class="bento-icon"><i class="fas fa-sign-out-alt"></i></div>
        <h3>Départ</h3>
        <p>Pointer votre heure de départ</p>
        <form method="POST" action="{{ route('attendances.checkout') }}">
            @csrf
            <button type="submit" class="btn-primary" {{ !$attendance || $attendance->check_out ? 'disabled' : '' }}>
                <i class="fas fa-sign-out-alt"></i> Pointer le départ
            </button>
        </form>
    </div>
</div>

<div style="display: flex; gap: 16px; justify-content: center; margin-top: 8px;" class="animate-in delay-3">
    <a href="{{ route('attendances.weekly') }}" class="btn-outline">
        <i class="fas fa-calendar-week"></i> Récap. hebdo
    </a>
    <a href="{{ route('attendances.export-pdf') }}" class="btn-outline">
        <i class="fas fa-download"></i> Exporter PDF
    </a>
</div>

@if($attendance)
    <div class="summary-card animate-in delay-3">
        <p style="color: var(--gray-600); margin: 0;">
            <i class="fas fa-clock" style="color: var(--primary); margin-right: 6px;"></i>
            Aujourd'hui : arrivée à <strong>{{ $attendance->check_in }}</strong>
            @if($attendance->check_out)
                · départ à <strong>{{ $attendance->check_out }}</strong>
            @endif
        </p>
    </div>
@endif

<script>
    function getLocation(callback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    callback(position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    alert('Erreur de géolocalisation : ' + error.message);
                    callback(null, null);
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            alert('La géolocalisation n\'est pas supportée par ce navigateur.');
            callback(null, null);
        }
    }

    document.querySelectorAll('form[action*="check"] button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            getLocation(function(lat, lng) {
                if (lat !== null && lng !== null) {
                    let latInput = document.createElement('input');
                    latInput.type = 'hidden';
                    latInput.name = 'latitude';
                    latInput.value = lat;
                    form.appendChild(latInput);
                    
                    let lngInput = document.createElement('input');
                    lngInput.type = 'hidden';
                    lngInput.name = 'longitude';
                    lngInput.value = lng;
                    form.appendChild(lngInput);
                    
                    form.submit();
                } else {
                    alert('Impossible d\'obtenir votre position. Veuillez autoriser la géolocalisation.');
                }
            });
        });
    });
</script>

<!-- <script>
    function getLocation(callback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => callback(position.coords.latitude, position.coords.longitude),
                error => callback(null, null, error.message)
            );
        } else {
            callback(null, null, "Géolocalisation non supportée");
        }
    }

    document.querySelectorAll('form[action*="check"] button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // on bloque la soumission immédiate
            const form = this.closest('form');
            
            getLocation(function(lat, lng, error) {
                if (lat !== null && lng !== null) {
                    let latInput = document.createElement('input');
                    latInput.type = 'hidden';
                    latInput.name = 'latitude';
                    latInput.value = lat;
                    form.appendChild(latInput);
                    
                    let lngInput = document.createElement('input');
                    lngInput.type = 'hidden';
                    lngInput.name = 'longitude';
                    lngInput.value = lng;
                    form.appendChild(lngInput);
                    
                    form.submit();
                } else {
                    alert('Impossible d\'obtenir votre position. Veuillez autoriser la géolocalisation.');
                }
            });
        });
    });
</script> -->
@endsection