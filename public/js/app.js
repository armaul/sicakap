/**
 * Absensi Satpam & Caraka - Main Client Application Logic
 */

document.addEventListener('DOMContentLoaded', () => {
  initRealtimeClock();
  initWebcam();
  initGeolocation();
  initUserDropdown();
});

/* ==========================================================================
   1. Real-time Digital Clock & Indonesian Date
   ========================================================================== */
function initRealtimeClock() {
  const hoursEl = document.getElementById('clockHours');
  const minutesEl = document.getElementById('clockMinutes');
  const secondsEl = document.getElementById('clockSeconds');
  const dateEl = document.getElementById('clockDate');

  if (!hoursEl || !minutesEl || !secondsEl) return;

  const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  const months = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];

  function update() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2, '0');
    const m = String(now.getMinutes()).padStart(2, '0');
    const s = String(now.getSeconds()).padStart(2, '0');

    hoursEl.textContent = h;
    minutesEl.textContent = m;
    secondsEl.textContent = s;

    if (dateEl) {
      const dayName = days[now.getDay()];
      const dayNum = now.getDate();
      const monthName = months[now.getMonth()];
      const year = now.getFullYear();
      dateEl.innerHTML = `<span>📅</span> ${dayName}, ${dayNum} ${monthName} ${year}`;
    }

    // Dynamic verification of shift end time in real-time
    const btnPulang = document.getElementById('btnAbsenPulang');
    if (btnPulang && btnPulang.getAttribute('data-can-clock-out') === '0') {
      const endTimeIso = btnPulang.getAttribute('data-end-time');
      if (endTimeIso) {
        const targetDate = new Date(endTimeIso);
        if (now >= targetDate) {
          btnPulang.setAttribute('data-can-clock-out', '1');
          btnPulang.disabled = false;
          btnPulang.classList.remove('locked');
          btnPulang.title = 'Ambil Swafoto & Absen Pulang';
          btnPulang.innerHTML = `
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
            <span id="btnPulangText">Absen Pulang</span>
          `;
          const hintBox = document.getElementById('attendanceHintBox');
          if (hintBox) {
            hintBox.innerHTML = '<span style="color:#f43f5e;">●</span> Jam operasional shift telah selesai! Tombol Merah ("Absen Pulang") kini <strong>AKTIF</strong>.';
          }
        }
      }
    }
  }

  update();
  setInterval(update, 1000);
}

/* ==========================================================================
   2. HTML5 Live Camera (getUserMedia) with Fallback Simulator
   ========================================================================== */
let currentStream = null;
let useFrontCamera = true;
let isCameraActive = false;

async function initWebcam() {
  const video = document.getElementById('webcamVideo');
  const statusPill = document.getElementById('cameraStatusPill');
  const fallbackBox = document.getElementById('cameraFallback');

  if (!video) return;

  // Check if getUserMedia is supported
  if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    showCameraFallback('Perangkat browser tidak mendukung akses kamera HTML5.');
    return;
  }

  try {
    if (currentStream) {
      currentStream.getTracks().forEach(track => track.stop());
    }

    const constraints = {
      video: {
        facingMode: useFrontCamera ? 'user' : 'environment',
        width: { ideal: 640 },
        height: { ideal: 480 }
      },
      audio: false
    };

    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    currentStream = stream;
    video.srcObject = stream;
    isCameraActive = true;

    if (fallbackBox) fallbackBox.style.display = 'none';
    video.style.display = 'block';

    if (statusPill) {
      statusPill.innerHTML = '<span class="pulse-dot" style="background:#10b981;"></span> Live Kamera Aktif';
    }
  } catch (err) {
    console.warn('Webcam permission error or no camera:', err);
    showCameraFallback('Kamera tidak aktif atau izin ditolak. Mode Swafoto Virtual diaktifkan.');
  }
}

