@extends('layouts.app')

@section('title', 'Admin - Kelola Jadwal Shift Kerja')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header & Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
                <span class="user-role-badge role-admin" style="font-size:0.75rem;">PANEL ADMINISTRATOR</span>
            </div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Kelola Jadwal Shift & Jam Kerja
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Atur pembagian jam operasional satpam 24 jam (pagi, siang, dan shift malam lintas hari) serta jadwal kerja caraka.
            </p>
        </div>

        <div style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
            <a href="{{ route('admin.schedules.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(245,158,11,0.15); border-color:rgba(245,158,11,0.3); color:#fcd34d;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                Atur Hari Masuk & Off Karyawan &rarr;
            </a>

            <a href="{{ route('admin.users.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Kelola Personil
            </a>

            <button onclick="openModalAddShift()" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:linear-gradient(135deg, var(--indigo-primary) 0%, #4f46e5 100%); color:#fff; border-color:var(--indigo-primary); box-shadow:0 4px 15px rgba(99,102,241,0.35);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                + Tambah Shift Baru
            </button>
        </div>
    </div>

    <!-- Shifts Grid -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:1.25rem;">
        @foreach($shifts as $s)
            <div class="glass-card shift-card {{ $s->is_night_shift ? 'night-shift' : '' }}" style="display:flex; flex-direction:column; justify-content:space-between;">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
                        <span class="user-role-badge role-{{ $s->role }}">{{ strtoupper($s->role) }}</span>
                        @if($s->is_night_shift)
                            <span class="shift-badge-night">🌙 Lintas Hari (Malam)</span>
                        @else
                            <span style="font-size:0.75rem; color:#34d399; font-weight:700; background:rgba(16,185,129,0.15); padding:0.2rem 0.5rem; border-radius:999px;">☀️ Normal</span>
                        @endif
                    </div>

                    <h2 style="font-size:1.25rem; font-weight:800; color:#fff; margin-bottom:0.25rem;">
                        {{ $s->name }}
                    </h2>
                    <div style="font-family:var(--font-mono); font-size:0.75rem; color:var(--text-muted); margin-bottom:0.75rem;">
                        KODE: {{ $s->code }}
                    </div>

                    <div style="font-family:var(--font-mono); font-size:1.35rem; font-weight:800; color:#38bdf8; margin-bottom:0.75rem;">
                        {{ substr($s->start_time, 0, 5) }} - {{ substr($s->end_time, 0, 5) }} WIB
                    </div>

                    <p style="font-size:0.85rem; color:var(--text-secondary); line-height:1.5; margin-bottom:1rem;">
                        {{ $s->description }}
                    </p>
                </div>

                <div style="border-top:1px solid var(--border-subtle); padding-top:0.85rem; margin-top:0.5rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.8rem; margin-bottom:0.75rem;">
                        <span style="color:var(--text-muted);">Toleransi Telat: <strong style="color:#fff;">{{ $s->grace_period_minutes }}m</strong></span>
                        <span style="color:var(--text-muted);">Riwayat Presensi: <strong style="color:var(--cyan-primary);">{{ $s->attendances_count }}</strong></span>
                    </div>

                    <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                        <button type="button" class="btn-filter" style="padding:0.35rem 0.75rem; font-size:0.75rem;" onclick="openModalEditShift({{ json_encode($s) }})">
                            ✏️ Ubah Shift
                        </button>

                        @if($s->attendances_count === 0)
                            <form action="{{ route('admin.shifts.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus shift {{ $s->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-filter" style="padding:0.35rem 0.75rem; font-size:0.75rem; background:rgba(244,63,94,0.15); border-color:rgba(244,63,94,0.3); color:#f43f5e;">
                                    🗑️ Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- Modal Tambah Shift Baru -->
<div class="modal-overlay" id="modalAddShift" onclick="closeModalAddShift()">
    <div class="modal-dialog" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-size:1.05rem; font-weight:700; color:#fff;">Tambah Shift Kerja Baru</h3>
            <button onclick="closeModalAddShift()" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.shifts.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Shift:</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Shift Cadangan Patroli Khusus" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Kode Unik:</label>
                        <input type="text" name="code" class="form-control" placeholder="Contoh: STP_PATROLI_B" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Target Peran:</label>
                        <select name="role" class="form-control" required>
                            <option value="satpam">Satpam (Security)</option>
                            <option value="caraka">Caraka (Kebersihan)</option>
                            <option value="all">Semua Peran</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Jam Mulai (HH:MM):</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jam Selesai (HH:MM):</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Toleransi (Menit):</label>
                        <input type="number" name="grace_period_minutes" class="form-control" value="15" min="0" max="120" required>
                    </div>
                </div>

                <div class="form-group" style="padding:0.75rem 1rem; background:rgba(99,102,241,0.1); border-radius:var(--radius-md); border:1px solid rgba(99,102,241,0.25);">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                        <input type="checkbox" name="is_night_shift" value="1" style="accent-color:var(--indigo-primary); width:18px; height:18px;">
                        <div>
                            <strong style="color:#fff; font-size:0.875rem;">🌙 Shift Malam Lintas Hari (Cross-Midnight)</strong>
                            <div style="font-size:0.75rem; color:var(--text-muted);">Centang jika jam kerja melewati pukul 00:00 tengah malam (misal 23:00 ke 07:00 hari berikutnya).</div>
                        </div>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi & Rincian Tugas:</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan cakupan pos jaga atau area pembersihan shift ini..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeModalAddShift()">Batal</button>
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Simpan Shift Baru
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Shift -->
<div class="modal-overlay" id="modalEditShift" onclick="closeModalEditShift()">
    <div class="modal-dialog" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-size:1.05rem; font-weight:700; color:#fff;">Ubah Jadwal Shift</h3>
            <button onclick="closeModalEditShift()" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <form id="formEditShift" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Shift:</label>
                    <input type="text" name="name" id="editShiftName" class="form-control" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Kode Unik:</label>
                        <input type="text" name="code" id="editShiftCode" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Target Peran:</label>
                        <select name="role" id="editShiftRole" class="form-control" required>
                            <option value="satpam">Satpam (Security)</option>
                            <option value="caraka">Caraka (Kebersihan)</option>
                            <option value="all">Semua Peran</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Jam Mulai:</label>
                        <input type="time" name="start_time" id="editShiftStartTime" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jam Selesai:</label>
                        <input type="time" name="end_time" id="editShiftEndTime" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Toleransi (Menit):</label>
                        <input type="number" name="grace_period_minutes" id="editShiftGrace" class="form-control" min="0" max="120" required>
                    </div>
                </div>

                <div class="form-group" style="padding:0.75rem 1rem; background:rgba(99,102,241,0.1); border-radius:var(--radius-md); border:1px solid rgba(99,102,241,0.25);">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                        <input type="checkbox" name="is_night_shift" id="editShiftNight" value="1" style="accent-color:var(--indigo-primary); width:18px; height:18px;">
                        <div>
                            <strong style="color:#fff; font-size:0.875rem;">🌙 Shift Malam Lintas Hari (Cross-Midnight)</strong>
                            <div style="font-size:0.75rem; color:var(--text-muted);">Centang jika jam kerja melewati pukul 00:00 tengah malam.</div>
                        </div>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi & Rincian Tugas:</label>
                    <textarea name="description" id="editShiftDesc" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeModalEditShift()">Batal</button>
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Perbarui Shift
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModalAddShift() {
    document.getElementById('modalAddShift').classList.add('show');
}
function closeModalAddShift() {
    document.getElementById('modalAddShift').classList.remove('show');
}

function openModalEditShift(s) {
    document.getElementById('formEditShift').action = '/admin/shifts/' + s.id;
    document.getElementById('editShiftName').value = s.name;
    document.getElementById('editShiftCode').value = s.code;
    document.getElementById('editShiftRole').value = s.role;
    document.getElementById('editShiftStartTime').value = s.start_time.substring(0, 5);
    document.getElementById('editShiftEndTime').value = s.end_time.substring(0, 5);
    document.getElementById('editShiftGrace').value = s.grace_period_minutes;
    document.getElementById('editShiftNight').checked = Boolean(s.is_night_shift);
    document.getElementById('editShiftDesc').value = s.description || '';
    document.getElementById('modalEditShift').classList.add('show');
}
function closeModalEditShift() {
    document.getElementById('modalEditShift').classList.remove('show');
}
</script>
@endpush
@endsection
