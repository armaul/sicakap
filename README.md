# SICAKAP - Sistem Informasi Absensi & Kegiatan Satpam & Caraka

Aplikasi sistem absensi modern dan logbook kegiatan terpadu berbasis **Laravel** yang dirancang khusus untuk personil **Satpam (Security)** dan **Caraka (Office Boy / Kurir / Layanan Operasional Dalam)**.

Aplikasi ini mengakomodasi pembagian shift kerja 24 jam (pagi, siang, dan **shift malam lintas hari / cross-midnight**) serta verifikasi kehadiran berbasis **swafoto (selfie) real-time menggunakan kamera HTML5 `<video>`** dan deteksi GPS.

---

## 🌟 Fitur Utama Sesuai Kebutuhan

### 1. Menu Utama (Dashboard Absensi)
- **Jam Digital Real-time:** Tampilan waktu berformat digital neon monospace (`HH:MM:SS WIB`) yang berdetik setiap detik secara real-time, lengkap dengan hari dan tanggal dalam Bahasa Indonesia.
- **Informasi Jadwal Shift Hari Ini:** Menampilkan nama shift (Shift Pagi, Shift Siang, Shift Malam, Shift Reguler Caraka), jam operasional, badge khusus shift malam lintas hari, toleransi keterlambatan (15 menit), dan pemilih shift.
- **Tampilan Kamera (Live Preview) HTML5 `<video>`:**
  - Live stream webcam menggunakan `navigator.mediaDevices.getUserMedia`.
  - Dilengkapi frame oval panduan wajah (*face guide reticle*), animasi sinar pemindai (*scan beam*), tombol switch kamera depan/belakang, efek lampu kilat (*camera flash*), dan fallback cerdas simulator swafoto jika berjalan di peramban tanpa webcam fisik.
- **Deteksi Geolocation (GPS):** Deteksi koordinat posisi presisi (latitude, longitude, akurasi radius kantor).
- **Dua Tombol Utama Sesuai Logika Kehadiran:**
  - 🟢 **Tombol Hijau ("Absen Masuk"):**
    - Aktif jika personil belum memiliki catatan `jam_masuk` pada hari/shift tersebut.
    - Menjepret swafoto dari frame video canvas, merekam lokasi & catatan tugas, lalu menyimpan status kehadiran (Tepat Waktu / Terlambat).
    - Setelah absen masuk berhasil, tombol dinonaktifkan dengan tanda centang *"Sudah Masuk"*.
  - 🔴 **Tombol Merah ("Absen Pulang"):**
    - **Baru akan muncul / aktif** setelah sistem mendeteksi pengguna telah melakukan absen masuk.
    - Menjepret swafoto kepulangan, menghitung otomatis total **Durasi Kerja** (termasuk menangani shift malam yang melewati pukul 00:00 tengah malam), dan menyelesaikan tugas hari tersebut.
    - Setelah absen pulang selesai, status terkunci *"Sudah Pulang"*.

### 2. Menu Riwayat Absensi
- **Tabel Rekapitulasi Kehadiran Bulanan:**
  - Filter interaktif berdasarkan **Bulan (Januari - Desember)**, **Tahun**, dan **Personil** (Satpam / Caraka).
  - Kolom lengkap: **Tanggal**, **Personil (Foto, Nama, NIP)**, **Shift**, **Jam Masuk** (dengan thumbnail foto selfie yang bisa diklik untuk zoom modal), **Jam Pulang** (dengan thumbnail selfie), **Durasi Kerja** (misal: `8 Jam 15 Menit`), **Status** (Tepat Waktu, Terlambat, Hadir), dan **Catatan / Pos Jaga**.
- **Kartu Ringkasan KPI Bulanan:**
  - Total Kehadiran, Total Tepat Waktu, Total Terlambat, dan Akumulasi Jam Kerja.
- **Fitur Ekspor & Cetak:**
  - Tombol **Export Excel / CSV** (dengan UTF-8 BOM untuk kompatibilitas penuh Microsoft Excel).
  - Tombol **Cetak Laporan** (print stylesheet siap cetak dokumen resmi).

