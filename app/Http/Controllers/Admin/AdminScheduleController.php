<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserSchedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminScheduleController extends Controller
{
    /**
     * Tampilan Utama Pengaturan Jadwal Shift & Hari Off Karyawan
     */
    public function index(Request $request)
    {
        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);
        $selectedRole = $request->get('role'); // null, satpam, caraka
        $selectedUserId = $request->get('user_id');

        // Dates for the month
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;

        $datesList = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $datesList[] = Carbon::createFromDate($year, $month, $d);
        }

        // Query field employees
        $employeesQuery = User::whereIn('role', ['satpam', 'caraka'])
            ->orderBy('role')
            ->orderBy('name');

        if ($selectedRole && in_array($selectedRole, ['satpam', 'caraka'])) {
            $employeesQuery->where('role', $selectedRole);
        }

        if ($selectedUserId) {
            $employeesQuery->where('id', $selectedUserId);
        }

        $employees = $employeesQuery->get();

        // Query schedules for this month
        $schedules = UserSchedule::with(['shift', 'user'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Keyed by "user_id-YYYY-MM-DD" for O(1) lookup
        $scheduleMatrix = [];
        foreach ($schedules as $sch) {
            $scheduleMatrix[$sch->user_id . '_' . $sch->date->format('Y-m-d')] = $sch;
        }

        // Available shifts for dropdown
        $shifts = Shift::all();
        $allStaff = User::whereIn('role', ['satpam', 'caraka'])->orderBy('role')->orderBy('name')->get();

        // Metrics for summary cards
        $totalSlots = count($employees) * $daysInMonth;
        $totalScheduled = $schedules->count();
        $totalWorking = $schedules->where('is_off', false)->count();
        $totalOff = $schedules->where('is_off', true)->count();
        $unassignedSlots = max(0, $totalSlots - $totalScheduled);

        return view('admin.schedules.index', [
            'activeUser' => Auth::user(),
            'allUsers' => User::all(),
            'month' => $month,
            'year' => $year,
            'selectedRole' => $selectedRole,
            'selectedUserId' => $selectedUserId,
            'datesList' => $datesList,
            'employees' => $employees,
            'allStaff' => $allStaff,
            'shifts' => $shifts,
            'scheduleMatrix' => $scheduleMatrix,
            'metrics' => [
                'totalStaff' => count($employees),
                'totalScheduled' => $totalScheduled,
                'totalWorking' => $totalWorking,
                'totalOff' => $totalOff,
                'unassignedSlots' => $unassignedSlots,
            ],
        ]);
    }

    /**
     * Simpan / Perbarui Jadwal 1 Hari untuk 1 Karyawan (Single Day Quick Edit)
     */
    public function storeOrUpdate(Request $request)
    {
        if ($request->has('schedule_type') && !$request->has('is_off')) {
            $request->merge(['is_off' => $request->input('schedule_type') === 'off' ? 1 : 0]);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'is_off' => 'required|boolean',
            'shift_id' => 'nullable|required_if:is_off,0|exists:shifts,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $isOff = (bool) $request->input('is_off');
        $shiftId = $isOff ? null : $validated['shift_id'];
        $notes = $validated['notes'] ?? ($isOff ? 'Libur / Off Tugas' : null);

        $schedule = $this->saveScheduleEntry(
            $validated['user_id'],
            Carbon::parse($validated['date'])->format('Y-m-d'),
            $isOff,
            $shiftId,
            $notes
        );

        $user = User::find($validated['user_id']);
        $statusText = $isOff ? 'Hari Libur (OFF)' : 'Masuk Kerja (' . ($schedule->shift->name ?? 'Shift') . ')';

        return back()->with('success', "Jadwal untuk {$user->name} pada tanggal " . Carbon::parse($validated['date'])->translatedFormat('d M Y') . " berhasil diatur sebagai {$statusText}.");
    }

    /**
     * Batch / Bulk Generator Jadwal (Rentang Tanggal & Pilihan Hari)
     */
    public function bulkStore(Request $request)
    {
        if ($request->has('schedule_type') && !$request->has('is_off')) {
            $request->merge(['is_off' => $request->input('schedule_type') === 'off' ? 1 : 0]);
        }

        $validated = $request->validate([
            'target_group' => 'required|in:specific,all_satpam,all_caraka,all',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'days_of_week' => 'nullable|array', // [0,1,2,3,4,5,6]
            'days_of_week.*' => 'integer|between:0,6',
            'is_off' => 'required|boolean',
            'shift_id' => 'nullable|required_if:is_off,0|exists:shifts,id',
            'notes' => 'nullable|string|max:255',
        ]);

        // Resolve Target Users
        $targetUsers = collect();
        if ($validated['target_group'] === 'all') {
            $targetUsers = User::whereIn('role', ['satpam', 'caraka'])->get();
        } elseif ($validated['target_group'] === 'all_satpam') {
            $targetUsers = User::where('role', 'satpam')->get();
        } elseif ($validated['target_group'] === 'all_caraka') {
            $targetUsers = User::where('role', 'caraka')->get();
        } elseif (!empty($validated['user_ids'])) {
            $targetUsers = User::whereIn('id', $validated['user_ids'])->get();
        }

        if ($targetUsers->isEmpty()) {
            return back()->with('error', 'Tidak ada personil yang dipilih untuk pengaturan jadwal.');
        }

        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = Carbon::parse($validated['end_date'])->endOfDay();
        $period = CarbonPeriod::create($startDate, $endDate);

        $isOff = (bool) $request->input('is_off');
        $shiftId = $isOff ? null : $validated['shift_id'];
        $daysOfWeek = $request->input('days_of_week', []); // if empty, applies to all days in range
        $notes = $validated['notes'] ?? ($isOff ? 'Libur / Off Tugas' : null);

        $recordsCount = 0;

        foreach ($period as $date) {
            $dayOfWeek = $date->dayOfWeek; // 0 = Sunday, 1 = Monday, ... 6 = Saturday

            // Check if day is selected (or all days if none specified)
            if (empty($daysOfWeek) || in_array($dayOfWeek, $daysOfWeek)) {
                $dateString = $date->format('Y-m-d');

                foreach ($targetUsers as $user) {
                    $this->saveScheduleEntry($user->id, $dateString, $isOff, $shiftId, $notes);
                    $recordsCount++;
                }
            }
        }

        $actionType = $isOff ? 'HARI LIBUR (OFF)' : 'MASUK KERJA';
        return back()->with('success', "Berhasil menerapkan jadwal massal: {$recordsCount} slot tanggal berhasil diatur sebagai {$actionType} untuk {$targetUsers->count()} personil.");
    }

    /**
     * Helper save single entry safely
     */
    protected function saveScheduleEntry(int $userId, string $dateString, bool $isOff, ?int $shiftId, ?string $notes)
    {
        $existing = UserSchedule::where('user_id', $userId)
            ->whereDate('date', $dateString)
            ->first();

        if ($existing) {
            $existing->update([
                'shift_id' => $isOff ? null : $shiftId,
                'is_off' => $isOff,
                'notes' => $notes,
                'created_by' => Auth::id(),
            ]);
            return $existing;
        }

        return UserSchedule::create([
            'user_id' => $userId,
            'date' => $dateString,
            'shift_id' => $isOff ? null : $shiftId,
            'is_off' => $isOff,
            'notes' => $notes,
            'created_by' => Auth::id(),
        ]);
    }

    /**
     * Hapus Pengaturan Jadwal Tertentu (Kembali ke Default)
     */
    public function destroy(UserSchedule $schedule)
    {
        $userName = $schedule->user->name ?? 'Personil';
        $dateStr = $schedule->date->translatedFormat('d M Y');
        $schedule->delete();

        return back()->with('success', "Jadwal untuk {$userName} pada tanggal {$dateStr} berhasil dihapus (kembali ke shift default).");
    }

    /**
     * Bersihkan Jadwal 1 Bulan Tertentu
     */
    public function clearMonth(Request $request)
    {
        $month = (int) $request->input('month');
        $year = (int) $request->input('year');
        $role = $request->input('role');

        $query = UserSchedule::whereYear('date', $year)->whereMonth('date', $month);

        if ($role && in_array($role, ['satpam', 'caraka'])) {
            $query->whereHas('user', function ($q) use ($role) {
                $q->where('role', $role);
            });
        }

        $deletedCount = $query->delete();

        return back()->with('success', "Berhasil menghapus {$deletedCount} entri jadwal pada periode {$month}/{$year}.");
    }

    /**
     * Download Template CSV untuk Pengisian Jadwal Karyawan
     */
    public function downloadTemplate(Request $request)
    {
        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);
        $role = $request->get('role');

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;

        $staffQuery = User::whereIn('role', ['satpam', 'caraka'])->orderBy('role')->orderBy('name');
        if ($role && in_array($role, ['satpam', 'caraka'])) {
            $staffQuery->where('role', $role);
        }
        $staffList = $staffQuery->get();

        $shifts = Shift::all();
        $shiftCodes = $shifts->pluck('code')->implode(', ');

        $existingSchedules = UserSchedule::with('shift')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->groupBy(function ($item) {
                return $item->user_id . '_' . $item->date->format('Y-m-d');
            });

        $filename = "Template_Atur_Jadwal_{$year}_" . str_pad($month, 2, '0', STR_PAD_LEFT) . ".csv";

        return response()->streamDownload(function () use ($staffList, $year, $month, $daysInMonth, $existingSchedules, $shiftCodes) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            // Petunjuk pengisian template
            fputcsv($file, ['# PETUNJUK PENGISIAN TEMPLATE JADWAL KERJA & LIBUR (OFF)']);
            fputcsv($file, ["# Periode Bulan: {$month}/{$year} | Kode Shift Tersedia: {$shiftCodes}"]);
            fputcsv($file, ['# Kolom Status: Isi "MASUK" (disertai Kode_Shift) ATAU "LIBUR" (hari libur/off tugas)']);
            fputcsv($file, ['# Simpan file tetap berformat .CSV lalu unggah melalui tombol "Import Jadwal"']);

            // Header Kolom
            fputcsv($file, [
                'NIP',
                'Nama_Karyawan',
                'Peran',
                'Tanggal',
                'Hari',
                'Status',
                'Kode_Shift',
                'Nama_Shift',
                'Catatan',
            ]);

            foreach ($staffList as $staff) {
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $date = Carbon::createFromDate($year, $month, $d);
                    $dateStr = $date->format('Y-m-d');
                    $key = $staff->id . '_' . $dateStr;
                    $sch = $existingSchedules->get($key)?->first();

                    $status = 'MASUK';
                    $shiftCode = '';
                    $shiftName = '';
                    $notes = '';

                    if ($sch) {
                        if ($sch->is_off) {
                            $status = 'LIBUR';
                            $shiftCode = 'OFF';
                            $shiftName = 'Libur (OFF)';
                            $notes = $sch->notes ?? 'Libur';
                        } else {
                            $status = 'MASUK';
                            $shiftCode = $sch->shift->code ?? '';
                            $shiftName = $sch->shift->name ?? '';
                            $notes = $sch->notes ?? '';
                        }
                    } else {
                        $status = 'MASUK';
                        $shiftCode = $staff->role === 'satpam' ? 'STP_PAGI' : 'CRK_REGULER';
                        $shiftName = $staff->role === 'satpam' ? 'Shift Pagi Satpam' : 'Shift Reguler Caraka';
                        $notes = '';
                    }

                    fputcsv($file, [
                        $staff->nip ?? '',
                        $staff->name,
                        strtoupper($staff->role),
                        $dateStr,
                        $date->translatedFormat('l'),
                        $status,
                        $shiftCode,
                        $shiftName,
                        $notes,
                    ]);
                }
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export Roster / Matriks Jadwal Karyawan ke Format Excel/CSV
     */
    public function export(Request $request)
    {
        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);
        $role = $request->get('role');
        $userId = $request->get('user_id');

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;

        $staffQuery = User::whereIn('role', ['satpam', 'caraka'])->orderBy('role')->orderBy('name');
        if ($role && in_array($role, ['satpam', 'caraka'])) {
            $staffQuery->where('role', $role);
        }
        if ($userId) {
            $staffQuery->where('id', $userId);
        }
        $staffList = $staffQuery->get();

        $existingSchedules = UserSchedule::with(['shift', 'creator'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->groupBy(function ($item) {
                return $item->user_id . '_' . $item->date->format('Y-m-d');
            });

        $shifts = Shift::all()->keyBy('role');

        $filename = "Rekap_Jadwal_Karyawan_{$year}_" . str_pad($month, 2, '0', STR_PAD_LEFT) . ".csv";

        return response()->streamDownload(function () use ($staffList, $year, $month, $daysInMonth, $existingSchedules, $shifts) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            fputcsv($file, [
                'No',
                'NIP',
                'Nama Karyawan',
                'Peran (Divisi)',
                'Tanggal',
                'Hari',
                'Status Jadwal',
                'Kode Shift',
                'Nama Shift',
                'Jam Operasional',
                'Catatan Penugasan',
                'Diatur Oleh',
            ]);

            $rowNum = 1;
            foreach ($staffList as $staff) {
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $date = Carbon::createFromDate($year, $month, $d);
                    $dateStr = $date->format('Y-m-d');
                    $key = $staff->id . '_' . $dateStr;
                    $sch = $existingSchedules->get($key)?->first();

                    $status = 'MASUK (Standar)';
                    $shiftCode = '-';
                    $shiftName = 'Shift Default';
                    $workHours = '-';
                    $notes = '-';
                    $setBy = 'Sistem';

                    if ($sch) {
                        if ($sch->is_off) {
                            $status = 'LIBUR (OFF)';
                            $shiftCode = 'OFF';
                            $shiftName = 'Hari Libur Bebas Tugas';
                            $workHours = 'OFF';
                            $notes = $sch->notes ?? 'Libur';
                        } else {
                            $status = 'MASUK (Khusus)';
                            $shiftCode = $sch->shift->code ?? '-';
                            $shiftName = $sch->shift->name ?? '-';
                            $workHours = $sch->shift ? substr($sch->shift->start_time, 0, 5) . ' - ' . substr($sch->shift->end_time, 0, 5) . ' WIB' : '-';
                            $notes = $sch->notes ?? '-';
                        }
                        $setBy = $sch->creator->name ?? 'Admin';
                    } else {
                        $defaultShift = $shifts->get($staff->role);
                        if ($defaultShift) {
                            $shiftCode = $defaultShift->code;
                            $shiftName = $defaultShift->name;
                            $workHours = substr($defaultShift->start_time, 0, 5) . ' - ' . substr($defaultShift->end_time, 0, 5) . ' WIB';
                        }
                    }

                    fputcsv($file, [
                        $rowNum++,
                        $staff->nip ?? '-',
                        $staff->name,
                        strtoupper($staff->role),
                        $dateStr,
                        $date->translatedFormat('l'),
                        $status,
                        $shiftCode,
                        $shiftName,
                        $workHours,
                        $notes,
                        $setBy,
                    ]);
                }
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Import Jadwal Karyawan dari Berkas CSV Template
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|max:5120',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        if (!$handle) {
            return back()->with('error', 'Gagal membuka berkas CSV yang diunggah.');
        }

        $shiftsByCode = Shift::all()->keyBy(function ($item) {
            return strtoupper(trim($item->code));
        });
        $usersByNip = User::whereNotNull('nip')->get()->keyBy(function ($item) {
            return strtoupper(trim($item->nip));
        });
        $usersByName = User::all()->keyBy(function ($item) {
            return strtolower(trim($item->name));
        });

        $processed = 0;
        $updated = 0;
        $header = null;
        $headerMap = [];

        while (($row = fgetcsv($handle, 2000, ',')) !== false) {
            if (empty($row) || !isset($row[0])) {
                continue;
            }
            $firstCol = trim($row[0]);
            if (str_starts_with($firstCol, '#')) {
                continue;
            }

            if (!$header) {
                $cleanRow = array_map(function ($col) {
                    return strtoupper(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $col)));
                }, $row);

                if (in_array('NIP', $cleanRow) || in_array('TANGGAL', $cleanRow)) {
                    $header = $cleanRow;
                    foreach ($header as $idx => $colName) {
                        $colNameLower = strtolower(str_replace([' ', '_'], '', $colName));
                        $headerMap[$colNameLower] = $idx;
                    }
                    continue;
                }
            }

            if (!$header) {
                continue;
            }

            $processed++;

            $nipIdx = $headerMap['nip'] ?? 0;
            $nameIdx = $headerMap['namakaryawan'] ?? ($headerMap['nama'] ?? 1);
            $dateIdx = $headerMap['tanggal'] ?? 3;
            $statusIdx = $headerMap['status'] ?? 5;
            $shiftCodeIdx = $headerMap['kodeshift'] ?? 6;
            $notesIdx = $headerMap['catatan'] ?? 8;

            $nipVal = strtoupper(trim($row[$nipIdx] ?? ''));
            $nameVal = trim($row[$nameIdx] ?? '');
            $dateVal = trim($row[$dateIdx] ?? '');
            $statusVal = strtoupper(trim($row[$statusIdx] ?? ''));
            $shiftCodeVal = strtoupper(trim($row[$shiftCodeIdx] ?? ''));
            $notesVal = trim($row[$notesIdx] ?? '');

            // Find User
            $user = null;
            if ($nipVal && isset($usersByNip[$nipVal])) {
                $user = $usersByNip[$nipVal];
            } elseif ($nameVal && isset($usersByName[strtolower($nameVal)])) {
                $user = $usersByName[strtolower($nameVal)];
            }

            if (!$user) {
                continue;
            }

            try {
                $carbonDate = Carbon::parse($dateVal);
                $dateString = $carbonDate->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }

            // Determine is_off
            $isOff = false;
            if (in_array($statusVal, ['LIBUR', 'OFF', 'CUTI']) || in_array($shiftCodeVal, ['LIBUR', 'OFF', 'CUTI'])) {
                $isOff = true;
            }

            $shiftId = null;
            if (!$isOff) {
                if ($shiftCodeVal && isset($shiftsByCode[$shiftCodeVal])) {
                    $shiftId = $shiftsByCode[$shiftCodeVal]->id;
                } else {
                    $defaultShift = Shift::where('role', $user->role)->first();
                    $shiftId = $defaultShift?->id;
                }
            }

            $notes = $notesVal ?: ($isOff ? 'Libur (Import)' : null);

            $this->saveScheduleEntry($user->id, $dateString, $isOff, $shiftId, $notes);
            $updated++;
        }

        fclose($handle);

        return back()->with('success', "Proses import selesai: {$updated} jadwal karyawan berhasil disimpan dari berkas CSV.");
    }
}
