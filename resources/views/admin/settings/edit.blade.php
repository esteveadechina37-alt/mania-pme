@extends('layouts.admin')

@section('title', 'Paramètres de l\'entreprise')

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
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 30px; flex-wrap: wrap; gap: 20px; position: relative;
    }
    .page-header::after {
        content: ''; position: absolute; top: -20px; left: 0;
        width: 150px; height: 150px; background: var(--primary-glow);
        filter: blur(80px); z-index: -1; pointer-events: none;
    }
    .page-title {
        font-family: 'Clash Display', sans-serif; font-size: 30px; font-weight: 700; color: var(--dark);
        margin: 0 0 6px 0; line-height: 1.2; letter-spacing: -0.02em;
    }
    .page-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF3D00 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .page-subtitle { color: var(--gray-600); font-family: 'Cabinet Grotesk', sans-serif; font-size: 15px; margin: 0; }

    .alert-success {
        background: #ECFDF5; border-left: 4px solid #10B981; border-radius: var(--radius-sm);
        padding: 14px 18px; margin-bottom: 24px; color: #065F46;
        display: flex; align-items: center; gap: 10px; font-size: 14px;
    }

    /* ========== MAIN LAYOUT ========== */
    .content-grid {
        display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;
    }
    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    /* ========== FORM CARD ========== */
    .form-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 28px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        margin-bottom: 24px; transition: var(--transition-smooth);
    }
    .form-card:hover { box-shadow: var(--shadow-lg); }
    .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 22px; font-weight: 700;
        color: var(--dark); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;
    }
    .card-title i { color: var(--primary); }

    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--gray-800); margin-bottom: 6px; }
    .form-input {
        width: 100%; padding: 10px 14px; border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm); font-size: 14px; background: var(--white);
        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;
        transition: all 0.2s ease;
    }
    .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); }
    .form-input[readonly] { background: var(--gray-100); color: var(--gray-600); }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white; padding: 12px 28px; border-radius: var(--radius-full);
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25); transition: var(--transition-smooth);
        text-decoration: none; font-family: 'Cabinet Grotesk', sans-serif;
    }
    .btn-primary:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }

    .btn-outline {
        background: var(--white); color: var(--dark); padding: 10px 20px;
        border-radius: var(--radius-full); border: 1px solid var(--gray-200);
        font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;
        cursor: pointer; transition: var(--transition-smooth);
    }
    .btn-outline:hover { background: var(--gray-50); border-color: var(--primary); }

    #map { height: 320px; width: 100%; border-radius: var(--radius-sm); margin-bottom: 16px; border: 1px solid var(--gray-200); }
    .range-wrap { display: flex; align-items: center; gap: 12px; }
    .range-wrap input[type=range] { flex: 1; accent-color: var(--primary); }
    .range-value { font-weight: 700; color: var(--primary); min-width: 60px; text-align: right; }

    /* ========== GUIDE CARD ========== */
    .guide-card {
        background: var(--white); border-radius: var(--radius-md);
        padding: 24px; box-shadow: var(--shadow-md); border: 1px solid var(--gray-200);
        position: relative; overflow: hidden; transition: var(--transition-smooth);
    }
    .guide-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
        opacity: 0; transition: var(--transition-smooth);
    }
    .guide-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
    .guide-card:hover::before { opacity: 1; }
    .guide-card .card-title {
        font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700;
        color: var(--dark); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;
        position: relative; z-index: 1;
    }
    .guide-card .card-title i { color: var(--primary); }
    .guide-item {
        display: flex; gap: 12px; margin-bottom: 20px; position: relative; z-index: 1;
    }
    .guide-icon {
        width: 36px; height: 36px; border-radius: var(--radius-sm);
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }
    .guide-text strong {
        font-family: 'Cabinet Grotesk', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--dark); display: block; margin-bottom: 4px;
    }
    .guide-text p { color: var(--gray-600); font-size: 13px; margin: 0; }
</style>

<div class="page-header animate-in">
    <div>
        <h1 class="page-title"><i class="fas fa-building" style="color:var(--primary);"></i> <span>Paramètres de l'entreprise</span></h1>
        <p class="page-subtitle">Définissez l'emplacement de vos locaux et le rayon de pointage autorisé</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success animate-in delay-1">
        <i class="fas fa-check-circle" style="color:#10B981; font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