function showCameraFallback(reasonText) {
  isCameraActive = false;
  const video = document.getElementById('webcamVideo');
  const fallbackBox = document.getElementById('cameraFallback');
  const statusPill = document.getElementById('cameraStatusPill');

  if (video) video.style.display = 'none';
  if (fallbackBox) {
    fallbackBox.style.display = 'flex';
    const textEl = fallbackBox.querySelector('.fallback-msg');
    if (textEl) textEl.textContent = reasonText;
  }
  if (statusPill) {
    statusPill.innerHTML = '<span class="pulse-dot" style="background:#f59e0b;"></span> Mode Swafoto Cerdas';
  }
}

// Switch Camera front/back
window.switchCamera = function() {
  useFrontCamera = !useFrontCamera;
  initWebcam();
};

/* ==========================================================================
   3. Live Geolocation Detection
   ========================================================================== */
let userLocationString = 'Pos Satpam / Kantor Utama';
window.currentUserLat = null;
window.currentUserLng = null;
window.currentUserDistanceMeters = null;
window.isWithinAllowedRadius = true;

function calculateHaversineDistance(lat1, lon1, lat2, lon2) {
  const R = 6371000; // in meters
  const dLat = (lat2 - lat1) * Math.PI / 180;
  const dLon = (lon2 - lon1) * Math.PI / 180;
  const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return R * c;
}

function initGeolocation() {
  const gpsBox = document.getElementById('gpsStatusBox');
  const gpsText = document.getElementById('gpsLocationText');

  if (!navigator.geolocation) {
    if (gpsText) gpsText.textContent = 'GPS tidak didukung perangkat ini.';
    return;
  }

  navigator.geolocation.getCurrentPosition(
    (position) => {
      window.currentUserLat = position.coords.latitude;
      window.currentUserLng = position.coords.longitude;
      const lat = window.currentUserLat.toFixed(5);
      const lng = window.currentUserLng.toFixed(5);
      const acc = Math.round(position.coords.accuracy);

      const loc = window.LOCATION_SETTINGS || {
        enabled: true,
        officeName: 'SMKN 1 Jatisari',
        officeLat: -6.3655,
        officeLng: 107.5312,
        radiusMeters: 100
      };

      if (loc.enabled) {
        window.currentUserDistanceMeters = calculateHaversineDistance(
          window.currentUserLat,
          window.currentUserLng,
          loc.officeLat,
          loc.officeLng
        );
        const distRounded = Math.round(window.currentUserDistanceMeters);
        window.isWithinAllowedRadius = window.currentUserDistanceMeters <= loc.radiusMeters;

        if (window.isWithinAllowedRadius) {
          userLocationString = `${loc.officeName} (Lat: ${lat}, Long: ${lng}) • Jarak: ${distRounded}m`;
          if (gpsText) {
            gpsText.innerHTML = `<span style="color:#34d399; font-weight:700;">🟢 Di Dalam Area:</span> ${distRounded}m dari ${loc.officeName} (Maks: ${loc.radiusMeters}m)`;
          }
          if (gpsBox) {
            gpsBox.classList.add('active');
            gpsBox.classList.remove('out-of-range');
          }
        } else {
          userLocationString = `Di Luar Area (Lat: ${lat}, Long: ${lng}) • Jarak: ${distRounded}m dari ${loc.officeName}`;
          if (gpsText) {
            gpsText.innerHTML = `<span style="color:#f87171; font-weight:700;">🔴 Di Luar Area:</span> ${distRounded}m dari ${loc.officeName} (Batas: ${loc.radiusMeters}m)`;
          }
          if (gpsBox) {
            gpsBox.classList.add('active');
            gpsBox.classList.add('out-of-range');
          }
        }
      } else {
        window.isWithinAllowedRadius = true;
        userLocationString = `${loc.officeName} (Lat: ${lat}, Long: ${lng}) ±${acc}m`;
        if (gpsText) {
          gpsText.innerHTML = `<span style="color:#38bdf8; font-weight:600;">🌐 GPS Aktif:</span> (Lat: ${lat}, Long: ${lng}) ±${acc}m`;
        }
        if (gpsBox) {
          gpsBox.classList.add('active');
          gpsBox.classList.remove('out-of-range');
        }
      }
    },
    (error) => {
      userLocationString = 'Area Pos Jaga Kantor Pusat (Default GPS)';
      if (gpsText) gpsText.innerHTML = '<span style="color:#f59e0b;">⚠️ Akses GPS Ditolak / Tidak Terdeteksi</span>';
    },
    { enableHighAccuracy: true, timeout: 8000, maximumAge: 60000 }
  );
}

