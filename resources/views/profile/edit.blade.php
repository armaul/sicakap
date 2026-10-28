@extends('layouts.app')

@section('title', 'Edit Profil Pengguna - Satpam & Caraka')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem; max-width:960px; margin:0 auto;">

    <!-- Page Header & Navigation Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.35rem;">
                <a href="{{ route('dashboard') }}" style="color:var(--text-muted); text-decoration:none; display:inline-flex; align-items:center; gap:4px; font-size:0.8rem; font-weight:600; transition:color 0.2s;" onmouseover="this.style.color='#38bdf8'" onmouseout="this.style.color='var(--text-muted)'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m15 18-6-6 6-6"/></svg>
                    Kembali ke Menu Utama
                </a>
                <span style="color:var(--border-subtle);">&bull;</span>
                <span class="user-role-badge role-{{ $activeUser->role }}">{{ strtoupper($activeUser->role) }}</span>
            </div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Edit Profil Saya
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Kelola informasi biodata pribadi, nomor kontak, foto profil, dan kata sandi akun Anda.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            Tutup & Kembali
        </a>
    </div>

    <!-- Main Profile Edit Form -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileEditForm">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns: 320px 1fr; gap:1.75rem; align-items:start;" class="profile-grid">

            <!-- Left Card: Avatar & Account Meta -->
            <div class="glass-card" style="text-align:center;">
                <div style="position:relative; width:130px; height:130px; margin:0 auto 1.25rem;">
                    <img id="avatarPreviewImg" src="{{ $activeUser->avatar ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200' }}" alt="{{ $activeUser->name }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover; border:3px solid var(--indigo-primary); box-shadow:0 0 25px rgba(99,102,241,0.4);">
                    
                    <label for="avatarInput" style="position:absolute; bottom:0; right:0; width:38px; height:38px; border-radius:50%; background:var(--indigo-primary); border:2px solid #0f172a; display:flex; align-items:center; justify-content:center; color:#fff; cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.4); transition:transform 0.2s;" title="Unggah Foto Profil Baru" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    </label>
                </div>

                <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/jpg,image/webp" style="display:none;" onchange="previewNewAvatar(event)">

                <h2 style="font-size:1.15rem; font-weight:800; color:#fff; margin-bottom:0.25rem;">
                    {{ $activeUser->name }}
                </h2>
                <div style="font-size:0.8rem; color:var(--text-muted); font-family:var(--font-mono); margin-bottom:0.75rem;">
                    {{ $activeUser->nip ?? 'NIP: -' }}
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label for="avatarInput" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.4rem; padding:0.45rem 0.85rem; font-size:0.775rem; cursor:pointer;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        Pilih Foto Baru (Max 5MB)
                    </label>
                    <div id="avatarFileName" style="font-size:0.7rem; color:#38bdf8; margin-top:4px; display:none;"></div>
                </div>

                <!-- Readonly Operational Badges -->
                <div style="background:rgba(15,23,42,0.6); border:1px solid var(--border-subtle); border-radius:var(--radius-md); padding:0.85rem; text-align:left; font-size:0.785rem; display:flex; flex-direction:column; gap:0.6rem;">
                    <div>
                        <span style="color:var(--text-muted); font-size:0.7rem; display:block; text-transform:uppercase;">Nomor Induk Pegawai (NIP):</span>
                        <strong style="color:var(--cyan-primary); font-family:var(--font-mono); font-size:0.85rem;">{{ $activeUser->nip }}</strong>
                        <span style="font-size:0.65rem; color:#64748b; display:block;">(Ditetapkan oleh Admin)</span>
                    </div>

                    <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:0.5rem;">
                        <span style="color:var(--text-muted); font-size:0.7rem; display:block; text-transform:uppercase;">Peran Tugas (Role):</span>
                        <strong style="color:#fff; text-transform:uppercase;">{{ $activeUser->role }}</strong>
                        <span style="font-size:0.65rem; color:#64748b; display:block;">({{ $activeUser->position }})</span>
                    </div>
                </div>
            </div>

            <!-- Right Card: Form Fields -->
            <div style="display:flex; flex-direction:column; gap:1.5rem;">
                
                <!-- Section 1: Data Diri & Kontak -->
                <div class="glass-card">
                    <h3 class="card-title" style="margin-bottom:1.25rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Informasi Pribadi & Kontak
                    </h3>

                    <div class="form-group">
                        <label class="form-label" for="profileName">Nama Lengkap:</label>
                        <input type="text" id="profileName" name="name" class="form-control" value="{{ old('name', $activeUser->name) }}" required placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <small style="color:#f43f5e; font-size:0.75rem; margin-top:3px; display:block;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="profile-inputs-split">
                        <div class="form-group">
                            <label class="form-label" for="profileEmail">Alamat Email:</label>
                            <input type="email" id="profileEmail" name="email" class="form-control" value="{{ old('email', $activeUser->email) }}" required placeholder="email@contoh.id">
                            @error('email')
                                <small style="color:#f43f5e; font-size:0.75rem; margin-top:3px; display:block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="profilePhone">Nomor HP / WhatsApp:</label>
                            <input type="text" id="profilePhone" name="phone" class="form-control" value="{{ old('phone', $activeUser->phone) }}" placeholder="Contoh: 081234567890">
                            @error('phone')
                                <small style="color:#f43f5e; font-size:0.75rem; margin-top:3px; display:block;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Keamanan & Kata Sandi (Opsional) -->
                <div class="glass-card">
                    <h3 class="card-title" style="margin-bottom:0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Keamanan & Ubah Kata Sandi
                    </h3>
                    <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:1.25rem;">
                        Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi akun Anda.
                    </p>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="profile-inputs-split">
                        <!-- Password Baru -->
                        <div class="form-group">
                            <label class="form-label" for="profilePassword">Kata Sandi Baru:</label>
                            <div style="position:relative;">
                                <input type="password" id="profilePassword" name="password" class="form-control" placeholder="Minimal 6 karakter" style="padding-right:2.5rem;">
                                <button type="button" onclick="togglePasswordVisibility('profilePassword', 'eyeIcon1')" style="position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); background:transparent; border:none; color:var(--text-muted); cursor:pointer; padding:0; display:flex; align-items:center;">
                                    <svg id="eyeIcon1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            @error('password')
                                <small style="color:#f43f5e; font-size:0.75rem; margin-top:3px; display:block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="form-group">
                            <label class="form-label" for="profilePasswordConfirm">Ulangi Kata Sandi Baru:</label>
                            <div style="position:relative;">
                                <input type="password" id="profilePasswordConfirm" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" style="padding-right:2.5rem;">
                                <button type="button" onclick="togglePasswordVisibility('profilePasswordConfirm', 'eyeIcon2')" style="position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); background:transparent; border:none; color:var(--text-muted); cursor:pointer; padding:0; display:flex; align-items:center;">
                                    <svg id="eyeIcon2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Action Buttons -->
                <div style="display:flex; justify-content:flex-end; gap:0.75rem; align-items:center;">
                    <a href="{{ route('dashboard') }}" class="btn-filter" style="text-decoration:none;">
                        Batal
                    </a>
                    
                    <button type="submit" class="btn-filter" style="background:linear-gradient(135deg, var(--indigo-primary) 0%, #4f46e5 100%); color:#fff; border-color:var(--indigo-primary); box-shadow:0 4px 15px rgba(99,102,241,0.35); padding:0.75rem 1.75rem; font-size:0.95rem; font-weight:700; display:inline-flex; align-items:center; gap:0.5rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan Profil
                    </button>
                </div>

            </div>

        </div>
    </form>

</div>

@push('scripts')
<script>
function previewNewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                icon: 'warning',
                title: 'Ukuran Foto Terlalu Besar',
                text: 'Batas maksimal ukuran foto profil adalah 5 MB.',
                background: '#1e293b',
                color: '#fff',
                confirmButtonColor: '#6366f1'
            });
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreviewImg').src = e.target.result;
            const fileNameEl = document.getElementById('avatarFileName');
            if (fileNameEl) {
                fileNameEl.textContent = 'Foto terpilih: ' + file.name;
                fileNameEl.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }
}

function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        if (icon) {
            icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/>';
        }
    } else {
        input.type = 'password';
        if (icon) {
            icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
        }
    }
}
</script>
@endpush
@endsection
