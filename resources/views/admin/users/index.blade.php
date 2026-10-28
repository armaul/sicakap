@extends('layouts.app')

@section('title', 'Admin - Kelola Pengguna & Personil')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header & Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
                <span class="user-role-badge role-admin" style="font-size:0.75rem;">PANEL ADMINISTRATOR</span>
            </div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Kelola Akun Personil & Keamanan Pengguna
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Tambah, ubah hak akses, reset kata sandi, dan kelola personil Satpam, Caraka, dan Supervisor.
            </p>
        </div>

        <div style="display:flex; gap:0.75rem; align-items:center;">
            <a href="{{ route('admin.shifts.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Atur Jadwal Shift &rarr;
            </a>

            <button onclick="openModalAddUser()" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:linear-gradient(135deg, var(--indigo-primary) 0%, #4f46e5 100%); color:#fff; border-color:var(--indigo-primary); box-shadow:0 4px 15px rgba(99,102,241,0.35);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                + Tambah Personil Baru
            </button>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(99,102,241,0.15); color:#818cf8;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $stats['total'] }}</div>
                <div class="kpi-label">Total Pengguna</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(16,185,129,0.15); color:#34d399;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $stats['satpam'] }}</div>
                <div class="kpi-label">Personil Satpam</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(6,182,212,0.15); color:#22d3ee;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 10"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $stats['caraka'] }}</div>
                <div class="kpi-label">Personil Caraka</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(245,158,11,0.15); color:#fbbf24;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $stats['admin'] }}</div>
                <div class="kpi-label">Supervisor & Admin</div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="glass-card" style="padding:1.25rem;">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
            <div style="flex:2; min-width:240px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Cari Nama, NIP, atau Email:</label>
                <input type="text" name="search" class="form-control" placeholder="Ketik kata kunci..." value="{{ $search }}" style="padding:0.55rem 0.85rem; font-size:0.875rem;">
            </div>

            <div style="flex:1; min-width:180px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Filter Peran (Role):</label>
                <select name="role" class="form-control" style="padding:0.55rem 0.85rem; font-size:0.875rem;">
                    <option value="">-- Semua Peran --</option>
                    <option value="satpam" {{ $selectedRole === 'satpam' ? 'selected' : '' }}>Satpam (Security)</option>
                    <option value="caraka" {{ $selectedRole === 'caraka' ? 'selected' : '' }}>Caraka (Kebersihan/Kurir)</option>
                    <option value="supervisor" {{ $selectedRole === 'supervisor' ? 'selected' : '' }}>Supervisor Operasional</option>
                    <option value="admin" {{ $selectedRole === 'admin' ? 'selected' : '' }}>Administrator Utama</option>
                </select>
            </div>

            <div style="align-self:flex-end; display:flex; gap:0.5rem;">
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Cari
                </button>
                @if($search || $selectedRole)
                    <a href="{{ route('admin.users.index') }}" class="btn-filter" style="color:var(--text-muted);">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="glass-card" style="padding:0; overflow:hidden;">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Personil</th>
                        <th>NIP</th>
                        <th>Peran (Role)</th>
                        <th>Jabatan / Penempatan</th>
                        <th>Kontak (Email / HP)</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                        <tr>
                            <td style="color:var(--text-muted); font-family:var(--font-mono); font-size:0.8rem;">
                                {{ $users->firstItem() + $index }}
                            </td>

                            <!-- Foto & Nama -->
                            <td>
                                <div style="display:flex; align-items:center; gap:0.75rem;">
                                    <img src="{{ $u->avatar }}" alt="{{ $u->name }}" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid var(--border-accent);">
                                    <div>
                                        <div style="font-weight:700; color:#fff; font-size:0.925rem;">{{ $u->name }}</div>
                                        @if($u->id === Auth::id())
                                            <span style="font-size:0.65rem; color:#34d399; font-weight:700; background:rgba(16,185,129,0.15); padding:1px 6px; border-radius:4px;">
                                                Akun Anda Saat Ini
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- NIP -->
                            <td style="font-family:var(--font-mono); font-weight:700; color:var(--cyan-primary);">
                                {{ $u->nip }}
                            </td>

                            <!-- Role Badge -->
                            <td>
                                <span class="user-role-badge role-{{ $u->role }}">
                                    {{ strtoupper($u->role) }}
                                </span>
                            </td>

                            <!-- Jabatan -->
                            <td style="color:var(--text-secondary); font-size:0.85rem;">
                                {{ $u->position ?? '-' }}
                            </td>

                            <!-- Email / Phone -->
                            <td style="font-size:0.8rem;">
                                <div style="color:#fff;">{{ $u->email }}</div>
                                <div style="color:var(--text-muted);">{{ $u->phone ?? '-' }}</div>
                            </td>

                            <!-- Action Buttons -->
                            <td style="text-align:right; white-space:nowrap;">
                                <button type="button" class="btn-filter" style="padding:0.35rem 0.65rem; font-size:0.75rem; margin-right:4px;"
                                    onclick="openModalEditUser({{ json_encode($u) }})">
                                    ✏️ Edit
                                </button>

                                @if($u->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }} ({{ $u->nip }})?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-filter" style="padding:0.35rem 0.65rem; font-size:0.75rem; background:rgba(244,63,94,0.15); border-color:rgba(244,63,94,0.3); color:#f43f5e;">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:3rem 1.5rem; color:var(--text-muted);">
                                Tidak ditemukan data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding:1rem;">
            {{ $users->links() }}
        </div>
    </div>

