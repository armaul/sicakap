<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\AdminBackupController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminShiftController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Tamu / Guest)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Logout (Hanya untuk pengguna yang sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Core Application Routes (Wajib Login / Protected Session)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Menu Utama: Dashboard Absensi Real-time
    Route::get('/', [AttendanceController::class, 'dashboard'])->name('dashboard');
    Route::post('/absen/masuk', [AttendanceController::class, 'clockIn'])->name('absen.masuk');
    Route::post('/absen/pulang', [AttendanceController::class, 'clockOut'])->name('absen.pulang');

    // Menu Riwayat Absensi
    Route::get('/riwayat', [AttendanceController::class, 'history'])->name('attendances.history');
    Route::get('/riwayat/export', [AttendanceController::class, 'exportCsv'])->name('attendances.export');

    // Menu Izin / Sakit
    Route::get('/izin', [LeaveController::class, 'index'])->name('leave.index');
    Route::post('/izin', [LeaveController::class, 'store'])->name('leave.store');
    Route::patch('/izin/{leave}/status', [LeaveController::class, 'updateStatus'])->name('leave.updateStatus');
    Route::delete('/izin/{leave}', [LeaveController::class, 'destroy'])->name('leave.destroy');

    // Logbook & Kegiatan Satpam / Caraka
    Route::get('/kegiatan', [ActivityLogController::class, 'index'])->name('activities.index');
    Route::post('/kegiatan', [ActivityLogController::class, 'store'])->name('activities.store');

    // Jadwal & Shift Kerja (User View)
    Route::get('/jadwal-shift', [ShiftController::class, 'index'])->name('shifts.index');

    // Edit Profil Pengguna (Tersedia untuk Seluruh Pengguna)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // Profile Switcher (Hanya untuk Administrator)
    Route::get('/switch-user/{id}', [SessionController::class, 'switchUser'])->name('session.switchUser');
});

/*
|--------------------------------------------------------------------------
| Administrator Protected Routes (CRUD User & CRUD Jadwal Shift)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kelola User
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Kelola Jadwal Shift Master
    Route::get('/shifts', [AdminShiftController::class, 'index'])->name('shifts.index');
    Route::post('/shifts', [AdminShiftController::class, 'store'])->name('shifts.store');
    Route::put('/shifts/{shift}', [AdminShiftController::class, 'update'])->name('shifts.update');
    Route::delete('/shifts/{shift}', [AdminShiftController::class, 'destroy'])->name('shifts.destroy');

    // Pengaturan Jadwal & Hari Masuk / Off Karyawan
    Route::get('/schedules', [AdminScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/template', [AdminScheduleController::class, 'downloadTemplate'])->name('schedules.template');
    Route::get('/schedules/export', [AdminScheduleController::class, 'export'])->name('schedules.export');
    Route::post('/schedules/import', [AdminScheduleController::class, 'import'])->name('schedules.import');
    Route::post('/schedules/assign', [AdminScheduleController::class, 'storeOrUpdate'])->name('schedules.assign');
    Route::post('/schedules/bulk', [AdminScheduleController::class, 'bulkStore'])->name('schedules.bulk');
    Route::delete('/schedules/{schedule}', [AdminScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::post('/schedules/clear-month', [AdminScheduleController::class, 'clearMonth'])->name('schedules.clearMonth');
    Route::post('/schedules/clear', [AdminScheduleController::class, 'clearMonth'])->name('schedules.clear');

    // Menu Backup & Restore Seluruh Data
    Route::get('/backup', [AdminBackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/export', [AdminBackupController::class, 'export'])->name('backup.export');
    Route::get('/backup/export-sql', [AdminBackupController::class, 'exportSql'])->name('backup.exportSql');
    Route::post('/backup/import', [AdminBackupController::class, 'import'])->name('backup.import');
});