/* ==========================================================================
   4. Capture Frame to Base64 Photo
   ========================================================================== */
function capturePhotoBase64() {
  triggerFlashEffect();

  const canvas = document.createElement('canvas');
  const video = document.getElementById('webcamVideo');

  canvas.width = 480;
  canvas.height = 360;
  const ctx = canvas.getContext('2d');

  if (isCameraActive && video && video.videoWidth) {
    // Mirror selfie snapshot
    ctx.translate(canvas.width, 0);
    ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  } else {
    // Generate styled snapshot avatar for testing when camera is unavailable
    const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
    gradient.addColorStop(0, '#1e293b');
    gradient.addColorStop(1, '#0f172a');
    ctx.fillStyle = gradient;
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Text watermark
    ctx.fillStyle = '#6366f1';
    ctx.font = 'bold 24px sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('BUKTI SWAFOTO KEHADIRAN', canvas.width / 2, 140);

    ctx.fillStyle = '#94a3b8';
    ctx.font = '16px sans-serif';
    const now = new Date();
    ctx.fillText(now.toLocaleString('id-ID'), canvas.width / 2, 180);
    ctx.fillText(userLocationString, canvas.width / 2, 210);

    // Border
    ctx.strokeStyle = '#10b981';
    ctx.lineWidth = 4;
    ctx.strokeRect(10, 10, canvas.width - 20, canvas.height - 20);
  }

  return canvas.toDataURL('image/jpeg', 0.85);
}

function triggerFlashEffect() {
  const flash = document.getElementById('cameraFlash');
  if (flash) {
    flash.classList.add('active');
    setTimeout(() => flash.classList.remove('active'), 150);
  }
}

/* ==========================================================================
   5. Tombol Hijau: Absen Masuk Handler
   ========================================================================== */