</div>

<!-- Modal Tambah User Baru -->
<div class="modal-overlay" id="modalAddUser" onclick="closeModalAddUser()">
    <div class="modal-dialog" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-size:1.05rem; font-weight:700; color:#fff;">Tambah Personil / Pengguna Baru</h3>
            <button onclick="closeModalAddUser()" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap:</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Pratama Wijaya" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">NIP (Nomor Induk):</label>
                        <input type="text" name="nip" class="form-control" placeholder="Contoh: STP-2024-005" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Peran (Role):</label>
                        <select name="role" class="form-control" required>
                            <option value="satpam">Satpam (Security)</option>
                            <option value="caraka">Caraka (Kebersihan/Kurir)</option>
                            <option value="supervisor">Supervisor Operasional</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Jabatan / Posisi Penempatan:</label>
                    <input type="text" name="position" class="form-control" placeholder="Contoh: Anggota Satpam Pos Jaga Gedung A" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Email Dinas:</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@satpamcaraka.id" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp / HP:</label>
                        <input type="text" name="phone" class="form-control" placeholder="0812-xxxx-xxxx">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi Awal:</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="password" id="addPasswordInput" class="form-control" placeholder="Minimal 6 karakter" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('addPasswordInput', this)" title="Lihat Kata Sandi">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeModalAddUser()">Batal</button>
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal-overlay" id="modalEditUser" onclick="closeModalEditUser()">
    <div class="modal-dialog" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-size:1.05rem; font-weight:700; color:#fff;">Ubah Data Pengguna</h3>
            <button onclick="closeModalEditUser()" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <form id="formEditUser" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap:</label>
                    <input type="text" name="name" id="editName" class="form-control" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">NIP:</label>
                        <input type="text" name="nip" id="editNip" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Peran (Role):</label>
                        <select name="role" id="editRole" class="form-control" required>
                            <option value="satpam">Satpam (Security)</option>
                            <option value="caraka">Caraka (Kebersihan/Kurir)</option>
                            <option value="supervisor">Supervisor Operasional</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Jabatan / Posisi Penempatan:</label>
                    <input type="text" name="position" id="editPosition" class="form-control" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Email Dinas:</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp / HP:</label>
                        <input type="text" name="phone" id="editPhone" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi Baru (Kosongkan jika tidak ingin diubah):</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="password" id="editPasswordInput" class="form-control" placeholder="Isi hanya jika ingin mereset password">
                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('editPasswordInput', this)" title="Lihat Kata Sandi">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeModalEditUser()">Batal</button>
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const eyeOpenSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
const eyeSlashSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>`;

function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = eyeSlashSvg;
        btn.setAttribute('title', 'Sembunyikan Kata Sandi');
    } else {
        input.type = 'password';
        btn.innerHTML = eyeOpenSvg;
        btn.setAttribute('title', 'Lihat Kata Sandi');
    }
}

function openModalAddUser() {
    const addPwd = document.getElementById('addPasswordInput');
    if (addPwd) {
        addPwd.value = '';
        addPwd.type = 'password';
        const btn = addPwd.parentElement.querySelector('.btn-toggle-password');
        if (btn) {
            btn.innerHTML = eyeOpenSvg;
            btn.setAttribute('title', 'Lihat Kata Sandi');
        }
    }
    document.getElementById('modalAddUser').classList.add('show');
}
function closeModalAddUser() {
    const addPwd = document.getElementById('addPasswordInput');
    if (addPwd) {
        addPwd.type = 'password';
        const btn = addPwd.parentElement.querySelector('.btn-toggle-password');
        if (btn) {
            btn.innerHTML = eyeOpenSvg;
            btn.setAttribute('title', 'Lihat Kata Sandi');
        }
    }
    document.getElementById('modalAddUser').classList.remove('show');
}

function openModalEditUser(user) {
    document.getElementById('formEditUser').action = '/admin/users/' + user.id;
    document.getElementById('editName').value = user.name;
    document.getElementById('editNip').value = user.nip;
    document.getElementById('editRole').value = user.role;
    document.getElementById('editPosition').value = user.position || '';
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editPhone').value = user.phone || '';
    
    const editPwd = document.getElementById('editPasswordInput');
    if (editPwd) {
        editPwd.value = '';
        editPwd.type = 'password';
        const btn = editPwd.parentElement.querySelector('.btn-toggle-password');
        if (btn) {
            btn.innerHTML = eyeOpenSvg;
            btn.setAttribute('title', 'Lihat Kata Sandi');
        }
    }
    document.getElementById('modalEditUser').classList.add('show');
}
function closeModalEditUser() {
    const editPwd = document.getElementById('editPasswordInput');
    if (editPwd) {
        editPwd.type = 'password';
        const btn = editPwd.parentElement.querySelector('.btn-toggle-password');
        if (btn) {
            btn.innerHTML = eyeOpenSvg;
            btn.setAttribute('title', 'Lihat Kata Sandi');
        }
    }
    document.getElementById('modalEditUser').classList.remove('show');
}
</script>
@endpush
@endsection