### 3. Menu Izin / Sakit
- **Formulir Pengajuan Ketidakhadiran:**
  - Pilihan kategori: **Sakit**, **Izin**, **Cuti**, atau **Tugas Dinas Luar**.
  - Tanggal mulai s/d tanggal selesai.
  - Alasan lengkap pengajuan.
  - **Fitur Unggah Bukti / Surat Keterangan Dokter:** Mendukung upload berkas (JPG, PNG, PDF, WEBP hingga 5MB) dengan drag-and-drop dan pratinjau instan (*live image preview*).
- **Rekap & Status Verifikasi:**
  - Status badge: **Menunggu Approval (Kuning)**, **Disetujui (Hijau)**, **Ditolak (Merah)**.
  - Modal pratinjau dokumen surat dokter.
  - Fitur verifikasi bagi atasan / supervisor (*Setujui* atau *Tolak* beserta catatan pertimbangan).

### 4. Logbook Kegiatan Caraka & Satpam
- Pencatatan aktivitas kerja harian:
  - Satpam: Patroli perimeter gedung, inspeksi APAR & CCTV, serah terima buku jaga, laporan insiden.
  - Caraka: Kebersihan lobby & ruang rapat, sanitasi berkala toilet, distribusi surat & pengantaran dokumen antar divisi.
- **Upload Foto Bukti Kegiatan (Wajib*):**
  - Setiap laporan kegiatan wajib melampirkan foto bukti fisik pekerjaan (maksimal **10 MB**, format JPG, PNG, WEBP).
  - Dilengkapi fitur *live preview* foto sebelum disimpan, validasi ukuran file langsung di browser, dan modal perbesaran (*zoom*) foto resolusi penuh.
- Timeline kegiatan per tanggal lengkap dengan jam pencatatan, thumbnail foto bukti, dan status pekerjaan.

### 5. Pengaturan & Struktur Shift Kerja
- Penjelasan lengkap arsitektur perhitungan shift malam satpam yang melintasi tengah malam (pukul 23:00 ke 07:00 hari berikutnya).
- Daftar roster personil satpam dan caraka aktif.

---

## 🗄️ Rancangan Struktur Database

Sistem menggunakan database relasional (default: SQLite portabel, siap beralih ke MySQL/MariaDB Laragon) dengan skema berikut:

### 1. Tabel `users`
| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT (PK) | ID unik pengguna |
| `name` | VARCHAR | Nama lengkap personil |
| `nip` | VARCHAR (Unique) | Nomor Induk Pegawai / ID Satpam / Caraka |
| `email` | VARCHAR (Unique) | Alamat email dinas |
| `role` | VARCHAR | Peran: `satpam`, `caraka`, `supervisor`, `admin` |
| `position` | VARCHAR | Jabatan: Komandan Regu, Jaga Malam, Koordinator Kebersihan, dll. |
| `phone` | VARCHAR | Nomor kontak / WhatsApp |
| `avatar` | VARCHAR | URL foto profil |
| `password` | VARCHAR | Hash kata sandi |

### 2. Tabel `shifts`
| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT (PK) | ID unik shift |
| `name` | VARCHAR | Nama shift (misal: "Shift Malam Satpam") |
| `code` | VARCHAR (Unique) | Kode unik (misal: `STP_MALAM`) |
| `role` | VARCHAR | Target peran: `satpam`, `caraka`, `all` |
| `start_time` | TIME | Jam mulai bertugas (misal: `23:00:00`) |
| `end_time` | TIME | Jam selesai bertugas (misal: `07:00:00`) |
| `is_night_shift` | BOOLEAN | Penanda shift lintas tengah malam (`true`/`false`) |
| `grace_period_minutes` | INT | Toleransi keterlambatan (default: 15 menit) |
| `description` | TEXT | Uraian pos & cakupan tugas shift |