window.handleAbsenMasuk = async function() {
  const btnMasuk = document.getElementById('btnAbsenMasuk');
  const shiftSelect = document.getElementById('shiftSelector');
  const catatanInput = document.getElementById('catatanMasuk');

  if (!btnMasuk) return;

  if (btnMasuk.getAttribute('data-is-off') === '1' || btnMasuk.disabled) {
    if (btnMasuk.getAttribute('data-is-off') === '1') {
      Swal.fire({
        icon: 'info',
        title: 'Hari Ini Anda Libur',
        html: `
          <div style="text-align:center;">
            <div style="font-size:2.5rem; margin-bottom:8px;">🏖️</div>
            <p style="color:#cbd5e1; margin-bottom:8px;">Hari ini Anda terjadwal <strong>LIBUR / OFF Tugas</strong>.</p>
            <p style="font-size:0.85rem; color:#94a3b8;">Absen masuk dinonaktifkan sampai jadwal dinas Anda berikutnya. Selamat beristirahat!</p>
          </div>
        `,
        confirmButtonColor: '#6366f1',
        confirmButtonText: 'Mengerti'
      });
    }
    return;
  }

  const shiftId = shiftSelect ? shiftSelect.value : null;
  if (!shiftId) {
    Swal.fire({
      icon: 'warning',
      title: 'Pilih Shift',
      text: 'Harap pastikan jadwal shift dipilih terlebih dahulu.',
      confirmButtonColor: '#6366f1'
    });
    return;
  }

  // Confirm dialog with live prompt
  const confirmResult = await Swal.fire({
    title: 'Konfirmasi Absen Masuk?',
    text: 'Sistem akan mengambil swafoto dan mencatat waktu kehadiran Anda saat ini.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Ambil Foto & Masuk',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#10b981',
    cancelButtonColor: '#475569'
  });

  if (!confirmResult.isConfirmed) return;

  // Validasi Geofencing Sisi Klien
  const locSettings = window.LOCATION_SETTINGS || { enabled: false };
  if (locSettings.enabled) {
    if (window.currentUserLat === null || window.currentUserLng === null) {
      Swal.fire({
        icon: 'warning',
        title: 'GPS Belum Siap',
        text: 'Titik koordinat GPS belum terdeteksi. Pastikan Anda telah mengaktifkan GPS dan mengizinkan izin lokasi pada peramban/perangkat Anda.',
        confirmButtonColor: '#4f46e5'
      });
      return;
    }

    if (!window.isWithinAllowedRadius && window.currentUserDistanceMeters !== null) {
      const dist = Math.round(window.currentUserDistanceMeters);
      Swal.fire({
        icon: 'error',
        title: 'Di Luar Area Kantor',
        html: `
          <div style="text-align:center;">
            <p style="margin-bottom:8px; color:#ef4444; font-weight:700;">Absen Masuk Ditolak!</p>
            <p style="font-size:0.9rem; color:#cbd5e1; margin-bottom:10px;">
              Anda terdeteksi berjarak <strong>${dist} meter</strong> dari <strong>${locSettings.officeName}</strong>.<br>
              Batas maksimal radius yang diizinkan adalah <strong>${locSettings.radiusMeters} meter</strong>.
            </p>
            <p style="font-size:0.8rem; color:#94a3b8;">
              Silakan mendekat ke area sekolah/pos satpam untuk melakukan absensi.
            </p>
          </div>
        `,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Mengerti'
      });
      return;
    }
  }

  // Capture Photo
  const photoBase64 = capturePhotoBase64();
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  btnMasuk.disabled = true;
  btnMasuk.innerHTML = '<span class="pulse-dot"></span> Memproses...';

  try {
    const response = await fetch('/absen/masuk', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        user_id: window.ACTIVE_USER_ID || null,
        shift_id: shiftId,
        photo: photoBase64,
        lokasi: userLocationString,
        lat: window.currentUserLat,
        lng: window.currentUserLng,
        catatan: catatanInput ? catatanInput.value : ''
      })
    });

    const result = await response.json();

    if (response.ok && result.success) {
      await Swal.fire({
        icon: 'success',
        title: 'Absen Masuk Berhasil!',
        html: `
          <div style="text-align:center;">
            <p style="margin-bottom:8px; font-weight:600;">Waktu: <span style="color:#10b981;">${result.data.jam_masuk_formatted}</span></p>
            <p style="font-size:0.9rem; color:#94a3b8; margin-bottom:12px;">Status: <strong>${result.data.status}</strong></p>
            ${result.data.foto_masuk ? `<img src="${result.data.foto_masuk}" style="width:140px; height:140px; border-radius:12px; object-fit:cover; border:2px solid #10b981;" />` : ''}
          </div>
        `,
        confirmButtonColor: '#10b981',
        confirmButtonText: 'Mengerti'
      });

      // Reload to update states smoothly
      window.location.reload();
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Gagal Absen',
        text: result.message || 'Terjadi kesalahan saat mencatat absensi.',
        confirmButtonColor: '#ef4444'
      });
      btnMasuk.disabled = false;
      btnMasuk.innerHTML = '<span>🟢</span> Absen Masuk';
    }
  } catch (error) {
    console.error('Clock-in error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Terjadi Kesalahan',
      text: 'Tidak dapat menghubungi server. Periksa koneksi Anda.',
      confirmButtonColor: '#ef4444'
    });
    btnMasuk.disabled = false;
    btnMasuk.innerHTML = '<span>🟢</span> Absen Masuk';
  }
};

