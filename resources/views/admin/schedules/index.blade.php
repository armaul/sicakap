@extends('layouts.app')

@section('title', 'Admin - Pengaturan Jadwal Shift & Hari Off Karyawan')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header & Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
                <span class="user-role-badge role-admin" style="font-size:0.75rem;">PANEL ADMINISTRATOR</span>
                <span style="font-size:0.75rem; color:var(--text-muted);">&bull;</span>
                <span style="font-size:0.8rem; color:#fcd34d; font-weight:700;">ROSTER & PENJADWALAN</span>
            </div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Pengaturan Jadwal Shift & Hari Off Karyawan
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Atur hari apa saja karyawan masuk kerja (Shift Pagi, Siang, Malam, Reguler) dan hari libur (OFF) untuk Satpam dan Caraka.
            </p>
        </div>

        <div style="display:flex; gap:0.5rem; align-items:center; flex-wrap:wrap;">
            <!-- Download Template Button -->
            <a href="{{ route('admin.schedules.template', request()->all()) }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.45rem; background:rgba(16,185,129,0.12); color:#34d399; border-color:rgba(16,185,129,0.3); font-weight:600;" title="Unduh template jadwal CSV siap isi untuk bulan ini">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Download Template
            </a>

            <!-- Export Jadwal Button -->
            <a href="{{ route('admin.schedules.export', request()->all()) }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.45rem; background:rgba(56,189,248,0.12); color:#38bdf8; border-color:rgba(56,189,248,0.3); font-weight:600;" title="Ekspor data jadwal aktif bulan ini ke format CSV/Excel">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                Export Jadwal
            </a>

            <!-- Import Jadwal Button -->
            <button type="button" onclick="openModalImportSchedule()" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.45rem; background:rgba(245,158,11,0.12); color:#fbbf24; border-color:rgba(245,158,11,0.3); font-weight:600;" title="Unggah berkas CSV hasil pengisian template jadwal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m16 16-4-4-4 4"/></svg>
                Import Jadwal
            </button>

            <!-- Master Jam Shift -->
            <a href="{{ route('admin.shifts.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.45rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Master Shift
            </a>

            <!-- Bulk Generator Button -->
            <button type="button" onclick="openModalBulkSchedule()" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.45rem; background:linear-gradient(135deg, var(--indigo-primary) 0%, #4f46e5 100%); color:#fff; border-color:var(--indigo-primary); box-shadow:0 4px 15px rgba(99,102,241,0.35); font-weight:700;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M12 14v4"/><path d="M10 16h4"/></svg>
                + Atur Massal
            </button>
        </div>
    </div>

    <!-- KPI Summary Cards -->
    <div class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom:0;">
        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(99,102,241,0.15); color:#818cf8;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $metrics['totalStaff'] }}</div>
                <div class="kpi-label">Personil Terjadwal</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(16,185,129,0.15); color:#34d399;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <div class="kpi-value" style="color:#34d399;">{{ $metrics['totalWorking'] }}</div>
                <div class="kpi-label">Hari Masuk Tugas</div>
            </div>
        </div>

        <div class="kpi-card" style="border-color:rgba(245,158,11,0.3); background:linear-gradient(135deg, rgba(30,41,59,0.7) 0%, rgba(245,158,11,0.06) 100%);">
            <div class="kpi-icon" style="background:rgba(245,158,11,0.15); color:#fbbf24;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/></svg>
            </div>
            <div>
                <div class="kpi-value" style="color:#fbbf24;">{{ $metrics['totalOff'] }}</div>
                <div class="kpi-label">Hari Libur (OFF)</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(6,182,212,0.15); color:#22d3ee;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $metrics['totalScheduled'] }}</div>
                <div class="kpi-label">Total Jadwal Bulan Ini</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(148,163,184,0.15); color:#94a3b8;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            </div>
            <div>
                <div class="kpi-value" style="color:var(--text-muted);">{{ $metrics['unassignedSlots'] }}</div>
                <div class="kpi-label">Shift Default (Standar)</div>
            </div>
        </div>
    </div>

    <!-- Filter & Month Navigation Bar -->
    <div class="glass-card" style="padding:1.25rem;">
        <form method="GET" action="{{ route('admin.schedules.index') }}" style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
            <!-- Month Selector -->
            <div style="flex:1; min-width:160px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Pilih Bulan:</label>
                <select name="month" class="form-control" style="padding:0.55rem 0.85rem; font-size:0.875rem;">
                    @foreach([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ] as $mNum => $mName)
                        <option value="{{ $mNum }}" {{ $month === $mNum ? 'selected' : '' }}>
                            {{ $mName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Year Selector -->
            <div style="flex:1; min-width:120px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Tahun:</label>
                <select name="year" class="form-control" style="padding:0.55rem 0.85rem; font-size:0.875rem;">
                    @for($y = 2024; $y <= 2028; $y++)
                        <option value="{{ $y }}" {{ $year === $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <!-- Role Filter -->
            <div style="flex:1; min-width:160px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Filter Divisi (Peran):</label>
                <select name="role" class="form-control" style="padding:0.55rem 0.85rem; font-size:0.875rem;">
                    <option value="">-- Semua Divisi --</option>
                    <option value="satpam" {{ $selectedRole === 'satpam' ? 'selected' : '' }}>Satpam (Security)</option>
                    <option value="caraka" {{ $selectedRole === 'caraka' ? 'selected' : '' }}>Caraka (Kebersihan/Kurir)</option>
                </select>
            </div>

            <!-- Specific Personil Filter -->
            <div style="flex:1.5; min-width:200px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Filter Personil:</label>
                <select name="user_id" class="form-control" style="padding:0.55rem 0.85rem; font-size:0.875rem;">
                    <option value="">-- Semua Personil --</option>
                    @foreach($allStaff as $staff)
                        <option value="{{ $staff->id }}" {{ $selectedUserId == $staff->id ? 'selected' : '' }}>
                            {{ $staff->name }} ({{ strtoupper($staff->role) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Buttons -->
            <div style="align-self:flex-end; display:flex; gap:0.5rem;">
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Tampilkan Roster
                </button>
                @if($selectedRole || $selectedUserId || $month != \Carbon\Carbon::now()->month || $year != \Carbon\Carbon::now()->year)
                    <a href="{{ route('admin.schedules.index') }}" class="btn-filter" style="color:var(--text-muted);">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Interactive Monthly Roster Matrix Table -->
    <div class="glass-card" style="padding:0; overflow:hidden;">
        <!-- Card Header Info -->
        <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-subtle); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
            <div>
                <h3 style="font-size:1.05rem; font-weight:700; color:#fff; display:flex; align-items:center; gap:0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    Matriks Roster Jadwal Periode: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
                </h3>
                <p style="font-size:0.8rem; color:var(--text-muted); margin-top:2px;">
                    💡 <strong>Klik pada kotak tanggal manapun</strong> untuk mengubah shift atau menetapkan hari libur (OFF) personil tersebut.
                </p>
            </div>

            <!-- Legend Badge Guide -->
            <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; font-size:0.75rem;">
                <span style="display:inline-flex; align-items:center; gap:4px; color:#34d399;">
                    <span style="width:10px; height:10px; background:#10b981; border-radius:3px;"></span> Shift Pagi / Reguler
                </span>
                <span style="display:inline-flex; align-items:center; gap:4px; color:#fbbf24;">
                    <span style="width:10px; height:10px; background:#f59e0b; border-radius:3px;"></span> Shift Siang
                </span>
                <span style="display:inline-flex; align-items:center; gap:4px; color:#a5b4fc;">
                    <span style="width:10px; height:10px; background:#6366f1; border-radius:3px;"></span> Shift Malam
                </span>
                <span style="display:inline-flex; align-items:center; gap:4px; color:#f43f5e;">
                    <span style="width:10px; height:10px; background:#f43f5e; border-radius:3px;"></span> Hari Libur (OFF)
                </span>
                <span style="display:inline-flex; align-items:center; gap:4px; color:var(--text-muted);">
                    <span style="width:10px; height:10px; background:rgba(255,255,255,0.1); border-radius:3px;"></span> Shift Standar
                </span>
            </div>
        </div>

        <!-- Scrollable Matrix Table -->
        <div class="table-responsive" style="max-height:680px; overflow:auto;">
            <table class="data-table" style="font-size:0.8rem; min-width:1300px;">
                <thead>
                    <tr>
                        <!-- Sticky Employee Column -->
                        <th style="position:sticky; left:0; z-index:10; min-width:220px; background:rgba(15,23,42,0.98); box-shadow:2px 0 5px rgba(0,0,0,0.4);">
                            Personil (Karyawan)
                        </th>
                        <th style="text-align:center; min-width:90px; background:rgba(15,23,42,0.95);">
                            Total Masuk/OFF
                        </th>

                        <!-- Dates Columns -->
                        @foreach($datesList as $d)
                            @php
                                $isWeekend = in_array($d->dayOfWeek, [0, 6]); // Sunday or Saturday
                                $isToday = $d->isToday();
                                $dayNameShort = substr($d->translatedFormat('D'), 0, 3);
                            @endphp
                            <th style="text-align:center; min-width:48px; padding:0.6rem 0.3rem; {{ $isWeekend ? 'background:rgba(244,63,94,0.06);' : '' }} {{ $isToday ? 'border-top:3px solid var(--indigo-primary); background:rgba(99,102,241,0.15);' : '' }}">
                                <div style="font-size:0.65rem; color:{{ $isWeekend ? '#fda4af' : 'var(--text-muted)' }}; text-transform:uppercase;">
                                    {{ $dayNameShort }}
                                </div>
                                <div style="font-family:var(--font-mono); font-size:0.95rem; font-weight:800; color:{{ $isToday ? '#6ee7b7' : '#fff' }};">
                                    {{ $d->day }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $staff)
                        @php
                            // Calculate working & off days for this employee this month
                            $staffWorkingCount = 0;
                            $staffOffCount = 0;
                            foreach ($datesList as $d) {
                                $key = $staff->id . '_' . $d->format('Y-m-d');
                                if (isset($scheduleMatrix[$key])) {
                                    if ($scheduleMatrix[$key]->is_off) {
                                        $staffOffCount++;
                                    } else {
                                        $staffWorkingCount++;
                                    }
                                }
                            }
                        @endphp
                        <tr>
                            <!-- Employee Info Sticky -->
                            <td style="position:sticky; left:0; z-index:5; background:rgba(15,23,42,0.96); box-shadow:2px 0 5px rgba(0,0,0,0.4);">
                                <div style="display:flex; align-items:center; gap:0.6rem;">
                                    <img src="{{ $staff->avatar }}" alt="{{ $staff->name }}" style="width:34px; height:34px; border-radius:50%; object-fit:cover; border:2px solid var(--border-accent);">
                                    <div>
                                        <div style="font-weight:700; color:#fff; font-size:0.875rem; white-space:nowrap;">{{ $staff->name }}</div>
                                        <div style="display:flex; align-items:center; gap:0.35rem; margin-top:1px;">
                                            <span class="user-role-badge role-{{ $staff->role }}" style="font-size:0.6rem; padding:1px 5px;">{{ strtoupper($staff->role) }}</span>
                                            <span style="font-size:0.7rem; color:var(--text-muted); font-family:var(--font-mono);">{{ $staff->nip }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Total Working vs OFF badge -->
                            <td style="text-align:center; white-space:nowrap;">
                                <span style="color:#34d399; font-weight:700; font-family:var(--font-mono); font-size:0.8rem;" title="Hari Masuk">{{ $staffWorkingCount }}M</span>
                                <span style="color:var(--text-muted);">&bull;</span>
                                <span style="color:#f43f5e; font-weight:700; font-family:var(--font-mono); font-size:0.8rem;" title="Hari Libur (OFF)">{{ $staffOffCount }}OFF</span>
                            </td>

                            <!-- Date Cells -->
                            @foreach($datesList as $d)
                                @php
                                    $dateStr = $d->format('Y-m-d');
                                    $key = $staff->id . '_' . $dateStr;
                                    $sch = $scheduleMatrix[$key] ?? null;
                                    $isWeekend = in_array($d->dayOfWeek, [0, 6]);
                                    $isToday = $d->isToday();
                                @endphp

                                <td style="text-align:center; padding:0.35rem; cursor:pointer; {{ $isWeekend ? 'background:rgba(244,63,94,0.03);' : '' }} {{ $isToday ? 'background:rgba(99,102,241,0.07);' : '' }}"
                                    onclick="openQuickScheduleModal({{ $staff->id }}, '{{ addslashes($staff->name) }}', '{{ $dateStr }}', '{{ $d->translatedFormat('l, d F Y') }}', {{ $sch ? ($sch->is_off ? 1 : 0) : 'null' }}, {{ $sch && $sch->shift_id ? $sch->shift_id : 'null' }}, '{{ addslashes($sch->notes ?? '') }}')"
                                    title="Klik untuk ubah jadwal {{ $staff->name }} pada {{ $d->translatedFormat('d M Y') }}">
                                    
                                    @if($sch)
                                        @if($sch->is_off)
                                            <!-- OFF / LIBUR -->
                                            <div style="background:rgba(244,63,94,0.18); border:1px solid rgba(244,63,94,0.4); color:#fda4af; font-size:0.675rem; font-weight:800; padding:0.25rem 0.2rem; border-radius:6px; text-transform:uppercase;">
                                                OFF
                                            </div>
                                        @elseif($sch->shift)
                                            @php
                                                $shiftCode = strtoupper($sch->shift->code);
                                                $bgPill = 'rgba(16,185,129,0.18)';
                                                $colorPill = '#6ee7b7';
                                                $borderPill = 'rgba(16,185,129,0.4)';
                                                $labelShort = 'PAGI';

                                                if ($sch->shift->is_night_shift || str_contains($shiftCode, 'MALAM')) {
                                                    $bgPill = 'rgba(99,102,241,0.2)';
                                                    $colorPill = '#c7d2fe';
                                                    $borderPill = 'rgba(99,102,241,0.4)';
                                                    $labelShort = 'MALAM';
                                                } elseif (str_contains($shiftCode, 'SIANG')) {
                                                    $bgPill = 'rgba(245,158,11,0.2)';
                                                    $colorPill = '#fde68a';
                                                    $borderPill = 'rgba(245,158,11,0.4)';
                                                    $labelShort = 'SIANG';
                                                } elseif (str_contains($shiftCode, 'REG')) {
                                                    $bgPill = 'rgba(6,182,212,0.2)';
                                                    $colorPill = '#a5f3fc';
                                                    $borderPill = 'rgba(6,182,212,0.4)';
                                                    $labelShort = 'REG';
                                                }
                                            @endphp
                                            <div style="background:{{ $bgPill }}; border:1px solid {{ $borderPill }}; color:{{ $colorPill }}; font-size:0.675rem; font-weight:700; padding:0.25rem 0.2rem; border-radius:6px; white-space:nowrap;">
                                                {{ $labelShort }}
                                            </div>
                                        @endif
                                    @else
                                        <!-- Default / Standar -->
                                        <div style="color:rgba(255,255,255,0.2); font-size:0.75rem; font-weight:700; padding:0.25rem 0.2rem; border-radius:4px; border:1px dashed rgba(255,255,255,0.1);">
                                            -
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($datesList) + 2 }}" style="text-align:center; padding:3rem; color:var(--text-muted);">
                                Tidak ada data personil yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- Modal 1: Quick Schedule Single Day Edit                                    -->
<!-- ========================================================================= -->
<div class="modal-overlay" id="modalQuickSchedule" onclick="closeQuickScheduleModal()">
    <div class="modal-dialog" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div>
                <h3 style="font-size:1.05rem; font-weight:700; color:#fff;">Atur Hari Masuk / Libur (OFF)</h3>
                <p style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;" id="quickScheduleSubtitle">
                    Pilih apakah personil bertugas shift atau libur pada tanggal ini.
                </p>
            </div>
            <button onclick="closeQuickScheduleModal()" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.schedules.assign') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" id="quickUserId">
            <input type="hidden" name="date" id="quickDate">

            <div class="modal-body" style="display:flex; flex-direction:column; gap:1.25rem;">
                
                <!-- Personil & Tanggal Highlight Box -->
                <div style="display:flex; align-items:center; justify-content:space-between; padding:0.85rem 1rem; background:rgba(15,23,42,0.8); border-radius:var(--radius-md); border:1px solid var(--border-accent);">
                    <div>
                        <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase;">Personil:</div>
                        <div style="font-weight:800; color:#fff; font-size:1rem;" id="quickUserName">-</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase;">Tanggal:</div>
                        <div style="font-family:var(--font-mono); font-weight:700; color:#38bdf8; font-size:0.9rem;" id="quickDateFormatted">-</div>
                    </div>
                </div>

                <!-- Status Penugasan: MASUK vs LIBUR (OFF) -->
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Status Jadwal Hari Ini:</label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                        <label style="display:flex; align-items:center; gap:0.6rem; padding:0.85rem; border:2px solid var(--border-subtle); border-radius:var(--radius-md); cursor:pointer; background:rgba(15,23,42,0.5);" id="labelOptionWorking">
                            <input type="radio" name="is_off" value="0" id="radioWorking" onchange="toggleQuickScheduleFields()" style="accent-color:#10b981;">
                            <div>
                                <div style="font-weight:700; color:#34d399; font-size:0.9rem;">💼 Masuk Kerja</div>
                                <div style="font-size:0.7rem; color:var(--text-muted);">Bertugas sesuai shift</div>
                            </div>
                        </label>

                        <label style="display:flex; align-items:center; gap:0.6rem; padding:0.85rem; border:2px solid var(--border-subtle); border-radius:var(--radius-md); cursor:pointer; background:rgba(15,23,42,0.5);" id="labelOptionOff">
                            <input type="radio" name="is_off" value="1" id="radioOff" onchange="toggleQuickScheduleFields()" style="accent-color:#f43f5e;">
                            <div>
                                <div style="font-weight:700; color:#fda4af; font-size:0.9rem;">🏖️ Libur (OFF)</div>
                                <div style="font-size:0.7rem; color:var(--text-muted);">Hari bebas tugas</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Shift Selection (Only visible when MASUK) -->
                <div class="form-group" id="quickShiftContainer" style="margin-bottom:0;">
                    <label class="form-label">Pilih Shift Kerja:</label>
                    <select name="shift_id" id="quickShiftSelect" class="form-control">
                        @foreach($shifts as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->name }} ({{ substr($s->start_time,0,5) }} - {{ substr($s->end_time,0,5) }} WIB{{ $s->is_night_shift ? ' Lintas Hari' : '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Notes / Keterangan -->
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Catatan / Pos Tugas (Opsional):</label>
                    <input type="text" name="notes" id="quickNotes" class="form-control" placeholder="Contoh: Jaga Pos Barat, Piket Cadangan, Libur Rutin">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeQuickScheduleModal()">Batal</button>
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- Modal 2: Bulk Schedule Generator (Atur Jadwal Massal Rentang Tanggal)       -->
<!-- ========================================================================= -->
<div class="modal-overlay" id="modalBulkSchedule" onclick="closeModalBulkSchedule()">
    <div class="modal-dialog" style="max-width:600px;" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div>
                <h3 style="font-size:1.05rem; font-weight:700; color:#fff;">Atur Jadwal & Hari Off Massal</h3>
                <p style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                    Terapkan shift masuk atau hari libur (OFF) sekaligus ke banyak personil dalam rentang tanggal.
                </p>
            </div>
            <button onclick="closeModalBulkSchedule()" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.schedules.bulk') }}" method="POST">
            @csrf
            <div class="modal-body" style="display:flex; flex-direction:column; gap:1.25rem;">
                
                <!-- Target Group -->
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Terapkan Untuk Personil:</label>
                    <select name="target_group" id="bulkTargetGroup" class="form-control" onchange="toggleBulkStaffList()">
                        <option value="all_satpam">Seluruh Personil Satpam</option>
                        <option value="all_caraka">Seluruh Personil Caraka</option>
                        <option value="all">Semua Personil (Satpam & Caraka)</option>
                        <option value="specific">Pilih Personil Tertentu...</option>
                    </select>

                    <div id="bulkSpecificStaffBox" style="display:none; margin-top:0.75rem; max-height:140px; overflow-y:auto; padding:0.75rem; background:rgba(15,23,42,0.8); border:1px solid var(--border-subtle); border-radius:var(--radius-md);">
                        @foreach($allStaff as $staff)
                            <label style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.4rem; font-size:0.825rem; color:var(--text-primary); cursor:pointer;">
                                <input type="checkbox" name="user_ids[]" value="{{ $staff->id }}" style="accent-color:var(--indigo-primary);">
                                <span>{{ $staff->name }} ({{ strtoupper($staff->role) }} - {{ $staff->nip }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Tanggal Mulai:</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $datesList[0]->format('Y-m-d') }}" required>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Tanggal Selesai:</label>
                        <input type="date" name="end_date" class="form-control" value="{{ end($datesList)->format('Y-m-d') }}" required>
                    </div>
                </div>

                <!-- Pilihan Hari dalam Seminggu -->
                <div class="form-group" style="margin-bottom:0;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                        <label class="form-label" style="margin-bottom:0;">Hari yang Berlaku:</label>
                        <div style="display:flex; gap:0.4rem;">
                            <button type="button" class="btn-tab-filter" style="font-size:0.7rem; padding:2px 8px;" onclick="setDaysPreset('all')">Semua Hari</button>
                            <button type="button" class="btn-tab-filter" style="font-size:0.7rem; padding:2px 8px;" onclick="setDaysPreset('weekdays')">Sen - Jum</button>
                            <button type="button" class="btn-tab-filter" style="font-size:0.7rem; padding:2px 8px;" onclick="setDaysPreset('weekends')">Sab - Min</button>
                        </div>
                    </div>
                    
                    <div style="display:grid; grid-template-columns:repeat(7, 1fr); gap:0.35rem; text-align:center;">
                        @php
                            $dayLabels = [
                                1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 0 => 'Min'
                            ];
                        @endphp
                        @foreach($dayLabels as $val => $lbl)
                            <label style="display:flex; flex-direction:column; align-items:center; gap:0.25rem; padding:0.5rem 0.2rem; background:rgba(15,23,42,0.6); border:1px solid var(--border-subtle); border-radius:var(--radius-sm); cursor:pointer;">
                                <span style="font-size:0.75rem; font-weight:700; color:#fff;">{{ $lbl }}</span>
                                <input type="checkbox" name="days_of_week[]" value="{{ $val }}" class="bulk-day-checkbox" checked style="accent-color:var(--indigo-primary);">
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Status Penugasan -->
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Tetapkan Status Jadwal:</label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                        <label style="display:flex; align-items:center; gap:0.6rem; padding:0.85rem; border:2px solid var(--border-subtle); border-radius:var(--radius-md); cursor:pointer; background:rgba(15,23,42,0.5);">
                            <input type="radio" name="is_off" value="0" id="bulkRadioWorking" checked onchange="toggleBulkFields()" style="accent-color:#10b981;">
                            <div>
                                <div style="font-weight:700; color:#34d399; font-size:0.9rem;">💼 Masuk Bertugas</div>
                                <div style="font-size:0.7rem; color:var(--text-muted);">Pilih shift kerja</div>
                            </div>
                        </label>

                        <label style="display:flex; align-items:center; gap:0.6rem; padding:0.85rem; border:2px solid var(--border-subtle); border-radius:var(--radius-md); cursor:pointer; background:rgba(15,23,42,0.5);">
                            <input type="radio" name="is_off" value="1" id="bulkRadioOff" onchange="toggleBulkFields()" style="accent-color:#f43f5e;">
                            <div>
                                <div style="font-weight:700; color:#fda4af; font-size:0.9rem;">🏖️ Hari Libur (OFF)</div>
                                <div style="font-size:0.7rem; color:var(--text-muted);">Tetapkan sebagai off</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Shift Selection for Bulk -->
                <div class="form-group" id="bulkShiftContainer" style="margin-bottom:0;">
                    <label class="form-label">Pilih Shift Kerja:</label>
                    <select name="shift_id" class="form-control">
                        @foreach($shifts as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->name }} ({{ substr($s->start_time,0,5) }} - {{ substr($s->end_time,0,5) }} WIB{{ $s->is_night_shift ? ' Lintas Hari' : '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Notes for Bulk -->
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Keterangan / Catatan Penugasan (Opsional):</label>
                    <input type="text" name="notes" class="form-control" placeholder="Contoh: Roster Reguler Bulan Ini, Piket Tetap">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeModalBulkSchedule()">Batal</button>
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff;">
                    Terapkan Jadwal Massal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- Modal 3: Import Schedule Modal (Upload CSV Template)                       -->
<!-- ========================================================================= -->
<div class="modal-overlay" id="modalImportSchedule">
    <div class="modal-box" style="max-width:560px;">
        <div class="modal-header">
            <div style="display:flex; align-items:center; gap:0.65rem;">
                <div style="width:38px; height:38px; border-radius:10px; background:rgba(245,158,11,0.15); color:#fbbf24; display:flex; align-items:center; justify-content:center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m16 16-4-4-4 4"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1.1rem; font-weight:700; color:#fff;">Import Jadwal Karyawan</h3>
                    <p style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">Unggah berkas CSV template jadwal hasil pengisian</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModalImportSchedule()">&times;</button>
        </div>

        <form action="{{ route('admin.schedules.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body" style="display:flex; flex-direction:column; gap:1.15rem;">
                <!-- Instructions Banner -->
                <div style="padding:0.9rem 1rem; border-radius:var(--radius-md); background:rgba(15,23,42,0.7); border:1px solid rgba(245,158,11,0.3); font-size:0.8rem; color:var(--text-secondary); line-height:1.5;">
                    <strong style="color:#fbbf24; display:flex; align-items:center; gap:0.4rem; margin-bottom:0.45rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        Panduan Pengisian & Import:
                    </strong>
                    <ol style="padding-left:1.2rem; margin:0; display:flex; flex-direction:column; gap:0.35rem;">
                        <li>Klik tombol <strong style="color:#34d399;">"Download Template"</strong> di atas untuk memperoleh template CSV yang sudah memuat seluruh personil dan tanggal bulan ini.</li>
                        <li>Buka file di Excel, lalu isi/sesuaikan kolom <strong>Status</strong> (<code style="color:#34d399;">MASUK</code> / <code style="color:#f43f5e;">LIBUR</code>) dan <strong>Kode_Shift</strong> (<code style="color:#38bdf8;">STP_PAGI</code>, <code style="color:#fbbf24;">STP_SIANG</code>, <code style="color:#818cf8;">STP_MALAM</code>, <code style="color:#34d399;">CRK_REGULER</code>, <code style="color:#fbbf24;">CRK_SIANG</code>, atau <code style="color:#f43f5e;">OFF</code>).</li>
                        <li>Simpan file tetap dalam format <strong>.CSV</strong>, lalu unggah melalui form di bawah ini.</li>
                    </ol>
                </div>

                <!-- File Input -->
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Pilih Berkas CSV Template:</label>
                    <input type="file" name="csv_file" class="form-control" accept=".csv, text/csv, text/plain" required style="padding:0.5rem; background:rgba(15,23,42,0.8); border:1px dashed var(--border-subtle); border-radius:var(--radius-md);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:5px;">
                        <span style="font-size:0.7rem; color:var(--text-muted);">Format didukung: <strong>.csv</strong> (Maksimal 5 MB)</span>
                        <a href="{{ route('admin.schedules.template', request()->all()) }}" style="font-size:0.75rem; color:#34d399; text-decoration:none; display:inline-flex; align-items:center; gap:3px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Unduh Template Bulan Ini
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeModalImportSchedule()">Batal</button>
                <button type="submit" class="btn-filter" style="background:#f59e0b; border-color:#f59e0b; color:#fff; font-weight:700;">
                    Unggah & Terapkan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// =========================================================================
// Modal 3: Import Schedule Handlers
// =========================================================================
function openModalImportSchedule() {
    document.getElementById('modalImportSchedule').classList.add('show');
}

function closeModalImportSchedule() {
    document.getElementById('modalImportSchedule').classList.remove('show');
}
// =========================================================================
// Modal 1: Quick Single Day Schedule Handlers
// =========================================================================
function openQuickScheduleModal(userId, userName, dateStr, dateFormatted, isOff, shiftId, notes) {
    document.getElementById('quickUserId').value = userId;
    document.getElementById('quickDate').value = dateStr;
    document.getElementById('quickUserName').textContent = userName;
    document.getElementById('quickDateFormatted').textContent = dateFormatted;
    document.getElementById('quickNotes').value = notes || '';

    // If already marked as OFF
    if (isOff === 1) {
        document.getElementById('radioOff').checked = true;
        document.getElementById('radioWorking').checked = false;
    } else {
        document.getElementById('radioWorking').checked = true;
        document.getElementById('radioOff').checked = false;
    }

    if (shiftId) {
        document.getElementById('quickShiftSelect').value = shiftId;
    }

    toggleQuickScheduleFields();
    document.getElementById('modalQuickSchedule').classList.add('show');
}

function closeQuickScheduleModal() {
    document.getElementById('modalQuickSchedule').classList.remove('show');
}

function toggleQuickScheduleFields() {
    const isOff = document.getElementById('radioOff').checked;
    const shiftContainer = document.getElementById('quickShiftContainer');
    const labelWorking = document.getElementById('labelOptionWorking');
    const labelOff = document.getElementById('labelOptionOff');

    if (isOff) {
        shiftContainer.style.display = 'none';
        labelOff.style.borderColor = '#f43f5e';
        labelWorking.style.borderColor = 'var(--border-subtle)';
    } else {
        shiftContainer.style.display = 'block';
        labelWorking.style.borderColor = '#10b981';
        labelOff.style.borderColor = 'var(--border-subtle)';
    }
}

// =========================================================================
// Modal 2: Bulk Schedule Handlers
// =========================================================================
function openModalBulkSchedule() {
    document.getElementById('modalBulkSchedule').classList.add('show');
}

function closeModalBulkSchedule() {
    document.getElementById('modalBulkSchedule').classList.remove('show');
}

function toggleBulkStaffList() {
    const val = document.getElementById('bulkTargetGroup').value;
    const box = document.getElementById('bulkSpecificStaffBox');
    box.style.display = (val === 'specific') ? 'block' : 'none';
}

function toggleBulkFields() {
    const isOff = document.getElementById('bulkRadioOff').checked;
    const shiftBox = document.getElementById('bulkShiftContainer');
    shiftBox.style.display = isOff ? 'none' : 'block';
}

function setDaysPreset(preset) {
    const checkboxes = document.querySelectorAll('.bulk-day-checkbox');
    checkboxes.forEach(cb => {
        const val = parseInt(cb.value);
        if (preset === 'all') {
            cb.checked = true;
        } else if (preset === 'weekdays') {
            cb.checked = (val >= 1 && val <= 5);
        } else if (preset === 'weekends') {
            cb.checked = (val === 0 || val === 6);
        }
    });
}
</script>
@endpush

@endsection
