<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminBackupController extends Controller
{
    /**
     * Tampilan utama Menu Backup & Restore Data Sistem
     */
    public function index(Request $request)
    {
        $tableCounts = [
            'users' => [
                'name' => 'Data Pengguna / Akun (Users)',
                'count' => User::count(),
                'icon' => 'user',
                'color' => '#6366f1',
            ],
            'shifts' => [
                'name' => 'Master Shift Operasional',
                'count' => Shift::count(),
                'icon' => 'clock',
                'color' => '#f59e0b',
            ],
            'user_schedules' => [
                'name' => 'Jadwal Roster & Hari Off',
                'count' => UserSchedule::count(),
                'icon' => 'calendar',
                'color' => '#10b981',
            ],
            'attendances' => [
                'name' => 'Riwayat & Rekapitulasi Absensi',
                'count' => Attendance::count(),
                'icon' => 'check-circle',
                'color' => '#3b82f6',
            ],
            'activity_logs' => [
                'name' => 'Logbook Kegiatan & Foto Bukti',
                'count' => ActivityLog::count(),
                'icon' => 'book-open',
                'color' => '#06b6d4',
            ],
            'leave_requests' => [
                'name' => 'Pengajuan Izin & Sakit',
                'count' => LeaveRequest::count(),
                'icon' => 'file-text',
                'color' => '#ec4899',
            ],
        ];

        $totalRecords = array_sum(array_column($tableCounts, 'count'));

        // Estimasi ukuran database dari MySQL information_schema
        $dbName = config('database.connections.mysql.database', 'absensi_satpam_caraka');
        $dbSizeBytes = 0;
        try {
            $sizeQuery = DB::select("
                SELECT SUM(data_length + index_length) AS size 
                FROM information_schema.TABLES 
                WHERE table_schema = ?
            ", [$dbName]);
            if (!empty($sizeQuery) && isset($sizeQuery[0]->size)) {
                $dbSizeBytes = (int) $sizeQuery[0]->size;
            }
        } catch (\Exception $e) {
            $dbSizeBytes = 0;
        }

        $formattedDbSize = $this->formatBytes($dbSizeBytes);

        // Cek status storage link
        $storageLinked = is_dir(public_path('storage'));

        return view('admin.backup.index', [
            'activeUser' => Auth::user(),
            'allUsers' => User::all(),
            'tableCounts' => $tableCounts,
            'totalRecords' => $totalRecords,
            'dbName' => $dbName,
            'formattedDbSize' => $formattedDbSize,
            'storageLinked' => $storageLinked,
            'uploadMax' => ini_get('upload_max_filesize'),
            'postMax' => ini_get('post_max_size'),
        ]);
    }

    /**
     * Export Full Backup ke file JSON terstruktur
     */
    public function export(Request $request)
    {
        $admin = Auth::user();

        $data = [
            'app' => 'SICAKAP - Sistem Absensi & Logbook Terpadu',
            'export_version' => '1.0',
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'generated_by' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'nip' => $admin->nip,
                'email' => $admin->email,
                'role' => $admin->role,
            ],
            'summary' => [
                'users' => User::count(),
                'shifts' => Shift::count(),
                'user_schedules' => UserSchedule::count(),
                'attendances' => Attendance::count(),
                'activity_logs' => ActivityLog::count(),
                'leave_requests' => LeaveRequest::count(),
                'total_records' => User::count() + Shift::count() + UserSchedule::count() + Attendance::count() + ActivityLog::count() + LeaveRequest::count(),
            ],
            'tables' => [
                'users' => DB::table('users')->get()->toArray(),
                'shifts' => DB::table('shifts')->get()->toArray(),
                'user_schedules' => DB::table('user_schedules')->get()->toArray(),
                'attendances' => DB::table('attendances')->get()->toArray(),
                'activity_logs' => DB::table('activity_logs')->get()->toArray(),
                'leave_requests' => DB::table('leave_requests')->get()->toArray(),
            ],
        ];

        $jsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $filename = 'SICAKAP_FULL_BACKUP_' . Carbon::now()->format('Y-m-d_His') . '.json';

        return response($jsonString, 200, [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export Full Backup ke file SQL Query script (Direct phpMyAdmin / MySQL CLI)
     */
    public function exportSql(Request $request)
    {
        $tables = ['users', 'shifts', 'user_schedules', 'attendances', 'activity_logs', 'leave_requests'];
        $now = Carbon::now();

        $sql = "-- ========================================================\n";
        $sql .= "-- SICAKAP - Sistem Absensi & Logbook Satpam Caraka\n";
        $sql .= "-- FULL DATABASE SQL BACKUP\n";
        $sql .= "-- Tanggal Export : " . $now->translatedFormat('l, d F Y - H:i:s') . " WIB\n";
        $sql .= "-- Operator Admin : " . Auth::user()->name . " (NIP: " . Auth::user()->nip . ")\n";
        $sql .= "-- ========================================================\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $rows = DB::table($table)->get();
            $count = $rows->count();

            $sql .= "-- --------------------------------------------------------\n";
            $sql .= "-- Data Tabel: `{$table}` ({$count} baris)\n";
            $sql .= "-- --------------------------------------------------------\n";

            if ($rows->isNotEmpty()) {
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $cols = array_map(fn($c) => "`{$c}`", array_keys($rowArray));
                    $vals = array_map(function ($val) {
                        if (is_null($val)) {
                            return 'NULL';
                        }
                        return "'" . addslashes((string) $val) . "'";
                    }, array_values($rowArray));

                    $sql .= "INSERT INTO `{$table}` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ");\n";
                }
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $sql .= "-- Selesai diexport pada " . Carbon::now()->format('Y-m-d H:i:s') . " WIB\n";

        $filename = 'SICAKAP_SQL_BACKUP_' . $now->format('Y-m-d_His') . '.sql';

        return response($sql, 200, [
            'Content-Type' => 'application/sql; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Import dan Pulihkan Seluruh Data dari File Backup JSON
     */
    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|max:51200', // maks 50MB
            'mode' => 'required|in:merge,replace',
        ], [
            'backup_file.required' => 'Silakan pilih berkas file backup terlebih dahulu.',
            'backup_file.file' => 'Berkas yang diunggah tidak valid.',
            'backup_file.max' => 'Ukuran berkas maksimal adalah 50 MB.',
            'mode.required' => 'Pilih salah satu mode pemulihan data (Gabung atau Timpa Bersih).',
            'mode.in' => 'Mode pemulihan data tidak dikenali.',
        ]);

        $file = $request->file('backup_file');
        $ext = strtolower($file->getClientOriginalExtension());

        if ($ext !== 'json') {
            return back()->with('error', 'Format berkas tidak valid! Hanya berkas backup resmi berekstensi .JSON yang dapat dipulihkan melalui menu ini.');
        }

        $jsonContent = file_get_contents($file->getRealPath());
        $backupData = json_decode($jsonContent, true);

        if (!$backupData || !isset($backupData['tables']) || !is_array($backupData['tables'])) {
            return back()->with('error', 'Struktur berkas backup tidak valid atau rusak. Pastikan file JSON berasal dari fitur Export SICAKAP.');
        }

        $mode = $request->input('mode');
        $currentAdmin = Auth::user();
        $importedCounts = [
            'users' => 0,
            'shifts' => 0,
            'user_schedules' => 0,
            'attendances' => 0,
            'activity_logs' => 0,
            'leave_requests' => 0,
        ];

        DB::beginTransaction();
        try {
            $this->setForeignKeyChecks(false);

            $tables = ['users', 'shifts', 'user_schedules', 'attendances', 'activity_logs', 'leave_requests'];

            if ($mode === 'replace') {
                // Mode Timpa Bersih: Kosongkan seluruh tabel operasional
                // Urutan truncate dari tabel turunan ke master
                foreach (array_reverse($tables) as $tbl) {
                    DB::table($tbl)->truncate();
                }

                // Pulihkan data sesuai urutan relasi foreign key
                foreach ($tables as $tbl) {
                    if (!empty($backupData['tables'][$tbl]) && is_array($backupData['tables'][$tbl])) {
                        $rows = array_map(function ($item) {
                            return (array) $item;
                        }, $backupData['tables'][$tbl]);

                        foreach (array_chunk($rows, 100) as $chunk) {
                            DB::table($tbl)->insert($chunk);
                        }
                        $importedCounts[$tbl] = count($rows);
                    }
                }

                // Pastikan admin yang sedang aktif tetap ada agar sesi login tidak rusak
                if (!DB::table('users')->where('id', $currentAdmin->id)->exists()) {
                    DB::table('users')->insert((array) $currentAdmin->getAttributes());
                }
            } else {
                // Mode Merge / Upsert: Update jika ID sudah ada, buat baru jika belum
                foreach ($tables as $tbl) {
                    if (!empty($backupData['tables'][$tbl]) && is_array($backupData['tables'][$tbl])) {
                        foreach ($backupData['tables'][$tbl] as $item) {
                            $row = (array) $item;
                            if (isset($row['id'])) {
                                DB::table($tbl)->updateOrInsert(['id' => $row['id']], $row);
                                $importedCounts[$tbl]++;
                            }
                        }
                    }
                }
            }

            $this->setForeignKeyChecks(true);
            DB::commit();

            $modeText = $mode === 'replace' ? 'Timpa Bersih (Full Replace)' : 'Penggabungan Data (Merge & Upsert)';
            $totalSuccess = array_sum($importedCounts);

            return back()->with('success', "Proses pemulihan data berhasil ({$modeText})! Sebanyak {$totalSuccess} total data berhasil dipulihkan: {$importedCounts['users']} Pengguna, {$importedCounts['shifts']} Shift, {$importedCounts['user_schedules']} Jadwal Roster, {$importedCounts['attendances']} Riwayat Absensi, {$importedCounts['activity_logs']} Logbook, dan {$importedCounts['leave_requests']} Izin.");
        } catch (\Exception $e) {
            $this->setForeignKeyChecks(true);
            DB::rollBack();

            return back()->with('error', 'Gagal memulihkan data cadangan. Pesan kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Aktifkan atau nonaktifkan foreign key checks sesuai driver database
     */
    protected function setForeignKeyChecks(bool $enable): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=' . ($enable ? '1' : '0') . ';');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ' . ($enable ? 'ON' : 'OFF') . ';');
        }
    }

    /**
     * Helper format ukuran byte ke KB/MB
     */
    protected function formatBytes($bytes, $precision = 2): string
    {
        if ($bytes <= 0) {
            return '0 KB';
        }
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
