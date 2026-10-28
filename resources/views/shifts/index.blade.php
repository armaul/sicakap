@extends('layouts.app')

@section('title', 'Jadwal & Shift Kerja - Satpam & Caraka')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.75rem;">

    <!-- Page Header & Action Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                Struktur Jadwal & Pembagian Shift Kerja
            </h1>
            <p style="color:var(--text-secondary); font-size:0.875rem;">
                Pengaturan waktu kerja satpam 24 jam (pagi, siang, dan shift malam lintas hari) serta jadwal harian petugas caraka.
            </p>
        </div>

        @if($activeUser->isAdmin())
            <a href="{{ route('admin.schedules.index') }}" class="btn-filter" style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(245,158,11,0.15); border-color:rgba(245,158,11,0.3); color:#fcd34d;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                Atur Hari Masuk & Off Karyawan &rarr;
            </a>
        @endif
    </div>

    <!-- Night Shift Architecture Insight Banner -->
    <div class="glass-card" style="border-color:rgba(99,102,241,0.4); background:linear-gradient(135deg, rgba(30,41,59,0.9) 0%, rgba(49,46,129,0.25) 100%);">
        <div style="display:flex; gap:1.25rem; align-items:flex-start;">
            <div style="width:48px; height:48px; border-radius:12px; background:rgba(99,102,241,0.2); border:1px solid rgba(99,102,241,0.4); display:flex; align-items:center; justify-content:center; color:#a5b4fc; flex-shrink:0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
            </div>
            <div>
                <h3 style="font-size:1.1rem; font-weight:700; color:#fff; margin-bottom:0.35rem;">
                    🌙 Logika Penanganan Shift Malam Satpam (Cross-Midnight Architecture)
                </h3>
                <p style="font-size:0.875rem; color:#cbd5e1; line-height:1.6; margin-bottom:0.75rem;">
                    Satpam memiliki jadwal jaga malam (pukul <strong>23:00 s/d 07:00 WIB</strong> hari berikutnya). Sistem dirancang dengan kolom <code>is_night_shift = true</code> dan pencatatan tanggal berbasis <em>Working Schedule Date</em> (bukan sekadar tanggal saat tombol ditekan). Dengan demikian:
                </p>
                <ul style="font-size:0.85rem; color:#94a3b8; line-height:1.7; padding-left:1.25rem;">
                    <li>Absen masuk pada <strong>23:00 (Hari 1)</strong> dan absen pulang pada <strong>07:00 (Hari 2)</strong> tercatat dalam satu baris absensi yang utuh.</li>
                    <li>Perhitungan durasi kerja menggunakan <code>Carbon::diffInMinutes()</code> secara otomatis mendeteksi pergantian tanggal tanpa nilai negatif atau error format jam.</li>
                    <li>Tombol "Absen Pulang" tetap mengenali kehadiran shift malam dari hari sebelumnya.</li>
                </ul>
            </div>
        </div>
    </div>

    @if($mySchedules->isNotEmpty())
        <!-- Personal Monthly Roster & OFF Days Table -->
        <div class="glass-card" style="padding:0; overflow:hidden;">
            <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-subtle); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem;">
                <div>
                    <h3 style="font-size:1.05rem; font-weight:700; color:#fff; display:flex; align-items:center; gap:0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        Jadwal Tugas & Hari Libur (OFF) Anda Bulan Ini
                    </h3>
                    <p style="font-size:0.8rem; color:var(--text-muted); margin-top:2px;">
                        Berikut adalah daftar hari masuk bertugas dan hari libur (OFF) yang telah ditetapkan oleh Administrator untuk Anda.
                    </p>
                </div>
                <div style="font-size:0.75rem; color:var(--text-muted); font-family:var(--font-mono);">
                    {{ $mySchedules->where('is_off', false)->count() }} Hari Masuk &bull; {{ $mySchedules->where('is_off', true)->count() }} Hari OFF
                </div>
            </div>

            <div class="table-responsive" style="max-height:360px; overflow-y:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Status Penugasan</th>
                            <th>Shift Kerja</th>
                            <th>Jam Operasional</th>
                            <th>Catatan / Pos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mySchedules as $sch)
                            @php
                                $isToday = $sch->date->isToday();
                            @endphp
                            <tr style="{{ $isToday ? 'background:rgba(99,102,241,0.1); font-weight:600;' : '' }}">
                                <td style="font-family:var(--font-mono); color:#fff;">
                                    {{ $sch->date->translatedFormat('d M Y') }}
                                    @if($isToday)
                                        <span style="font-size:0.65rem; color:#34d399; background:rgba(16,185,129,0.15); padding:1px 6px; border-radius:4px; margin-left:4px;">Hari Ini</span>
                                    @endif
                                </td>
                                <td style="color:var(--text-secondary);">
                                    {{ $sch->date->translatedFormat('l') }}
                                </td>
                                <td>
                                    @if($sch->is_off)
                                        <span style="font-size:0.75rem; font-weight:800; padding:0.25rem 0.65rem; border-radius:999px; background:rgba(244,63,94,0.18); color:#fda4af; border:1px solid rgba(244,63,94,0.35);">
                                            🏖️ LIBUR (OFF)
                                        </span>
                                    @else
                                        <span style="font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px; background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3);">
                                            💼 MASUK BERTUGAS
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($sch->is_off)
                                        <span style="color:var(--text-muted);">-</span>
                                    @else
                                        <strong style="color:#fff;">{{ $sch->shift->name ?? 'Shift Kerja' }}</strong>
                                    @endif
                                </td>
                                <td style="font-family:var(--font-mono); font-size:0.85rem; color:#38bdf8;">
                                    @if($sch->is_off)
                                        <span style="color:var(--text-muted);">-</span>
                                    @else
                                        {{ substr($sch->shift->start_time ?? '00:00', 0, 5) }} - {{ substr($sch->shift->end_time ?? '00:00', 0, 5) }} WIB
                                    @endif
                                </td>
                                <td style="font-size:0.8rem; color:var(--text-secondary);">
                                    {{ $sch->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Shifts Cards Grid -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:1.5rem;">
        @foreach($shifts as $shift)
            <div class="glass-card shift-card {{ $shift->is_night_shift ? 'night-shift' : '' }}" style="display:flex; flex-direction:column; justify-content:space-between;">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
                        <span class="user-role-badge role-{{ $shift->role }}">{{ strtoupper($shift->role) }}</span>
                        @if($shift->is_night_shift)
                            <span class="shift-badge-night">🌙 Lintas Hari</span>
                        @else
                            <span style="font-size:0.75rem; color:#34d399; font-weight:700; background:rgba(16,185,129,0.15); padding:0.2rem 0.5rem; border-radius:999px;">☀️ Normal</span>
                        @endif
                    </div>

                    <h2 style="font-size:1.25rem; font-weight:800; color:#fff; margin-bottom:0.4rem;">
                        {{ $shift->name }}
                    </h2>

                    <div style="font-family:var(--font-mono); font-size:1.35rem; font-weight:800; color:#38bdf8; margin-bottom:0.75rem;">
                        {{ substr($shift->start_time, 0, 5) }} - {{ substr($shift->end_time, 0, 5) }} WIB
                    </div>

                    <p style="font-size:0.85rem; color:var(--text-secondary); line-height:1.5; margin-bottom:1rem;">
                        {{ $shift->description }}
                    </p>
                </div>

                <div style="border-top:1px solid var(--border-subtle); padding-top:0.85rem; display:flex; justify-content:space-between; align-items:center; font-size:0.8rem;">
                    <span style="color:var(--text-muted);">Toleransi Telat:</span>
                    <strong style="color:#fff;">{{ $shift->grace_period_minutes }} Menit</strong>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Personnel & Role Assignments -->
    <div class="glass-card">
        <h3 class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Daftar Personil Satpam & Caraka Aktif
        </h3>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:1rem;">
            @foreach($allUsers as $u)
                <div style="display:flex; align-items:center; gap:0.85rem; padding:0.85rem 1rem; background:rgba(15,23,42,0.6); border-radius:var(--radius-lg); border:1px solid var(--border-subtle);">
                    <img src="{{ $u->avatar }}" alt="{{ $u->name }}" style="width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid var(--border-accent);">
                    <div style="flex:1; overflow:hidden;">
                        <div style="font-weight:700; color:#fff; font-size:0.925rem; white-space:nowrap; text-overflow:ellipsis; overflow:hidden;">{{ $u->name }}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">{{ $u->position }}</div>
                        <div style="font-size:0.7rem; font-family:var(--font-mono); color:var(--cyan-primary); margin-top:2px;">{{ $u->nip }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
