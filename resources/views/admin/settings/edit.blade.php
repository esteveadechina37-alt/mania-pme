@extends('layouts.admin')

@section('title', "Paramètres de l'entreprise")

@section('content')
<style>
    :root {
        --primary: #FF6200;
        --primary-hover: #E05500;
        --primary-light: rgba(255, 98, 0, 0.08);
        --dark: #0A0A0A;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-600: #6B7280;
        --white: #FFFFFF;
        --shadow-sm: 0 2px 8px rgba(10,10,10,0.04);
        --radius-sm: 6px;
        --radius-md: 12px;
        --radius-full: 9999px;
    }
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.4s ease both; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 12px; flex-wrap: wrap; gap: 8px;
    }
    .page-title {
        font-size: 20px; font-weight: 700; color: var(--dark);
        margin: 0; display: flex; align-items: center; gap: 6px;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981;
        border-radius: 6px; padding: 8px 12px; margin-bottom: 12px;
        font-size: 12px; display: flex; align-items: center; gap: 6px; color: #065F46;
    }
    .content-grid {
        display: grid; grid-template-columns: 1fr 240px;
        gap: 12px; align-items: start;
    }
    @media (max-width: 800px) { .content-grid { grid-template-columns: 1fr; } }

    .form-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px 16px; box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200); margin-bottom: 10px;
    }
    .card-title {
        font-size: 14px; font-weight: 700; color: var(--dark);
        margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .card-title i { color: var(--primary); }

    .form-group { margin-bottom: 10px; }
    .form-label {
        font-size: 11px; font-weight: 600; color: var(--dark);
        margin-bottom: 3px; display: flex; align-items: center; gap: 4px;
    }
    .form-label i { color: var(--primary); font-size: 12px; }
    .form-input {
        width: 100%; padding: 6px 10px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 12px;
        background: var(--white); color: var(--dark);
        transition: 0.2s; outline: none;
    }
    .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 2px var(--primary-light); }
    .form-input[readonly] { background: var(--gray-50); color: var(--gray-600); }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 8px 16px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 12px; border: none; cursor: pointer;
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px;
        box-shadow: 0 3px 8px rgba(255,98,0,0.2); transition: 0.2s;
    }
    .btn-primary:hover { transform: translateY(-1px); }

    .btn-outline {
        background: var(--white); color: var(--dark); padding: 6px 12px;
        border-radius: var(--radius-full); border: 1px solid var(--gray-200);
        font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;
        cursor: pointer; transition: 0.2s;
    }
    .btn-outline:hover { background: var(--gray-50); border-color: var(--primary); }

    #map { height: 220px; width: 100%; border-radius: var(--radius-sm); margin-bottom: 10px; border: 1px solid var(--gray-200); }
    .range-wrap { display: flex; align-items: center; gap: 10px; font-size: 12px; }
    .range-wrap input[type=range] { flex: 1; accent-color: var(--primary); }
    .range-value { font-weight: 700; color: var(--primary); min-width: 50px; text-align: right; }

    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 14px; box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        position: sticky; top: 60px;
    }
    .guide-card h3 {
        font-size: 13px; font-weight: 700; color: var(--dark);
        margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
    }
    .guide-card h3 i { color: var(--primary); font-size: 14px; }
    .guide-item { display: flex; gap: 6px; margin-bottom: 8px; font-size: 11px; }
    .guide-item:last-child { margin-bottom: 0; }
    .guide-icon {
        width: 24px; height: 24px; border-radius: 5px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }
    .guide-text strong { font-size: 12px; display: block; margin-bottom: 2px; }
    .guide-text p { color: var(--gray-600); margin: 0; line-height: 1.3; }
</style>

<div class="page-header animate-in">
    <h1 class="page-title">
        <i class="fas fa-building" style="color:var(--primary)"></i>
        <span>Paramètres de l'entreprise</span>
    </h1>
</div>

