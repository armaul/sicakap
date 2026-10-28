@extends('layouts.app')

@section('title', 'Menu Riwayat Absensi Bulanan - Satpam & Caraka')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header & Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Rekapitulasi Riwayat Absensi
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Daftar catatan kehadiran personil satpam dan caraka per bulan lengkap dengan bukti swafoto dan durasi kerja.
            </p>
        </div>

        <div style="display:flex; gap:0.75rem; align-items:center;">
            <a href="{{ route('attendances.export', ['month' => $selectedMonth, 'year' => $selectedYear, 'user_id' => $selectedUserId]) }}" 
                class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(16,185,129,0.15); border-color:rgba(16,185,129,0.3); color:#34d399;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Export Excel / CSV
            </a>

            <button onclick="window.print()" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Monthly Recap KPI Cards -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(99,102,241,0.15); color:#818cf8;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $recap['totalHadir'] }} Hari</div>
                <div class="kpi-label">Total Kehadiran</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(16,185,129,0.15); color:#34d399;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $recap['totalTepatWaktu'] }}</div>
                <div class="kpi-label">Tepat Waktu</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(245,158,11,0.15); color:#fbbf24;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $recap['totalTerlambat'] }}</div>
                <div class="kpi-label">Terlambat</div>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(6,182,212,0.15); color:#22d3ee;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2v4"/><path d="M12 18v4"/><path d="m4.93 4.93 2.83 2.83"/><path d="m16.24 16.24 2.83 2.83"/></svg>
            </div>
            <div>
                <div class="kpi-value">{{ $recap['totalJamKerja'] }} Jam</div>
                <div class="kpi-label">Akumulasi Jam Kerja</div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="glass-card" style="padding:1.25rem;">
        <form method="GET" action="{{ route('attendances.history') }}" style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
            <!-- Bulan -->
            <div style="flex:1; min-width:160px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Pilih Bulan:</label>
                <select name="month" class="form-control" style="padding:0.5rem 0.85rem; font-size:0.875rem;">
                    @php
                        $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tahun -->
            <div style="flex:1; min-width:120px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Pilih Tahun:</label>
                <select name="year" class="form-control" style="padding:0.5rem 0.85rem; font-size:0.875rem;">
                    @for($y = Carbon\Carbon::now()->year + 1; $y >= Carbon\Carbon::now()->year - 2; $y--)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Personil (Filter) -->
            <div style="flex:1.5; min-width:200px;">
                <label class="form-label" style="font-size:0.75rem; margin-bottom:0.25rem;">Filter Personil:</label>
                <select name="user_id" class="form-control" style="padding:0.5rem 0.85rem; font-size:0.875rem;">
                    <option value="">-- Semua Personil (Satpam & Caraka) --</option>
                    @foreach($allUsers as $u)
                        <option value="{{ $u->id }}" {{ $selectedUserId == $u->id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ strtoupper($u->role) }} - {{ $u->nip }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div style="align-self:flex-end;">
                <button type="submit" class="btn-filter" style="background:var(--indigo-primary); border-color:var(--indigo-primary); color:#fff; display:flex; align-items:center; gap:0.5rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Tampilkan Rekap
                </button>
            </div>
        </form>
    </div>

    <!-- Rekapitulasi Table (As requested: Tanggal, Shift, Jam Masuk, Jam Pulang, Durasi Kerja, Status) -->
    <div class="glass-card" style="padding:0; overflow:hidden;">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Tanggal</th>
                        <th>Personil</th>
                        <th>Shift</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Durasi Kerja</th>
                        <th>Status</th>
                        <th>Lokasi / Pos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $index => $row)
                        <tr>
                            <td style="color:var(--text-muted); font-family:var(--font-mono); font-size:0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            
                            <!-- Tanggal -->
                            <td style="white-space:nowrap;">
                                <div style="font-weight:700; color:#fff;">
                                    {{ $row->date->translatedFormat('d M Y') }}
                                </div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">
                                    {{ $row->date->translatedFormat('l') }}
                                </div>
                            </td>

                            <!-- Personil -->
                            <td style="white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:0.75rem;">
                                    <img src="{{ $row->user->avatar ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80' }}" alt="{{ $row->user->name }}" style="width:34px; height:34px; border-radius:50%; object-fit:cover; border:1px solid var(--border-accent);">
                                    <div>
                                        <div style="font-weight:700; color:#fff;">{{ $row->user->name }}</div>
                                        <div style="font-size:0.7rem; color:var(--text-muted);">
                                            {{ $row->user->nip }} &bull; <span class="user-role-badge role-{{ $row->user->role }}">{{ strtoupper($row->user->role) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Shift -->
                            <td style="white-space:nowrap;">
                                <div style="font-weight:600; color:#fff;">
                                    {{ $row->shift->name ?? 'Shift Reguler' }}
                                </div>
                                <div style="font-size:0.75rem; font-family:var(--font-mono); color:var(--text-muted);">
                                    {{ substr($row->shift->start_time ?? '07:00', 0, 5) }} - {{ substr($row->shift->end_time ?? '15:00', 0, 5) }} WIB
                                    @if($row->shift && $row->shift->is_night_shift)
                                        <span style="color:#a5b4fc;">(Malam)</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Jam Masuk (with selfie preview) -->
                            <td style="white-space:nowrap;">
                                @if($row->jam_masuk)
                                    <div style="display:flex; align-items:center; gap:0.6rem;">
                                        @if($row->foto_masuk)
                                            <img src="{{ $row->foto_masuk }}" alt="Selfie Masuk" class="selfie-thumbnail" 
                                                onclick="previewImageModal('{{ $row->foto_masuk }}', 'Bukti Swafoto Masuk: {{ $row->user->name }} ({{ $row->jam_masuk->format('H:i') }} WIB)')"
                                                title="Klik untuk melihat foto selfie">
                                        @endif
                                        <div>
                                            <div style="font-family:var(--font-mono); font-weight:700; color:#34d399; font-size:0.95rem;">
                                                {{ $row->jam_masuk->format('H:i:s') }}
                                            </div>
                                            <div style="font-size:0.7rem; color:var(--text-muted);">WIB</div>
                                        </div>
                                    </div>
                                @else
                                    <span style="color:var(--text-muted); font-size:0.8rem;">-</span>
                                @endif
                            </td>

                            <!-- Jam Pulang (with selfie preview) -->
                            <td style="white-space:nowrap;">
                                @if($row->jam_pulang)
                                    <div style="display:flex; align-items:center; gap:0.6rem;">
                                        @if($row->foto_pulang)
                                            <img src="{{ $row->foto_pulang }}" alt="Selfie Pulang" class="selfie-thumbnail"
                                                onclick="previewImageModal('{{ $row->foto_pulang }}', 'Bukti Swafoto Pulang: {{ $row->user->name }} ({{ $row->jam_pulang->format('H:i') }} WIB)')"
                                                title="Klik untuk melihat foto selfie">
                                        @endif
                                        <div>
                                            <div style="font-family:var(--font-mono); font-weight:700; color:#f43f5e; font-size:0.95rem;">
                                                {{ $row->jam_pulang->format('H:i:s') }}
                                            </div>
                                            <div style="font-size:0.7rem; color:var(--text-muted);">WIB</div>
                                        </div>
                                    </div>
                                @else
                                    <span style="color:var(--text-muted); font-size:0.8rem;">Belum Pulang</span>
                                @endif
                            </td>

                            <!-- Durasi Kerja -->
                            <td style="white-space:nowrap;">
                                @if($row->durasi_kerja)
                                    <span style="font-family:var(--font-mono); font-weight:700; color:#38bdf8; background:rgba(6,182,212,0.1); padding:0.25rem 0.6rem; border-radius:6px; border:1px solid rgba(6,182,212,0.25);">
                                        {{ $row->durasi_kerja }}
                                    </span>
                                @else
                                    <span style="color:var(--text-muted); font-size:0.8rem;">Dalam Tugas</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td style="white-space:nowrap;">
                                @if(str_contains($row->status, 'Tepat Waktu'))
                                    <span style="background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3); font-size:0.75rem; font-weight:700; padding:0.25rem 0.6rem; border-radius:999px;">
                                        Tepat Waktu
                                    </span>
                                @elseif(str_contains($row->status, 'Terlambat'))
                                    <span style="background:rgba(245,158,11,0.15); color:#fbbf24; border:1px solid rgba(245,158,11,0.3); font-size:0.75rem; font-weight:700; padding:0.25rem 0.6rem; border-radius:999px;">
                                        {{ $row->status }}
                                    </span>
                                @else
                                    <span style="background:rgba(99,102,241,0.15); color:#818cf8; border:1px solid rgba(99,102,241,0.3); font-size:0.75rem; font-weight:700; padding:0.25rem 0.6rem; border-radius:999px;">
                                        {{ $row->status }}
                                    </span>
                                @endif
                            </td>

                            <!-- Catatan / Lokasi -->
                            <td style="max-width:240px; font-size:0.8rem; color:var(--text-secondary); text-overflow:ellipsis; overflow:hidden; white-space:nowrap;" title="{{ $row->catatan }}">
                                {{ $row->catatan ?: ($row->lokasi_masuk ?: 'Kantor Pusat') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; padding:3rem 1.5rem; color:var(--text-muted);">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:0.75rem; opacity:0.6;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                <div style="font-size:0.95rem; font-weight:600; color:#fff;">Tidak ada data riwayat absensi</div>
                                <div style="font-size:0.8rem;">Belum ada catatan kehadiran yang sesuai dengan filter bulan dan personil yang dipilih.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
