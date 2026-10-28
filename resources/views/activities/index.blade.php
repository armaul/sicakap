@extends('layouts.app')

@section('title', 'Logbook Kegiatan Satpam & Caraka')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Logbook Kegiatan Satpam & Caraka
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Pencatatan aktivitas patroli keamanan, kebersihan ruangan, dan distribusi surat harian.
            </p>
        </div>

        <button onclick="document.getElementById('modalNewActivity').classList.add('show')" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:linear-gradient(135deg, var(--indigo-primary) 0%, #4f46e5 100%); color:#fff; border-color:var(--indigo-primary);">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
            + Catat Kegiatan Baru
        </button>
    </div>

    <!-- Filter by Category & Date -->
    <div class="glass-card" style="padding:1.25rem;">
        <form method="GET" action="{{ route('activities.index') }}" style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
            <div style="flex:1; min-width:180px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Tanggal Kegiatan:</label>
                <input type="date" name="date" class="form-control" value="{{ $selectedDate }}" style="padding:0.5rem 0.85rem; font-size:0.875rem;">
            </div>

            <div style="flex:1; min-width:200px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Kategori Tugas:</label>
                <select name="category" class="form-control" style="padding:0.5rem 0.85rem; font-size:0.875rem;">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Patroli" {{ $selectedCategory === 'Patroli' ? 'selected' : '' }}>Patroli Keamanan (Satpam)</option>
                    <option value="Inspeksi" {{ $selectedCategory === 'Inspeksi' ? 'selected' : '' }}>Pemeriksaan APAR / CCTV (Satpam)</option>
                    <option value="Serah Terima Jaga" {{ $selectedCategory === 'Serah Terima Jaga' ? 'selected' : '' }}>Serah Terima Jaga (Satpam)</option>
                    <option value="Kebersihan" {{ $selectedCategory === 'Kebersihan' ? 'selected' : '' }}>Sanitasi & Kebersihan (Caraka)</option>
                    <option value="Pengiriman Surat" {{ $selectedCategory === 'Pengiriman Surat' ? 'selected' : '' }}>Distribusi Dokumen / Surat (Caraka)</option>
                    <option value="Insiden" {{ $selectedCategory === 'Insiden' ? 'selected' : '' }}>Laporan Insiden Khusus</option>
                </select>
            </div>

            <div style="align-self:flex-end;">
                <button type="submit" class="btn-filter" style="background:rgba(99,102,241,0.2); border-color:rgba(99,102,241,0.4); color:#fff;">
                    Filter Logbook
                </button>
            </div>
        </form>
    </div>

    <!-- Activity Log List -->
    <div class="glass-card">
        @if($activities->isEmpty())
            <div style="text-align:center; padding:3rem 1.5rem; color:var(--text-muted);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:0.75rem; opacity:0.6;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                <div style="font-size:0.95rem; font-weight:600; color:#fff;">Tidak ada kegiatan pada tanggal ini</div>
                <div style="font-size:0.8rem;">Gunakan tombol "+ Catat Kegiatan Baru" untuk menambahkan laporan patroli atau tugas caraka.</div>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:1rem;">
                @foreach($activities as $item)
                    <div class="activity-card-item">
                        <div style="padding:0.5rem 0.75rem; background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.3); border-radius:var(--radius-md); text-align:center; min-width:80px;">
                            <div style="font-family:var(--font-mono); font-size:1rem; font-weight:700; color:#38bdf8;">
                                {{ substr($item->time_recorded ?? $item->created_at->format('H:i'), 0, 5) }}
                            </div>
                            <div style="font-size:0.65rem; color:var(--text-muted); text-transform:uppercase;">WIB</div>
                        </div>

                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:0.6rem; flex-wrap:wrap; margin-bottom:0.35rem;">
                                <h3 style="font-size:1.05rem; font-weight:700; color:#fff;">{{ $item->title }}</h3>
                                <span style="background:rgba(6,182,212,0.15); color:#22d3ee; font-size:0.7rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:4px;">
                                    {{ $item->category }}
                                </span>
                                @if($item->location)
                                    <span style="font-size:0.75rem; color:var(--text-muted);">
                                        📍 {{ $item->location }}
                                    </span>
                                @endif
                            </div>

                            <p style="font-size:0.875rem; color:var(--text-secondary); line-height:1.5; margin-bottom:0.5rem;">
                                {{ $item->description }}
                            </p>

                            @if($item->photo)
                                <div style="margin-bottom:0.75rem;">
                                    <a href="{{ $item->photo }}" target="_blank" onclick="event.preventDefault(); showPhotoModal('{{ $item->photo }}', '{{ addslashes($item->title) }}')" style="display:inline-block; border-radius:var(--radius-md); overflow:hidden; border:1px solid rgba(255,255,255,0.15); max-width:260px; cursor:zoom-in;">
                                        <img src="{{ $item->photo }}" alt="Foto Bukti" style="width:100%; max-height:140px; object-fit:cover; display:block; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                        <div style="padding:4px 8px; background:rgba(15,23,42,0.9); font-size:0.7rem; color:#38bdf8; display:flex; align-items:center; gap:4px;">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
                                            Lihat Foto Bukti
                                        </div>
                                    </a>
                                </div>
                            @endif

                            <div style="display:flex; align-items:center; gap:0.75rem; font-size:0.75rem; color:var(--text-muted);">
                                <img src="{{ $item->user->avatar }}" alt="{{ $item->user->name }}" style="width:20px; height:20px; border-radius:50%; object-fit:cover;">
                                <span>Petugas: <strong>{{ $item->user->name }}</strong> ({{ strtoupper($item->user->role) }})</span>
                            </div>
                        </div>

                        <span style="background:rgba(16,185,129,0.15); color:#34d399; font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px;">
                            ✓ Selesai
                        </span>
                    </div>
                @endforeach
            </div>

            <div style="margin-top:1rem;">
                {{ $activities->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Catat Kegiatan Baru -->
<div class="modal-overlay" id="modalNewActivity" onclick="this.classList.remove('show')">
    <div class="modal-dialog" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-size:1rem; font-weight:700; color:#fff;">Catat Kegiatan / Patroli Baru</h3>
            <button onclick="document.getElementById('modalNewActivity').classList.remove('show')" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateActivityForm()">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Judul Aktivitas / Tugas: <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Patroli Area Gedung B & Gudang" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori: <span style="color:#ef4444;">*</span></label>
                    <select name="category" class="form-control" required>
                        <option value="Patroli">Patroli Keamanan</option>
                        <option value="Inspeksi">Inspeksi APAR / CCTV / Gerbang</option>
                        <option value="Kebersihan">Sanitasi & Kebersihan Ruangan</option>
                        <option value="Pengiriman Surat">Pengantaran Berkas & Kurir</option>
                        <option value="Serah Terima Jaga">Serah Terima Jaga Shift</option>
                        <option value="Insiden">Laporan Khusus</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Lokasi / Area:</label>
                    <input type="text" name="location" class="form-control" placeholder="Contoh: Lantai 2, Pos Timur, Ruang Server">
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi Hasil Pemeriksaan / Pekerjaan: <span style="color:#ef4444;">*</span></label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan kondisi area, temuan patroli, atau pekerjaan kebersihan yang telah diselesaikan..." required></textarea>
                </div>

                <!-- Form Upload Foto Wajib* Max 10MB -->
                <div class="form-group" style="margin-bottom:0;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.35rem;">
                        <label class="form-label" style="margin-bottom:0;">
                            Foto Bukti Kegiatan: <span style="color:#ef4444; font-weight:700;">*Wajib</span>
                        </label>
                        <span style="font-size:0.75rem; color:#38bdf8; font-weight:600;">Maks. 10 MB</span>
                    </div>

                    <div style="position:relative; border:2px dashed var(--border-subtle); border-radius:var(--radius-md); padding:1.25rem 1rem; text-align:center; background:rgba(15,23,42,0.6); transition:all 0.2s;" id="activityDropzone">
                        <input type="file" name="photo" id="activityPhotoInput" accept="image/jpeg,image/png,image/jpg,image/webp" required style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:5;" onchange="handleActivityPhotoPreview(this)">
                        
                        <div id="activityUploadPlaceholder">
                            <div style="width:44px; height:44px; margin:0 auto 0.5rem; border-radius:50%; background:rgba(99,102,241,0.15); color:#818cf8; display:flex; align-items:center; justify-content:center;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            </div>
                            <div style="font-size:0.875rem; font-weight:600; color:#fff; margin-bottom:0.25rem;">
                                Klik atau seret foto bukti kegiatan ke sini
                            </div>
                            <div style="font-size:0.75rem; color:var(--text-muted);">
                                Format: JPG, JPEG, PNG, WEBP &bull; Ukuran maksimal <strong>10 MB</strong>
                            </div>
                        </div>

                        <!-- Live Photo Preview -->
                        <div id="activityPhotoPreviewContainer" style="display:none; flex-direction:column; align-items:center; gap:0.5rem;">
                            <img id="activityPhotoPreviewImg" src="" alt="Preview Foto" style="max-height:160px; max-width:100%; border-radius:8px; object-fit:contain; border:1px solid rgba(255,255,255,0.15); box-shadow:0 4px 12px rgba(0,0,0,0.4);">
                            <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap; justify-content:center;">
                                <span id="activityPhotoFileName" style="font-size:0.75rem; color:#38bdf8; font-weight:600;">-</span>
                                <span id="activityPhotoFileSize" style="font-size:0.7rem; color:var(--text-muted);">-</span>
                            </div>
                            <button type="button" onclick="resetActivityPhoto()" style="position:relative; z-index:10; font-size:0.75rem; color:#f43f5e; background:transparent; border:none; cursor:pointer; text-decoration:underline;">
                                Ganti Foto Lain
                            </button>
                        </div>
                    </div>
                    <div id="activityPhotoError" style="display:none; font-size:0.75rem; color:#f43f5e; margin-top:0.35rem; font-weight:600;"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="document.getElementById('modalNewActivity').classList.remove('show')">
                    Batal
                </button>
                <button type="submit" id="btnSubmitActivity" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff; font-weight:700;">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Zoom Foto Bukti Kegiatan -->
<div class="modal-overlay" id="modalZoomPhoto" onclick="this.classList.remove('show')">
    <div class="modal-dialog" style="max-width:700px; padding:0; background:rgba(15,23,42,0.95); border:1px solid var(--border-subtle); overflow:hidden;" onclick="event.stopPropagation()">
        <div style="padding:1rem 1.25rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border-subtle);">
            <h3 style="font-size:1rem; font-weight:700; color:#fff;" id="zoomPhotoTitle">Foto Bukti Kegiatan</h3>
            <button onclick="document.getElementById('modalZoomPhoto').classList.remove('show')" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>
        <div style="padding:1rem; text-align:center;">
            <img id="zoomPhotoImg" src="" alt="Foto Bukti" style="max-width:100%; max-height:75vh; border-radius:8px; object-fit:contain;">
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleActivityPhotoPreview(input) {
    const errorEl = document.getElementById('activityPhotoError');
    const placeholder = document.getElementById('activityUploadPlaceholder');
    const previewContainer = document.getElementById('activityPhotoPreviewContainer');
    const previewImg = document.getElementById('activityPhotoPreviewImg');
    const fileNameEl = document.getElementById('activityPhotoFileName');
    const fileSizeEl = document.getElementById('activityPhotoFileSize');
    const dropzone = document.getElementById('activityDropzone');

    errorEl.style.display = 'none';
    errorEl.textContent = '';
    dropzone.style.borderColor = 'var(--border-subtle)';

    if (!input.files || !input.files[0]) {
        return;
    }

    const file = input.files[0];
    const maxSizeBytes = 10 * 1024 * 1024; // 10MB

    // Check size limit (max 10MB)
    if (file.size > maxSizeBytes) {
        input.value = '';
        errorEl.textContent = 'Ukuran foto terlalu besar (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB). Maksimal yang diperbolehkan adalah 10 MB!';
        errorEl.style.display = 'block';
        dropzone.style.borderColor = '#f43f5e';
        placeholder.style.display = 'block';
        previewContainer.style.display = 'none';
        return;
    }

    // Check mime type
    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        input.value = '';
        errorEl.textContent = 'Format berkas tidak valid! Hanya diperbolehkan JPG, PNG, atau WEBP.';
        errorEl.style.display = 'block';
        dropzone.style.borderColor = '#f43f5e';
        placeholder.style.display = 'block';
        previewContainer.style.display = 'none';
        return;
    }

    // Display image preview
    const reader = new FileReader();
    reader.onload = function(e) {
        previewImg.src = e.target.result;
        fileNameEl.textContent = file.name;
        fileSizeEl.textContent = '(' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
        placeholder.style.display = 'none';
        previewContainer.style.display = 'flex';
        dropzone.style.borderColor = '#10b981';
    };
    reader.readAsDataURL(file);
}

function resetActivityPhoto() {
    const input = document.getElementById('activityPhotoInput');
    const placeholder = document.getElementById('activityUploadPlaceholder');
    const previewContainer = document.getElementById('activityPhotoPreviewContainer');
    const previewImg = document.getElementById('activityPhotoPreviewImg');
    const dropzone = document.getElementById('activityDropzone');
    const errorEl = document.getElementById('activityPhotoError');

    input.value = '';
    previewImg.src = '';
    placeholder.style.display = 'block';
    previewContainer.style.display = 'none';
    dropzone.style.borderColor = 'var(--border-subtle)';
    errorEl.style.display = 'none';
}

function validateActivityForm() {
    const input = document.getElementById('activityPhotoInput');
    const errorEl = document.getElementById('activityPhotoError');
    const dropzone = document.getElementById('activityDropzone');

    if (!input.files || input.files.length === 0) {
        errorEl.textContent = 'Foto bukti kegiatan wajib diunggah!';
        errorEl.style.display = 'block';
        dropzone.style.borderColor = '#f43f5e';
        return false;
    }

    if (input.files[0].size > 10 * 1024 * 1024) {
        errorEl.textContent = 'Ukuran foto maksimal adalah 10 MB!';
        errorEl.style.display = 'block';
        dropzone.style.borderColor = '#f43f5e';
        return false;
    }

    return true;
}

function showPhotoModal(src, title) {
    document.getElementById('zoomPhotoImg').src = src;
    document.getElementById('zoomPhotoTitle').textContent = title || 'Foto Bukti Kegiatan';
    document.getElementById('modalZoomPhoto').classList.add('show');
}
</script>
@endpush
@endsection