### 3. Tabel `attendances` (Inti Rekap Presensi)
| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT (PK) | ID unik presensi |
| `user_id` | BIGINT (FK) | Relasi ke tabel `users` |
| `shift_id` | BIGINT (FK) | Relasi ke tabel `shifts` |
| `date` | DATE | Tanggal jadwal kerja (*Working Schedule Date*) |
| `jam_masuk` | DATETIME | Waktu clock-in sesungguhnya |
| `foto_masuk` | TEXT | Path/URL swafoto bukti masuk |
| `lokasi_masuk` | VARCHAR | Koordinat GPS / label lokasi masuk |
| `jam_pulang` | DATETIME | Waktu clock-out sesungguhnya |
| `foto_pulang` | TEXT | Path/URL swafoto bukti pulang |
| `lokasi_pulang` | VARCHAR | Koordinat GPS / label lokasi pulang |
| `durasi_menit` | INT | Total menit kerja dihitung otomatis |
| `durasi_kerja` | VARCHAR | Format durasi (misal: `"8 Jam 15 Menit"`) |
| `status` | VARCHAR | Status: `Tepat Waktu`, `Terlambat (Xm)`, `Izin`, `Sakit` |
| `catatan` | TEXT | Catatan area tugas / pos jaga / pekerjaan |

> **Indeks Unik:** `unique(['user_id', 'date'])` mencegah duplikasi absensi pada hari kerja yang sama.

### 4. Tabel `leave_requests` (Pengajuan Izin & Sakit)
| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT (PK) | ID pengajuan |
| `user_id` | BIGINT (FK) | Relasi ke pemohon |
| `type` | VARCHAR | Jenis: `Sakit`, `Izin`, `Cuti`, `Dinas Luar` |
| `start_date` | DATE | Tanggal mulai izin/sakit |
| `end_date` | DATE | Tanggal berakhir |
| `alasan` | TEXT | Keterangan detail |
| `surat_bukti` | VARCHAR | Path file / foto surat keterangan dokter |
| `status` | VARCHAR | `Menunggu`, `Disetujui`, `Ditolak` |
| `catatan_atasan` | TEXT | Catatan hasil verifikasi |
| `approved_by` | BIGINT (FK) | ID atasan/supervisor peninjau |

### 5. Tabel `activity_logs` (Logbook Kegiatan)
| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT (PK) | ID aktivitas |
| `user_id` | BIGINT (FK) | Relasi ke personil pelaksana |
| `attendance_id` | BIGINT (FK) | Relasi opsional ke sesi presensi |
| `title` | VARCHAR | Judul kegiatan |
| `category` | VARCHAR | `Patroli`, `Inspeksi`, `Kebersihan`, `Pengiriman Surat`, `Insiden` |
| `location` | VARCHAR | Area penempatan / lantai |
| `description` | TEXT | Hasil temuan / rincian pekerjaan |
| `status` | VARCHAR | `Selesai`, `Dalam Proses` |
| `time_recorded`| TIME | Waktu pelaksanaan |

---

## 🌙 Solusi Teknis: Penanganan Shift Malam (Cross-Midnight)

Jadwal satpam sering kali dimulai pada **23:00 (Hari ke-1)** dan berakhir pada **07:00 (Hari ke-2)**:
1. **Pencatatan Tanggal:** Kolom `date` mengacu pada **tanggal mulai dinas** (Hari ke-1), bukan tanggal kepulangan.
2. **Kueri Absen Pulang:** Saat personil menekan tombol *"Absen Pulang"* di pagi hari (Hari ke-2), sistem secara otomatis memeriksa apakah terdapat sesi shift malam aktif dari hari sebelumnya (`yesterday`) yang belum clock-out.
3. **Perhitungan Durasi:**
   ```php
   $in = Carbon::parse($attendance->jam_masuk);
   $out = Carbon::parse($attendance->jam_pulang);
   $diffMinutes = max(0, $in->diffInMinutes($out));
   
   $hours = intdiv($diffMinutes, 60);
   $mins = $diffMinutes % 60;
   $attendance->durasi_kerja = "{$hours} Jam {$mins} Menit";
   ```
   Metode ini menghasilkan angka durasi yang akurat tanpa nilai negatif atau kalkulasi jam yang salah.

---

## 🚀 Panduan Menjalankan Aplikasi

Aplikasi telah terinstal dan terkonfigurasi lengkap di direktori ini.

