@extends('layouts.app')

@section('title', 'Backup & Restore Data Sistem - Administrator')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header & Action Shortcuts -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1.25rem;">
        <div>
            <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.35rem;">
                <span class="user-role-badge role-admin" style="font-size:0.75rem;">
                    PANEL ADMINISTRATOR SISTEM
                </span>
                <span style="font-size:0.75rem; color:var(--text-muted);">&bull;</span>
                <span style="font-size:0.8rem; color:#f59e0b; display:inline-flex; align-items:center; gap:0.35rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Pusat Keamanan & Pemulihan Data
                </span>
            </div>
            <h1 style="font-size:1.65rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Backup & Restore Seluruh Data Sistem
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Ekspor cadangan seluruh basis data aplikasi SICAKAP atau pulihkan data sistem dari berkas cadangan resmi.
            </p>
        </div>

        <!-- Quick System Status Badges -->
        <div style="display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center;">
            <div style="background:rgba(15,23,42,0.8); border:1px solid var(--border-subtle); padding:0.45rem 0.85rem; border-radius:var(--radius-md); font-size:0.78rem;">
                <span style="color:var(--text-muted);">Database:</span>
                <strong style="color:#38bdf8; font-family:var(--font-mono); margin-left:4px;">{{ $dbName }}</strong>
            </div>
            <div style="background:rgba(15,23,42,0.8); border:1px solid var(--border-subtle); padding:0.45rem 0.85rem; border-radius:var(--radius-md); font-size:0.78rem;">
                <span style="color:var(--text-muted);">Ukuran Data:</span>
                <strong style="color:#34d399; font-family:var(--font-mono); margin-left:4px;">{{ $formattedDbSize }}</strong>
            </div>
            <div style="background:rgba(15,23,42,0.8); border:1px solid var(--border-subtle); padding:0.45rem 0.85rem; border-radius:var(--radius-md); font-size:0.78rem;">
                <span style="color:var(--text-muted);">Storage Link:</span>
                @if($storageLinked)
                    <strong style="color:#34d399; margin-left:4px;">● Aktif</strong>
                @else
                    <strong style="color:#f43f5e; margin-left:4px;">● Belum Terhubung</strong>
                @endif
            </div>
        </div>
    </div>

    <!-- Metric Stats Grid (Tabel yang Dicadangkan) -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(170px, 1fr)); gap:1rem;">
        @foreach($tableCounts as $key => $table)
            <div class="glass-card" style="padding:1.1rem; border-top:3px solid {{ $table['color'] }}; display:flex; flex-direction:column; justify-content:space-between; gap:0.75rem;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.725rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.04em;">
                        {{ $key }}
                    </span>
                    <span style="width:28px; height:28px; border-radius:8px; background:rgba(255,255,255,0.06); display:flex; align-items:center; justify-content:center; color:{{ $table['color'] }};">
                        @if($key === 'users')
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        @elseif($key === 'shifts')
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        @elseif($key === 'user_schedules')
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                        @elseif($key === 'attendances')
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        @elseif($key === 'activity_logs')
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        @else
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @endif
                    </span>
                </div>
                <div>
                    <div style="font-size:1.65rem; font-weight:800; color:#fff; font-family:var(--font-mono); line-height:1.2;">
                        {{ number_format($table['count'], 0, ',', '.') }}
                    </div>
                    <div style="font-size:0.75rem; color:var(--text-secondary); margin-top:2px;">
                        {{ $table['name'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Two Main Operational Cards: Export (Download) & Import (Restore) -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(460px, 1fr)); gap:1.5rem; align-items:start;">

        <!-- ========================================================================= -->
        <!-- 1. PANEL EKSPOR & UNDUH CADANGAN DATA (BACKUP)                            -->
        <!-- ========================================================================= -->
        <div class="glass-card" style="padding:1.5rem; display:flex; flex-direction:column; gap:1.25rem;">
            <div style="display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--border-subtle); padding-bottom:1rem;">
                <div style="width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg, rgba(99,102,241,0.2) 0%, rgba(59,130,246,0.2) 100%); border:1px solid rgba(99,102,241,0.3); display:flex; align-items:center; justify-content:center; color:#818cf8; flex-shrink:0;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                </div>
                <div>
                    <h2 style="font-size:1.15rem; font-weight:700; color:#fff; margin-bottom:2px;">Ekspor Cadangan (Backup)</h2>
                    <p style="font-size:0.8rem; color:var(--text-muted); margin:0;">
                        Unduh seluruh isi data sistem untuk arsip berkala atau migrasi server.
                    </p>
                </div>
            </div>

            <!-- Informasi Data yang Terkandung -->
            <div style="background:rgba(15,23,42,0.6); border:1px solid var(--border-subtle); border-radius:var(--radius-md); padding:1rem;">
                <div style="font-size:0.78rem; font-weight:700; color:#38bdf8; text-transform:uppercase; margin-bottom:0.5rem; letter-spacing:0.04em;">
                    Cakupan Seluruh Data yang Diekspor:
                </div>
                <ul style="margin:0; padding-left:1.2rem; font-size:0.825rem; color:var(--text-secondary); display:flex; flex-direction:column; gap:0.35rem;">
                    <li><strong>Akun & Profil Pengguna:</strong> Data Admin, Supervisor, Satpam, dan Caraka beserta NIP & password hash.</li>
                    <li><strong>Master Shift:</strong> Kode shift, jam masuk, jam pulang, toleransi keterlambatan, dan deskripsi.</li>
                    <li><strong>Jadwal Roster:</strong> Pembagian shift harian dan penandaan hari libur / off tugas karyawan.</li>
                    <li><strong>Riwayat Absensi:</strong> Jam masuk, jam pulang, durasi kerja, status ketepatan, GPS lokasi, dan URL foto selfie.</li>
                    <li><strong>Logbook Kegiatan:</strong> Catatan patroli satpam, tugas kebersihan caraka, dan foto bukti pelaksanaan.</li>
                    <li><strong>Surat Izin:</strong> Pengajuan izin/sakit, rentang tanggal, surat dokter/bukti, dan status persetujuan atasan.</li>
                </ul>
            </div>

            <!-- Download Buttons -->
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <!-- Tombol JSON (Rekomendasi Utama Web) -->
                <a href="{{ route('admin.backup.export') }}" class="btn-absen" style="display:flex; align-items:center; justify-content:center; gap:0.65rem; background:linear-gradient(135deg, var(--indigo-primary) 0%, #4338ca 100%); color:#fff; text-decoration:none; padding:0.9rem 1.25rem; font-size:0.95rem; font-weight:700; box-shadow:0 8px 25px rgba(99,102,241,0.35);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    <span>Unduh Backup Seluruh Data (.JSON)</span>
                </a>
                <div style="font-size:0.725rem; color:var(--text-muted); text-align:center;">
                    Format JSON resmi dapat dipulihkan kapan saja melalui tombol menu <strong>Import Data</strong> di samping.
                </div>

                <!-- Tombol SQL Script (Alternatif untuk phpMyAdmin / CLI) -->
                <div style="margin-top:0.5rem; pt:0.5rem; border-top:1px dashed var(--border-subtle); padding-top:0.75rem;">
                    <a href="{{ route('admin.backup.exportSql') }}" class="btn-filter" style="width:100%; display:flex; align-items:center; justify-content:center; gap:0.5rem; background:rgba(30,41,59,0.8); border-color:var(--border-subtle); color:#94a3b8; padding:0.65rem 1rem; font-size:0.85rem; text-decoration:none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 4v16"/></svg>
                        <span>Unduh Format Query Script (.SQL untuk phpMyAdmin / MySQL)</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 2. PANEL IMPOR & PULIHKAN DATA CADANGAN (RESTORE)                         -->
        <!-- ========================================================================= -->
        <div class="glass-card" style="padding:1.5rem; display:flex; flex-direction:column; gap:1.25rem;">
            <div style="display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--border-subtle); padding-bottom:1rem;">
                <div style="width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg, rgba(245,158,11,0.2) 0%, rgba(234,88,12,0.2) 100%); border:1px solid rgba(245,158,11,0.3); display:flex; align-items:center; justify-content:center; color:#fbbf24; flex-shrink:0;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                </div>
                <div>
                    <h2 style="font-size:1.15rem; font-weight:700; color:#fff; margin-bottom:2px;">Pulihkan Data (Import Restore)</h2>
                    <p style="font-size:0.8rem; color:var(--text-muted); margin:0;">
                        Unggah berkas cadangan .JSON untuk memulihkan seluruh data aplikasi.
                    </p>
                </div>
            </div>

            <!-- Form Upload Backup -->
            <form action="{{ route('admin.backup.import') }}" method="POST" enctype="multipart/form-data" id="importBackupForm" onsubmit="return confirmImport(event)">
                @csrf

                <!-- Dropzone File Upload -->
                <div class="form-group">
                    <label class="form-label" style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Pilih Berkas Cadangan (.JSON): <span style="color:#ef4444;">*</span></span>
                        <span style="font-size:0.725rem; color:#38bdf8;">Maksimal 50 MB</span>
                    </label>

                    <div style="position:relative; border:2px dashed var(--border-subtle); border-radius:var(--radius-md); padding:1.5rem 1rem; text-align:center; background:rgba(15,23,42,0.6); transition:all 0.2s;" id="backupDropzone">
                        <input type="file" name="backup_file" id="backupFileInput" accept=".json,application/json" required 
                            style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:5;"
                            onchange="handleBackupFileSelect(this)">

                        <div id="backupPlaceholder">
                            <div style="width:44px; height:44px; margin:0 auto 0.5rem; border-radius:50%; background:rgba(245,158,11,0.15); color:#fbbf24; display:flex; align-items:center; justify-content:center;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="12" y2="18"/><line x1="9" x2="15" y1="15" y2="15"/></svg>
                            </div>
                            <div style="font-size:0.875rem; font-weight:600; color:#fff; margin-bottom:0.25rem;">
                                Klik atau seret berkas backup (.JSON) ke sini
                            </div>
                            <div style="font-size:0.75rem; color:var(--text-muted);">
                                Format resmi: <code>SICAKAP_FULL_BACKUP_*.json</code>
                            </div>
                        </div>

                        <!-- Selected File Preview -->
                        <div id="backupFileInfo" style="display:none; flex-direction:column; align-items:center; gap:0.4rem;">
                            <div style="display:flex; align-items:center; gap:0.5rem;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                <span id="backupFileName" style="font-weight:700; color:#fff; font-size:0.875rem; font-family:var(--font-mono);">-</span>
                            </div>
                            <span id="backupFileSize" style="font-size:0.75rem; color:#38bdf8;">-</span>
                            <button type="button" onclick="resetBackupFile()" style="margin-top:0.25rem; font-size:0.75rem; color:#f43f5e; background:transparent; border:none; cursor:pointer; text-decoration:underline;">
                                Ganti Berkas Lain
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mode Pemulihan Data (Radio Choice) -->
                <div class="form-group" style="margin-top:1.25rem;">
                    <label class="form-label" style="font-size:0.85rem; font-weight:700;">
                        Pilih Metode Pemulihan Data:
                    </label>

                    <div style="display:flex; flex-direction:column; gap:0.75rem; margin-top:0.5rem;">
                        <!-- Mode 1: Merge / Upsert -->
                        <label style="display:flex; align-items:flex-start; gap:0.75rem; padding:0.85rem 1rem; background:rgba(30,41,59,0.7); border:1px solid rgba(99,102,241,0.3); border-radius:var(--radius-md); cursor:pointer; transition:all 0.2s;" class="restore-mode-option">
                            <input type="radio" name="mode" value="merge" checked style="accent-color:var(--indigo-primary); margin-top:3px;">
                            <div style="flex:1;">
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    <strong style="color:#fff; font-size:0.875rem;">Mode 1: Gabungkan & Update (Merge / Upsert)</strong>
                                    <span style="background:rgba(16,185,129,0.15); color:#34d399; font-size:0.68rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:999px;">Rekomendasi Aman</span>
                                </div>
                                <p style="font-size:0.75rem; color:var(--text-muted); margin:0.25rem 0 0 0; line-height:1.4;">
                                    Memperbarui baris data yang sudah ada dan menambahkan data baru tanpa menghapus riwayat atau transaksi lain yang sudah ada sebelumnya di sistem.
                                </p>
                            </div>
                        </label>

                        <!-- Mode 2: Replace / Fresh Restore -->
                        <label style="display:flex; align-items:flex-start; gap:0.75rem; padding:0.85rem 1rem; background:rgba(30,41,59,0.7); border:1px solid rgba(244,63,94,0.3); border-radius:var(--radius-md); cursor:pointer; transition:all 0.2s;" class="restore-mode-option">
                            <input type="radio" name="mode" value="replace" style="accent-color:#f43f5e; margin-top:3px;">
                            <div style="flex:1;">
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    <strong style="color:#fda4af; font-size:0.875rem;">Mode 2: Timpa Bersih (Full Replace / Restore Bersih)</strong>
                                    <span style="background:rgba(244,63,94,0.15); color:#f43f5e; font-size:0.68rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:999px;">Peringatan</span>
                                </div>
                                <p style="font-size:0.75rem; color:var(--text-muted); margin:0.25rem 0 0 0; line-height:1.4;">
                                    Menghapus bersih seluruh data tabel operasional dan menggantikannya secara utuh dengan isi berkas backup yang diunggah. Akun administrator Anda yang aktif tetap dipertahankan.
                                </p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="btnSubmitRestore" class="btn-absen" style="width:100%; margin-top:1rem; display:flex; align-items:center; justify-content:center; gap:0.5rem; background:linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color:#0f172a; padding:0.85rem; font-size:0.95rem; font-weight:800; box-shadow:0 8px 25px rgba(245,158,11,0.35);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                    <span>Mulai Proses Pemulihan Data (Restore)</span>
                </button>
            </form>
        </div>

    </div>

    <!-- Safety Tips & Technical Notes -->
    <div class="glass-card" style="padding:1.25rem; background:rgba(15,23,42,0.5); border-left:4px solid #38bdf8;">
        <div style="display:flex; align-items:flex-start; gap:0.85rem;">
            <div style="color:#38bdf8; font-size:1.25rem; line-height:1;">💡</div>
            <div style="font-size:0.825rem; color:var(--text-secondary); line-height:1.5;">
                <strong style="color:#fff;">Petunjuk & Praktik Terbaik Pemeliharaan Data:</strong>
                <ul style="margin:0.35rem 0 0 0; padding-left:1.2rem; display:flex; flex-direction:column; gap:0.25rem;">
                    <li>Lakukan backup berkala (misal: setiap akhir pekan atau akhir bulan) dan simpan berkas di media penyimpanan eksternal atau cloud yang aman.</li>
                    <li>Sebelum melakukan pembaruan sistem besar atau pengosongan jadwal roster bulanan, disarankan untuk mengunduh salinan backup terlebih dahulu.</li>
                    <li>Seluruh transaksi impor dilindungi dengan <em>Database Transaction Safety</em>: jika berkas rusak atau terjadi anomali di tengah proses, sistem otomatis membatalkan perubahan (Rollback) sehingga basis data tetap aman.</li>
                </ul>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function handleBackupFileSelect(input) {
    const placeholder = document.getElementById('backupPlaceholder');
    const fileInfo = document.getElementById('backupFileInfo');
    const fileName = document.getElementById('backupFileName');
    const fileSize = document.getElementById('backupFileSize');
    const dropzone = document.getElementById('backupDropzone');

    if (!input.files || !input.files[0]) {
        return;
    }

    const file = input.files[0];
    const maxSizeBytes = 50 * 1024 * 1024; // 50MB

    if (file.size > maxSizeBytes) {
        Swal.fire({
            icon: 'error',
            title: 'Berkas Terlalu Besar',
            text: 'Ukuran berkas melebihi batas maksimal 50 MB (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB).',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#6366f1'
        });
        resetBackupFile();
        return;
    }

    if (!file.name.toLowerCase().endsWith('.json')) {
        Swal.fire({
            icon: 'warning',
            title: 'Format Berkas Salah',
            text: 'Format file tidak didukung! Pastikan berkas berakhiran ekstensi .json yang diunduh dari menu Export SICAKAP.',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#6366f1'
        });
        resetBackupFile();
        return;
    }

    fileName.textContent = file.name;
    fileSize.textContent = '(' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
    placeholder.style.display = 'none';
    fileInfo.style.display = 'flex';
    dropzone.style.borderColor = '#10b981';
}

function resetBackupFile() {
    const input = document.getElementById('backupFileInput');
    const placeholder = document.getElementById('backupPlaceholder');
    const fileInfo = document.getElementById('backupFileInfo');
    const dropzone = document.getElementById('backupDropzone');

    input.value = '';
    placeholder.style.display = 'block';
    fileInfo.style.display = 'none';
    dropzone.style.borderColor = 'var(--border-subtle)';
}

function confirmImport(event) {
    event.preventDefault();

    const input = document.getElementById('backupFileInput');
    if (!input.files || input.files.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Berkas Belum Dipilih',
            text: 'Silakan pilih berkas cadangan .json terlebih dahulu sebelum memulai proses pemulihan.',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#6366f1'
        });
        return false;
    }

    const form = document.getElementById('importBackupForm');
    const mode = form.elements['mode'].value;

    let warningText = 'Data dari berkas cadangan akan digabungkan (Merge/Update) ke dalam sistem.';
    let confirmBtnText = 'Ya, Mulai Restore!';
    let confirmBtnColor = '#f59e0b';

    if (mode === 'replace') {
        warningText = 'PERINGATAN: Seluruh data operasional lama akan DIHAPUS BERSIH dan digantikan sepenuhnya dengan isi berkas backup ini. Pastikan Anda telah mengunduh backup terkini!';
        confirmBtnText = 'Ya, Timpa Bersih Seluruh Data!';
        confirmBtnColor = '#f43f5e';
    }

    Swal.fire({
        title: 'Konfirmasi Pemulihan Data',
        text: warningText,
        icon: mode === 'replace' ? 'warning' : 'question',
        showCancelButton: true,
        confirmButtonColor: confirmBtnColor,
        cancelButtonColor: '#475569',
        confirmButtonText: confirmBtnText,
        cancelButtonText: 'Batal',
        background: '#0f172a',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sedang Memulihkan Data...',
                html: '<div style="font-size:0.875rem; color:#94a3b8; margin-top:0.5rem;">Mohon tidak menutup jendela atau menyegarkan halaman sampai proses selesai.</div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: '#0f172a',
                color: '#fff'
            });
            form.submit();
        }
    });

    return false;
}
</script>
@endpush
@endsection
