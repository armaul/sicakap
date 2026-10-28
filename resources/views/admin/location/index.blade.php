@extends('layouts.app')

@section('title', 'Setting Pembatasan Lokasi Maps - SICAKAP')

@section('content')
<!-- Leaflet Core Stylesheet (Directly loaded to guarantee tile rendering) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
    /* ==========================================================================
       Leaflet Map Core Tile & Layer Fixes (Prevents broken image grids)
       ========================================================================== */
    .leaflet-pane,
    .leaflet-tile,
    .leaflet-marker-icon,
    .leaflet-marker-shadow,
    .leaflet-tile-container,
    .leaflet-layer {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
    }
    .leaflet-tile {
        visibility: hidden;
        max-width: none !important;
        max-height: none !important;
        width: 256px !important;
        height: 256px !important;
        user-select: none;
        -webkit-user-select: none;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
    }
    .leaflet-tile-loaded {
        visibility: inherit !important;
    }
    .leaflet-container {
        font-family: inherit !important;
        background: #0f172a !important;
        outline: none !important;
    }

    /* ==========================================================================
       Location Settings Custom Styling (Glassmorphism Dark Theme)
       ========================================================================== */
    .loc-wrapper {
        max-width: 1240px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    .loc-card {
        background: rgba(30, 41, 59, 0.75);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    .loc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .loc-title-group {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .loc-title-icon {
        width: 46px;
        height: 46px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.45);
        color: #fff;
        flex-shrink: 0;
    }

    .loc-grid {
        display: grid;
        grid-template-columns: 460px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .loc-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Form Elements */
    .loc-field {
        margin-bottom: 1.15rem;
    }

    .loc-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #cbd5e1;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .loc-input {
        width: 100%;
        background: rgba(15, 23, 42, 0.9) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 8px !important;
        padding: 0.75rem 1rem !important;
        color: #f8fafc !important;
        font-size: 0.95rem !important;
        font-family: inherit !important;
        box-sizing: border-box !important;
        transition: all 0.2s ease !important;
    }

    .loc-input:focus {
        outline: none !important;
        border-color: #818cf8 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3) !important;
        background: rgba(15, 23, 42, 1) !important;
    }

    .loc-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.35rem;
        line-height: 1.4;
    }

    /* Switch Component */
    .loc-toggle-box {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
    }

    .switch-ui {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
        flex-shrink: 0;
    }

    .switch-ui input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider-ui {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #334155;
        transition: .3s;
        border-radius: 34px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .slider-ui:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: #ffffff;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }

    input:checked + .slider-ui {
        background: linear-gradient(135deg, #10b981, #059669);
        border-color: #10b981;
    }

    input:checked + .slider-ui:before {
        transform: translateX(22px);
    }

    /* Radius Slider & Badge */
    .radius-control-row {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-top: 0.25rem;
    }

    .range-input {
        flex: 1;
        accent-color: #6366f1;
        cursor: pointer;
        height: 8px;
        background: #1e293b;
        border-radius: 4px;
    }

    .radius-pill {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-weight: 800;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        box-shadow: 0 3px 10px rgba(79, 70, 229, 0.4);
    }

    /* Preset Chips */
    .chip-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-top: 0.65rem;
    }

    .chip-btn {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #cbd5e1;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-size: 0.775rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .chip-btn:hover {
        background: rgba(99, 102, 241, 0.25);
        border-color: #818cf8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .chip-btn.active {
        background: #4f46e5;
        border-color: #6366f1;
        color: #fff;
    }

    /* Action Buttons */
    .btn-save-loc {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 0.85rem 1.6rem !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.6rem !important;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4) !important;
        transition: all 0.2s ease !important;
        width: 100%;
        justify-content: center;
    }

    .btn-save-loc:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 22px rgba(79, 70, 229, 0.6) !important;
    }

    .btn-action-sm {
        background: rgba(56, 189, 248, 0.15);
        border: 1px solid rgba(56, 189, 248, 0.35);
        color: #38bdf8;
        padding: 0.45rem 0.85rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
    }

    .btn-action-sm:hover {
        background: rgba(56, 189, 248, 0.25);
        color: #fff;
    }

    /* Map Card Container */
    #mapPreview {
        height: 520px;
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.4);
        position: relative;
        z-index: 5;
    }

    .leaflet-popup-content-wrapper {
        background: #0f172a !important;
        color: #f8fafc !important;
        border-radius: 8px !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.6) !important;
    }
    .leaflet-popup-tip {
        background: #0f172a !important;
    }