/* ==========================================================================
   6. Tombol Merah: Absen Pulang Handler
   ========================================================================== */
window.handleAbsenPulang = async function() {
  const btnPulang = document.getElementById('btnAbsenPulang');
  const catatanInput = document.getElementById('catatanMasuk');

  if (!btnPulang) return;

  const canClockOut = btnPulang.getAttribute('data-can-clock-out') === '1';
  const endTimeFormatted = btnPulang.getAttribute('data-end-time-formatted') || '';

  if (!canClockOut || btnPulang.disabled) {
    if (!canClockOut && endTimeFormatted) {
      Swal.fire({
        icon: 'warning',
        title: 'Belum Jam Pulang Shift',
        html: `
          <div style="text-align:center;">
            <p style="margin-bottom:8px; color:#cbd5e1;">Sesuai ketentuan jadwal shift Anda, absen pulang baru dapat dilakukan pada:</p>
            <p style="font-size:1.35rem; font-weight:800; color:#fbbf24; margin:12px 0; font-family:var(--font-mono);">${endTimeFormatted}</p>
            <p style="font-size:0.85rem; color:#94a3b8;">Harap menyelesaikan tugas operasional dinas Anda hingga waktu shift berakhir.</p>
          </div>
        `,
        confirmButtonColor: '#f59e0b',
        confirmButtonText: 'Mengerti'
      });
    }
    return;
  }

  const confirmResult = await Swal.fire({
    title: 'Konfirmasi Absen Pulang?',
    text: 'Sistem akan menghitung durasi kerja dan menyelesaikan shift Anda hari ini.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Ambil Foto & Pulang',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#f43f5e',
    cancelButtonColor: '#475569'
  });

  if (!confirmResult.isConfirmed) return;

  // Validasi Geofencing Sisi Klien untuk Absen Pulang
  const locSettings = window.LOCATION_SETTINGS || { enabled: false };
  if (locSettings.enabled) {
    if (window.currentUserLat === null || window.currentUserLng === null) {
      Swal.fire({
        icon: 'warning',
        title: 'GPS Belum Siap',
        text: 'Titik koordinat GPS belum terdeteksi. Pastikan GPS dan izin lokasi aktif pada perangkat Anda.',
        confirmButtonColor: '#4f46e5'
      });
      return;
    }

    if (!window.isWithinAllowedRadius && window.currentUserDistanceMeters !== null) {
      const dist = Math.round(window.currentUserDistanceMeters);
      Swal.fire({
        icon: 'error',
        title: 'Di Luar Area Kantor',
        html: `
          <div style="text-align:center;">
            <p style="margin-bottom:8px; color:#ef4444; font-weight:700;">Absen Pulang Ditolak!</p>
            <p style="font-size:0.9rem; color:#cbd5e1; margin-bottom:10px;">
              Anda terdeteksi berjarak <strong>${dist} meter</strong> dari <strong>${locSettings.officeName}</strong>.<br>
              Batas maksimal radius yang diizinkan adalah <strong>${locSettings.radiusMeters} meter</strong>.
            </p>
          </div>
        `,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Mengerti'
      });
      return;
    }
  }

  // Capture Photo
  const photoBase64 = capturePhotoBase64();
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  btnPulang.disabled = true;
  btnPulang.innerHTML = '<span class="pulse-dot"></span> Memproses Pulang...';

  try {
    const response = await fetch('/absen/pulang', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        user_id: window.ACTIVE_USER_ID || null,
        photo: photoBase64,
        lokasi: userLocationString,
        lat: window.currentUserLat,
        lng: window.currentUserLng,
        catatan: catatanInput ? catatanInput.value : ''
      })
    });

    const result = await response.json();

    if (response.ok && result.success) {
      await Swal.fire({
        icon: 'success',
        title: 'Absen Pulang Berhasil!',
        html: `
          <div style="text-align:center;">
            <p style="margin-bottom:6px; font-weight:600;">Waktu Pulang: <span style="color:#f43f5e;">${result.data.jam_pulang_formatted}</span></p>
            <p style="font-size:1.1rem; color:#38bdf8; font-weight:700; margin-bottom:12px;">Total Durasi Kerja: ${result.data.durasi_kerja}</p>
            <p style="font-size:0.85rem; color:#94a3b8; margin-bottom:12px;">Terima kasih atas dedikasi dan pengabdian Anda!</p>
            ${result.data.foto_pulang ? `<img src="${result.data.foto_pulang}" style="width:140px; height:140px; border-radius:12px; object-fit:cover; border:2px solid #f43f5e;" />` : ''}
          </div>
        `,
        confirmButtonColor: '#6366f1',
        confirmButtonText: 'Selesai'
      });

      window.location.reload();
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Gagal Absen Pulang',
        text: result.message || 'Terjadi kesalahan saat memproses absen pulang.',
        confirmButtonColor: '#ef4444'
      });
      btnPulang.disabled = false;
      btnPulang.innerHTML = '<span>🔴</span> Absen Pulang';
    }
  } catch (error) {
    console.error('Clock-out error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Terjadi Kesalahan',
      text: 'Tidak dapat menghubungi server. Periksa koneksi Anda.',
      confirmButtonColor: '#ef4444'
    });
    btnPulang.disabled = false;
    btnPulang.innerHTML = '<span>🔴</span> Absen Pulang';
  }
};

