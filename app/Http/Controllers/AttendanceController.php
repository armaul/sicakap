<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceController extends Controller
{
    /**
     * Get the active authenticated user.
     */
    protected function getActiveUser(?Request $request = null): User
    {
        return Auth::user();
    }


    /**
     * Dashboard Absensi (Menu Utama)
     */
    public function dashboard(Request $request)
    {
        $activeUser = $this->getActiveUser($request);
        $allUsers = User::orderBy('role')->orderBy('name')->get();
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // Check if there is an ongoing night shift from yesterday
        $yesterdayAttendance = Attendance::with('shift')
            ->where('user_id', $activeUser->id)
            ->whereDate('date', $yesterday)
            ->whereNotNull('jam_masuk')
            ->whereNull('jam_pulang')
            ->first();

        // Current today's attendance record
        $attendance = $yesterdayAttendance ?: Attendance::with('shift')
            ->where('user_id', $activeUser->id)
            ->whereDate('date', $today)
            ->first();

        // Shifts for user role
        if ($activeUser->isAdmin()) {
            $shifts = Shift::all();
        } else {
            $shifts = Shift::where('role', $activeUser->role)->orWhere('role', 'all')->get();
            if ($shifts->isEmpty()) {
                $shifts = Shift::all();
            }
        }

        if ($shifts->isEmpty()) {
            $defaultShift = Shift::create([
                'name' => 'Shift Reguler Pagi',
                'code' => 'REG_PAGI',
                'role' => $activeUser->role ?? 'satpam',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'is_night_shift' => false,
                'grace_period_minutes' => 15,
                'description' => 'Shift kerja standar operasional harian.'
            ]);
            $shifts = collect([$defaultShift]);
        } else {
            $defaultShift = $shifts->first();
        }

        // Check if employee has an assigned schedule / roster today
        $todaySchedule = \App\Models\UserSchedule::with('shift')
            ->where('user_id', $activeUser->id)
            ->whereDate('date', $today)
            ->first();

        $isScheduledOff = $todaySchedule ? (bool) $todaySchedule->is_off : false;

        // Next scheduled working day if employee is currently OFF
        $nextWorkingSchedule = null;
        if ($isScheduledOff) {
            $nextWorkingSchedule = \App\Models\UserSchedule::with('shift')
                ->where('user_id', $activeUser->id)
                ->whereDate('date', '>', $today)
                ->where('is_off', false)
                ->orderBy('date')
                ->first();
        }

        if ($attendance && $attendance->shift) {
            $selectedShift = $attendance->shift;
        } elseif ($todaySchedule && $todaySchedule->shift) {
            $selectedShift = $todaySchedule->shift;
        } elseif ($nextWorkingSchedule && $nextWorkingSchedule->shift) {
            $selectedShift = $nextWorkingSchedule->shift;
        } else {
            $selectedShift = $defaultShift;
        }

        // Recent activity logs today for this user
        $todayActivities = ActivityLog::where('user_id', $activeUser->id)
            ->whereDate('created_at', $today)
            ->latest()
            ->take(5)
            ->get();

        // Monthly stats for user
        $startOfMonth = Carbon::today()->startOfMonth();
        $monthlyAttendances = Attendance::where('user_id', $activeUser->id)
            ->where('date', '>=', $startOfMonth)
            ->get();

        $totalDays = $monthlyAttendances->whereNotNull('jam_masuk')->count();
        $onTimeDays = $monthlyAttendances->filter(fn($a) => str_contains($a->status, 'Tepat Waktu'))->count();
        $lateDays = $monthlyAttendances->filter(fn($a) => str_contains($a->status, 'Terlambat'))->count();

        // Data monitoring rekapitulasi harian untuk Admin & Supervisor
        $adminMonitoring = null;
        if ($activeUser->isSupervisor()) {
            $fieldStaff = User::whereIn('role', ['satpam', 'caraka'])->orderBy('role')->orderBy('name')->get();

            $todayAttendances = Attendance::with(['user', 'shift'])
                ->whereDate('date', $today)
                ->get()
                ->keyBy('user_id');

            $todayLeaves = \App\Models\LeaveRequest::where('status', 'Disetujui')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->get()
                ->keyBy('user_id');

            $totalStaff = $fieldStaff->count();
            $hadirCount = $todayAttendances->whereNotNull('jam_masuk')->count();
            $onDutyCount = $todayAttendances->whereNotNull('jam_masuk')->whereNull('jam_pulang')->count();
            $completedCount = $todayAttendances->whereNotNull('jam_pulang')->count();
            $onTimeCount = $todayAttendances->filter(fn($a) => str_contains($a->status, 'Tepat Waktu'))->count();
            $lateCount = $todayAttendances->filter(fn($a) => str_contains($a->status, 'Terlambat'))->count();
            $leaveCount = $todayLeaves->count();
            $notPresentCount = max(0, $totalStaff - $hadirCount - $leaveCount);

            $staffRecap = $fieldStaff->map(function ($staff) use ($todayAttendances, $todayLeaves) {
                $att = $todayAttendances->get($staff->id);
                $leave = $todayLeaves->get($staff->id);

                return (object) [
                    'user' => $staff,
                    'attendance' => $att,
                    'leave' => $leave,
                ];
            });

            $allTodayActivities = ActivityLog::with('user')
                ->whereDate('created_at', $today)
                ->latest()
                ->take(10)
                ->get();

            $adminMonitoring = [
                'totalStaff' => $totalStaff,
                'hadirCount' => $hadirCount,
                'onDutyCount' => $onDutyCount,
                'completedCount' => $completedCount,
                'onTimeCount' => $onTimeCount,
                'lateCount' => $lateCount,
                'leaveCount' => $leaveCount,
                'notPresentCount' => $notPresentCount,
                'staffRecap' => $staffRecap,
                'allTodayActivities' => $allTodayActivities,
            ];
        }

        // Perhitungan kelayakan absen pulang berdasarkan ketentuan shift
        $canClockOut = false;
        $shiftEndTime = null;
        $shiftEndTimeFormatted = null;
        $shiftEndTimeIso = null;

        $hasClockedIn = $attendance && !is_null($attendance->jam_masuk);
        $hasClockedOut = $attendance && !is_null($attendance->jam_pulang);

        $shiftForClockOut = ($attendance && $attendance->shift) ? $attendance->shift : $selectedShift;

        if ($shiftForClockOut) {
            $shiftDate = ($attendance && $attendance->date) ? $attendance->date->format('Y-m-d') : $today;
            $isCrossMidnight = (bool) ($shiftForClockOut->is_night_shift || ($shiftForClockOut->end_time <= $shiftForClockOut->start_time));

            $shiftEndTime = Carbon::parse($shiftDate . ' ' . $shiftForClockOut->end_time);
            if ($isCrossMidnight) {
                $shiftEndTime = $shiftEndTime->addDay();
            }

            $now = Carbon::now();
            $canClockOut = $now->greaterThanOrEqualTo($shiftEndTime);
            $shiftEndTimeFormatted = $shiftEndTime->format('H:i') . ' WIB' . ($isCrossMidnight ? ' (Besok)' : '');
            $shiftEndTimeIso = $shiftEndTime->toIso8601String();
        } else {
            $canClockOut = true;
        }

        return view('dashboard', [
            'activeUser' => $activeUser,
            'allUsers' => $allUsers,
            'today' => Carbon::now(),
            'shifts' => $shifts,
            'selectedShift' => $selectedShift,
            'attendance' => $attendance,
            'todayActivities' => $todayActivities,
            'todaySchedule' => $todaySchedule,
            'isScheduledOff' => $isScheduledOff,
            'nextWorkingSchedule' => $nextWorkingSchedule,
            'adminMonitoring' => $adminMonitoring,
            'canClockOut' => $canClockOut,
            'shiftEndTime' => $shiftEndTime,
            'shiftEndTimeFormatted' => $shiftEndTimeFormatted,
            'shiftEndTimeIso' => $shiftEndTimeIso,
            'locationSettings' => \App\Models\Setting::getLocationSettings(),
            'stats' => [
                'totalDays' => $totalDays,
                'onTimeDays' => $onTimeDays,
                'lateDays' => $lateDays,
            ],
        ]);
    }

    /**
     * Process Absen Masuk (Clock-in)
     */
    public function clockIn(Request $request): JsonResponse
    {
        $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'photo' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        // Verifikasi ketat: Pembatasan radius lokasi maps kantor/sekolah
        [$isLocationValid, $locationError, $distanceMeters] = $this->validateLocationCoordinates($request);
        if (!$isLocationValid) {
            return response()->json([
                'success' => false,
                'message' => $locationError,
            ], 422);
        }

        $activeUser = $this->getActiveUser($request);
        $today = Carbon::today()->format('Y-m-d');
        $shift = Shift::findOrFail($request->shift_id);

        // Verifikasi ketat: Karyawan yang terjadwal Libur/OFF tidak dapat absen masuk
        $todaySchedule = \App\Models\UserSchedule::where('user_id', $activeUser->id)
            ->whereDate('date', $today)
            ->first();

        if ($todaySchedule && $todaySchedule->is_off) {
            $nextSchedule = \App\Models\UserSchedule::with('shift')
                ->where('user_id', $activeUser->id)
                ->whereDate('date', '>', $today)
                ->where('is_off', false)
                ->orderBy('date')
                ->first();

            $nextInfo = $nextSchedule ? ' Anda dijadwalkan masuk kembali pada hari ' . $nextSchedule->date->translatedFormat('l, d F Y') . ' (' . ($nextSchedule->shift->name ?? 'Shift') . ').' : '';

            return response()->json([
                'success' => false,
                'message' => 'Hari ini Anda terjadwal LIBUR / OFF Tugas. Absen masuk dinonaktifkan sampai jadwal dinas Anda berikutnya.' . $nextInfo,
            ], 422);
        }

        $attendance = Attendance::where('user_id', $activeUser->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            $attendance = new Attendance([
                'user_id' => $activeUser->id,
                'date' => $today,
            ]);
        }

        // If user already clocked in
        if ($attendance->hasClockedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan Absen Masuk hari ini pada pukul ' . $attendance->jam_masuk->format('H:i') . ' WIB.',
            ], 422);
        }

        $now = Carbon::now();
        $photoUrl = $this->storeBase64Photo($request->photo, 'in_' . $activeUser->id);

        $attendance->shift_id = $shift->id;
        $attendance->jam_masuk = $now;
        $attendance->foto_masuk = $photoUrl;
        $attendance->lokasi_masuk = $request->lokasi ?: 'Kantor Pusat Satpam/Caraka';
        $attendance->catatan = $request->catatan;

        // Check punctuality
        $shiftStartTime = Carbon::parse($today . ' ' . $shift->start_time);
        $toleranceTime = $shiftStartTime->copy()->addMinutes($shift->grace_period_minutes);

        if ($now->greaterThan($toleranceTime)) {
            $lateMinutes = (int) round($shiftStartTime->diffInMinutes($now));
            $attendance->status = "Terlambat ({$lateMinutes}m)";
        } else {
            $attendance->status = 'Tepat Waktu';
        }

        $attendance->save();

        // Optional logbook activity entry
        ActivityLog::create([
            'user_id' => $activeUser->id,
            'attendance_id' => $attendance->id,
            'title' => 'Absen Masuk Bertugas: ' . $shift->name,
            'category' => $activeUser->isSatpam() ? 'Patroli' : 'Kebersihan',
            'location' => $attendance->lokasi_masuk,
            'description' => 'Mulai bertugas shift ' . $shift->name . '. ' . ($request->catatan ?: 'Kondisi awal aman dan siap bertugas.'),
            'status' => 'Selesai',
            'photo' => $photoUrl,
            'time_recorded' => $now->format('H:i:s'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen Masuk Berhasil! Selamat bertugas.',
            'data' => [
                'jam_masuk' => $now->format('H:i:s'),
                'jam_masuk_formatted' => $now->format('H:i') . ' WIB',
                'status' => $attendance->status,
                'foto_masuk' => $photoUrl,
                'lokasi_masuk' => $attendance->lokasi_masuk,
            ],
        ]);
    }

    /**
     * Process Absen Pulang (Clock-out)
     */
    public function clockOut(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        // Verifikasi ketat: Pembatasan radius lokasi maps kantor/sekolah
        [$isLocationValid, $locationError, $distanceMeters] = $this->validateLocationCoordinates($request);
        if (!$isLocationValid) {
            return response()->json([
                'success' => false,
                'message' => $locationError,
            ], 422);
        }

        $activeUser = $this->getActiveUser($request);
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // Look for today's attendance, or yesterday's ongoing night shift
        $attendance = Attendance::where('user_id', $activeUser->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance || !$attendance->hasClockedIn()) {
            $yesterdayAttendance = Attendance::where('user_id', $activeUser->id)
                ->whereDate('date', $yesterday)
                ->whereNotNull('jam_masuk')
                ->whereNull('jam_pulang')
                ->first();

            if ($yesterdayAttendance) {
                $attendance = $yesterdayAttendance;
            }
        }

        if (!$attendance || !$attendance->hasClockedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan Absen Masuk. Harap absen masuk terlebih dahulu.',
            ], 422);
        }

        if ($attendance->hasClockedOut()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan Absen Pulang hari ini pada pukul ' . $attendance->jam_pulang->format('H:i') . ' WIB.',
            ], 422);
        }

        $now = Carbon::now();
        $shift = $attendance->shift ?: Shift::find($attendance->shift_id);

        // Verifikasi ketat: Belum memasuki jam absen pulang tidak bisa absen pulang sesuai ketentuan shift
        if ($shift) {
            $shiftDate = $attendance->date ? $attendance->date->format('Y-m-d') : Carbon::today()->format('Y-m-d');
            $isCrossMidnight = (bool) ($shift->is_night_shift || ($shift->end_time <= $shift->start_time));

            $shiftEndTime = Carbon::parse($shiftDate . ' ' . $shift->end_time);
            if ($isCrossMidnight) {
                $shiftEndTime = $shiftEndTime->addDay();
            }

            if ($now->lessThan($shiftEndTime)) {
                $timeFormatted = $shiftEndTime->format('H:i') . ' WIB' . ($isCrossMidnight ? ' besok hari' : '');
                return response()->json([
                    'success' => false,
                    'message' => "Belum memasuki jam absen pulang. Sesuai ketentuan shift {$shift->name}, Anda baru dapat melakukan absen pulang pada pukul {$timeFormatted}.",
                ], 422);
            }
        }

        $photoUrl = $this->storeBase64Photo($request->photo, 'out_' . $activeUser->id);

        $attendance->jam_pulang = $now;
        $attendance->foto_pulang = $photoUrl;
        $attendance->lokasi_pulang = $request->lokasi ?: 'Kantor Pusat Satpam/Caraka';
        if ($request->catatan) {
            $attendance->catatan = ($attendance->catatan ? $attendance->catatan . "\nCatatan Pulang: " : "Catatan Pulang: ") . $request->catatan;
        }

        // Calculate duration (accurate for both normal & cross-midnight night shifts)
        $in = Carbon::parse($attendance->jam_masuk);
        $diffMinutes = max(0, $in->diffInMinutes($now));
        $attendance->durasi_menit = $diffMinutes;

        $hours = intdiv($diffMinutes, 60);
        $mins = $diffMinutes % 60;
        $attendance->durasi_kerja = "{$hours} Jam {$mins} Menit";

        $attendance->save();

        // Activity log entry for checkout
        ActivityLog::create([
            'user_id' => $activeUser->id,
            'attendance_id' => $attendance->id,
            'title' => 'Absen Pulang Selesai Bertugas: ' . ($attendance->shift->name ?? 'Shift'),
            'category' => $activeUser->isSatpam() ? 'Serah Terima Jaga' : 'Kebersihan',
            'location' => $attendance->lokasi_pulang,
            'description' => 'Selesai bertugas. Durasi kerja: ' . $attendance->durasi_kerja . '. ' . ($request->catatan ?: 'Serah terima tugas selesai.'),
            'status' => 'Selesai',
            'photo' => $photoUrl,
            'time_recorded' => $now->format('H:i:s'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen Pulang Berhasil! Terima kasih atas dedikasi dan kerja keras Anda hari ini.',
            'data' => [
                'jam_pulang' => $now->format('H:i:s'),
                'jam_pulang_formatted' => $now->format('H:i') . ' WIB',
                'durasi_kerja' => $attendance->durasi_kerja,
                'foto_pulang' => $photoUrl,
                'lokasi_pulang' => $attendance->lokasi_pulang,
            ],
        ]);
    }

    /**
     * Menu Riwayat Absensi
     */
    public function history(Request $request)
    {
        $activeUser = $this->getActiveUser();
        $allUsers = User::orderBy('role')->orderBy('name')->get();

        $selectedMonth = (int) $request->get('month', Carbon::now()->month);
        $selectedYear = (int) $request->get('year', Carbon::now()->year);
        $selectedUserId = $request->get('user_id', $activeUser->isSupervisor() ? null : $activeUser->id);

        $query = Attendance::with(['user', 'shift'])
            ->whereYear('date', $selectedYear)
            ->whereMonth('date', $selectedMonth);

        if ($selectedUserId) {
            $query->where('user_id', $selectedUserId);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        // Recap Metrics
        $totalHadir = $attendances->whereNotNull('jam_masuk')->count();
        $totalTepatWaktu = $attendances->filter(fn($a) => str_contains($a->status, 'Tepat Waktu'))->count();
        $totalTerlambat = $attendances->filter(fn($a) => str_contains($a->status, 'Terlambat'))->count();
        $totalMenitKerja = $attendances->sum('durasi_menit');
        $totalJamKerja = round($totalMenitKerja / 60, 1);

        return view('attendances.history', [
            'activeUser' => $activeUser,
            'allUsers' => $allUsers,
            'attendances' => $attendances,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'selectedUserId' => $selectedUserId,
            'recap' => [
                'totalHadir' => $totalHadir,
                'totalTepatWaktu' => $totalTepatWaktu,
                'totalTerlambat' => $totalTerlambat,
                'totalJamKerja' => $totalJamKerja,
            ],
        ]);
    }

    /**
     * Export Riwayat Absensi ke CSV
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);
        $userId = $request->get('user_id');

        $query = Attendance::with(['user', 'shift'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $attendances = $query->orderBy('date', 'asc')->get();

        $filename = "Rekap_Absensi_{$year}_{$month}.csv";

        return response()->streamDownload(function () use ($attendances) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'Tanggal',
                'NIP',
                'Nama Personil',
                'Peran (Satpam/Caraka)',
                'Shift',
                'Jam Masuk',
                'Lokasi Masuk',
                'Jam Pulang',
                'Lokasi Pulang',
                'Durasi Kerja',
                'Status',
                'Catatan',
            ]);

            foreach ($attendances as $index => $att) {
                fputcsv($file, [
                    $index + 1,
                    $att->date->format('d/m/Y'),
                    $att->user->nip ?? '-',
                    $att->user->name ?? '-',
                    strtoupper($att->user->role ?? '-'),
                    $att->shift->name ?? '-',
                    $att->jam_masuk ? $att->jam_masuk->format('H:i:s') : '-',
                    $att->lokasi_masuk ?? '-',
                    $att->jam_pulang ? $att->jam_pulang->format('H:i:s') : '-',
                    $att->lokasi_pulang ?? '-',
                    $att->durasi_kerja ?? '-',
                    $att->status ?? '-',
                    $att->catatan ?? '-',
                ]);
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Helper to decode and store base64 captured photo
     */
    protected function storeBase64Photo(?string $base64Data, string $prefix): ?string
    {
        if (!$base64Data) {
            return null;
        }

        // Check if it's already a URL
        if (str_starts_with($base64Data, 'http://') || str_starts_with($base64Data, 'https://')) {
            return $base64Data;
        }

        try {
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
                $ext = strtolower($type[1]);
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $ext = 'jpg';
                }
            } else {
                $ext = 'jpg';
            }

            $decoded = base64_decode($base64Data);
            if ($decoded === false) {
                return null;
            }

            $filename = 'selfie_' . $prefix . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
            Storage::disk('public')->put('selfies/' . $filename, $decoded);

            return asset('storage/selfies/' . $filename);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Validate whether user's coordinates are within the configured office radius.
     *
     * @return array{0: bool, 1: ?string, 2: ?float} [isValid, errorMessage, distanceMeters]
     */
    protected function validateLocationCoordinates(Request $request): array
    {
        $settings = \App\Models\Setting::getLocationSettings();

        // Jika pembatasan lokasi tidak diaktifkan, selalu lolos
        if (!$settings['is_enabled']) {
            return [true, null, null];
        }

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        // Jika lat/lng tidak terkirim langsung, coba ekstrak dari string lokasi jika ada format "Lat: ..., Long: ..."
        if (($lat === null || $lng === null) && $request->filled('lokasi')) {
            if (preg_match('/Lat:\s*([-\d\.]+),\s*Long:\s*([-\d\.]+)/i', $request->lokasi, $matches)) {
                $lat = (float) $matches[1];
                $lng = (float) $matches[2];
            }
        }

        if ($lat === null || $lng === null || !is_numeric($lat) || !is_numeric($lng)) {
            return [
                false,
                'Titik koordinat GPS tidak terdeteksi. Harap izinkan akses lokasi (GPS) pada peramban/perangkat Anda untuk melakukan absensi.',
                null,
            ];
        }

        $userLat = (float) $lat;
        $userLng = (float) $lng;
        $officeLat = $settings['latitude'];
        $officeLng = $settings['longitude'];
        $maxRadius = $settings['radius_meters'];
        $officeName = $settings['office_name'];

        $distance = $this->calculateDistanceMeters($userLat, $userLng, $officeLat, $officeLng);

        if ($distance > $maxRadius) {
            $distRounded = round($distance);
            return [
                false,
                "Anda berada di luar area yang diizinkan! Jarak Anda saat ini {$distRounded} meter dari {$officeName}. Batas maksimal radius adalah {$maxRadius} meter.",
                $distance,
            ];
        }

        return [true, null, $distance];
    }

    /**
     * Calculate distance between two coordinates in meters using the Haversine formula.
     */
    protected function calculateDistanceMeters(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // in meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