@if(session('success'))
    <div class="alert-success animate-in">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="content-grid">
    <div>
        {{-- Carte principale (infos de l'entreprise + carte + rayon) --}}
        <div class="form-card animate-in delay-1">
            <h3 class="card-title"><i class="fas fa-building"></i> Informations de l'entreprise</h3>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <div class="form-group" style="flex:1; min-width:150px;">
                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                    <input type="text" name="address" form="settingsForm" class="form-input" 
                           value="{{ old('address', $company->address) }}" placeholder="Rue, quartier...">
                </div>
                <div class="form-group" style="flex:1; min-width:120px;">
                    <label class="form-label"><i class="fas fa-city"></i> Ville</label>
                    <input type="text" name="city" form="settingsForm" class="form-input" 
                           value="{{ old('city', $company->city) }}" placeholder="Ex: Cotonou">
                </div>
            </div>

            <h3 class="card-title" style="margin-top:12px;"><i class="fas fa-map-pin"></i> Emplacement & périmètre</h3>
            <div style="display:flex; gap:8px; margin-bottom:10px;">
                <input type="text" id="searchInput" class="form-input" placeholder="Rechercher une adresse…">
                <button type="button" onclick="searchAddress()" class="btn-outline">
                    <i class="fas fa-search"></i> Chercher
                </button>
            </div>
            <div id="map"></div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-crosshairs"></i> Coordonnées GPS</label>
                <div style="display:flex; gap:8px;">
                    <input type="text" id="lat" class="form-input" value="{{ old('latitude', $company->latitude) }}" readonly>
                    <input type="text" id="lng" class="form-input" value="{{ old('longitude', $company->longitude) }}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-bullseye"></i> Rayon autorisé</label>
                <div class="range-wrap">
                    <input type="range" id="radiusSlider" min="50" max="2000" step="10"
                           value="{{ old('geofence_radius', $company->geofence_radius ?? 200) }}"
                           oninput="document.getElementById('radiusValue').textContent = this.value + ' m'">
                    <span class="range-value" id="radiusValue">{{ old('geofence_radius', $company->geofence_radius ?? 200) }} m</span>
                </div>
                <p style="font-size:10px; color:var(--gray-600); margin-top:4px;">
                    Distance maximale autour du marqueur pour accepter un pointage.
                </p>
            </div>
        </div>

        {{-- Formulaire d'enregistrement --}}
        <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="latitude" id="formLat" value="{{ old('latitude', $company->latitude) }}">
            <input type="hidden" name="longitude" id="formLng" value="{{ old('longitude', $company->longitude) }}">
            <input type="hidden" name="geofence_radius" id="formRadius" value="{{ old('geofence_radius', $company->geofence_radius ?? 200) }}">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Enregistrer les paramètres
            </button>
        </form>
    </div>

    {{-- Guide compact --}}
    <div class="guide-card animate-in delay-2">
        <h3><i class="fas fa-lightbulb"></i> Guide</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-building"></i></div>
            <div class="guide-text">
                <strong>Adresse et ville</strong>
                <p>Utilisées sur les bulletins et attestations.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="guide-text">
                <strong>Position GPS</strong>
                <p>Déplacez le marqueur ou cherchez une adresse.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-bullseye"></i></div>
            <div class="guide-text">
                <strong>Rayon</strong>
                <p>Pointage impossible au‑delà de cette distance.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var lat = {{ $company->latitude ?? 6.4834 }};
    var lng = {{ $company->longitude ?? 2.6316 }};
    var map = L.map('map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker = L.marker([lat, lng], { draggable: true }).addTo(map)
        .bindPopup('Position de l\'entreprise').openPopup();

    function updateCoordinates(pos) {
        document.getElementById('lat').value = pos.lat.toFixed(7);
        document.getElementById('lng').value = pos.lng.toFixed(7);
        document.getElementById('formLat').value = pos.lat.toFixed(7);
        document.getElementById('formLng').value = pos.lng.toFixed(7);
    }

    marker.on('dragend', function(e) {
        updateCoordinates(marker.getLatLng());
    });

    updateCoordinates(marker.getLatLng());

    document.getElementById('radiusSlider').addEventListener('input', function() {
        document.getElementById('formRadius').value = this.value;
    });

    function searchAddress() {
        var query = document.getElementById('searchInput').value;
        if (!query) return;
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    var first = data[0];
                    var newLat = parseFloat(first.lat);
                    var newLng = parseFloat(first.lon);
                    map.setView([newLat, newLng], 16);
                    marker.setLatLng([newLat, newLng]);
                    updateCoordinates(marker.getLatLng());
                } else {
                    alert('Adresse non trouvée.');
                }
            });
    }
</script>
@endpush