/* ==========================================================================
   7. User Switcher Dropdown
   ========================================================================== */
function initUserDropdown() {
  const trigger = document.getElementById('userDropdownTrigger');
  const menu = document.getElementById('userDropdownMenu');

  if (!trigger || !menu) return;

  trigger.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('show');
  });

  document.addEventListener('click', (e) => {
    if (!menu.contains(e.target)) {
      menu.classList.remove('show');
    }
  });
}

/* ==========================================================================
   8. Image Modal Viewer
   ========================================================================== */
window.previewImageModal = function(src, title) {
  const modal = document.getElementById('imagePreviewModal');
  const img = document.getElementById('modalPreviewImg');
  const titleEl = document.getElementById('modalPreviewTitle');

  if (modal && img) {
    img.src = src;
    if (titleEl) titleEl.textContent = title || 'Pratinjau Foto Bukti Kehadiran';
    modal.classList.add('show');
  }
};

window.closeImageModal = function() {
  const modal = document.getElementById('imagePreviewModal');
  if (modal) modal.classList.remove('show');
};

/* ==========================================================================
   9. Mobile Menu Drawer Navigation
   ========================================================================== */
window.toggleMobileMenu = function() {
  const drawer = document.getElementById('mobileNavDrawer');
  const overlay = document.getElementById('mobileDrawerOverlay');
  if (!drawer || !overlay) return;

  const isOpen = drawer.classList.contains('show');
  if (isOpen) {
    window.closeMobileMenu();
  } else {
    window.openMobileMenu();
  }
};

window.openMobileMenu = function() {
  const drawer = document.getElementById('mobileNavDrawer');
  const overlay = document.getElementById('mobileDrawerOverlay');
  if (drawer && overlay) {
    drawer.classList.add('show');
    overlay.classList.add('show');
    drawer.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
};

window.closeMobileMenu = function() {
  const drawer = document.getElementById('mobileNavDrawer');
  const overlay = document.getElementById('mobileDrawerOverlay');
  if (drawer && overlay) {
    drawer.classList.remove('show');
    overlay.classList.remove('show');
    drawer.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
};

// Close modals and drawer on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    if (typeof window.closeMobileMenu === 'function') window.closeMobileMenu();
    if (typeof window.closeImageModal === 'function') window.closeImageModal();
  }
});
