@extends('layouts.admin')

@section('title', 'Pointage')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
    <h1 style="font-family:'Clash Display', sans-serif; font-size:28px;"><i class="fas fa-user-check" style="color:#FF6200;"></i> Pointage</h1>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border-left:4px solid #10B981; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#065F46;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#FEF2F2; border-left:4px solid #EF4444; border-radius:8px; padding:14px 18px; margin-bottom:24px; color:#991B1B;">
        {{ session('error') }}
    </div>
@endif

<div style="display: flex; gap: 24px; justify-content: center; margin-top: 40px;">
    <form method="POST" action="{{ route('attendances.checkin') }}">
        @csrf
        <button type="submit" style="background:#FF6200; color:#fff; padding:14px 32px; border-radius:100px; border:none; font-weight:600; font-size:16px; cursor:pointer;"
                {{ $attendance ? 'disabled' : '' }}>
            <i class="fas fa-sign-in-alt"></i> Pointer l'arrivée
        </button>
    </form>
    <form method="POST" action="{{ route('attendances.checkout') }}">
        @csrf
        <button type="submit" style="background:#FF6200; color:#fff; padding:14px 32px; border-radius:100px; border:none; font-weight:600; font-size:16px; cursor:pointer;"
                {{ !$attendance || $attendance->check_out ? 'disabled' : '' }}>
            <i class="fas fa-sign-out-alt"></i> Pointer le départ
        </button>
    </form>
</div>

@if($attendance)
    <div style="margin-top: 24px; text-align: center; color: #6B6B6B;">
        Aujourd'hui : arrivée à {{ $attendance->check_in }}
        @if($attendance->check_out)
            · départ à {{ $attendance->check_out }}
        @endif
    </div>
@endif

<script>
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
                    // Ajouter les coordonnées au formulaire
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

@endsection