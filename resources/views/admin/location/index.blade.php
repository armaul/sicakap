@extends('layouts.app')

@section('title', 'Setting Pembatasan Lokasi Maps - SICAKAP')

@push('styles')
<!-- Leaflet CSS for Interactive OpenStreetMap (Free, No API Key Required) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .location-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 0.825rem;
        font-weight: 600;
        color: #cbd5e1;
        margin-bottom: 0.45rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        width: 100%;
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: #f8fafc;
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        background: rgba(15, 23, 42, 0.95);
    }

    .input-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.35rem;
    }

    /* Slider Style */
    .radius-slider-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .radius-slider {
        flex: 1;
        accent-color: #6366f1;
        cursor: pointer;
        height: 6px;
    }

    .radius-badge-val {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
        min-width: 90px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
    }

    /* Preset Buttons */
    .preset-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.6rem;
    }

    .btn-preset {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #cbd5e1;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-preset:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #818cf8;
        color: #fff;
    }

    /* Map Box */
    #mapPreview {
        height: 520px;
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        z-index: 10;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    /* Custom Switch Toggle */
    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 0.9rem 1.1rem;
        margin-bottom: 1.5rem;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
        flex-shrink: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider-toggle {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #475569;
        transition: .3s;
        border-radius: 34px;
    }

    .slider-toggle:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider-toggle {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    input:checked + .slider-toggle:before {
        transform: translateX(22px);
    }

    .btn-save-loc {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border: none;
        padding: 0.9rem 1.8rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.2s;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
    }

    .btn-save-loc:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.6);
    }

    .btn-gps-current {
        background: rgba(56, 189, 248, 0.15);
        border: 1px solid rgba(56, 189, 248, 0.35);
        color: #38bdf8;
        padding: 0.45rem 0.9rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.4rem;
        transition: all 0.2s;
    }

    .btn-gps-current:hover {
        background: rgba(56, 189, 248, 0.25);
        color: #fff;
    }

    .leaflet-popup-content-wrapper {
        background: #0f172a !important;
        color: #f8fafc !important;
        border-radius: 8px !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
    }
    .leaflet-popup-tip {
        background: #0f172a !important;
    }
</style>
@endpush