<div class="content-grid">
    {{-- Colonne gauche : cartes paramètres --}}
    <div class="animate-in delay-1">
        {{-- Carte : Emplacement --}}
        <div class="form-card">
            <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Emplacement des locaux</h3>
            <div style="margin-bottom:12px;">
                <label class="form-label">Rechercher une adresse</label>
                <div style="display:flex; gap:8px;">
                    <input type="text" id="searchInput" class="form-input" placeholder="Ex: Cotonou, Bénin">
                    <button type="button" onclick="searchAddress()" class="btn-outline">
                        <i class="fas fa-search"></i> Chercher
                    </button>
                </div>
            </div>
            <div id="map"></div>
            <div class="form-group">
                <label class="form-label">Latitude</label>
                <input type="text" id="lat" class="form-input" value="{{ old('latitude', $company->latitude) }}" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Longitude</label>
                <input type="text" id="lng" class="form-input" value="{{ old('longitude', $company->longitude) }}" readonly>
            </div>
            <p style="font-size:12px; color:var(--gray-600);">Déplacez le marqueur sur la carte pour ajuster précisément la position.</p>
        </div>

        {{-- Carte : Rayon --}}
        <div class="form-card">
            <h3 class="card-title"><i class="fas fa-bullseye"></i> Rayon de pointage autorisé</h3>
            <div class="range-wrap">
                <input type="range" id="radiusSlider" min="50" max="2000" step="10"
                       value="{{ old('geofence_radius', $company->geofence_radius ?? 200) }}"
                       oninput="document.getElementById('radiusValue').textContent = this.value + ' m'">
                <span class="range-value" id="radiusValue">{{ old('geofence_radius', $company->geofence_radius ?? 200) }} m</span>
            </div>
            <p style="font-size:12px; color:var(--gray-600); margin-top:8px;">
                L'employé doit se trouver dans ce rayon autour du marqueur pour pouvoir pointer.
            </p>
        </div>

        {{-- Formulaire d'enregistrement --}}
        <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="latitude" id="formLat" value="{{ old('latitude', $company->latitude) }}">
            <input type="hidden" name="longitude" id="formLng" value="{{ old('longitude', $company->longitude) }}">
            <input type="hidden" name="geofence_radius" id="formRadius" value="{{ old('geofence_radius', $company->geofence_radius ?? 200) }}">
            <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                <i class="fas fa-save"></i> Enregistrer les paramètres
            </button>
        </form>
    </div>

    {{-- Colonne droite : Guide --}}
    <div class="guide-card animate-in delay-2" style="position: sticky; top: 100px;">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guide des paramètres</h3>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="guide-text">
                <strong>Positionnez votre entreprise</strong>
                <p>Recherchez l'adresse ou déplacez le marqueur sur la carte pour définir l'emplacement exact de vos locaux.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-bullseye"></i></div>
            <div class="guide-text">
                <strong>Définissez le rayon</strong>
                <p>Choisissez la distance maximale à laquelle un employé peut se trouver pour pointer. Plus le rayon est petit, plus le pointage est sécurisé.</p>
            </div>
        </div>
        <div class="guide-item">
            <div class="guide-icon"><i class="fas fa-save"></i></div>
            <div class="guide-text">
                <strong>Enregistrez</strong>
                <p>N'oubliez pas de sauvegarder les modifications. Les paramètres prendront effet immédiatement pour tous les pointages.</p>
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

    marker.on('dragend', function(e) {
        var pos = marker.getLatLng();
        document.getElementById('lat').value = pos.lat.toFixed(7);
        document.getElementById('lng').value = pos.lng.toFixed(7);
        document.getElementById('formLat').value = pos.lat.toFixed(7);
        document.getElementById('formLng').value = pos.lng.toFixed(7);
    });

    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
    document.getElementById('formLat').value = lat;
    document.getElementById('formLng').value = lng;

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
                    document.getElementById('lat').value = newLat.toFixed(7);
                    document.getElementById('lng').value = newLng.toFixed(7);
                    document.getElementById('formLat').value = newLat.toFixed(7);
                    document.getElementById('formLng').value = newLng.toFixed(7);
                } else {
                    alert('Adresse non trouvée.');
                }
            });
    }
</script>
@endpush