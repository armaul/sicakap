@extends('layouts.app')

@section('title', $activeUser->isSupervisor() ? 'Menu Utama - Rekapitulasi & Monitoring Kehadiran' : 'Menu Utama - Dashboard Absensi Satpam & Caraka')

@section('content')

@if($activeUser->isSupervisor() && $adminMonitoring)
    {{-- ========================================================================= --}}
    {{-- 1. HALAMAN REKAPAN & MONITORING REAL-TIME (ROLE ADMIN & SUPERVISOR)       --}}
    {{--    Tampil murni sebagai dashboard pemantauan tanpa kamera & tombol absen  --}}
    {{-- ========================================================================= --}}
    <div style="display:flex; flex-direction:column; gap:1.75rem;">

        <!-- Header Panel & Real-Time Digital Clock -->
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1.25rem;">
            <div>
                <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.35rem;">
                    <span class="user-role-badge role-admin" style="font-size:0.75rem;">
                        PANEL MONITORING & REKAPAN OPERASIONAL
                    </span>
                    <span style="font-size:0.75rem; color:var(--text-muted);">&bull;</span>
                    <span style="font-size:0.8rem; color:#34d399; display:inline-flex; align-items:center; gap:0.35rem;">
                        <span class="pulse-dot"></span> Live Monitoring Hari Ini
                    </span>
                </div>
                <h1 style="font-size:1.65rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                    Rekapitulasi Kehadiran Personil Hari Ini
                </h1>
                <p style="color:var(--text-secondary); font-size:0.875rem;">
                    Pantau status kehadiran real-time, swafoto absensi, jadwal shift, dan logbook kegiatan Satpam & Caraka.
                </p>
            </div>

            <!-- Real-Time Clock Box -->
            <div class="clock-card" style="padding:0.75rem 1.25rem; min-width:240px; text-align:center;">
                <div class="clock-badge" style="font-size:0.65rem; margin-bottom:0.2rem;">
                    <span class="pulse-dot"></span> WAKTU SISTEM (WIB)
                </div>
                <div class="digital-time" style="font-size:2rem; margin:0.1rem 0;">
                    <span id="clockHours">--</span><span class="digital-colon">:</span><span id="clockMinutes">--</span><span class="digital-colon">:</span><span id="clockSeconds" class="digital-seconds" style="font-size:1.3rem;">--</span>
                </div>
                <div class="digital-date" id="clockDate" style="font-size:0.75rem;">
                    <span>📅</span> {{ $today->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>

        <!-- Quick Action Shortcuts -->
        <div style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:center;">
            @if($activeUser->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(99,102,241,0.15); border-color:rgba(99,102,241,0.3); color:#a5b4fc;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Kelola Pengguna
                </a>
                <a href="{{ route('admin.shifts.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(245,158,11,0.15); border-color:rgba(245,158,11,0.3); color:#fcd34d;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Kelola Shift
                </a>
            @endif
            <a href="{{ route('attendances.history') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                Rekap Riwayat & Ekspor CSV
            </a>
            <a href="{{ route('leave.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Daftar Izin & Cuti
            </a>
            <a href="{{ route('activities.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                Logbook Seluruh Kegiatan
            </a>
        </div>

        <!-- KPI Metric Cards Grid (6 Ringkasan Real-Time) -->
        <div class="kpi-grid admin-kpi-grid" style="margin-bottom:0;">
            <!-- Total Personil -->
            <div class="kpi-card">
                <div class="kpi-icon" style="background:rgba(99,102,241,0.15); color:#818cf8;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <div class="kpi-value">{{ $adminMonitoring['totalStaff'] }}</div>
                    <div class="kpi-label">Total Personil</div>
                </div>
            </div>

            <!-- Sedang Bertugas -->
            <div class="kpi-card" style="border-color:rgba(16,185,129,0.3); background:linear-gradient(135deg, rgba(30,41,59,0.7) 0%, rgba(16,185,129,0.08) 100%);">
                <div class="kpi-icon" style="background:rgba(16,185,129,0.15); color:#34d399;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="kpi-value" style="color:#34d399;">{{ $adminMonitoring['onDutyCount'] }}</div>
                    <div class="kpi-label" style="display:flex; align-items:center; gap:0.35rem;">
                        <span class="pulse-dot"></span> Sedang Bertugas
                    </div>
                </div>
            </div>

            <!-- Hadir Hari Ini -->
            <div class="kpi-card">
                <div class="kpi-icon" style="background:rgba(6,182,212,0.15); color:#22d3ee;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <div class="kpi-value">{{ $adminMonitoring['hadirCount'] }}</div>
                    <div class="kpi-label">Hadir Hari Ini</div>
                    <div style="font-size:0.7rem; color:var(--text-muted); margin-top:2px;">
                        <span style="color:#34d399;">{{ $adminMonitoring['onTimeCount'] }} Tepat</span> &bull; 
                        <span style="color:#fbbf24;">{{ $adminMonitoring['lateCount'] }} Terlambat</span>
                    </div>
                </div>
            </div>

            <!-- Selesai Pulang -->
            <div class="kpi-card">
                <div class="kpi-icon" style="background:rgba(148,163,184,0.15); color:#cbd5e1;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    <div class="kpi-value">{{ $adminMonitoring['completedCount'] }}</div>
                    <div class="kpi-label">Selesai (Pulang)</div>
                </div>
            </div>

            <!-- Izin / Sakit -->
            <div class="kpi-card">
                <div class="kpi-icon" style="background:rgba(245,158,11,0.15); color:#fbbf24;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                    <div class="kpi-value">{{ $adminMonitoring['leaveCount'] }}</div>
                    <div class="kpi-label">Izin / Sakit</div>
                </div>
            </div>

            <!-- Belum Hadir -->
            <div class="kpi-card" style="border-color:{{ $adminMonitoring['notPresentCount'] > 0 ? 'rgba(244,63,94,0.25)' : 'var(--border-subtle)' }};">
                <div class="kpi-icon" style="background:rgba(244,63,94,0.15); color:#fda4af;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                </div>
                <div>
                    <div class="kpi-value" style="color:{{ $adminMonitoring['notPresentCount'] > 0 ? '#f43f5e' : '#fff' }};">{{ $adminMonitoring['notPresentCount'] }}</div>
                    <div class="kpi-label">Belum Absen</div>
                </div>
            </div>
        </div>

        <!-- Tabel Rekapitulasi Presensi Personil Hari Ini -->
        <div class="glass-card" style="padding:0; overflow:hidden;">
            <!-- Header Card & Filter Tabs -->
            <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-subtle); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
                <div>
                    <h3 style="font-size:1.05rem; font-weight:700; color:#fff; display:flex; align-items:center; gap:0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M9 14h6"/><path d="M9 18h6"/><path d="M9 10h6"/></svg>
                        Tabel Rekapan Status Kehadiran Personil Hari Ini ({{ $today->translatedFormat('d F Y') }})
                    </h3>
                    <p style="font-size:0.8rem; color:var(--text-muted); margin-top:2px;">
                        Klik foto thumbnail swafoto untuk melihat bukti kehadiran ukuran penuh.
                    </p>
                </div>

                <!-- Client-Side Filter Tabs -->
                <div class="staff-filter-tabs" id="staffFilterTabs">
                    <button type="button" class="btn-tab-filter active" onclick="filterStaffTable('all', this)">
                        Semua ({{ $adminMonitoring['totalStaff'] }})
                    </button>
                    <button type="button" class="btn-tab-filter" onclick="filterStaffTable('satpam', this)">
                        Satpam
                    </button>
                    <button type="button" class="btn-tab-filter" onclick="filterStaffTable('caraka', this)">
                        Caraka
                    </button>
                    <button type="button" class="btn-tab-filter" onclick="filterStaffTable('onduty', this)" style="color:#34d399;">
                        ● Sedang Bertugas ({{ $adminMonitoring['onDutyCount'] }})
                    </button>
                    <button type="button" class="btn-tab-filter" onclick="filterStaffTable('notpresent', this)" style="color:#fda4af;">
                        Belum Hadir ({{ $adminMonitoring['notPresentCount'] }})
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:40px;">No</th>
                            <th>Personil</th>
                            <th>Peran (Role)</th>
                            <th>Shift Kerja</th>
                            <th>Absen Masuk</th>
                            <th>Lokasi Masuk</th>
                            <th>Absen Pulang</th>
                            <th>Durasi Kerja</th>
                            <th>Status Kehadiran</th>
                            <th>Catatan Tugas</th>
                        </tr>
                    </thead>
                    <tbody id="staffRecapTbody">
                        @forelse($adminMonitoring['staffRecap'] as $index => $item)
                            @php
                                $staff = $item->user;
                                $att = $item->attendance;
                                $leave = $item->leave;

                                $hasIn = $att && !is_null($att->jam_masuk);
                                $hasOut = $att && !is_null($att->jam_pulang);

                                // Filter state
                                $filterState = 'not_present';
                                if ($leave) {
                                    $filterState = 'leave';
                                } elseif ($hasIn && !$hasOut) {
                                    $filterState = 'on_duty';
                                } elseif ($hasOut) {
                                    $filterState = 'completed';
                                }
                            @endphp
                            <tr class="staff-recap-row" data-role="{{ $staff->role }}" data-status="{{ $filterState }}">
                                <td style="color:var(--text-muted); font-family:var(--font-mono); font-size:0.8rem;">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Personil Avatar & Nama -->
                                <td>
                                    <div style="display:flex; align-items:center; gap:0.75rem;">
                                        <img src="{{ $staff->avatar }}" alt="{{ $staff->name }}" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid var(--border-accent);">
                                        <div>
                                            <div style="font-weight:700; color:#fff; font-size:0.9rem;">{{ $staff->name }}</div>
                                            <div style="font-size:0.75rem; color:var(--text-muted); font-family:var(--font-mono);">{{ $staff->nip }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Peran -->
                                <td>
                                    <span class="user-role-badge role-{{ $staff->role }}">
                                        {{ strtoupper($staff->role) }}
                                    </span>
                                </td>

                                <!-- Shift Kerja -->
                                <td>
                                    @if($att && $att->shift)
                                        <div style="font-weight:600; color:#fff; font-size:0.825rem;">{{ $att->shift->name }}</div>
                                        <div style="font-size:0.725rem; color:var(--text-muted); font-family:var(--font-mono);">
                                            {{ substr($att->shift->start_time,0,5) }} - {{ substr($att->shift->end_time,0,5) }} WIB
                                        </div>
                                    @else
                                        <span style="font-size:0.8rem; color:var(--text-muted);">-</span>
                                    @endif
                                </td>

                                <!-- Jam & Foto Masuk -->
                                <td>
                                    @if($hasIn)
                                        <div style="display:flex; align-items:center; gap:0.5rem;">
                                            @if($att->foto_masuk)
                                                <img src="{{ $att->foto_masuk }}" alt="Swafoto Masuk" class="selfie-thumbnail" onclick="previewImageModal('{{ $att->foto_masuk }}', 'Bukti Swafoto Masuk - {{ $staff->name }}')">
                                            @endif
                                            <div>
                                                <span style="font-family:var(--font-mono); font-size:0.925rem; font-weight:700; color:#34d399;">
                                                    {{ $att->jam_masuk->format('H:i') }}
                                                </span>
                                                <span style="font-size:0.7rem; color:var(--text-muted);">WIB</span>
                                            </div>
                                        </div>
                                    @else
                                        <span style="color:var(--text-muted); font-size:0.8rem;">--:--</span>
                                    @endif
                                </td>

                                <!-- Lokasi Masuk -->
                                <td style="font-size:0.8rem; max-width:180px; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;" title="{{ $att->lokasi_masuk ?? '-' }}">
                                    @if($hasIn)
                                        <span style="color:#94a3b8;">{{ $att->lokasi_masuk ?? 'Pos Satpam' }}</span>
                                    @else
                                        <span style="color:var(--text-muted);">-</span>
                                    @endif
                                </td>

                                <!-- Jam & Foto Pulang -->
                                <td>
                                    @if($hasOut)
                                        <div style="display:flex; align-items:center; gap:0.5rem;">
                                            @if($att->foto_pulang)
                                                <img src="{{ $att->foto_pulang }}" alt="Swafoto Pulang" class="selfie-thumbnail" onclick="previewImageModal('{{ $att->foto_pulang }}', 'Bukti Swafoto Pulang - {{ $staff->name }}')">
                                            @endif
                                            <div>
                                                <span style="font-family:var(--font-mono); font-size:0.925rem; font-weight:700; color:#f43f5e;">
                                                    {{ $att->jam_pulang->format('H:i') }}
                                                </span>
                                                <span style="font-size:0.7rem; color:var(--text-muted);">WIB</span>
                                            </div>
                                        </div>
                                    @elseif($hasIn)
                                        <span style="font-size:0.75rem; color:#34d399; font-weight:700; background:rgba(16,185,129,0.12); padding:2px 8px; border-radius:4px; display:inline-flex; align-items:center; gap:4px;">
                                            <span class="pulse-dot" style="width:6px; height:6px;"></span> Bertugas
                                        </span>
                                    @else
                                        <span style="color:var(--text-muted); font-size:0.8rem;">--:--</span>
                                    @endif
                                </td>

                                <!-- Durasi Kerja -->
                                <td style="font-family:var(--font-mono); font-size:0.825rem; color:#38bdf8;">
                                    {{ $att->durasi_kerja ?? ($hasIn ? 'Sedang dihitung' : '-') }}
                                </td>

                                <!-- Status Kehadiran -->
                                <td>
                                    @if($leave)
                                        <span style="font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px; background:rgba(245,158,11,0.15); color:#fbbf24; border:1px solid rgba(245,158,11,0.3);">
                                            {{ $leave->type }} (Izin)
                                        </span>
                                    @elseif($hasIn)
                                        @if(str_contains($att->status, 'Tepat Waktu'))
                                            <span style="font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px; background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3);">
                                                {{ $att->status }}
                                            </span>
                                        @else
                                            <span style="font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px; background:rgba(245,158,11,0.15); color:#fbbf24; border:1px solid rgba(245,158,11,0.3);">
                                                {{ $att->status }}
                                            </span>
                                        @endif
                                    @else
                                        <span style="font-size:0.75rem; font-weight:600; padding:0.25rem 0.65rem; border-radius:999px; background:rgba(148,163,184,0.1); color:var(--text-muted); border:1px solid var(--border-subtle);">
                                            Belum Absen
                                        </span>
                                    @endif
                                </td>

                                <!-- Catatan Tugas -->
                                <td style="font-size:0.8rem; max-width:200px; color:var(--text-secondary);">
                                    {{ $att->catatan ?? ($leave->reason ?? '-') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align:center; padding:2.5rem; color:var(--text-muted);">
                                    Belum ada data personil Satpam atau Caraka.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Live Feed Logbook Kegiatan Personil Hari Ini -->
        <div class="glass-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 class="card-title" style="margin-bottom:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Aktivitas & Logbook Kegiatan Personil Hari Ini
                </h3>

                <a href="{{ route('activities.index') }}" class="btn-filter" style="font-size:0.8rem; padding:0.4rem 0.85rem;">
                    Buka Semua Logbook &rarr;
                </a>
            </div>

            @if($adminMonitoring['allTodayActivities']->isEmpty())
                <div style="text-align:center; padding:2rem 1rem; color:var(--text-muted); font-size:0.875rem;">
                    Belum ada log kegiatan lapangan yang dikirim oleh Satpam atau Caraka hari ini.
                </div>
            @else
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    @foreach($adminMonitoring['allTodayActivities'] as $act)
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:0.85rem 1.25rem; background:rgba(15,23,42,0.6); border-radius:var(--radius-md); border:1px solid var(--border-subtle); flex-wrap:wrap; gap:0.75rem;">
                            <div style="display:flex; align-items:center; gap:1rem;">
                                <img src="{{ $act->user->avatar }}" alt="{{ $act->user->name }}" style="width:34px; height:34px; border-radius:50%; object-fit:cover; border:2px solid var(--border-accent);">
                                <div>
                                    <div style="display:flex; align-items:center; gap:0.5rem;">
                                        <span style="font-weight:700; color:#fff; font-size:0.9rem;">{{ $act->user->name }}</span>
                                        <span class="user-role-badge role-{{ $act->user->role }}" style="font-size:0.6rem; padding:1px 6px;">{{ strtoupper($act->user->role) }}</span>
                                        <span style="font-family:var(--font-mono); font-size:0.75rem; color:var(--cyan-primary);">
                                            {{ substr($act->time_recorded ?? $act->created_at->format('H:i:s'), 0, 5) }} WIB
                                        </span>
                                    </div>
                                    <div style="font-size:0.8rem; color:var(--text-secondary); margin-top:2px;">
                                        <strong style="color:#e2e8f0;">{{ $act->title }}</strong> &bull; {{ $act->location ?? 'Pos Utama' }} &bull; {{ $act->description }}
                                    </div>
                                </div>
                            </div>

                            <span style="background:rgba(16,185,129,0.15); color:#34d399; font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px;">
                                {{ $act->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
    <script>
    function filterStaffTable(filter, btnEl) {
        const rows = document.querySelectorAll('.staff-recap-row');
        const buttons = document.querySelectorAll('#staffFilterTabs .btn-tab-filter');

        buttons.forEach(b => b.classList.remove('active'));
        if (btnEl) btnEl.classList.add('active');

        rows.forEach(row => {
            const role = row.getAttribute('data-role');
            const status = row.getAttribute('data-status');

            if (filter === 'all') {
                row.style.display = '';
            } else if (filter === 'satpam') {
                row.style.display = (role === 'satpam') ? '' : 'none';
            } else if (filter === 'caraka') {
                row.style.display = (role === 'caraka') ? '' : 'none';
            } else if (filter === 'onduty') {
                row.style.display = (status === 'on_duty') ? '' : 'none';
            } else if (filter === 'notpresent') {
                row.style.display = (status === 'not_present') ? '' : 'none';
            }
        });
    }
    </script>
    @endpush

@else
    {{-- ========================================================================= --}}
    {{-- 2. HALAMAN ABSENSI LAPANGAN (ROLE SATPAM & CARAKA)                        --}}
    {{--    Lengkap dengan kamera swafoto real-time HTML5 & tombol absen masuk/pulang--}}
    {{-- ========================================================================= --}}
    @php
        $hasClockedIn = $attendance && !is_null($attendance->jam_masuk);
        $hasClockedOut = $attendance && !is_null($attendance->jam_pulang);
    @endphp

    <div class="dashboard-attendance-grid">

        <!-- Left Column: Clock & Shift Info -->
        <div class="dashboard-col-left">
            
            @if($isScheduledOff)
                <div class="glass-card" style="border-color:rgba(244,63,94,0.4); background:linear-gradient(135deg, rgba(30,41,59,0.95) 0%, rgba(244,63,94,0.15) 100%);">
                    <div style="display:flex; align-items:center; gap:0.85rem;">
                        <div style="width:44px; height:44px; border-radius:10px; background:rgba(244,63,94,0.2); border:1px solid rgba(244,63,94,0.4); display:flex; align-items:center; justify-content:center; font-size:1.4rem; flex-shrink:0;">
                            🏖️
                        </div>
                        <div>
                            <div style="font-size:0.75rem; font-weight:700; color:#fda4af; text-transform:uppercase; letter-spacing:0.05em;">
                                Status Roster Hari Ini
                            </div>
                            <div style="font-weight:800; color:#fff; font-size:1.05rem;">
                                Hari Ini Anda Terjadwal LIBUR / OFF Tugas
                            </div>
                            <div style="font-size:0.75rem; color:#cbd5e1; margin-top:2px;">
                                {{ $todaySchedule->notes ? 'Keterangan: ' . $todaySchedule->notes : 'Anda tidak diwajibkan melakukan absen masuk hari ini. Selamat beristirahat!' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 1. Real-Time Digital Clock -->
            <div class="clock-card">
                <div class="clock-badge">
                    <span class="pulse-dot"></span>
                    <span>WAKTU REAL-TIME SISTEM (WIB)</span>
                </div>
                
                <div class="digital-time">
                    <span id="clockHours">--</span><span class="digital-colon">:</span><span id="clockMinutes">--</span><span class="digital-colon">:</span><span id="clockSeconds" class="digital-seconds">--</span>
                </div>

                <div class="digital-date" id="clockDate">
                    <span>📅</span> Memuat tanggal...
                </div>
            </div>

            <!-- 2. Informasi Jadwal Shift Pengguna Hari Ini -->
            @if($isScheduledOff)
                <div class="glass-card shift-card" style="border-color:rgba(244,63,94,0.35); background:linear-gradient(135deg, rgba(30,41,59,0.9) 0%, rgba(244,63,94,0.1) 100%);">
                    <div class="shift-header-flex">
                        <div>
                            <div style="font-size:0.75rem; font-weight:700; color:#fda4af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">
                                Status Roster Jadwal Hari Ini
                            </div>
                            <h2 class="shift-title-text" style="color:#fff;">Libur / OFF Tugas</h2>
                        </div>
                        <span style="background:rgba(244,63,94,0.18); color:#fda4af; border:1px solid rgba(244,63,94,0.4); font-size:0.75rem; font-weight:700; padding:0.3rem 0.65rem; border-radius:999px;">
                            🏖️ Bebas Tugas
                        </span>
                    </div>

                    <div class="shift-time-range" style="color:#fda4af; font-size:1.15rem;">
                        Tidak Ada Jadwal Dinas Hari Ini
                    </div>

                    <p class="shift-desc">
                        {{ $todaySchedule->notes ? 'Keterangan: ' . $todaySchedule->notes : 'Hari ini Anda terjadwal libur sesuai pembagian roster kerja operasional. Anda tidak perlu berada di lokasi kerja dan absen masuk dinonaktifkan.' }}
                    </p>

                    @if($nextWorkingSchedule)
                        <div style="padding:0.75rem 1rem; background:rgba(15,23,42,0.65); border-radius:var(--radius-md); border:1px solid rgba(56,189,248,0.25); margin-top:0.5rem; font-size:0.825rem;">
                            <span style="color:#94a3b8; display:block; font-size:0.725rem; text-transform:uppercase; font-weight:600; letter-spacing:0.04em;">Jadwal Masuk Dinas Berikutnya:</span>
                            <div style="font-weight:700; color:#38bdf8; font-size:0.95rem; margin-top:2px;">
                                {{ \Carbon\Carbon::parse($nextWorkingSchedule->date)->translatedFormat('l, d F Y') }}
                            </div>
                            <div style="color:#cbd5e1; font-size:0.78rem; margin-top:2px;">
                                Shift: <strong>{{ $nextWorkingSchedule->shift->name ?? 'Shift Reguler' }}</strong> ({{ substr($nextWorkingSchedule->shift->start_time ?? '00:00', 0, 5) }} - {{ substr($nextWorkingSchedule->shift->end_time ?? '00:00', 0, 5) }} WIB)
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="glass-card shift-card {{ $selectedShift->is_night_shift ? 'night-shift' : '' }}">
                    <div class="shift-header-flex">
                        <div>
                            <div style="font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">
                                Jadwal Shift Anda Hari Ini
                            </div>
                            <h2 class="shift-title-text">{{ $selectedShift->name }}</h2>
                        </div>

                        @if($selectedShift->is_night_shift)
                            <span class="shift-badge-night">
                                <span>🌙</span> Shift Malam (Lintas Hari)
                            </span>
                        @else
                            <span style="background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3); font-size:0.75rem; font-weight:700; padding:0.3rem 0.65rem; border-radius:999px;">
                                <span>☀️</span> Shift Reguler
                            </span>
                        @endif
                    </div>

                    <!-- Jam Shift & Toleransi -->
                    <div class="shift-time-range">
                        {{ substr($selectedShift->start_time, 0, 5) }} - {{ substr($selectedShift->end_time, 0, 5) }} WIB
                    </div>

                    <p class="shift-desc">
                        {{ $selectedShift->description }}
                    </p>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; padding:0.85rem; background:rgba(15,23,42,0.6); border-radius:var(--radius-md); border:1px solid var(--border-subtle); margin-bottom:1rem; font-size:0.8rem;">
                        <div>
                            <span style="color:var(--text-muted); display:block;">Toleransi Keterlambatan:</span>
                            <strong style="color:var(--text-primary);">{{ $selectedShift->grace_period_minutes }} Menit</strong>
                        </div>
                        <div>
                            <span style="color:var(--text-muted); display:block;">Peran Tugas:</span>
                            <strong style="color:var(--cyan-primary); text-transform:uppercase;">{{ $selectedShift->role }}</strong>
                        </div>
                    </div>

                    <!-- Shift Switcher if assigned to another shift -->
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="shiftSelector" class="form-label" style="font-size:0.8rem;">Konfirmasi Shift Kerja Hari Ini:</label>
                        <select id="shiftSelector" class="form-control" style="font-size:0.85rem; padding:0.55rem 0.85rem;" {{ $hasClockedIn ? 'disabled' : '' }}>
                            @foreach($shifts as $sh)
                                <option value="{{ $sh->id }}" {{ $selectedShift->id === $sh->id ? 'selected' : '' }}>
                                    {{ $sh->name }} ({{ substr($sh->start_time,0,5) }} - {{ substr($sh->end_time,0,5) }} WIB{{ $sh->is_night_shift ? ' Lintas Hari' : '' }})
                                </option>
                            @endforeach
                        </select>
                        @if($hasClockedIn)
                            <small style="color:var(--text-muted); font-size:0.75rem; margin-top:4px; display:block;">
                                Shift terkunci karena Anda sudah melakukan Absen Masuk.
                            </small>
                        @endif
                    </div>
                </div>
            @endif

            <!-- 3. Catatan Jaga / Pos Penempatan -->
            <div class="glass-card">
                <h3 class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    Catatan Pos / Aktivitas Hari Ini
                </h3>
                <div class="form-group" style="margin-bottom:0;">
                    <input type="text" id="catatanMasuk" class="form-control" 
                        placeholder="{{ $activeUser->isSatpam() ? 'Contoh: Jaga Pos Gerbang Utama, Patroli Perimeter Timur' : 'Contoh: Kebersihan Lobby Lantai 1, Pengiriman Surat Divisi' }}" 
                        value="{{ $attendance?->catatan ?? '' }}" {{ $hasClockedOut ? 'disabled' : '' }}>
                    <small style="color:var(--text-muted); font-size:0.75rem; margin-top:4px; display:block;">
                        Opsional: masukkan keterangan pos atau area tugas Anda.
                    </small>
                </div>
            </div>

            <!-- 4. Quick Personal KPI Stats -->
            <div class="glass-card" style="padding:1.25rem;">
                <div style="font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:0.75rem;">
                    Rekap Kehadiran Bulan Ini ({{ $today->translatedFormat('F Y') }})
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:0.75rem; text-align:center;">
                    <div style="padding:0.6rem; background:rgba(15,23,42,0.5); border-radius:var(--radius-md); border:1px solid var(--border-subtle);">
                        <div style="font-size:1.4rem; font-weight:800; color:#fff;">{{ $stats['totalDays'] }}</div>
                        <div style="font-size:0.7rem; color:var(--text-muted); font-weight:600;">Hadir</div>
                    </div>
                    <div style="padding:0.6rem; background:rgba(16,185,129,0.1); border-radius:var(--radius-md); border:1px solid rgba(16,185,129,0.25);">
                        <div style="font-size:1.4rem; font-weight:800; color:#34d399;">{{ $stats['onTimeDays'] }}</div>
                        <div style="font-size:0.7rem; color:#34d399; font-weight:600;">Tepat Waktu</div>
                    </div>
                    <div style="padding:0.6rem; background:rgba(245,158,11,0.1); border-radius:var(--radius-md); border:1px solid rgba(245,158,11,0.25);">
                        <div style="font-size:1.4rem; font-weight:800; color:#fbbf24;">{{ $stats['lateDays'] }}</div>
                        <div style="font-size:0.7rem; color:#fbbf24; font-weight:600;">Terlambat</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Live Camera & Absen Action Buttons -->
        <div class="dashboard-col-right">
            
            <!-- Live Camera HTML5 Preview Card -->
            <div class="glass-card" style="text-align:center;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                    <h3 class="card-title" style="margin-bottom:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        Live Preview Swafoto (Selfie)
                    </h3>
                    
                    <button type="button" class="btn-cam-switch" onclick="switchCamera()" title="Ganti Kamera Depan/Belakang">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m20 16-4 4-4-4"/><path d="M4 8v5a4 4 0 0 0 4 4h8"/><path d="m4 8 4-4 4 4"/><path d="M20 16v-5a4 4 0 0 0-4-4H8"/></svg>
                        Ganti Kamera
                    </button>
                </div>

                <!-- HTML5 <video> Live Preview -->
                <div class="camera-container">
                    <video id="webcamVideo" class="camera-video" autoplay playsinline muted style="{{ $isScheduledOff ? 'filter: brightness(0.25) blur(4px);' : '' }}"></video>
                    
                    <!-- Fallback simulator when no physical webcam or in headless browser -->
                    <div id="cameraFallback" style="display:none; width:100%; height:100%; flex-direction:column; align-items:center; justify-content:center; padding:1.5rem; background:linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                        <img src="{{ $activeUser->avatar }}" alt="{{ $activeUser->name }}" style="width:110px; height:110px; border-radius:50%; object-fit:cover; border:3px solid var(--indigo-primary); margin-bottom:1rem; box-shadow:0 0 25px rgba(99,102,241,0.5);">
                        <div style="font-weight:700; color:#fff; font-size:1.05rem;">{{ $activeUser->name }}</div>
                        <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.75rem;">{{ $activeUser->nip }}</div>
                        <p class="fallback-msg" style="font-size:0.75rem; color:#94a3b8; max-width:280px;"></p>
                    </div>

                    <!-- Overlay Face Guide & Scan Beam -->
                    <div class="camera-overlay">
                        <div style="display:flex; justify-content:space-between; width:100%;">
                            @if($isScheduledOff)
                                <span class="camera-status-pill" style="border-color:rgba(244,63,94,0.4); background:rgba(244,63,94,0.2); color:#fda4af;">
                                    <span class="pulse-dot" style="background:#f43f5e;"></span> Status: Libur / OFF Tugas
                                </span>
                            @else
                                <span class="camera-status-pill" id="cameraStatusPill">
                                    <span class="pulse-dot"></span> Live Kamera Aktif
                                </span>
                            @endif
                            <span style="font-size:0.7rem; color:rgba(255,255,255,0.7); background:rgba(0,0,0,0.5); padding:2px 8px; border-radius:4px; font-family:var(--font-mono);">
                                HD 720p
                            </span>
                        </div>

                        @if(!$isScheduledOff)
                            <div class="camera-guide-oval"></div>
                            <div class="scan-line"></div>
                        @endif
                    </div>

                    <!-- PEMBERITAHUAN DI SCAN FOTO: ANDA SEDANG LIBUR -->
                    @if($isScheduledOff)
                        <div class="camera-off-overlay">
                            <div class="camera-off-card">
                                <div style="width:58px; height:58px; border-radius:50%; background:rgba(244,63,94,0.18); border:2px solid rgba(244,63,94,0.45); display:flex; align-items:center; justify-content:center; margin:0 auto 0.65rem; font-size:1.85rem; box-shadow:0 0 25px rgba(244,63,94,0.3);">
                                    🏖️
                                </div>
                                <div style="font-size:0.72rem; font-weight:800; color:#fda4af; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.25rem;">
                                    Pemberitahuan Sistem
                                </div>
                                <h3 style="font-size:1.18rem; font-weight:800; color:#fff; margin-bottom:0.35rem;">
                                    Anda Sedang Libur / OFF Tugas
                                </h3>
                                <p style="font-size:0.8rem; color:#cbd5e1; line-height:1.45; margin-bottom:0.75rem;">
                                    Hari ini Anda tidak memiliki jadwal dinas operasional.<br>Kamera absensi dinonaktifkan.
                                </p>
                                @if($nextWorkingSchedule)
                                    <div style="background:rgba(15,23,42,0.8); border:1px solid rgba(56,189,248,0.25); border-radius:8px; padding:0.55rem 0.85rem; font-size:0.75rem; color:#94a3b8; text-align:left;">
                                        <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; font-weight:600;">Jadwal Masuk Dinas Berikutnya:</div>
                                        <strong style="color:#38bdf8; font-size:0.85rem;">{{ \Carbon\Carbon::parse($nextWorkingSchedule->date)->translatedFormat('l, d F Y') }}</strong>
                                        <div style="color:#cbd5e1; font-size:0.75rem; margin-top:2px;">Shift: <strong>{{ $nextWorkingSchedule->shift->name ?? 'Shift Reguler' }}</strong> ({{ substr($nextWorkingSchedule->shift->start_time ?? '00:00',0,5) }} - {{ substr($nextWorkingSchedule->shift->end_time ?? '00:00',0,5) }} WIB)</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Camera Flash Animation Overlay -->
                    <div class="camera-flash" id="cameraFlash"></div>
                </div>

                <!-- GPS Geolocation & Radius Geofence Bar -->
                <div class="gps-status-box" id="gpsStatusBox" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem;">
                    <div style="display:flex; align-items:center; gap:0.5rem; flex:1; min-width:0;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="gpsIcon" style="flex-shrink:0;"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span id="gpsLocationText" style="text-overflow:ellipsis; overflow:hidden; white-space:nowrap; font-size:0.8rem;">Mendeteksi lokasi GPS kantor...</span>
                    </div>
                    <button type="button" class="btn-preset" id="btnOpenMapModal" onclick="openRadiusMapModal()" style="font-size:0.75rem; padding:0.25rem 0.65rem; background:rgba(99,102,241,0.2); border-color:#818cf8; color:#fff; display:inline-flex; align-items:center; gap:0.35rem; cursor:pointer;" title="Lihat posisi Anda dan radius kantor pada peta">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                        Lihat Peta Radius
                    </button>
                </div>

                <!-- TWO MAIN ACTION BUTTONS AS REQUIRED -->
                <div class="attendance-actions-grid">
                    
                    <!-- TOMBOL HIJAU: Absen Masuk -->
                    <button type="button" 
                        id="btnAbsenMasuk"
                        class="btn-absen btn-absen-masuk {{ $hasClockedIn ? 'completed' : ($isScheduledOff ? 'off-duty' : '') }}"
                        onclick="handleAbsenMasuk()"
                        {{ ($hasClockedIn || $isScheduledOff) ? 'disabled' : '' }}
                        data-is-off="{{ $isScheduledOff ? '1' : '0' }}"
                        title="{{ $isScheduledOff ? 'Hari ini Anda terjadwal Libur / OFF. Absen masuk dinonaktifkan sampai jadwal dinas berikutnya.' : ($hasClockedIn ? 'Anda sudah melakukan Absen Masuk' : 'Ambil Swafoto & Absen Masuk') }}">
                        
                        @if($isScheduledOff)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/></svg>
                            <span>Libur / OFF Tugas</span>
                        @elseif($hasClockedIn)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Sudah Masuk ({{ $attendance->jam_masuk->format('H:i') }})</span>
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                            <span>Absen Masuk</span>
                        @endif
                    </button>

                    <!-- TOMBOL MERAH: Absen Pulang -->
                    <button type="button"
                        id="btnAbsenPulang"
                        class="btn-absen btn-absen-pulang {{ $hasClockedOut ? 'completed' : ($hasClockedIn && !$canClockOut ? 'locked' : '') }}"
                        onclick="handleAbsenPulang()"
                        {{ (!$hasClockedIn || $hasClockedOut || !$canClockOut) ? 'disabled' : '' }}
                        data-can-clock-out="{{ $canClockOut ? '1' : '0' }}"
                        data-end-time="{{ $shiftEndTimeIso }}"
                        data-end-time-formatted="{{ $shiftEndTimeFormatted }}"
                        title="{{ !$hasClockedIn ? 'Tombol ini baru aktif setelah Anda Absen Masuk' : ($hasClockedOut ? 'Anda sudah selesai Absen Pulang' : (!$canClockOut ? 'Belum memasuki jam pulang shift (Pukul ' . $shiftEndTimeFormatted . ')' : 'Ambil Swafoto & Absen Pulang')) }}">
                        
                        @if($hasClockedOut)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Sudah Pulang ({{ $attendance->jam_pulang->format('H:i') }})</span>
                        @elseif($hasClockedIn && !$canClockOut)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <span id="btnPulangText">Belum Jam Pulang ({{ $shiftEndTimeFormatted }})</span>
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                            <span id="btnPulangText">Absen Pulang</span>
                        @endif
                    </button>
                </div>

                <!-- Dynamic Logic Hint -->
                <div style="margin-top:0.75rem; font-size:0.75rem; color:var(--text-muted);" id="attendanceHintBox">
                    @if($isScheduledOff)
                        <span style="color:#fda4af;">🏖️</span> <strong style="color:#fda4af;">Status Roster Libur:</strong> Absen masuk dinonaktifkan karena Anda sedang terjadwal libur hari ini.
                        @if($nextWorkingSchedule)
                            Jadwal dinas berikutnya: <strong style="color:#38bdf8;">{{ \Carbon\Carbon::parse($nextWorkingSchedule->date)->translatedFormat('l, d F Y') }}</strong> ({{ $nextWorkingSchedule->shift->name ?? 'Shift Kerja' }}).
                        @endif
                    @elseif(!$hasClockedIn)
                        <span style="color:#34d399;">●</span> Tombol Hijau ("Absen Masuk") aktif karena Anda belum absen hari ini.
                    @elseif(!$hasClockedOut)
                        @if(!$canClockOut)
                            <span style="color:#f59e0b;">🔒</span> <strong style="color:#f59e0b;">Sedang Bertugas:</strong> Anda sudah absen masuk. Absen Pulang baru dapat dilakukan sesuai ketentuan shift pada pukul <strong style="color:#fff;">{{ $shiftEndTimeFormatted }}</strong>.
                        @else
                            <span style="color:#f43f5e;">●</span> Jam operasional shift telah selesai! Tombol Merah ("Absen Pulang") kini <strong>AKTIF</strong>.
                        @endif
                    @else
                        <span style="color:#60a5fa;">●</span> Kehadiran hari ini lengkap: Anda telah menyelesaikan absen masuk dan pulang.
                    @endif
                </div>
            </div>

            <!-- Attendance Status Summary Card -->
            @if($hasClockedIn)
                <div class="glass-card" style="border-color:rgba(16,185,129,0.3); background:linear-gradient(135deg, rgba(30,41,59,0.85) 0%, rgba(16,185,129,0.06) 100%);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                        <div style="font-weight:700; color:#fff; font-size:0.95rem; display:flex; align-items:center; gap:0.5rem;">
                            <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#10b981;"></span>
                            Status Kehadiran Hari Ini
                        </div>
                        
                        <span class="status-pill-lg {{ str_contains($attendance->status, 'Tepat Waktu') ? 'status-pill-tepat' : 'status-pill-terlambat' }}">
                            {{ $attendance->status }}
                        </span>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <!-- Clock-in Info -->
                        <div style="display:flex; gap:0.75rem; align-items:center; padding:0.75rem; background:rgba(15,23,42,0.6); border-radius:var(--radius-md);">
                            @if($attendance->foto_masuk)
                                <img src="{{ $attendance->foto_masuk }}" alt="Selfie Masuk" class="selfie-thumbnail" onclick="previewImageModal('{{ $attendance->foto_masuk }}', 'Swafoto Absen Masuk - {{ $activeUser->name }}')">
                            @endif
                            <div>
                                <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase;">Jam Masuk:</div>
                                <div style="font-family:var(--font-mono); font-size:1.1rem; font-weight:700; color:#34d399;">
                                    {{ $attendance->jam_masuk->format('H:i:s') }} WIB
                                </div>
                            </div>
                        </div>

                        <!-- Clock-out Info -->
                        <div style="display:flex; gap:0.75rem; align-items:center; padding:0.75rem; background:rgba(15,23,42,0.6); border-radius:var(--radius-md);">
                            @if($attendance->foto_pulang)
                                <img src="{{ $attendance->foto_pulang }}" alt="Selfie Pulang" class="selfie-thumbnail" onclick="previewImageModal('{{ $attendance->foto_pulang }}', 'Swafoto Absen Pulang - {{ $activeUser->name }}')">
                            @else
                                <div style="width:44px; height:44px; border-radius:8px; background:rgba(51,65,85,0.4); display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:0.75rem;">
                                    N/A
                                </div>
                            @endif
                            <div>
                                <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase;">Jam Pulang:</div>
                                <div style="font-family:var(--font-mono); font-size:1.1rem; font-weight:700; color:{{ $hasClockedOut ? '#f43f5e' : 'var(--text-muted)' }};">
                                    {{ $hasClockedOut ? $attendance->jam_pulang->format('H:i:s') . ' WIB' : 'Sedang Bertugas' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($hasClockedOut)
                        <div style="margin-top:1rem; padding:0.75rem 1rem; background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.3); border-radius:var(--radius-md); display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.85rem; color:#cbd5e1; font-weight:600;">Total Durasi Kerja:</span>
                            <span style="font-family:var(--font-mono); font-size:1.1rem; font-weight:800; color:#38bdf8;">
                                {{ $attendance->durasi_kerja }}
                            </span>
                        </div>
                    @endif
                </div>
            @endif

        </div>

    </div>

    <!-- Bottom Section: Aktivitas Hari Ini -->
    <div style="margin-top:2rem;">
        <div class="glass-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 class="card-title" style="margin-bottom:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Log Kegiatan Terkini Anda Hari Ini
                </h3>
                
                <a href="{{ route('activities.index') }}" class="btn-filter" style="font-size:0.8rem; padding:0.4rem 0.85rem;">
                    Buka Logbook Lengkap &rarr;
                </a>
            </div>

            @if($todayActivities->isEmpty())
                <div style="text-align:center; padding:2rem 1rem; color:var(--text-muted); font-size:0.875rem;">
                    Belum ada aktivitas yang dicatat hari ini. Saat Anda melakukan absensi masuk atau mencatat tugas di logbook, kegiatan akan tampil di sini.
                </div>
            @else
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    @foreach($todayActivities as $act)
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:0.85rem 1.25rem; background:rgba(15,23,42,0.6); border-radius:var(--radius-md); border:1px solid var(--border-subtle);">
                            <div style="display:flex; align-items:center; gap:1rem;">
                                <span style="font-family:var(--font-mono); font-size:0.8rem; color:var(--cyan-primary); background:rgba(6,182,212,0.1); padding:0.25rem 0.6rem; border-radius:4px;">
                                    {{ substr($act->time_recorded ?? $act->created_at->format('H:i:s'), 0, 5) }} WIB
                                </span>
                                <div>
                                    <div style="font-weight:700; color:#fff; font-size:0.9rem;">{{ $act->title }}</div>
                                    <div style="font-size:0.775rem; color:var(--text-muted);">
                                        {{ $act->category }} &bull; {{ $act->location ?? 'Kantor Pusat' }} &bull; {{ $act->description }}
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex; align-items:center; gap:0.75rem;">
                                @if($act->photo)
                                    <a href="{{ $act->photo }}" target="_blank" title="Lihat Foto Bukti" style="border-radius:6px; overflow:hidden; border:1px solid rgba(255,255,255,0.2); display:inline-block; flex-shrink:0;">
                                        <img src="{{ $act->photo }}" alt="Foto Bukti" style="width:40px; height:40px; object-fit:cover; display:block;">
                                    </a>
                                @endif

                                <span style="background:rgba(16,185,129,0.15); color:#34d399; font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px;">
                                    {{ $act->status }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Modal Pratinjau Peta Geofence Radius -->
<div id="radiusMapModal" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.78); backdrop-filter:blur(6px); align-items:center; justify-content:center; padding:1rem;">
    <div style="background:#1e293b; border:1px solid #475569; border-radius:14px; width:100%; max-width:650px; overflow:hidden; box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:1rem 1.25rem; border-bottom:1px solid rgba(255,255,255,0.1); background:#0f172a;">
            <div style="display:flex; align-items:center; gap:0.5rem; color:#f8fafc; font-weight:700;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Peta Posisi & Batas Radius Absensi
            </div>
            <button type="button" onclick="closeRadiusMapModal()" style="background:none; border:none; color:#94a3b8; font-size:1.5rem; line-height:1; cursor:pointer;" title="Tutup">&times;</button>
        </div>
        <div style="padding:1rem;">
            <div id="userRadiusMap" style="height:360px; width:100%; border-radius:8px; border:1px solid #334155;"></div>
            <div id="mapDistanceInfo" style="margin-top:0.75rem; padding:0.65rem 0.85rem; border-radius:6px; font-size:0.825rem; font-weight:600; text-align:center; background:#0f172a; color:#cbd5e1;">
                Menghitung jarak ke titik pusat...
            </div>
        </div>
        <div style="padding:0.75rem 1.25rem; border-top:1px solid rgba(255,255,255,0.1); background:#0f172a; display:flex; justify-content:space-between; align-items:center;">
            <div style="font-size:0.75rem; color:#94a3b8;">
                Titik Merah: Kantor &bull; Titik Biru: Posisi Anda &bull; Lingkaran: Radius Izin
            </div>
            <button type="button" class="btn-preset" onclick="closeRadiusMapModal()" style="padding:0.4rem 1rem;">Tutup Peta</button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- Leaflet CSS for Map Modal -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
<!-- Leaflet JS for Map Modal -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Konfigurasi Geofencing dari Database
    window.LOCATION_SETTINGS = {
        enabled: {{ ($locationSettings['is_enabled'] ?? true) ? 'true' : 'false' }},
        officeName: @json($locationSettings['office_name'] ?? 'SMKN 1 Jatisari (Kampus Utama)'),
        officeLat: {{ (float) ($locationSettings['latitude'] ?? -6.3655) }},
        officeLng: {{ (float) ($locationSettings['longitude'] ?? 107.5312) }},
        radiusMeters: {{ (int) ($locationSettings['radius_meters'] ?? 100) }}
    };

    // Modal Peta Geofence Handlers
    let radiusMapInstance = null;
    let userMarker = null;
    let officeMarker = null;
    let geofenceCircle = null;
    let distanceLine = null;

    window.openRadiusMapModal = function() {
        const modal = document.getElementById('radiusMapModal');
        if (!modal) return;
        modal.style.display = 'flex';

        setTimeout(() => {
            initOrUpdateRadiusMap();
        }, 150);
    };

    window.closeRadiusMapModal = function() {
        const modal = document.getElementById('radiusMapModal');
        if (modal) modal.style.display = 'none';
    };

    function initOrUpdateRadiusMap() {
        const mapContainer = document.getElementById('userRadiusMap');
        if (!mapContainer) return;

        const loc = window.LOCATION_SETTINGS;
        const officePos = [loc.officeLat, loc.officeLng];
        const userPos = (window.currentUserLat && window.currentUserLng) 
            ? [window.currentUserLat, window.currentUserLng] 
            : null;

        if (!radiusMapInstance) {
            radiusMapInstance = L.map('userRadiusMap').setView(officePos, 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap | SICAKAP'
            }).addTo(radiusMapInstance);

            const redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            officeMarker = L.marker(officePos, { icon: redIcon }).addTo(radiusMapInstance);
            officeMarker.bindPopup(`<strong>${loc.officeName}</strong><br>Titik Pusat Kantor`).openPopup();

            geofenceCircle = L.circle(officePos, {
                color: '#6366f1',
                fillColor: '#818cf8',
                fillOpacity: 0.25,
                radius: loc.radiusMeters,
                weight: 2
            }).addTo(radiusMapInstance);
        } else {
            radiusMapInstance.invalidateSize();
            officeMarker.setLatLng(officePos);
            geofenceCircle.setLatLng(officePos);
            geofenceCircle.setRadius(loc.radiusMeters);
        }

        const infoBox = document.getElementById('mapDistanceInfo');

        if (userPos) {
            const blueIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            if (!userMarker) {
                userMarker = L.marker(userPos, { icon: blueIcon }).addTo(radiusMapInstance);
            } else {
                userMarker.setLatLng(userPos);
            }
            userMarker.bindPopup('<strong>Posisi Anda Saat Ini</strong>');

            if (!distanceLine) {
                distanceLine = L.polyline([officePos, userPos], { color: '#f59e0b', weight: 2, dashArray: '5, 8' }).addTo(radiusMapInstance);
            } else {
                distanceLine.setLatLngs([officePos, userPos]);
            }

            const bounds = L.latLngBounds([officePos, userPos]);
            radiusMapInstance.fitBounds(bounds, { padding: [50, 50] });

            if (window.currentUserDistanceMeters !== null && infoBox) {
                const dist = Math.round(window.currentUserDistanceMeters);
                const isWithin = dist <= loc.radiusMeters;
                if (isWithin) {
                    infoBox.style.color = '#34d399';
                    infoBox.style.border = '1px solid rgba(16,185,129,0.3)';
                    infoBox.innerHTML = `✅ Posisi Valid: Anda berjarak <strong>${dist} meter</strong> dari ${loc.officeName} (Di dalam radius maks. ${loc.radiusMeters}m)`;
                } else {
                    infoBox.style.color = '#f87171';
                    infoBox.style.border = '1px solid rgba(239,68,68,0.3)';
                    infoBox.innerHTML = `❌ Di Luar Area: Anda berjarak <strong>${dist} meter</strong> dari ${loc.officeName} (Batas maksimal: ${loc.radiusMeters}m)`;
                }
            }
        } else {
            radiusMapInstance.setView(officePos, 17);
            if (infoBox) {
                infoBox.style.color = '#cbd5e1';
                infoBox.innerHTML = `GPS Anda belum terdeteksi. Silakan izinkan akses lokasi di browser.`;
            }
        }
    }
</script>
@endpush