@section('content')
<div class="container" style="max-width: 1200px; padding: 2rem 1rem;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(79,70,229,0.4);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:white;"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h1 style="font-size: 1.6rem; font-weight: 800; color: #f8fafc; margin: 0; line-height: 1.2;">
                        Setting Pembatasan Lokasi Maps (Geofencing)
                    </h1>
                    <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">
                        Atur titik koordinat pusat sekolah dan batasan radius GPS absensi masuk & pulang satpam / caraka.
                    </p>
                </div>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="btn-preset" style="padding: 0.5rem 1rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <!-- Alert Flash Notifications -->
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div><strong>Sukses!</strong> {{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem;">
            <strong>Terdapat kesalahan pengisian data:</strong>
            <ul style="margin: 0.5rem 0 0 1.25rem; font-size: 0.85rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Grid: Form Left, Map Right -->
    <div style="display: grid; grid-template-columns: 1fr 1.35fr; gap: 1.5rem; align-items: start;">
        
        <!-- Form Settings Card -->
        <div class="location-card">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #f8fafc; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Parameter Koordinat & Radius
            </h3>

            <form action="{{ route('admin.location.update') }}" method="POST" id="locationForm">
                @csrf

                <!-- Toggle Aktifkan Pembatasan -->
                <div class="toggle-wrapper">
                    <label class="switch">
                        <input type="checkbox" name="is_enabled" value="1" id="isEnabledToggle" {{ $settings['is_enabled'] ? 'checked' : '' }}>
                        <span class="slider-toggle"></span>
                    </label>
                    <div>
                        <div style="font-weight: 700; color: #f8fafc; font-size: 0.95rem;">Aktifkan Pembatasan Radius</div>
                        <div style="font-size: 0.78rem; color: #94a3b8;">
                            Jika aktif, pegawai di luar radius <strong style="color:#ef4444;">DITOLAK</strong> saat absen. Jika nonaktif, absen diizinkan dari mana saja.
                        </div>
                    </div>
                </div>

                <!-- Nama Lokasi / Kantor -->
                <div class="form-group">
                    <label class="form-label" for="office_name">Nama Lokasi / Kantor Pusat</label>
                    <input type="text" name="office_name" id="office_name" class="form-control" value="{{ old('office_name', $settings['office_name']) }}" required placeholder="Contoh: SMKN 1 Jatisari">
                    <div class="input-hint">Nama area/gedung yang akan ditampilkan pada informasi GPS absensi pegawai.</div>
                </div>

                <!-- Koordinat Grid: Latitude & Longitude -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div class="form-group">
                        <label class="form-label" for="latitude">Latitude (Lintang)</label>
                        <input type="number" step="any" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $settings['latitude']) }}" required placeholder="-6.3655">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="longitude">Longitude (Bujur)</label>
                        <input type="number" step="any" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $settings['longitude']) }}" required placeholder="107.5312">
                    </div>
                </div>

                <!-- Tombol Ambil GPS Saya & Preset -->
                <div style="margin-bottom: 1.25rem;">
                    <button type="button" class="btn-gps-current" onclick="getCurrentAdminLocation()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="12 8 8 12 12 16 12 8"/></svg>
                        Gunakan Titik GPS Perangkat Saya Sekarang
                    </button>
                    <button type="button" class="btn-preset" onclick="setPresetSMKN1()" style="margin-top: 0.4rem; margin-left: 0.35rem;">
                        📍 Reset ke SMKN 1 Jatisari
                    </button>
                    <div class="input-hint">Anda juga bisa <strong>klik atau geser pin marker</strong> langsung pada peta di sebelah kanan.</div>
                </div>

                <!-- Radius Slider & Input -->
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.45rem;">
                        <label class="form-label" for="radius_meters" style="margin-bottom: 0;">Radius Maksimal (Meter)</label>
                        <span class="radius-badge-val" id="radiusBadgeVal">{{ $settings['radius_meters'] }} Meter</span>
                    </div>

                    <div class="radius-slider-wrapper">
                        <input type="range" class="radius-slider" id="radiusSlider" min="20" max="1000" step="10" value="{{ old('radius_meters', $settings['radius_meters']) }}">
                        <input type="number" name="radius_meters" id="radius_meters" class="form-control" style="width: 100px; text-align: center; font-weight: 700;" value="{{ old('radius_meters', $settings['radius_meters']) }}" min="10" max="100000" required>
                    </div>

                    <!-- Preset Chips -->
                    <div class="preset-chips">
                        <span style="font-size: 0.72rem; color: #94a3b8; align-self: center;">Pilihan Cepat:</span>
                        <button type="button" class="btn-preset" onclick="setRadiusPreset(50)">50m (Ketat)</button>
                        <button type="button" class="btn-preset" onclick="setRadiusPreset(100)">100m (Standar)</button>
                        <button type="button" class="btn-preset" onclick="setRadiusPreset(200)">200m (Gedung Luas)</button>
                        <button type="button" class="btn-preset" onclick="setRadiusPreset(500)">500m (Kompleks)</button>
                    </div>
                    <div class="input-hint">Lingkaran biru pada peta menunjukkan zona radius geofence yang diizinkan untuk absensi.</div>
                </div>

                <!-- Submit Button -->
                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <button type="submit" class="btn-save-loc">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Pengaturan Radius
                    </button>
                </div>
            </form>
        </div>

        <!-- Interactive Map Preview Card -->
        <div class="location-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #f8fafc; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                    Pratinjau Peta Interaktif
                </h3>
                <span id="mapStatusPill" style="font-size: 0.75rem; padding: 0.25rem 0.65rem; border-radius: 20px; background: rgba(56, 189, 248, 0.15); color: #38bdf8; font-weight: 600;">
                    Geser Pin / Klik Peta
                </span>
            </div>

            <!-- Leaflet Map Canvas -->
            <div id="mapPreview"></div>

            <div style="margin-top: 1rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 0.85rem 1rem; font-size: 0.8rem; color: #94a3b8;">
                <div style="display: flex; align-items: center; gap: 0.5rem; color: #cbd5e1; font-weight: 600; margin-bottom: 0.25rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    Informasi Akurasi Geofencing
                </div>
                Perhitungan jarak menggunakan formula <strong>Haversine</strong> matematis spherical. Keakuratan GPS di browser smartphone rata-rata &plusmn;5 s/d 25 meter tergantung sinyal satelit. Kami sarankan radius minimal <strong>50&ndash;100 meter</strong> agar tidak terjadi false-negative bagi satpam di pos gerbang atau caraka di area belakang gedung.
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.3655;
    const defaultLng = parseFloat(document.getElementById('longitude').value) || 107.5312;
    const initialRadius = parseInt(document.getElementById('radius_meters').value) || 100;

    // 1. Inisialisasi Map Leaflet
    const map = L.map('mapPreview').setView([defaultLat, defaultLng], 17);

    // Tile Layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors | SICAKAP Geofencing'
    }).addTo(map);

    // 2. Custom Red Pin Marker (Pusat Sekolah)
    const officeIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    let marker = L.marker([defaultLat, defaultLng], {
        icon: officeIcon,
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

    // Window global presets
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
        btn.innerHTML = '<span>⏳ Mendeteksi GPS...</span>';
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
                    title: 'GPS Berhasil Ditemukan',
                    html: `Koordinat: <strong>${lat.toFixed(6)}, ${lng.toFixed(6)}</strong><br><small style="color:#94a3b8;">Akurasi sinyal perangkat: ±${acc} meter</small>`,
                    confirmButtonColor: '#10b981'
                });
            },
            function (err) {
                btn.innerHTML = originalText;
                btn.disabled = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengakses GPS',
                    text: 'Pastikan izin lokasi telah diizinkan pada browser Anda (Error: ' + err.message + ')',
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

    // Invalidate map size after load to prevent grey tile rendering
    setTimeout(() => {
        map.invalidateSize();
    }, 400);
});
</script>
@endpush