</style>

<div class="loc-wrapper">

    <!-- Top Header -->
    <div class="loc-header">
        <div class="loc-title-group">
            <div class="loc-title-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <h1 style="font-size:1.55rem; font-weight:800; color:#ffffff; margin:0; line-height:1.2;">
                    Setting Pembatasan Lokasi Maps (Geofencing)
                </h1>
                <p style="color:#94a3b8; font-size:0.875rem; margin-top:4px;">
                    Konfigurasikan titik koordinat pusat sekolah dan batas radius absensi satpam & caraka.
                </p>
            </div>
        </div>

        <a href="{{ route('dashboard') }}" class="btn-action-sm" style="background:rgba(255,255,255,0.06); border-color:rgba(255,255,255,0.15); color:#cbd5e1; text-decoration:none;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Alert Flash Notifications -->
    @if(session('success'))
        <div style="background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.4); color:#34d399; padding:0.9rem 1.25rem; border-radius:10px; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.75rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div><strong>Berhasil Disimpan!</strong> {{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.4); color:#f87171; padding:0.9rem 1.25rem; border-radius:10px; margin-bottom:1.5rem;">
            <strong>Terdapat kesalahan input:</strong>
            <ul style="margin:0.4rem 0 0 1.25rem; font-size:0.85rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Grid: Left Form, Right Map -->
    <div class="loc-grid">

        <!-- Left Form Card -->
        <div class="loc-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.05rem; font-weight:700; color:#ffffff; margin:0; display:flex; align-items:center; gap:0.5rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Parameter Lokasi & Radius
                </h3>
            </div>

            <form action="{{ route('admin.location.update') }}" method="POST" id="locationForm">
                @csrf

                <!-- Toggle Switch -->
                <div class="loc-toggle-box">
                    <label class="switch-ui">
                        <input type="checkbox" name="is_enabled" value="1" id="isEnabledToggle" {{ $settings['is_enabled'] ? 'checked' : '' }}>
                        <span class="slider-ui"></span>
                    </label>
                    <div style="flex:1;">
                        <div style="font-weight:700; color:#f8fafc; font-size:0.95rem;">
                            Aktifkan Pembatasan Radius
                        </div>
                        <div style="font-size:0.775rem; color:#94a3b8; margin-top:2px;">
                            Jika aktif, pegawai di luar radius <span style="color:#f87171; font-weight:700;">DITOLAK</span> saat absen. Jika nonaktif, absen diizinkan bebas.
                        </div>
                    </div>
                </div>

                <!-- Nama Kantor -->
                <div class="loc-field">
                    <label class="loc-label" for="office_name">Nama Titik / Sekolah</label>
                    <input type="text" name="office_name" id="office_name" class="loc-input" value="{{ old('office_name', $settings['office_name']) }}" required placeholder="Contoh: SMKN 1 Jatisari (Kampus Utama)">
                    <div class="loc-hint">Label nama lokasi yang dicatat pada riwayat absensi pegawai.</div>
                </div>

                <!-- Koordinat Grid -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                    <div class="loc-field">
                        <label class="loc-label" for="latitude">Latitude (Lintang)</label>
                        <input type="number" step="any" name="latitude" id="latitude" class="loc-input" value="{{ old('latitude', $settings['latitude']) }}" required placeholder="-6.3655">
                    </div>
                    <div class="loc-field">
                        <label class="loc-label" for="longitude">Longitude (Bujur)</label>
                        <input type="number" step="any" name="longitude" id="longitude" class="loc-input" value="{{ old('longitude', $settings['longitude']) }}" required placeholder="107.5312">
                    </div>
                </div>

                <!-- Action GPS & Reset Button -->
                <div style="display:flex; flex-wrap:wrap; gap:0.5rem; margin-bottom:1.25rem;">
                    <button type="button" class="btn-action-sm" onclick="getCurrentAdminLocation()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="12 8 8 12 12 16 12 8"/></svg>
                        Gunakan GPS Saya Saat Ini
                    </button>
                    <button type="button" class="chip-btn" onclick="setPresetSMKN1()">
                        📍 Reset ke SMKN 1 Jatisari
                    </button>
                </div>

                <!-- Radius Slider & Input -->
                <div class="loc-field">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem;">
                        <label class="loc-label" for="radius_meters" style="margin-bottom:0;">Batas Maksimal Radius</label>
                        <span class="radius-pill" id="radiusBadgeVal">{{ $settings['radius_meters'] }} Meter</span>
                    </div>

                    <div class="radius-control-row">
                        <input type="range" class="range-input" id="radiusSlider" min="20" max="1000" step="10" value="{{ old('radius_meters', $settings['radius_meters']) }}">
                        <input type="number" name="radius_meters" id="radius_meters" class="loc-input" style="width:90px; text-align:center; font-weight:700; padding:0.5rem !important;" value="{{ old('radius_meters', $settings['radius_meters']) }}" min="10" max="100000" required>
                    </div>

                    <!-- Preset Chips -->
                    <div class="chip-group">
                        <span style="font-size:0.75rem; color:#94a3b8; align-self:center;">Preset:</span>
                        <button type="button" class="chip-btn" onclick="setRadiusPreset(50)">50m (Ketat)</button>
                        <button type="button" class="chip-btn" onclick="setRadiusPreset(100)">100m (Standar)</button>
                        <button type="button" class="chip-btn" onclick="setRadiusPreset(200)">200m (Luas)</button>
                        <button type="button" class="chip-btn" onclick="setRadiusPreset(500)">500m (Kompleks)</button>
                    </div>
                    <div class="loc-hint">Lingkaran biru pada peta menunjukkan area toleransi geofence kehadiran.</div>
                </div>

                <!-- Submit Button -->
                <div style="margin-top:1.5rem; padding-top:1.25rem; border-top:1px solid rgba(255,255,255,0.1);">
                    <button type="submit" class="btn-save-loc">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Pengaturan Radius
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Map Preview Card -->
        <div class="loc-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <h3 style="font-size:1.05rem; font-weight:700; color:#ffffff; margin:0; display:flex; align-items:center; gap:0.5rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                    Pratinjau Peta Interaktif
                </h3>
                <span style="font-size:0.75rem; padding:0.25rem 0.65rem; border-radius:20px; background:rgba(99,102,241,0.2); color:#a5b4fc; font-weight:600; border:1px solid rgba(165,180,252,0.3);">
                    Geser Pin / Klik Peta untuk Pindah
                </span>
            </div>

            <!-- Leaflet Canvas -->
            <div id="mapPreview"></div>

            <div style="margin-top:1rem; background:rgba(15,23,42,0.65); border:1px solid rgba(255,255,255,0.1); border-radius:10px; padding:0.85rem 1.15rem; font-size:0.8rem; color:#94a3b8; line-height:1.5;">
                <div style="display:flex; align-items:center; gap:0.5rem; color:#fde68a; font-weight:700; margin-bottom:0.25rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    Panduan Akurasi GPS Geofencing
                </div>
                Sistem menghitung jarak posisi pegawai menggunakan formula matematis <strong>Haversine</strong>. Akurasi GPS smartphone rata-rata &plusmn;5 s/d 20 meter. Direkomendasikan mengatur radius minimal <strong>50 &ndash; 100 meter</strong> agar personil di pos gerbang luar atau belakang gedung sekolah tidak terblokir saat sinyal satelit berfluktuasi.
            </div>
        </div>

    </div>

