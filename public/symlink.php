<?php
/**
 * SICAKAP - Helper Symlink Storage untuk Shared Hosting cPanel
 * Jalankan sekali via browser: https://sicakap.smkn1jatisari.sch.id/symlink.php
 * Hapus file ini setelah symlink berhasil dibuat untuk alasan keamanan.
 */

$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

echo "<h2>SICAKAP Storage Symlink Setup</h2>";

if (file_exists($shortcut)) {
    echo "<p style='color:green;'>✅ Tautan 'public/storage' sudah ada dan aktif!</p>";
} else {
    if (@symlink($target, $shortcut)) {
        echo "<p style='color:green;'>🎉 Berhasil! Symlink berhasil dibuat: public/storage &rarr; storage/app/public</p>";
        echo "<p>Foto selfie absensi dan foto logbook sekarang sudah dapat ditampilkan.</p>";
    } else {
        echo "<p style='color:red;'>⚠️ Gagal membuat symlink otomatis. Silakan gunakan menu Terminal di cPanel dan jalankan: <code>php artisan storage:link</code></p>";
    }
}
