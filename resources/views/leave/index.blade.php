@extends('layouts.app')

@section('title', 'Menu Izin / Sakit - Satpam & Caraka')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header -->
    <div>
        <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
            Menu Pengajuan Izin & Sakit
        </h1>
        <p style="color:var(--text-secondary); font-size:0.875rem;">
            Formulir resmi pengajuan ketidakhadiran personil satpam dan caraka dengan lampiran surat keterangan dokter atau bukti pendukung.
        </p>
    </div>

    <!-- Main Grid: Form Left, History Right -->
    <div class="leave-content-grid">

        <!-- Left: Form Pengajuan Ketidakhadiran -->
        <div class="glass-card">
            <h2 class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="18" y2="12"/><line x1="9" x2="15" y1="15" y2="15"/></svg>
                Formulir Pengajuan Ketidakhadiran
            </h2>

            <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data" id="leaveForm">
                @csrf

                <!-- Jenis Ketidakhadiran -->
                <div class="form-group">
                    <label class="form-label">Jenis Pengajuan:</label>
                    <select name="type" id="leaveType" class="form-control" required onchange="handleLeaveTypeChange()">
                        <option value="Sakit">Sakit (Wajib Lampirkan Surat Dokter)</option>
                        <option value="Izin">Izin (Keperluan Keluarga / Mendesak)</option>
                        <option value="Cuti">Cuti Tahunan</option>
                        <option value="Dinas Luar">Tugas Kedinasan Luar</option>
                    </select>
                </div>

                <!-- Rentang Tanggal -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai:</label>
                        <input type="date" name="start_date" id="startDate" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai:</label>
                        <input type="date" name="end_date" id="endDate" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <!-- Alasan / Keterangan -->
                <div class="form-group">
                    <label class="form-label">Alasan / Keterangan Lengkap:</label>
                    <textarea name="alasan" class="form-control" rows="3" placeholder="Jelaskan alasan ketidakhadiran secara terperinci..." required></textarea>
                </div>

                <!-- Upload Surat Dokter / Bukti Pendukung -->
                <div class="form-group">
                    <label class="form-label" id="labelBukti">
                        Unggah Surat Keterangan Dokter / Bukti Pendukung:
                    </label>

                    <div class="file-drop-zone" id="dropZone" onclick="document.getElementById('suratFileInput').click()">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:var(--indigo-primary); margin-bottom:0.5rem;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        <div style="font-size:0.875rem; font-weight:700; color:#fff; margin-bottom:0.25rem;">
                            Klik untuk memilih file surat dokter / seret file ke sini
                        </div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">
                            Format yang didukung: JPG, PNG, PDF, WEBP (Maksimal 5MB)
                        </div>

                        <!-- Image Preview Area -->
                        <div id="filePreviewContainer" style="display:none; margin-top:1rem; text-align:center;">
                            <img id="filePreviewImg" src="" alt="Pratinjau Surat Dokter" style="max-height:160px; border-radius:8px; border:1px solid var(--border-accent); box-shadow:0 4px 12px rgba(0,0,0,0.4);">
                            <div id="filePreviewName" style="font-size:0.75rem; color:#34d399; margin-top:0.35rem; font-weight:600;"></div>
                        </div>
                    </div>

                    <input type="file" name="surat_file" id="suratFileInput" style="display:none;" accept="image/*,application/pdf" onchange="previewFile(this)">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-absen" style="width:100%; min-height:50px; background:linear-gradient(135deg, var(--indigo-primary) 0%, #4338ca 100%); color:#fff; font-size:1rem; box-shadow:0 8px 25px rgba(99,102,241,0.4);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" x2="11" y1="2" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Kirim Pengajuan Izin / Sakit
                </button>
            </form>
        </div>

        <!-- Right: Daftar Pengajuan & Status Approval -->
        <div style="display:flex; flex-direction:column; gap:1.5rem;">
            
            <!-- Quick Status Cards -->
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem;">
                <div style="padding:1rem; background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.25); border-radius:var(--radius-lg); text-align:center;">
                    <div style="font-size:1.6rem; font-weight:800; color:#fbbf24;">{{ $stats['pending'] }}</div>
                    <div style="font-size:0.75rem; color:#fbbf24; font-weight:700; text-transform:uppercase;">Menunggu</div>
                </div>

                <div style="padding:1rem; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.25); border-radius:var(--radius-lg); text-align:center;">
                    <div style="font-size:1.6rem; font-weight:800; color:#34d399;">{{ $stats['approved'] }}</div>
                    <div style="font-size:0.75rem; color:#34d399; font-weight:700; text-transform:uppercase;">Disetujui</div>
                </div>

                <div style="padding:1rem; background:rgba(244,63,94,0.1); border:1px solid rgba(244,63,94,0.25); border-radius:var(--radius-lg); text-align:center;">
                    <div style="font-size:1.6rem; font-weight:800; color:#f43f5e;">{{ $stats['rejected'] }}</div>
                    <div style="font-size:0.75rem; color:#f43f5e; font-weight:700; text-transform:uppercase;">Ditolak</div>
                </div>
            </div>

            <!-- List of Submissions -->
            <div class="glass-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                    <h3 class="card-title" style="margin-bottom:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        Riwayat & Status Pengajuan
                    </h3>
                    <span style="font-size:0.75rem; color:var(--text-muted);">
                        {{ $activeUser->isSupervisor() ? 'Mode Supervisor: Anda dapat menyetujui/menolak' : 'Menampilkan pengajuan Anda' }}
                    </span>
                </div>

                @if($leaveRequests->isEmpty())
                    <div style="text-align:center; padding:3rem 1rem; color:var(--text-muted);">
                        Belum ada riwayat pengajuan izin atau sakit yang tercatat.
                    </div>
                @else
                    <div style="display:flex; flex-direction:column; gap:1rem;">
                        @foreach($leaveRequests as $req)
                            <div style="padding:1.15rem; background:rgba(15,23,42,0.6); border-radius:var(--radius-lg); border:1px solid var(--border-subtle); display:flex; flex-direction:column; gap:0.75rem;">
                                
                                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                    <div>
                                        <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.25rem;">
                                            <span style="font-weight:700; font-size:1rem; color:#fff;">
                                                {{ $req->user->name }}
                                            </span>
                                            <span class="user-role-badge role-{{ $req->user->role }}">{{ strtoupper($req->user->role) }}</span>
                                            <span style="background:rgba(99,102,241,0.15); color:#818cf8; font-size:0.75rem; font-weight:700; padding:0.2rem 0.5rem; border-radius:4px;">
                                                {{ $req->type }}
                                            </span>
                                        </div>

                                        <div style="font-size:0.8rem; color:var(--text-muted); font-family:var(--font-mono);">
                                            📅 {{ $req->start_date->translatedFormat('d M Y') }} s/d {{ $req->end_date->translatedFormat('d M Y') }}
                                        </div>
                                    </div>

                                    <!-- Status Pill -->
                                    @if($req->status === 'Disetujui')
                                        <span style="background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3); font-size:0.75rem; font-weight:700; padding:0.3rem 0.75rem; border-radius:999px;">
                                            Disetujui
                                        </span>
                                    @elseif($req->status === 'Ditolak')
                                        <span style="background:rgba(244,63,94,0.15); color:#f43f5e; border:1px solid rgba(244,63,94,0.3); font-size:0.75rem; font-weight:700; padding:0.3rem 0.75rem; border-radius:999px;">
                                            Ditolak
                                        </span>
                                    @else
                                        <span style="background:rgba(245,158,11,0.15); color:#fbbf24; border:1px solid rgba(245,158,11,0.3); font-size:0.75rem; font-weight:700; padding:0.3rem 0.75rem; border-radius:999px;">
                                            Menunggu Approval
                                        </span>
                                    @endif
                                </div>

                                <!-- Alasan -->
                                <p style="font-size:0.85rem; color:#cbd5e1; line-height:1.4;">
                                    "{{ $req->alasan }}"
                                </p>

                                <!-- Surat Bukti / Surat Dokter Preview -->
                                @if($req->surat_bukti)
                                    <div style="display:flex; align-items:center; gap:0.75rem; padding:0.5rem 0.75rem; background:rgba(30,41,59,0.5); border-radius:var(--radius-md); border:1px solid var(--border-subtle);">
                                        <img src="{{ $req->surat_bukti }}" alt="Surat Dokter" style="width:40px; height:40px; border-radius:6px; object-fit:cover; border:1px solid var(--border-accent); cursor:pointer;" onclick="previewImageModal('{{ $req->surat_bukti }}', 'Surat Keterangan Dokter / Bukti: {{ $req->user->name }}')">
                                        <div style="flex:1;">
                                            <div style="font-size:0.75rem; font-weight:700; color:#fff;">Lampiran Surat Keterangan Dokter</div>
                                            <div style="font-size:0.7rem; color:var(--text-muted);">Klik thumbnail untuk melihat dokumen berukuran penuh</div>
                                        </div>
                                        <button type="button" class="btn-filter" style="font-size:0.75rem; padding:0.3rem 0.65rem;" onclick="previewImageModal('{{ $req->surat_bukti }}', 'Surat Keterangan Dokter / Bukti: {{ $req->user->name }}')">
                                            Lihat Foto
                                        </button>
                                    </div>
                                @endif

                                <!-- Catatan Atasan if available -->
                                @if($req->catatan_atasan)
                                    <div style="font-size:0.8rem; color:#94a3b8; background:rgba(15,23,42,0.8); padding:0.5rem 0.75rem; border-radius:var(--radius-sm); border-left:3px solid var(--indigo-primary);">
                                        <strong>Catatan Verifikasi:</strong> {{ $req->catatan_atasan }}
                                    </div>
                                @endif

                                <!-- Supervisor Action Panel (Approve / Reject) -->
                                @if($activeUser->isSupervisor() && $req->status === 'Menunggu')
                                    <div style="display:flex; gap:0.5rem; justify-content:flex-end; border-top:1px solid var(--border-subtle); padding-top:0.75rem; margin-top:0.25rem;">
                                        <form action="{{ route('leave.updateStatus', $req->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Disetujui">
                                            <input type="hidden" name="catatan_atasan" value="Surat dokter terverifikasi dan disetujui.">
                                            <button type="submit" class="btn-filter" style="background:rgba(16,185,129,0.2); border-color:rgba(16,185,129,0.4); color:#34d399; font-size:0.8rem; padding:0.4rem 0.85rem;">
                                                ✓ Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('leave.updateStatus', $req->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Ditolak">
                                            <input type="hidden" name="catatan_atasan" value="Bukti pendukung belum memenuhi syarat.">
                                            <button type="submit" class="btn-filter" style="background:rgba(244,63,94,0.2); border-color:rgba(244,63,94,0.4); color:#f43f5e; font-size:0.8rem; padding:0.4rem 0.85rem;">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif($req->user_id === $activeUser->id && $req->status === 'Menunggu')
                                    <div style="display:flex; justify-content:flex-end;">
                                        <form action="{{ route('leave.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:transparent; border:none; color:var(--text-muted); font-size:0.75rem; cursor:pointer;">
                                                Batalkan Pengajuan
                                            </button>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        @endforeach

                        <div style="margin-top:1rem;">
                            {{ $leaveRequests->links() }}
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
function handleLeaveTypeChange() {
    const type = document.getElementById('leaveType').value;
    const label = document.getElementById('labelBukti');
    if (type === 'Sakit') {
        label.innerHTML = 'Unggah Surat Keterangan Dokter: <span style="color:#f43f5e;">*Wajib</span>';
    } else {
        label.innerHTML = 'Unggah Bukti Pendukung (Opsional):';
    }
}

function previewFile(input) {
    const file = input.files[0];
    const container = document.getElementById('filePreviewContainer');
    const img = document.getElementById('filePreviewImg');
    const nameEl = document.getElementById('filePreviewName');

    if (file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                img.style.display = 'inline-block';
                container.style.display = 'block';
                nameEl.textContent = '✓ ' + file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
            };
            reader.readAsDataURL(file);
        } else {
            img.style.display = 'none';
            container.style.display = 'block';
            nameEl.textContent = '✓ ' + file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
        }
    }
}
</script>
@endpush
@endsection