</div>

<!-- Leaflet JS Loaded directly -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.3655;
    const defaultLng = parseFloat(document.getElementById('longitude').value) || 107.5312;
    const initialRadius = parseInt(document.getElementById('radius_meters').value) || 100;

    // 1. Inisialisasi Map Leaflet
    const map = L.map('mapPreview', {
        zoomControl: true,
        scrollWheelZoom: true
    }).setView([defaultLat, defaultLng], 17);

    // Tile Layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors | SICAKAP'
    }).addTo(map);

    // 2. Custom Marker
    const redIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    let marker = L.marker([defaultLat, defaultLng], {
        icon: redIcon,
        draggable: true,
        title: 'Geser pin ini untuk memindahkan titik pusat'
    }).addTo(map);

    marker.bindPopup(`<strong>${document.getElementById('office_name').value || 'Pusat Sekolah'}</strong><br>Titik Pusat Absensi`).openPopup();

    // 3. Geofence Circle Overlay (Lingkaran Radius)
    let circle = L.circle([defaultLat, defaultLng], {
        color: '#6366f1',
        fillColor: '#818cf8',
        fillOpacity: 0.28,
        radius: initialRadius,
        weight: 2
    }).addTo(map);

    // Helper: Update Input form dari marker
    function updateInputs(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
        circle.setLatLng([lat, lng]);
    }

    // Drag Marker Event
    marker.on('dragend', function (e) {
        const pos = e.target.getLatLng();
        updateInputs(pos.lat, pos.lng);
        map.panTo([pos.lat, pos.lng]);
    });

    // Click Map Event: Pindahkan marker ke titik klik
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng.lat, e.latlng.lng);
        map.panTo(e.latlng);
    });

    // 4. Sinkronisasi Slider Radius & Input Angka
    const radiusSlider = document.getElementById('radiusSlider');
    const radiusInput = document.getElementById('radius_meters');
    const radiusBadge = document.getElementById('radiusBadgeVal');

    function syncRadius(val) {
        val = parseInt(val) || 50;
        radiusSlider.value = val;
        radiusInput.value = val;
        radiusBadge.textContent = val + ' Meter';
        circle.setRadius(val);
    }

    radiusSlider.addEventListener('input', function () {
        syncRadius(this.value);
    });

    radiusInput.addEventListener('input', function () {
        syncRadius(this.value);
    });

    // Global preset helper
    window.setRadiusPreset = function(meters) {
        syncRadius(meters);
    };

    window.setPresetSMKN1 = function() {
        const lat = -6.3655;
        const lng = 107.5312;
        marker.setLatLng([lat, lng]);
        updateInputs(lat, lng);
        map.setView([lat, lng], 17);
        document.getElementById('office_name').value = 'SMKN 1 Jatisari (Kampus Utama)';
        marker.setPopupContent('<strong>SMKN 1 Jatisari (Kampus Utama)</strong><br>Titik Pusat Absensi').openPopup();
    };

    // 5. GPS Current Location Admin
    window.getCurrentAdminLocation = function () {
        if (!navigator.geolocation) {
            Swal.fire({
                icon: 'warning',
                title: 'GPS Tidak Didukung',
                text: 'Peramban Anda tidak mendukung sensor Geolocation.',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }

        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span>⏳ Mendeteksi...</span>';
        btn.disabled = true;

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const acc = Math.round(pos.coords.accuracy);

                marker.setLatLng([lat, lng]);
                updateInputs(lat, lng);
                map.setView([lat, lng], 18);

                btn.innerHTML = originalText;
                btn.disabled = false;

                Swal.fire({
                    icon: 'success',
                    title: 'GPS Ditemukan!',
                    html: `Koordinat: <strong>${lat.toFixed(6)}, ${lng.toFixed(6)}</strong><br><small style="color:#94a3b8;">Akurasi perangkat: ±${acc}m</small>`,
                    confirmButtonColor: '#10b981'
                });
            },
            function (err) {
                btn.innerHTML = originalText;
                btn.disabled = false;
                Swal.fire({
                    icon: 'error',
                    title: 'GPS Gagal Didapatkan',
                    text: 'Pastikan izin akses lokasi diizinkan di browser Anda.',
                    confirmButtonColor: '#ef4444'
                });
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    };

    // Form change on office name
    document.getElementById('office_name').addEventListener('input', function () {
        marker.setPopupContent(`<strong>${this.value || 'Pusat Sekolah'}</strong><br>Titik Pusat Absensi`);
    });

    // Invalidate map size multiple times to ensure perfect rendering after container layout completes
    setTimeout(() => { map.invalidateSize(); }, 200);
    setTimeout(() => { map.invalidateSize(); }, 600);
    setTimeout(() => { map.invalidateSize(); }, 1200);
    window.addEventListener('resize', () => { map.invalidateSize(); });
});
</script>
@endsection