### 1. Konfigurasi Database MySQL
Aplikasi menggunakan **MySQL** dengan konfigurasi pada berkas [`.env`](file:///c:/Users/USER/Downloads/project%20website/absensi%20kegiatan%20caraka%20satpam/.env):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_satpam_caraka
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Menjalankan Server Lokal Laravel
Jalankan perintah berikut di PowerShell atau terminal:
```bash
php artisan serve
```
Aplikasi akan aktif di alamat: **`http://127.0.0.1:8000`**

### 3. Akun Personil & Administrator Bawaan (Kredensial Login)
Setiap akun dapat login di halaman **`/login`** menggunakan **NIP** atau **Email** dengan kata sandi: **`password123`**

| Peran (Role) | Nama Lengkap | NIP / Akun Login | Kata Sandi | Akses Khusus |
| :--- | :--- | :--- | :--- | :--- |
| **Administrator** | Administrator Utama | `ADM-2024-001` / `admin@satpamcaraka.id` | `password123` | **Full Akses: Kelola Seluruh User & Jadwal Shift** |
| **Satpam (Pagi)** | Budi Santoso | `STP-2024-001` / `budi.santoso@satpam.id` | `password123` | Presensi kamera, patroli pos, pengajuan izin |
| **Satpam (Malam)**| Hendra Wijaya | `STP-2024-002` / `hendra.wijaya@satpam.id` | `password123` | Presensi shift malam lintas hari (23:00 - 07:00) |
| **Caraka (Pagi)** | Dewi Sartika | `CRK-2024-001` / `dewi.sartika@caraka.id` | `password123` | Presensi harian, logbook kebersihan & kurir |
| **Caraka (Siang)**| Rian Ardianto | `CRK-2024-002` / `rian.ardianto@caraka.id` | `password123` | Presensi harian & tugas pembersihan siang-sore |
| **Supervisor** | Bambang Hermawan, S.H. | `SPV-2023-010` / `supervisor@kantor.id` | `password123` | Approval izin & sakit, rekapitulasi semua personil |

---

## 📁 Struktur Berkas Proyek

```
absensi kegiatan caraka satpam/
├── app/
│   ├── Http/Controllers/
│   │   ├── AttendanceController.php  # Clock-in, Clock-out, Dashboard, Riwayat, Ekspor CSV
│   │   ├── LeaveController.php       # Form izin/sakit, upload surat dokter, verifikasi atasan
│   │   ├── ActivityLogController.php # Logbook patroli & kebersihan
│   │   ├── ShiftController.php       # Informasi roster & shift kerja
│   │   └── SessionController.php     # 1-Click Profile Switcher
│   └── Models/
│       ├── User.php
│       ├── Shift.php
│       ├── Attendance.php
│       ├── LeaveRequest.php
│       └── ActivityLog.php
├── database/
│   ├── migrations/                  # 7 migrasi database lengkap
│   └── seeders/
│       └── DatabaseSeeder.php       # Seeder otomatis shift, personil, dan data riwayat
├── public/
│   ├── css/
│   │   └── app.css                  # Desain ultra-modern, glassmorphism, responsive
│   ├── js/
│   │   └── app.js                   # Jam real-time, HTML5 webcam stream, GPS, validasi tombol
│   └── storage/
│       ├── selfies/                 # Direktori penyimpanan swafoto bukti presensi
│       └── surat_izin/              # Direktori penyimpanan foto surat dokter
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php            # Master layout & navbar interaktif
│   ├── dashboard.blade.php          # Menu Utama: Jam real-time, kamera video, 2 tombol utama
│   ├── attendances/
│   │   └── history.blade.php        # Menu Riwayat: Rekap bulanan, KPI, export CSV, cetak
│   ├── leave/
│   │   └── index.blade.php          # Menu Izin/Sakit: Form upload bukti & status verifikasi
│   ├── activities/
│   │   └── index.blade.php          # Menu Logbook: Catatan patroli & sanitasi
│   └── shifts/
│       └── index.blade.php          # Menu Jadwal: Penjelasan logika shift malam
└── routes/
    └── web.php                      # Rute aplikasi lengkap
```
