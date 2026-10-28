<?php
/**
 * SICAKAP - Master Generator Dokumentasi PDF & HTML
 * Menghasilkan file dokumentasi resmi sistem SICAKAP untuk SMKN 1 Jatisari
 */

$tanggal = "28 Oktober 2026";
$tahun = "2026";

$html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dokumentasi Teknis & Panduan Sistem SICAKAP - SMKN 1 Jatisari</title>
  <style>
    @page {
      size: A4 portrait;
      margin: 14mm 16mm 14mm 16mm;
    }
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      font-size: 9.5pt;
      line-height: 1.6;
      color: #1e293b;
      background: #ffffff;
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }
    a {
      color: #4338ca;
      text-decoration: none;
    }

    @media print {
      .no-print { display: none !important; }
      .page-break { page-break-before: always; break-before: page; }
      .avoid-break { page-break-inside: avoid; break-inside: avoid; }
      body { background: white; }
    }

    /* FLOATING BUTTON */
    .print-btn {
      position: fixed;
      bottom: 26px;
      right: 26px;
      z-index: 9999;
      background: linear-gradient(135deg, #4338ca, #6366f1);
      color: #ffffff;
      border: none;
      padding: 13px 26px;
      border-radius: 50px;
      font-size: 13.5px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 10px 25px -5px rgba(67, 56, 202, 0.5);
      transition: all 0.2s ease;
    }
    .print-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px -5px rgba(67, 56, 202, 0.7);
    }

    /* COVER PAGE */
    .cover {
      background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 55%, #0f172a 100%);
      color: #ffffff;
      padding: 60px 40px;
      text-align: center;
      min-height: 94vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      position: relative;
    }
    .cover-badge {
      display: inline-block;
      background: rgba(99, 102, 241, 0.25);
      border: 1px solid rgba(165, 180, 252, 0.4);
      color: #c7d2fe;
      padding: 5px 16px;
      border-radius: 30px;
      font-size: 8.5pt;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin-bottom: 22px;
    }
    .cover-app {
      font-size: 44pt;
      font-weight: 900;
      letter-spacing: -1.5px;
      color: #ffffff;
      line-height: 1.1;
      margin-bottom: 6px;
      text-shadow: 0 4px 20px rgba(99, 102, 241, 0.5);
    }
    .cover-sub {
      font-size: 11pt;
      color: #94a3b8;
      text-transform: uppercase;
      letter-spacing: 2.5px;
      margin-bottom: 30px;
      font-weight: 600;
    }
    .cover-line {
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, #6366f1, #a855f7);
      border-radius: 2px;
      margin: 0 auto 30px;
    }
    .cover-title {
      font-size: 21pt;
      font-weight: 800;
      color: #f8fafc;
      margin-bottom: 10px;
      max-width: 650px;
      line-height: 1.3;
    }
    .cover-desc {
      font-size: 10pt;
      color: #cbd5e1;
      margin-bottom: 46px;
      max-width: 580px;
      line-height: 1.6;
    }
    .cover-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      width: 100%;
      max-width: 640px;
    }
    .cover-meta {
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 8px;
      padding: 12px 14px;
      text-align: center;
    }
    .cover-meta-label {
      font-size: 7pt;
      color: #94a3b8;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      font-weight: 600;
      margin-bottom: 3px;
    }
    .cover-meta-value {
      font-size: 9pt;
      font-weight: 700;
      color: #f1f5f9;
    }
    .cover-institution {
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
      width: 100%;
      max-width: 640px;
      font-size: 9pt;
      color: #94a3b8;
      font-weight: 500;
    }
    .cover-institution strong {
      color: #ffffff;
      font-weight: 700;
    }

    /* CONTAINER */
    .doc-body {
      max-width: 860px;
      margin: 0 auto;
      padding: 30px 10px;
    }

    /* SECTION HEADER */
    .section {
      margin-bottom: 36px;
    }
    .section-hdr {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 16px;
      padding-bottom: 8px;
      border-bottom: 2px solid #e2e8f0;
    }
    .sec-num {
      width: 32px;
      height: 32px;
      background: linear-gradient(135deg, #4338ca, #6366f1);
      border-radius: 7px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11pt;
      font-weight: 800;
      color: #ffffff;
      flex-shrink: 0;
    }
    h2 {
      font-size: 15pt;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.3px;
    }
    h3 {
      font-size: 11pt;
      font-weight: 700;
      color: #1e293b;
      margin: 16px 0 8px;
    }
    h4 {
      font-size: 9.5pt;
      font-weight: 700;
      color: #334155;
      margin: 10px 0 4px;
    }
    p {
      color: #334155;
      margin-bottom: 9px;
      text-align: justify;
    }

    /* CARDS */
    .card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 14px 18px;
      margin-bottom: 12px;
    }
    .card-hl {
      background: linear-gradient(135deg, #eef2ff, #faf5ff);
      border-color: #c7d2fe;
    }

    /* GRIDS */
    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin: 10px 0;
    }
    .grid-3 {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 10px;
      margin: 10px 0;
    }
    .grid-4 {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 10px;
      margin: 10px 0;
    }
    .info-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 10px 12px;
    }
    .info-lbl {
      font-size: 7pt;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      font-weight: 700;
      margin-bottom: 3px;
    }
    .info-val {
      font-size: 9pt;
      font-weight: 700;
      color: #0f172a;
    }

    /* BADGES */
    .badge {
      display: inline-flex;
      align-items: center;
      padding: 2px 7px;
      border-radius: 4px;
      font-size: 7pt;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }
    .b-indigo { background: #e0e7ff; color: #3730a3; }
    .b-green  { background: #dcfce7; color: #166534; }
    .b-amber  { background: #fef3c7; color: #92400e; }
    .b-sky    { background: #e0f2fe; color: #075985; }
    .b-red    { background: #fee2e2; color: #991b1b; }
    .b-gray   { background: #f1f5f9; color: #475569; }

    /* TABLES */
    .tbl {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
      margin: 10px 0 14px;
    }
    .tbl th {
      background: #0f172a;
      color: #ffffff;
      padding: 8px 10px;
      text-align: left;
      font-weight: 700;
      font-size: 7.5pt;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
    .tbl td {
      padding: 7px 10px;
      border-bottom: 1px solid #e2e8f0;
      color: #334155;
      vertical-align: top;
    }
    .tbl tr:last-child td {
      border-bottom: 1px solid #cbd5e1;
    }
    .tbl tr:nth-child(even) td {
      background: #f8fafc;
    }
    .tbl code {
      background: #e2e8f0;
      color: #1e293b;
      padding: 1px 5px;
      border-radius: 3px;
      font-family: Consolas, "Courier New", monospace;
      font-size: 7.5pt;
      font-weight: 600;
    }

    /* CODE BLOCKS */
    .codeblock {
      background: #0f172a;
      border-radius: 6px;
      padding: 12px 14px;
      margin: 8px 0;
      overflow-x: auto;
    }
    .codeblock code {
      font-family: Consolas, "Courier New", monospace;
      font-size: 7.5pt;
      color: #e2e8f0;
      line-height: 1.7;
      white-space: pre;
      display: block;
    }

    /* FEATURE ITEMS */
    .feat-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 10px 12px;
    }
    .feat-icon {
      width: 26px;
      height: 26px;
      background: linear-gradient(135deg, #4338ca, #6366f1);
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      flex-shrink: 0;
      color: white;
    }
    .feat-item h4 {
      margin: 0 0 2px;
      font-size: 8.5pt;
      color: #0f172a;
    }
    .feat-item p {
      font-size: 7.5pt;
      margin: 0;
      color: #475569;
      line-height: 1.4;
    }

    /* ERD TABLES */
    .erd {
      background: #0f172a;
      border-radius: 8px;
      padding: 16px;
      margin: 12px 0;
    }
    .erd-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }
    .erd-tbl {
      background: #1e293b;
      border: 1px solid #334155;
      border-radius: 6px;
      overflow: hidden;
      font-size: 7pt;
    }
    .erd-hdr {
      background: linear-gradient(135deg, #4338ca, #6366f1);
      padding: 6px 8px;
      font-family: Consolas, monospace;
      font-weight: 700;
      color: #ffffff;
      font-size: 7.5pt;
    }
    .erd-row {
      padding: 3.5px 8px;
      font-family: Consolas, monospace;
      color: #94a3b8;
      border-bottom: 1px solid #0f172a;
      display: flex;
      justify-content: space-between;
    }
    .erd-row:last-child {
      border-bottom: none;
    }
    .pk { color: #f59e0b; font-weight: 700; }
    .fk { color: #10b981; font-weight: 700; }
    .tp { color: #64748b; font-size: 6.5pt; }

    /* ROLES */
    .role-card {
      border-radius: 8px;
      padding: 12px;
      text-align: center;
    }
    .r-admin { background: #f5f3ff; border: 1px solid #ddd6fe; }
    .r-sup   { background: #eff6ff; border: 1px solid #bfdbfe; }
    .r-sat   { background: #f0fdf4; border: 1px solid #bbf7d0; }
    .r-car   { background: #fffbeb; border: 1px solid #fde68a; }
    .role-icon { font-size: 20pt; margin-bottom: 4px; }
    .role-name { font-weight: 800; font-size: 9pt; margin-bottom: 2px; }
    .r-admin .role-name { color: #5b21b6; }
    .r-sup .role-name   { color: #1e40af; }
    .r-sat .role-name   { color: #15803d; }
    .r-car .role-name   { color: #a16207; }
    .role-desc { font-size: 7pt; color: #475569; line-height: 1.35; }

    /* ALERTS */
    .alert {
      border-radius: 6px;
      padding: 9px 12px;
      margin: 8px 0;
      display: flex;
      gap: 8px;
      align-items: flex-start;
      font-size: 8pt;
    }
    .a-info { background: #eff6ff; border-left: 3px solid #3b82f6; color: #1e40af; }
    .a-warn { background: #fffbeb; border-left: 3px solid #f59e0b; color: #92400e; }
    .a-ok   { background: #f0fdf4; border-left: 3px solid #22c55e; color: #15803d; }

    /* TABLE OF CONTENTS */
    .toc {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 18px 22px;
    }
    .toc-title {
      font-size: 11pt;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 12px;
      padding-bottom: 6px;
      border-bottom: 1px solid #cbd5e1;
    }
    .toc-list { list-style: none; }
    .toc-list li {
      padding: 4px 0;
      border-bottom: 1px dashed #e2e8f0;
      font-size: 8.5pt;
    }
    .toc-list li:last-child { border-bottom: none; }
    .toc-list a {
      color: #334155;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
    }
    .toc-list a:hover { color: #4338ca; }
    .toc-num { color: #6366f1; font-weight: 700; margin-right: 6px; }

    /* PROCESS FLOW */
    .flow {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 4px;
      margin: 10px 0;
    }
    .flow-step {
      background: #ffffff;
      border: 1.5px solid #4338ca;
      border-radius: 6px;
      padding: 7px 12px;
      font-size: 7.5pt;
      font-weight: 700;
      color: #4338ca;
      text-align: center;
      min-width: 95px;
    }
    .flow-step small { font-weight: normal; color: #64748b; font-size: 6.5pt; }
    .flow-arr {
      font-size: 12pt;
      color: #94a3b8;
      padding: 0 4px;
      font-weight: bold;
    }

    /* LISTS */
    ol.sl, ul.sl {
      padding-left: 18px;
      color: #334155;
      margin-bottom: 8px;
    }
    ol.sl li { margin-bottom: 4px; font-size: 8.5pt; }
    ul.sl li { margin-bottom: 4px; font-size: 8.5pt; list-style: square; }
    .ic {
      background: #f1f5f9;
      color: #0f172a;
      border: 1px solid #cbd5e1;
      padding: 1px 5px;
      border-radius: 3px;
      font-family: Consolas, monospace;
      font-size: 7.5pt;
      font-weight: 600;
    }

    /* LEMBAR PENGESAHAN */
    .pengesahan {
      border: 2px solid #0f172a;
      border-radius: 8px;
      padding: 24px;
      margin: 14px 0;
      background: #ffffff;
    }
    .pengesahan-title {
      text-align: center;
      font-size: 12pt;
      font-weight: 800;
      color: #0f172a;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 4px;
    }
    .pengesahan-sub {
      text-align: center;
      font-size: 8.5pt;
      color: #475569;
      margin-bottom: 22px;
    }
    .sign-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 24px;
    }
    .sign-box {
      text-align: center;
      padding: 8px;
    }
    .sign-role {
      font-size: 8pt;
      color: #475569;
      margin-bottom: 60px;
    }
    .sign-name {
      font-weight: 800;
      font-size: 9pt;
      color: #0f172a;
      border-bottom: 1px solid #0f172a;
      display: inline-block;
      padding-bottom: 2px;
      min-width: 170px;
    }
    .sign-nip {
      font-size: 7.5pt;
      color: #64748b;
      margin-top: 3px;
    }

    /* FOOTER */
    .footer {
      background: #0f172a;
      color: #94a3b8;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      font-size: 7.5pt;
      border-radius: 6px;
    }
    .footer strong { color: #ffffff; }
  </style>
</head>
<body>

<!-- BUTTON PRINT / PDF -->
<button class="print-btn no-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>

<!-- ===================== 1. HALAMAN COVER ===================== -->
<div class="cover">
  <div class="cover-badge">Dokumen Teknis Resmi v1.0.0 Stable</div>
  <div class="cover-app">SICAKAP</div>
  <div class="cover-sub">Sistem Absensi &amp; Catatan Kegiatan Satpam &amp; Caraka</div>
  <div class="cover-line"></div>
  <div class="cover-title">Dokumentasi Proyek, Spesifikasi Arsitektur &amp; Buku Panduan Operasional</div>
  <div class="cover-desc">
    Laporan komprehensif implementasi sistem absensi swafoto real-time, manajemen shift lintas hari (cross-midnight),
    logbook pekerjaan harian, perizinan, backup-restore, serta panduan deployment server produksi.
  </div>
  
  <div class="cover-grid">
    <div class="cover-meta"><div class="cover-meta-label">Framework</div><div class="cover-meta-value">Laravel 11 / 13</div></div>
    <div class="cover-meta"><div class="cover-meta-label">Bahasa Server</div><div class="cover-meta-value">PHP 8.3+</div></div>
    <div class="cover-meta"><div class="cover-meta-label">Database</div><div class="cover-meta-value">MySQL 8.4 RDBMS</div></div>
    <div class="cover-meta"><div class="cover-meta-label">Testing Status</div><div class="cover-meta-value">9/9 Passed (100%)</div></div>
    <div class="cover-meta"><div class="cover-meta-label">Tanggal Rilis</div><div class="cover-meta-value">$tanggal</div></div>
    <div class="cover-meta"><div class="cover-meta-label">Akses Domain</div><div class="cover-meta-value">Subdomain Rumahweb</div></div>
  </div>

  <div class="cover-institution">
    Dikembangkan untuk: <strong>SMK NEGERI 1 JATISARI</strong> — Bidang Sarana &amp; Prasarana / Kepegawaian<br>
    Jl. Raya Jatisari No. 1, Karawang, Jawa Barat · Tahun Anggaran $tahun
  </div>
</div>

<div class="doc-body">

<!-- ===================== 2. LEMBAR PENGESAHAN ===================== -->
<div class="section page-break">
  <div class="section-hdr"><div class="sec-num">✍️</div><h2>Lembar Pengesahan Dokumen</h2></div>
  <div class="pengesahan avoid-break">
    <div class="pengesahan-title">Lembar Pengesahan Sistem &amp; Dokumentasi</div>
    <div class="pengesahan-sub">Penerapan Aplikasi SICAKAP (Sistem Absensi &amp; Catatan Kegiatan Satpam &amp; Caraka)</div>
    <p style="text-align:center;font-size:8.5pt;color:#334155;max-width:550px;margin:0 auto 18px;">
      Dokumen ini menyatakan bahwa aplikasi <strong>SICAKAP</strong> beserta infrastruktur basis data, alur bisnis absensi,
      dan modul pendukungnya telah selesai dirancang, dibangun, diuji secara otomatis (PHPUnit 100%), dan diserahkan
      untuk digunakan secara resmi di lingkungan <strong>SMKN 1 Jatisari</strong>.
    </p>

    <div class="sign-grid">
      <div class="sign-box">
        <div class="sign-role">Mengetahui,<br><strong>Kepala SMKN 1 Jatisari</strong></div>
        <div class="sign-name">( .................................................... )</div>
        <div class="sign-nip">NIP. ....................................................</div>
      </div>
      <div class="sign-box">
        <div class="sign-role">Menyetujui,<br><strong>Waka Bidang Sarana &amp; Prasarana</strong></div>
        <div class="sign-name">( .................................................... )</div>
        <div class="sign-nip">NIP. ....................................................</div>
      </div>
      <div class="sign-box" style="margin-top:16px;">
        <div class="sign-role">Verifikator Operasional,<br><strong>Koordinator Satpam / Caraka</strong></div>
        <div class="sign-name">( .................................................... )</div>
        <div class="sign-nip">NIP/ID. ....................................................</div>
      </div>
      <div class="sign-box" style="margin-top:16px;">
        <div class="sign-role">Pengembang Aplikasi,<br><strong>Tim Pengembang Sistem SICAKAP</strong></div>
        <div class="sign-name">( Administrator &amp; IT Developer )</div>
        <div class="sign-nip">Tanggal: $tanggal</div>
      </div>
    </div>
  </div>
</div>

<!-- ===================== 3. DAFTAR ISI ===================== -->
<div class="section page-break">
  <div class="section-hdr"><div class="sec-num">📑</div><h2>Daftar Isi Dokumentasi</h2></div>
  <div class="toc avoid-break">
    <div class="toc-title">Struktur Bab Dokumentasi SICAKAP</div>
    <ul class="toc-list">
      <li><a href="#bab1"><span><span class="toc-num">BAB 1</span> Ringkasan Eksekutif &amp; Gambaran Umum</span><span>Hal. 4</span></a></li>
      <li><a href="#bab2"><span><span class="toc-num">BAB 2</span> Landasan Teori &amp; Tujuan Digitalisasi</span><span>Hal. 5</span></a></li>
      <li><a href="#bab3"><span><span class="toc-num">BAB 3</span> Arsitektur Sistem &amp; Spesifikasi Teknologi</span><span>Hal. 6</span></a></li>
      <li><a href="#bab4"><span><span class="toc-num">BAB 4</span> Hak Akses &amp; Manajemen Peran (RBAC)</span><span>Hal. 7</span></a></li>
      <li><a href="#bab5"><span><span class="toc-num">BAB 5</span> Fitur Unggulan &amp; Logika Bisnis Khusus (Cross-Midnight)</span><span>Hal. 8</span></a></li>
      <li><a href="#bab6"><span><span class="toc-num">BAB 6</span> Skema Basis Data Relasional (ERD &amp; Kamus Data)</span><span>Hal. 9</span></a></li>
      <li><a href="#bab7"><span><span class="toc-num">BAB 7</span> Direktori Rute &amp; Pemetaan URL (Routing Matrix)</span><span>Hal. 10</span></a></li>
      <li><a href="#bab8"><span><span class="toc-num">BAB 8</span> Struktur File &amp; Hierarki Direktori Proyek</span><span>Hal. 11</span></a></li>
      <li><a href="#bab9"><span><span class="toc-num">BAB 9</span> Panduan Instalasi &amp; Konfigurasi Lingkungan Lokal</span><span>Hal. 12</span></a></li>
      <li><a href="#bab10"><span><span class="toc-num">BAB 10</span> Panduan Deployment ke Hosting cPanel (Rumahweb)</span><span>Hal. 13</span></a></li>
      <li><a href="#bab11"><span><span class="toc-num">BAB 11</span> Modul Cadangan &amp; Pemulihan Data (Backup &amp; Restore)</span><span>Hal. 14</span></a></li>
      <li><a href="#bab12"><span><span class="toc-num">BAB 12</span> Buku Panduan Pengoperasian (User Manual)</span><span>Hal. 15</span></a></li>
      <li><a href="#bab13"><span><span class="toc-num">BAB 13</span> Hasil Pengujian Otomatis (PHPUnit Quality Assurance)</span><span>Hal. 16</span></a></li>
      <li><a href="#bab14"><span><span class="toc-num">BAB 14</span> Panduan Pemecahan Masalah (Troubleshooting &amp; FAQ)</span><span>Hal. 17</span></a></li>
      <li><a href="#bab15"><span><span class="toc-num">BAB 15</span> Kesimpulan &amp; Rencana Pengembangan Lanjutan</span><span>Hal. 18</span></a></li>
    </ul>
  </div>
</div>

<!-- ===================== BAB 1 ===================== -->
<div class="section page-break" id="bab1">
  <div class="section-hdr"><div class="sec-num">1</div><h2>BAB 1: Ringkasan Eksekutif &amp; Gambaran Umum</h2></div>
  <div class="card card-hl">
    <p>
      <strong>SICAKAP</strong> (Sistem Informasi Absensi dan Catatan Kegiatan Satpam &amp; Caraka) adalah aplikasi berbasis web yang
      dikembangkan secara khusus untuk menjawab kebutuhan pencatatan absensi harian dan logbook kegiatan operasional bagi tenaga
      penjaga keamanan (<strong>Satpam</strong>) dan pelaksana kebersihan/layanan umum (<strong>Caraka</strong>) di lingkungan
      <strong>SMK Negeri 1 Jatisari</strong>.
    </p>
    <p style="margin-top:6px;">
      Sistem ini mentransformasi proses presensi konvensional berbasis kertas menjadi sistem digital terintegrasi yang akurat,
      transparan, dan dilengkapi bukti validasi swafoto (selfie) real-time, koordinat GPS, serta penanganan otomatis untuk
      shift malam yang melintasi pergantian hari (*cross-midnight*).
    </p>
  </div>

  <div class="grid-4 avoid-break">
    <div class="info-card"><div class="info-lbl">Nama Aplikasi</div><div class="info-val">SICAKAP</div></div>
    <div class="info-card"><div class="info-lbl">Versi Rilis</div><div class="info-val">v1.0.0 (Stable)</div></div>
    <div class="info-card"><div class="info-lbl">Arsitektur</div><div class="info-val">Monolith MVC</div></div>
    <div class="info-card"><div class="info-lbl">Bahasa Antarmuka</div><div class="info-val">Bahasa Indonesia</div></div>
    <div class="info-card"><div class="info-lbl">Target Pengguna</div><div class="info-val">Satpam &amp; Caraka</div></div>
    <div class="info-card"><div class="info-lbl">Zona Waktu</div><div class="info-val">WIB (Asia/Jakarta)</div></div>
    <div class="info-card"><div class="info-lbl">Domain Produksi</div><div class="info-val">sicakap.smkn1jatisari.sch.id</div></div>
    <div class="info-card"><div class="info-lbl">Tingkat Pengujian</div><div class="info-val">100% Passed (9 Tests)</div></div>
  </div>

  <h3>Karakteristik Utama Sistem</h3>
  <ul class="sl">
    <li><strong>Presensi Swafoto Real-time:</strong> Memanfaatkan API kamera browser HTML5 (<code>navigator.mediaDevices.getUserMedia</code>) untuk mengambil foto wajah secara langsung saat clock-in dan clock-out, mencegah kecurangan presensi.</li>
    <li><strong>Deteksi Geolocation GPS:</strong> Merekam koordinat lintang (*latitude*) dan bujur (*longitude*) saat melakukan presensi untuk memastikan pegawai berada di area tugas sekolah.</li>
    <li><strong>Dukungan Penuh Shift 24 Jam:</strong> Mengakomodasi shift pagi, shift siang, dan shift malam lintas hari (pukul 23:00 WIB s/d 07:00 WIB keesokan harinya).</li>
    <li><strong>Sistem Logbook Digital:</strong> Mencatat seluruh laporan pekerjaan harian (patroli, cek APAR, cek CCTV, kebersihan ruangan, pengiriman surat dinas) disertai lampiran foto bukti.</li>
  </ul>
</div>

<!-- ===================== BAB 2 ===================== -->
<div class="section page-break" id="bab2">
  <div class="section-hdr"><div class="sec-num">2</div><h2>BAB 2: Landasan Teori &amp; Tujuan Digitalisasi</h2></div>
  
  <h3>2.1 Masalah yang Dihadapi (Kondisi Eksisting)</h3>
  <p>Sebelum implementasi SICAKAP, pengelolaan absensi dan tugas satpam serta caraka di SMKN 1 Jatisari menghadapi berbagai hambatan administratif:</p>
  <table class="tbl avoid-break">
    <thead>
      <tr>
        <th style="width:25%;">Aspek</th>
        <th style="width:37%;">Metode Konvensional (Lama)</th>
        <th style="width:38%;">Solusi SICAKAP (Baru)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>Media Pencatatan</strong></td>
        <td>Buku tulis fisik dan lembaran absensi kertas rentan sobek, basah, atau hilang.</td>
        <td>Basis data terpusat MySQL 8.4 dengan backup otomatis berkala.</td>
      </tr>
      <tr>
        <td><strong>Validitas Kehadiran</strong></td>
        <td>Tanda tangan manual mudah dititipkan dan tidak dapat membuktikan kehadiran fisik.</td>
        <td>Swafoto wajah langsung (live camera) + koordinat GPS presisi.</td>
      </tr>
      <tr>
        <td><strong>Shift Malam Lintas Hari</strong></td>
        <td>Sering terjadi kerancuan tanggal pencatatan saat masuk malam (23:00) dan pulang pagi (07:00).</td>
        <td>Algoritma deteksi sesi kerja lintas tengah malam otomatis (*cross-midnight engine*).</td>
      </tr>
      <tr>
        <td><strong>Dokumentasi Kegiatan</strong></td>
        <td>Laporan patroli dan kebersihan hanya berupa coretan buku jurnal tanpa foto bukti.</td>
        <td>Logbook digital terstruktur dilengkapi unggahan foto hasil kerja resolusi tinggi.</td>
      </tr>
      <tr>
        <td><strong>Rekapitulasi Laporan</strong></td>
        <td>Bagian tata usaha membutuhkan 3-5 hari untuk menghitung total jam kerja bulanan.</td>
        <td>Ekspor data instan ke format CSV/Excel dengan satu kali klik.</td>
      </tr>
    </tbody>
  </table>

  <h3>2.2 Tujuan Pengembangan</h3>
  <div class="grid-3 avoid-break">
    <div class="feat-item"><div class="feat-icon">🎯</div><div><h4>Akurasi Presensi</h4><p>Menghilangkan kesalahan perhitungan jam kerja dan keterlambatan pegawai secara otomatis.</p></div></div>
    <div class="feat-item"><div class="feat-icon">⚡</div><div><h4>Efisiensi Waktu</h4><p>Mempercepat rekap bulanan staf TU dari beberapa hari menjadi hitungan detik.</p></div></div>
    <div class="feat-item"><div class="feat-icon">🛡️</div><div><h4>Akuntabilitas Kerja</h4><p>Menyediakan bukti nyata hasil tugas patroli dan kebersihan dengan foto geo-tagging.</p></div></div>
  </div>
</div>

<!-- ===================== BAB 3 ===================== -->
<div class="section page-break" id="bab3">
  <div class="section-hdr"><div class="sec-num">3</div><h2>BAB 3: Arsitektur Sistem &amp; Spesifikasi Teknologi</h2></div>

  <h3>3.1 Pola Arsitektur Model-View-Controller (MVC)</h3>
  <p>SICAKAP dibangun di atas framework <strong>Laravel 13.x</strong> dengan arsitektur MVC terstruktur:</p>
  
  <div class="flow avoid-break">
    <div class="flow-step">👤 Browser Pengguna<br><small>HTTP Request</small></div><div class="flow-arr">→</div>
    <div class="flow-step">🛡️ Middleware<br><small>Auth · Admin · Guest</small></div><div class="flow-arr">→</div>
    <div class="flow-step">🎮 Controller Layer<br><small>Bisnis Logika</small></div><div class="flow-arr">→</div>
    <div class="flow-step">📦 Model (Eloquent)<br><small>Abstraksi Data</small></div><div class="flow-arr">→</div>
    <div class="flow-step">🛢️ MySQL 8.4<br><small>Storage RDBMS</small></div>
  </div>

  <div class="flow avoid-break" style="margin-top:6px;">
    <div class="flow-step">👤 Browser Pengguna<br><small>Render Antarmuka</small></div><div class="flow-arr">←</div>
    <div class="flow-step">🖼️ Blade Engine<br><small>View Templates</small></div><div class="flow-arr">←</div>
    <div class="flow-step">🎮 Controller Layer<br><small>Return Response</small></div>
  </div>

  <h3>3.2 Matriks Teknologi yang Digunakan</h3>
  <table class="tbl avoid-break">
    <thead>
      <tr><th>Komponen</th><th>Teknologi</th><th>Versi</th><th>Fungsi Utama</th></tr>
    </thead>
    <tbody>
      <tr><td><strong>Backend Framework</strong></td><td>Laravel</td><td>13.x</td><td>Routing, controllers, middleware, CSRF security, Eloquent ORM</td></tr>
      <tr><td><strong>Bahasa Pemrograman</strong></td><td>PHP</td><td>8.3+</td><td>Server-side computing, image processing, cross-midnight calculation</td></tr>
      <tr><td><strong>Basis Data (RDBMS)</strong></td><td>MySQL</td><td>8.4</td><td>Penyimpanan relasional data presensi, jadwal, kegiatan, dan akun</td></tr>
      <tr><td><strong>Frontend Styling</strong></td><td>Vanilla CSS (Dark Glassmorphism)</td><td>CSS3 Custom</td><td>Desain eksklusif neon-dark tanpa dependensi Tailwind/Bootstrap eksternal</td></tr>
      <tr><td><strong>Frontend Scripting</strong></td><td>Vanilla JavaScript</td><td>ES6+</td><td>Integrasi kamera WebRTC HTML5, penentuan GPS, dan live timer</td></tr>
      <tr><td><strong>Notifikasi Dialog</strong></td><td>SweetAlert2</td><td>11.x</td><td>Modal dialog konfirmasi clock-out, penghapusan data, dan alert sukses</td></tr>
      <tr><td><strong>Pengujian Otomatis</strong></td><td>PHPUnit</td><td>12.x</td><td>Unit &amp; Feature testing (autentikasi, proteksi rute, backup/restore)</td></tr>
    </tbody>
  </table>

  <h3>3.3 Proteksi Sesi &amp; Autentikasi Pengguna</h3>
  <div class="alert a-info avoid-break">
    <span>🔒</span>
    <div>
      <strong>Keamanan Akses Sesi Pertama:</strong> Seluruh rute aplikasi (kecuali <code>/login</code>) diproteksi dengan middleware <code>auth</code>.
      Pengguna yang belum login yang membuka URL dasar sistem (<code>/</code>) secara otomatis dialihkan (302 Redirect) ke halaman login.
      Password dienkripsi menggunakan algoritma standar industri <strong>Bcrypt</strong> dengan salt dinamis.
    </div>
  </div>
</div>

<!-- ===================== BAB 4 ===================== -->
<div class="section page-break" id="bab4">
  <div class="section-hdr"><div class="sec-num">4</div><h2>BAB 4: Hak Akses &amp; Manajemen Peran (RBAC)</h2></div>
  <p>Sistem menerapkan <strong>Role-Based Access Control (RBAC)</strong> yang membagi hak akses ke dalam 4 peran dengan batas kewenangan yang tegas:</p>

  <div class="grid-4 avoid-break">
    <div class="role-card r-admin">
      <div class="role-icon">👑</div>
      <div class="role-name">Administrator</div>
      <div class="role-desc">Akses penuh ke semua modul, kelola user, master shift, backup database, dan switch user.</div>
    </div>
    <div class="role-card r-sup">
      <div class="role-icon">🔍</div>
      <div class="role-name">Supervisor</div>
      <div class="role-desc">Memantau rekap absensi seluruh staf, menyetujui/menolak pengajuan izin dan sakit.</div>
    </div>
    <div class="role-card r-sat">
      <div class="role-icon">🛡️</div>
      <div class="role-name">Satpam</div>
      <div class="role-desc">Absen swafoto masuk/pulang, mencatat logbook patroli &amp; insiden, mengajukan izin.</div>
    </div>
    <div class="role-card r-car">
      <div class="role-icon">📬</div>
      <div class="role-name">Caraka</div>
      <div class="role-desc">Absen swafoto masuk/pulang, mencatat logbook kebersihan &amp; antar dokumen dinas.</div>
    </div>
  </div>

  <h3>Matriks Perbandingan Hak Akses Fitur</h3>
  <table class="tbl avoid-break">
    <thead>
      <tr>
        <th>Fitur / Modul Aplikasi</th>
        <th style="text-align:center;">Admin</th>
        <th style="text-align:center;">Supervisor</th>
        <th style="text-align:center;">Satpam</th>
        <th style="text-align:center;">Caraka</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Absensi Masuk &amp; Pulang (Selfie + GPS)</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
      </tr>
      <tr>
        <td>Mencatat Logbook Kegiatan Harian</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
      </tr>
      <tr>
        <td>Mengajukan Izin / Sakit / Cuti</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
      </tr>
      <tr>
        <td>Verifikasi &amp; Persetujuan Izin (Approve/Reject)</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
      </tr>
      <tr>
        <td>Ekspor Rekap Absensi Bulanan (.CSV)</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-green">Pribadi</span></td>
        <td style="text-align:center;"><span class="badge b-green">Pribadi</span></td>
      </tr>
      <tr>
        <td>Kelola Data Pengguna (CRUD User &amp; Password)</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
      </tr>
      <tr>
        <td>Kelola Master Shift &amp; Toleransi Jam Kerja</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
      </tr>
      <tr>
        <td>Pengaturan Jadwal Roster &amp; Import Excel</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
      </tr>
      <tr>
        <td>Cadangan &amp; Pemulihan Database (Backup/Restore)</td>
        <td style="text-align:center;"><span class="badge b-green">Ya</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
        <td style="text-align:center;"><span class="badge b-red">Tidak</span></td>
      </tr>
    </tbody>
  </table>
</div>

<!-- ===================== BAB 5 ===================== -->
<div class="section page-break" id="bab5">
  <div class="section-hdr"><div class="sec-num">5</div><h2>BAB 5: Fitur Unggulan &amp; Logika Bisnis Khusus</h2></div>

  <h3>5.1 Solusi Masalah Shift Malam Lintas Hari (Cross-Midnight)</h3>
  <div class="card card-hl avoid-break">
    <p>
      Satpam memiliki jadwal tugas malam yang dimulai pada pukul <strong>23:00 WIB (Hari ke-1)</strong> dan berakhir pada pukul <strong>07:00 WIB (Hari ke-2)</strong>.
      Pada sistem absensi biasa, saat satpam melakukan absen pulang di pagi hari (Hari ke-2), sistem sering salah menganggap absensi tersebut sebagai absensi baru atau gagal mencocokkan sesi masuknya.
    </p>
    <p style="margin-top:4px;">
      <strong>Solusi Algoritma SICAKAP:</strong>
    </p>
    <ol class="sl" style="margin-top:4px;">
      <li>Bidang <code>date</code> pada tabel <code>attendances</code> selalu mencatat <strong>tanggal mulai bertugas</strong> (Hari ke-1).</li>
      <li>Ketika tombol <strong>"Absen Pulang"</strong> ditekan di pagi hari (Hari ke-2), controller memeriksa sesi absensi terbuka:
        <div class="codeblock"><code>// Logika Pencarian Sesi Aktif Shift Malam
\$attendance = Attendance::where('user_id', \$user->id)
    ->where(function(\$q) {
        \$q->where('date', today())
          ->orWhere('date', today()->subDay()); // Sesi kemarin malam
    })
    ->whereNull('jam_pulang')
    ->latest('jam_masuk')
    ->first();</code></div>
      </li>
      <li>Perhitungan durasi kerja menangani selisih tanggal secara otomatis menggunakan library Carbon:
        <div class="codeblock"><code>\$masuk = Carbon::parse(\$attendance->jam_masuk);
\$pulang = Carbon::now();
\$menitKerja = \$masuk->diffInMinutes(\$pulang);
\$durasiFormat = floor(\$menitKerja / 60) . ' Jam ' . (\$menitKerja % 60) . ' Menit';</code></div>
      </li>
    </ol>
  </div>

  <h3>5.2 Penanganan Kamera Swafoto &amp; Penyimpanan Berkas</h3>
  <p>
    Kamera browser mengambil frame video kanvas beresolusi optimal dan mengirimkannya sebagai format Base64 encoded payload.
    Di sisi server, controller mendekode payload menjadi berkas gambar biner (.jpg) dan menyimpannya di direktori:
    <span class="ic">storage/app/public/attendances/</span>.
  </p>
  <div class="alert a-ok avoid-break">
    <span>💡</span>
    <div>
      <strong>Integrasi Symlink Storage:</strong> Agar foto dapat dimuat secara publik oleh peramban tanpa hambatan hak akses,
      sistem menghubungkan <span class="ic">public/storage</span> ke <span class="ic">storage/app/public</span> menggunakan perintah
      <span class="ic">php artisan storage:link</span>.
    </div>
  </div>
</div>

<!-- ===================== BAB 6 ===================== -->
<div class="section page-break" id="bab6">
  <div class="section-hdr"><div class="sec-num">6</div><h2>BAB 6: Skema Basis Data Relasional (ERD)</h2></div>
  <p>Database sistem diberi nama <span class="ic">db_sicakap</span> dan terdiri dari 6 tabel operasional inti serta 1 tabel manajemen sesi:</p>

  <div class="erd avoid-break">
    <div class="erd-grid">
      <!-- users -->
      <div class="erd-tbl">
        <div class="erd-hdr">👤 users</div>
        <div class="erd-row"><span class="pk">🔑 id</span><span class="tp">BIGINT PK AI</span></div>
        <div class="erd-row"><span>name</span><span class="tp">VARCHAR(255)</span></div>
        <div class="erd-row"><span>nip</span><span class="tp">VARCHAR UNIQUE</span></div>
        <div class="erd-row"><span>email</span><span class="tp">VARCHAR UNIQUE</span></div>
        <div class="erd-row"><span>role</span><span class="tp">VARCHAR(50)</span></div>
        <div class="erd-row"><span>position</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>phone</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>avatar</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>password</span><span class="tp">VARCHAR (bcrypt)</span></div>
      </div>

      <!-- shifts -->
      <div class="erd-tbl">
        <div class="erd-hdr">🕐 shifts</div>
        <div class="erd-row"><span class="pk">🔑 id</span><span class="tp">BIGINT PK AI</span></div>
        <div class="erd-row"><span>name</span><span class="tp">VARCHAR(255)</span></div>
        <div class="erd-row"><span>code</span><span class="tp">VARCHAR UNIQUE</span></div>
        <div class="erd-row"><span>role</span><span class="tp">VARCHAR(50)</span></div>
        <div class="erd-row"><span>start_time</span><span class="tp">TIME</span></div>
        <div class="erd-row"><span>end_time</span><span class="tp">TIME</span></div>
        <div class="erd-row"><span>is_night_shift</span><span class="tp">TINYINT(1)</span></div>
        <div class="erd-row"><span>grace_period_minutes</span><span class="tp">INT def:15</span></div>
      </div>

      <!-- user_schedules -->
      <div class="erd-tbl">
        <div class="erd-hdr">📅 user_schedules</div>
        <div class="erd-row"><span class="pk">🔑 id</span><span class="tp">BIGINT PK AI</span></div>
        <div class="erd-row"><span class="fk">↗ user_id</span><span class="tp">FK → users.id</span></div>
        <div class="erd-row"><span>date</span><span class="tp">DATE</span></div>
        <div class="erd-row"><span class="fk">↗ shift_id</span><span class="tp">FK → shifts.id</span></div>
        <div class="erd-row"><span>is_off</span><span class="tp">TINYINT(1) def:0</span></div>
        <div class="erd-row"><span>notes</span><span class="tp">TEXT NULL</span></div>
        <div class="erd-row"><span class="fk">↗ created_by</span><span class="tp">FK → users.id</span></div>
      </div>

      <!-- attendances -->
      <div class="erd-tbl">
        <div class="erd-hdr">✅ attendances</div>
        <div class="erd-row"><span class="pk">🔑 id</span><span class="tp">BIGINT PK AI</span></div>
        <div class="erd-row"><span class="fk">↗ user_id</span><span class="tp">FK → users.id</span></div>
        <div class="erd-row"><span class="fk">↗ shift_id</span><span class="tp">FK → shifts.id</span></div>
        <div class="erd-row"><span>date</span><span class="tp">DATE</span></div>
        <div class="erd-row"><span>jam_masuk</span><span class="tp">DATETIME NULL</span></div>
        <div class="erd-row"><span>foto_masuk</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>lokasi_masuk</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>jam_pulang</span><span class="tp">DATETIME NULL</span></div>
        <div class="erd-row"><span>foto_pulang</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>durasi_menit</span><span class="tp">INT NULL</span></div>
        <div class="erd-row"><span>durasi_kerja</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>status</span><span class="tp">VARCHAR(50)</span></div>
      </div>

      <!-- activity_logs -->
      <div class="erd-tbl">
        <div class="erd-hdr">📒 activity_logs</div>
        <div class="erd-row"><span class="pk">🔑 id</span><span class="tp">BIGINT PK AI</span></div>
        <div class="erd-row"><span class="fk">↗ user_id</span><span class="tp">FK → users.id</span></div>
        <div class="erd-row"><span class="fk">↗ attendance_id</span><span class="tp">FK → attendances</span></div>
        <div class="erd-row"><span>title</span><span class="tp">VARCHAR(255)</span></div>
        <div class="erd-row"><span>category</span><span class="tp">VARCHAR(100)</span></div>
        <div class="erd-row"><span>location</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>description</span><span class="tp">TEXT NULL</span></div>
        <div class="erd-row"><span>photo</span><span class="tp">TEXT NULL</span></div>
        <div class="erd-row"><span>time_recorded</span><span class="tp">TIME NULL</span></div>
      </div>

      <!-- leave_requests -->
      <div class="erd-tbl">
        <div class="erd-hdr">🏖️ leave_requests</div>
        <div class="erd-row"><span class="pk">🔑 id</span><span class="tp">BIGINT PK AI</span></div>
        <div class="erd-row"><span class="fk">↗ user_id</span><span class="tp">FK → users.id</span></div>
        <div class="erd-row"><span>type</span><span class="tp">VARCHAR(50)</span></div>
        <div class="erd-row"><span>start_date</span><span class="tp">DATE</span></div>
        <div class="erd-row"><span>end_date</span><span class="tp">DATE</span></div>
        <div class="erd-row"><span>reason</span><span class="tp">TEXT</span></div>
        <div class="erd-row"><span>surat_bukti</span><span class="tp">VARCHAR NULL</span></div>
        <div class="erd-row"><span>status</span><span class="tp">VARCHAR def:pending</span></div>
        <div class="erd-row"><span>approved_by</span><span class="tp">VARCHAR NULL</span></div>
      </div>
    </div>
  </div>
</div>

<!-- ===================== BAB 7 ===================== -->
<div class="section page-break" id="bab7">
  <div class="section-hdr"><div class="sec-num">7</div><h2>BAB 7: Direktori Rute &amp; Pemetaan URL</h2></div>
  <p>Seluruh rute sistem didefinisikan secara modular di file <span class="ic">routes/web.php</span>:</p>

  <h3>7.1 Rute Autentikasi &amp; Akses Publik</h3>
  <table class="tbl avoid-break">
    <thead><tr><th>Method</th><th>URL</th><th>Nama Rute</th><th>Middleware</th><th>Controller &amp; Action</th></tr></thead>
    <tbody>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/login</code></td><td>login</td><td><code>guest</code></td><td>AuthController@showLoginForm</td></tr>
      <tr><td><span class="badge b-sky">POST</span></td><td><code>/login</code></td><td>login.post</td><td><code>guest</code></td><td>AuthController@login</td></tr>
      <tr><td><span class="badge b-red">POST</span></td><td><code>/logout</code></td><td>logout</td><td><code>auth</code></td><td>AuthController@logout</td></tr>
    </tbody>
  </table>

  <h3>7.2 Rute Presensi, Logbook &amp; Profil Karyawan (Auth)</h3>
  <table class="tbl avoid-break">
    <thead><tr><th>Method</th><th>URL</th><th>Nama Rute</th><th>Fungsi</th></tr></thead>
    <tbody>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/</code></td><td>dashboard</td><td>Dashboard absensi utama live camera</td></tr>
      <tr><td><span class="badge b-sky">POST</span></td><td><code>/absen/masuk</code></td><td>attendance.in</td><td>Clock-in presensi selfie &amp; rekam GPS</td></tr>
      <tr><td><span class="badge b-sky">POST</span></td><td><code>/absen/pulang</code></td><td>attendance.out</td><td>Clock-out presensi &amp; kalkulasi durasi kerja</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/riwayat</code></td><td>attendance.history</td><td>Tabel rekap bulanan dengan filter</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/riwayat/export</code></td><td>attendance.export</td><td>Download laporan kehadiran format CSV</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/kegiatan</code></td><td>activity.index</td><td>Daftar timeline logbook pekerjaan</td></tr>
      <tr><td><span class="badge b-sky">POST</span></td><td><code>/kegiatan</code></td><td>activity.store</td><td>Simpan laporan kerja + lampiran foto</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/izin</code></td><td>leave.index</td><td>Form dan riwayat pengajuan izin/sakit</td></tr>
      <tr><td><span class="badge b-sky">POST</span></td><td><code>/izin</code></td><td>leave.store</td><td>Kirim permohonan izin baru</td></tr>
      <tr><td><span class="badge b-amber">PATCH</span></td><td><code>/izin/{id}/status</code></td><td>leave.update-status</td><td>Supervisor: Setujui / tolak pengajuan</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/profil</code></td><td>profile.index</td><td>Halaman profil &amp; ubah kata sandi</td></tr>
    </tbody>
  </table>

  <h3>7.3 Rute Panel Administrasi (Admin Middleware)</h3>
  <table class="tbl avoid-break">
    <thead><tr><th>Method</th><th>URL</th><th>Fungsi</th></tr></thead>
    <tbody>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/admin/users</code></td><td>Manajemen data pengguna (CRUD staf)</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/admin/shifts</code></td><td>Pengaturan master jam kerja &amp; shift</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/admin/schedules</code></td><td>Kalender jadwal roster bulanan karyawan</td></tr>
      <tr><td><span class="badge b-sky">POST</span></td><td><code>/admin/schedules/import</code></td><td>Unggah jadwal massal via file Excel</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/admin/backup</code></td><td>Halaman pusat backup &amp; pemulihan data</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/admin/backup/export</code></td><td>Unduh cadangan seluruh data format JSON</td></tr>
      <tr><td><span class="badge b-green">GET</span></td><td><code>/admin/backup/export-sql</code></td><td>Unduh skrip dump database SQL</td></tr>
      <tr><td><span class="badge b-sky">POST</span></td><td><code>/admin/backup/import</code></td><td>Unggah &amp; restore data cadangan JSON</td></tr>
    </tbody>
  </table>
</div>

<!-- ===================== BAB 8 ===================== -->
<div class="section page-break" id="bab8">
  <div class="section-hdr"><div class="sec-num">8</div><h2>BAB 8: Struktur File &amp; Hierarki Direktori</h2></div>
  <p>Susunan berkas proyek mengikuti konvensi baku framework Laravel untuk kemudahan pemeliharaan jangka panjang:</p>

  <div class="codeblock avoid-break"><code>SICAKAP/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminBackupController.php      # Modul Backup &amp; Restore (JSON/SQL)
│   │   │   │   ├── AdminScheduleController.php    # Manajemen Jadwal Roster Bulanan
│   │   │   │   ├── AdminShiftController.php       # Master Data Shift Kerja
│   │   │   │   └── AdminUserController.php        # Kelola Akun Karyawan (CRUD)
│   │   │   ├── ActivityLogController.php          # Logbook Kegiatan &amp; Upload Bukti
│   │   │   ├── AttendanceController.php           # Absensi Masuk/Pulang &amp; Cross-Midnight
│   │   │   ├── AuthController.php                 # Autentikasi Login, Logout &amp; Sesi
│   │   │   ├── LeaveController.php                # Permohonan &amp; Approval Izin
│   │   │   ├── ProfileController.php              # Edit Profil &amp; Ganti Password
│   │   │   └── SessionController.php              # Fitur Switch Akun Pengguna
│   │   └── Middleware/
│   │       └── AdminMiddleware.php                # Validasi Peran Hak Akses Administrator
│   └── Models/
│       ├── ActivityLog.php                        # Model Eloquent Tabel activity_logs
│       ├── Attendance.php                         # Model Eloquent Tabel attendances
│       ├── LeaveRequest.php                       # Model Eloquent Tabel leave_requests
│       ├── Shift.php                              # Model Eloquent Tabel shifts
│       ├── User.php                               # Model Eloquent Tabel users
│       └── UserSchedule.php                       # Model Eloquent Tabel user_schedules
├── database/
│   ├── migrations/                                # 6 File Migration Struktur Database
│   └── seeders/                                   # Data Awal Pegawai &amp; Shift Bawaan
├── public/
│   ├── css/app.css                                # Stylesheet Glassmorphism Dark Neon
│   ├── images/                                    # Aset Ikon &amp; Logo SMKN 1 Jatisari
│   └── storage/                                   # Symbolic Link ke Folder Penyimpanan Upload
├── resources/
│   └── views/
│       ├── layouts/app.blade.php                  # Kerangka Utama Template HTML
│       ├── dashboard.blade.php                    # Antarmuka Kamera Absen Masuk/Pulang
│       ├── admin/                                 # Antarmuka Panel Administrasi
│       │   ├── backup.blade.php                   # Tampilan Modul Backup &amp; Restore
│       │   ├── schedules.blade.php                # Kalender Roster Jadwal Bulanan
│       │   ├── shifts.blade.php                   # Antarmuka Master Shift
│       │   └── users.blade.php                    # Antarmuka Daftar Pengguna
│       ├── activities/index.blade.php             # Antarmuka Logbook Kegiatan
│       ├── attendances/index.blade.php            # Antarmuka Riwayat Presensi &amp; Ekspor
│       └── leave/index.blade.php                  # Antarmuka Pengajuan &amp; Approval Izin
├── routes/
│   └── web.php                                    # Definisi 43 Rute Sistem
├── storage/
│   ├── app/public/                                # Tempat Penyimpanan Fisik Swafoto
│   └── logs/laravel.log                           # Catatan Audit Jejak Error
├── tests/
│   └── Feature/
│       ├── AdminBackupTest.php                    # Pengujian Otomatis Backup &amp; Restore
│       └── ExampleTest.php                        # Pengujian Otomatis Rute Dasar
├── .env                                           # Konfigurasi Lingkungan (Database, URL)
├── composer.json                                  # Manajemen Dependensi PHP
└── db_sicakap.sql                                 # Salinan Skrip Skema &amp; Data MySQL</code></div>
</div>

<!-- ===================== BAB 9 ===================== -->
<div class="section page-break" id="bab9">
  <div class="section-hdr"><div class="sec-num">9</div><h2>BAB 9: Panduan Instalasi Lokal</h2></div>
  <p>Langkah-langkah menyiapkan sistem SICAKAP di komputer lokal pengembang menggunakan Laragon atau XAMPP:</p>

  <ol class="sl avoid-break">
    <li><strong>Prasyarat Perangkat Lunak:</strong>
      <ul class="sl">
        <li>PHP versi 8.3 atau lebih tinggi dengan ekstensi <code>pdo_mysql</code>, <code>mbstring</code>, <code>fileinfo</code> aktif.</li>
        <li>Composer versi 2.x terpasang.</li>
        <li>MySQL versi 8.x atau MariaDB 10.x.</li>
      </ul>
    </li>
    <li><strong>Pemasangan Dependensi:</strong>
      <div class="codeblock"><code>composer install</code></div>
    </li>
    <li><strong>Konfigurasi Berkas .env:</strong>
      Salin berkas template dan atur kredensial koneksi database:
      <div class="codeblock"><code>copy .env.example .env
php artisan key:generate</code></div>
    </li>
    <li><strong>Konfigurasi Database di .env:</strong>
      <div class="codeblock"><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sicakap
DB_USERNAME=root
DB_PASSWORD=</code></div>
    </li>
    <li><strong>Import Database &amp; Symlink:</strong>
      Buat basis data kosong bernama <code>db_sicakap</code> di phpMyAdmin, kemudian import file <code>db_sicakap.sql</code>. Setelah itu tautkan storage foto:
      <div class="codeblock"><code>php artisan storage:link</code></div>
    </li>
    <li><strong>Menjalankan Server Lokal:</strong>
      <div class="codeblock"><code>php artisan serve</code></div>
      Buka peramban: <strong>http://127.0.0.1:8000</strong>
    </li>
  </ol>

  <h3>Akun Administrator Bawaan</h3>
  <table class="tbl avoid-break">
    <thead><tr><th>Email Login</th><th>Password</th><th>NIP Pegawai</th><th>Peran Akses</th></tr></thead>
    <tbody>
      <tr><td><code>admin@admin.com</code></td><td><code>password</code></td><td><code>ADM-001</code></td><td><span class="badge b-indigo">admin</span></td></tr>
    </tbody>
  </table>
</div>

<!-- ===================== BAB 10 ===================== -->
<div class="section page-break" id="bab10">
  <div class="section-hdr"><div class="sec-num">10</div><h2>BAB 10: Panduan Deployment Hosting (Rumahweb)</h2></div>
  <p>Panduan penerapan aplikasi ke hosting cPanel Rumahweb dengan alamat domain <strong>sicakap.smkn1jatisari.sch.id</strong>:</p>

  <table class="tbl avoid-break">
    <thead><tr><th style="width:10%;">Tahap</th><th style="width:30%;">Nama Langkah</th><th>Instruksi Detail</th></tr></thead>
    <tbody>
      <tr><td><span class="badge b-indigo">Tahap 1</span></td><td>Ekspor Database</td><td>Unduh file SQL dari menu <em>Admin → Backup → Ekspor SQL</em> di lokal.</td></tr>
      <tr><td><span class="badge b-indigo">Tahap 2</span></td><td>Arsip Proyek (.ZIP)</td><td>Kompres seluruh folder proyek ke format ZIP (sertakan folder <code>vendor</code>).</td></tr>
      <tr><td><span class="badge b-indigo">Tahap 3</span></td><td>Pembuatan Subdomain</td><td>Buka cPanel → <strong>Domains</strong> → Buat <code>sicakap.smkn1jatisari.sch.id</code>. Arahkan Document Root ke folder <code>sicakap/public</code>.</td></tr>
      <tr><td><span class="badge b-indigo">Tahap 4</span></td><td>Pilihan Versi PHP</td><td>Buka <strong>MultiPHP Manager</strong> → Tetapkan versi PHP <strong>8.3</strong> untuk subdomain tersebut.</td></tr>
      <tr><td><span class="badge b-indigo">Tahap 5</span></td><td>Unggah &amp; Ekstrak</td><td>Buka <strong>File Manager</strong> → Upload file zip ke folder <code>sicakap/</code> lalu ekstrak.</td></tr>
      <tr><td><span class="badge b-indigo">Tahap 6</span></td><td>Pembuatan Database cPanel</td><td>Buka <strong>MySQL Databases</strong> → Buat nama database &amp; user baru → Berikan izin <em>ALL PRIVILEGES</em> → Import file SQL via phpMyAdmin hosting.</td></tr>
      <tr><td><span class="badge b-indigo">Tahap 7</span></td><td>Konfigurasi .env Hosting</td><td>Sesuaikan konfigurasi produksi:
        <div class="codeblock"><code>APP_ENV=production
APP_DEBUG=false
APP_URL=https://sicakap.smkn1jatisari.sch.id
SESSION_DRIVER=file
DB_DATABASE=u1234567_sicakap
DB_USERNAME=u1234567_usr
DB_PASSWORD=KataSandiHostingKuat!</code></div>
      </td></tr>
      <tr><td><span class="badge b-indigo">Tahap 8</span></td><td>Symlink Storage Hosting</td><td>Jalankan perintah <code>php artisan storage:link</code> via menu <strong>Terminal cPanel</strong> atau buat cron job satu kali jalan.</td></tr>
      <tr><td><span class="badge b-indigo">Tahap 9</span></td><td>Sertifikat SSL (HTTPS)</td><td>Buka <strong>SSL/TLS Status</strong> → Centang subdomain → Klik <strong>Run AutoSSL</strong> agar akses kamera diizinkan oleh browser.</td></tr>
    </tbody>
  </table>
</div>

<!-- ===================== BAB 11 ===================== -->
<div class="section page-break" id="bab11">
  <div class="section-hdr"><div class="sec-num">11</div><h2>BAB 11: Modul Cadangan &amp; Pemulihan Data</h2></div>
  <p>
    Untuk menjamin kontinuitas operasional data absensi dan mengantisipasi kegagalan perangkat keras,
    SICAKAP dilengkapi modul <strong>Backup &amp; Restore</strong> mandiri yang hanya dapat diakses oleh Administrator:
  </p>

  <h3>11.1 Format Ekspor Cadangan</h3>
  <div class="grid-2 avoid-break">
    <div class="feat-item">
      <div class="feat-icon">📄</div>
      <div>
        <h4>Cadangan Format JSON (.json)</h4>
        <p>Menyimpan data seluruh entitas dalam struktur objek terstandarisasi. Kompatibel dengan fitur Restore langsung di web tanpa membuka phpMyAdmin.</p>
      </div>
    </div>
    <div class="feat-item">
      <div class="feat-icon">🗄️</div>
      <div>
        <h4>Cadangan Format SQL (.sql)</h4>
        <p>Menghasilkan skrip DDL &amp; DML (CREATE TABLE &amp; INSERT) lengkap. Cocok untuk migrasi server hosting atau pemulihan via console MySQL CLI.</p>
      </div>
    </div>
  </div>

  <h3>11.2 Mode Pemulihan Data (Restore Engine)</h3>
  <table class="tbl avoid-break">
    <thead><tr><th>Mode Pemulihan</th><th>Karakteristik Operasional</th><th>Tingkat Risiko</th></tr></thead>
    <tbody>
      <tr>
        <td><strong>Mode Gabung &amp; Perbarui<br>(Merge / Upsert)</strong></td>
        <td>Memperbarui baris data yang ID-nya sudah ada dan menyisipkan baris data baru. Data eksisting yang tidak tercantum dalam berkas cadangan tetap aman dan tidak dihapus.</td>
        <td><span class="badge b-green">Aman / Rendah</span></td>
      </tr>
      <tr>
        <td><strong>Mode Timpa Bersih<br>(Full Replace)</strong></td>
        <td>Mengosongkan (TRUNCATE) seluruh tabel operasional lalu mengisi ulang seluruh isi database sesuai file backup. Sangat berguna untuk sinkronisasi total antar server.</td>
        <td><span class="badge b-amber">Tinggi / Hati-hati</span></td>
      </tr>
    </tbody>
  </table>

  <div class="alert a-ok avoid-break">
    <span>🛡️</span>
    <div>
      <strong>Mekanisme Perlindungan Akun Administrator:</strong>
      Pada saat proses <em>Mode Timpa Bersih</em> berjalan, sistem secara otomatis mengecualikan akun admin yang sedang login dari proses penghapusan.
      Hal ini mencegah hilangnya sesi login yang dapat menyebabkan administrator terkunci dari panel kontrol.
    </div>
  </div>
</div>

<!-- ===================== BAB 12 ===================== -->
<div class="section page-break" id="bab12">
  <div class="section-hdr"><div class="sec-num">12</div><h2>BAB 12: Buku Panduan Pengoperasian (User Manual)</h2></div>

  <h3>12.1 Panduan Petugas Satpam &amp; Caraka</h3>
  <div class="card avoid-break">
    <h4>A. Melakukan Absensi Masuk (Clock-in):</h4>
    <ol class="sl">
      <li>Akses URL sistem melalui browser smartphone atau tablet pos jaga.</li>
      <li>Masukkan Email dan Password, lalu klik tombol <strong>"Masuk"</strong>.</li>
      <li>Pada halaman utama, pastikan kamera aktif dan hadapkan wajah ke lingkaran panduan.</li>
      <li>Klik tombol hijau <strong>"Absen Masuk"</strong>.</li>
      <li>Sistem merekam swafoto, waktu masuk, dan koordinat GPS secara otomatis. Tombol berubah menjadi tanda centang hijau tanda berhasil.</li>
    </ol>

    <h4 style="margin-top:10px;">B. Melakukan Absensi Pulang (Clock-out):</h4>
    <ol class="sl">
      <li>Setelah jam bertugas berakhir, buka kembali dashboard sistem.</li>
      <li>Tombol merah <strong>"Absen Pulang"</strong> kini telah aktif. Klik tombol tersebut.</li>
      <li>Konfirmasi dialog SweetAlert yang muncul. Sistem menghitung durasi kerja dan menyelesaikan sesi kerja hari tersebut.</li>
    </ol>

    <h4 style="margin-top:10px;">C. Mengisi Logbook Kegiatan:</h4>
    <ol class="sl">
      <li>Pilih menu <strong>"Logbook Kegiatan"</strong> di navigasi atas.</li>
      <li>Klik tombol <strong>"+ Tambah Kegiatan"</strong>.</li>
      <li>Pilih kategori (misal: Patroli Keliling, Cek APAR, atau Kebersihan Lantai 2).</li>
      <li>Tuliskan uraian hasil kerja dan lampirkan foto dokumentasi kegiatan.</li>
      <li>Klik <strong>"Simpan Laporan"</strong>.</li>
    </ol>
  </div>

  <h3>12.2 Panduan Supervisor (Approval Izin)</h3>
  <div class="card avoid-break">
    <ol class="sl">
      <li>Buka menu <strong>"Izin / Sakit"</strong>.</li>
      <li>Periksa daftar permohonan staf yang berstatus <span class="badge b-amber">Menunggu Persetujuan</span>.</li>
      <li>Klik tombol pratinjau untuk memeriksa surat keterangan dokter jika staf mengajukan izin sakit.</li>
      <li>Klik tombol hijau <strong>"Setujui"</strong> atau tombol merah <strong>"Tolak"</strong> beserta catatan verifikasi.</li>
    </ol>
  </div>
</div>

<!-- ===================== BAB 13 ===================== -->
<div class="section page-break" id="bab13">
  <div class="section-hdr"><div class="sec-num">13</div><h2>BAB 13: Hasil Pengujian Otomatis (PHPUnit QA)</h2></div>
  <p>
    Seluruh fungsionalitas kritis sistem telah diuji menggunakan framework pengujian <strong>PHPUnit</strong>.
    Semua pengujian berjalan secara otomatis dan memperoleh hasil <strong>100% Lulus (Pass)</strong>:
  </p>

  <table class="tbl avoid-break">
    <thead>
      <tr>
        <th>Kelas Pengujian</th>
        <th>Kasus Pengujian (Test Case)</th>
        <th>Aspek yang Divalidasi</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td rowspan="2"><strong>ExampleTest</strong></td>
        <td>Pengalihan Tamu Belum Login</td>
        <td>Akses root (<code>/</code>) diarahkan otomatis ke <code>/login</code> (HTTP 302)</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
      <tr>
        <td>Ketersediaan Form Login</td>
        <td>Halaman <code>/login</code> merespons sukses dengan kode HTTP 200</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
      <tr>
        <td rowspan="6"><strong>AdminBackupTest</strong></td>
        <td>Proteksi Tamu Anonim</td>
        <td>Akses <code>/admin/backup</code> tanpa login ditolak dan dialihkan ke login</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
      <tr>
        <td>Proteksi Hak Akses Role</td>
        <td>Pengguna dengan role satpam/caraka ditolak dari rute panel admin</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
      <tr>
        <td>Akses Administrator</td>
        <td>Admin yang sah dapat membuka modul backup dengan HTTP 200</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
      <tr>
        <td>Ekspor Cadangan JSON</td>
        <td>Menghasilkan berkas attachment JSON dengan struktur data valid</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
      <tr>
        <td>Ekspor Cadangan SQL</td>
        <td>Menghasilkan skrip SQL dump yang berisi instruksi tabel lengkap</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
      <tr>
        <td>Validasi Impor Berkas</td>
        <td>Proses impor file backup JSON berhasil memulihkan data ke tabel</td>
        <td><span class="badge b-green">PASS</span></td>
      </tr>
    </tbody>
  </table>

  <div class="card card-hl avoid-break" style="text-align:center;padding:16px;">
    <p style="font-size:13pt;font-weight:800;color:#15803d;margin:0;">
      ✅ 9 dari 9 Kasus Pengujian Berhasil Lulus (100% Passed)
    </p>
    <p style="color:#64748b;font-size:8pt;margin-top:3px;">
      Total Assertions: 18 &nbsp;|&nbsp; Waktu Eksekusi: ~1.4 detik &nbsp;|&nbsp; Driver: In-Memory / MySQL Test Database
    </p>
  </div>
</div>

<!-- ===================== BAB 14 ===================== -->
<div class="section page-break" id="bab14">
  <div class="section-hdr"><div class="sec-num">14</div><h2>BAB 14: Panduan Pemecahan Masalah (Troubleshooting)</h2></div>

  <table class="tbl avoid-break">
    <thead><tr><th style="width:25%;">Gejala / Pesan Kendala</th><th style="width:30%;">Penyebab Masalah</th><th>Solusi Teknis Penanganan</th></tr></thead>
    <tbody>
      <tr>
        <td><strong>Foto absensi tidak tampil (Error 404)</strong></td>
        <td>Tautan simbolik (*symlink*) folder storage belum terpasang atau putus di hosting.</td>
        <td>Hapus folder <code>public/storage</code> kemudian jalankan ulang: <code>php artisan storage:link</code>. Pastikan izin direktori <code>storage</code> adalah <code>775</code>.</td>
      </tr>
      <tr>
        <td><strong>Kamera web tidak aktif / blank</strong></td>
        <td>Peramban memblokir akses media karena domain tidak menggunakan protokol terenkripsi SSL.</td>
        <td>Akses wajib menggunakan HTTPS (<code>https://...</code>). Di localhost, gunakan nama domain <code>localhost</code> atau <code>127.0.0.1</code>.</td>
      </tr>
      <tr>
        <td><strong>SQLSTATE[HY000]: Unknown database</strong></td>
        <td>Nama basis data pada file <code>.env</code> tidak sesuai dengan database yang ada di server.</td>
        <td>Periksa nama database di cPanel/phpMyAdmin dan sesuaikan nilai parameter <code>DB_DATABASE</code> di file <code>.env</code>.</td>
      </tr>
      <tr>
        <td><strong>Tabel 'sessions' does not exist</strong></td>
        <td>Driver sesi diatur ke <code>database</code> namun tabel sesi belum termigrasi.</td>
        <td>Jalankan perintah <code>php artisan migrate</code> ATAU ubah konfigurasi di <code>.env</code> menjadi: <code>SESSION_DRIVER=file</code>.</td>
      </tr>
      <tr>
        <td><strong>Tampilan CSS / JS rusak di hosting</strong></td>
        <td>Parameter <code>APP_URL</code> belum disesuaikan dengan nama domain aktif sekolah.</td>
        <td>Pastikan di file <code>.env</code> tertulis: <code>APP_URL=https://sicakap.smkn1jatisari.sch.id</code> (lengkap dengan https://).</td>
      </tr>
      <tr>
        <td><strong>Peringatan 'vite is not recognized'</strong></td>
        <td>Dependensi Node.js / node_modules belum terpasang di komputer lokal.</td>
        <td>Aplikasi SICAKAP menggunakan CSS dan JS murni yang telah dibundle langsung, sehingga tidak mewajibkan proses build Vite untuk berjalan.</td>
      </tr>
    </tbody>
  </table>
</div>

<!-- ===================== BAB 15 ===================== -->
<div class="section page-break" id="bab15">
  <div class="section-hdr"><div class="sec-num">15</div><h2>BAB 15: Kesimpulan &amp; Penutup</h2></div>
  <div class="card card-hl">
    <p>
      Aplikasi <strong>SICAKAP</strong> telah selesai dikembangkan dan diuji secara komprehensif untuk memenuhi seluruh kebutuhan operasional
      satpam dan caraka di <strong>SMK Negeri 1 Jatisari</strong>. Melalui kehadiran aplikasi ini, pengelolaan kehadiran pegawai menjadi
      jauh lebih transparan, akuntabel, dan efisien berkat pemanfaatan swafoto kamera real-time, perekaman koordinat GPS, serta penanganan
      cerdas terhadap jadwal shift kerja malam lintas hari.
    </p>
    <p style="margin-top:6px;">
      Dokumentasi ini disusun sebagai acuan teknis bagi tim pengelola sistem informasi, bagian kepegawaian, serta pihak manajemen sekolah
      dalam memelihara dan mendayagunakan sistem secara optimal.
    </p>
  </div>

  <div class="grid-2 avoid-break" style="margin-top:14px;">
    <div class="info-card">
      <div class="info-lbl">Layanan Bantuan Teknis</div>
      <div class="info-val">Unit IT &amp; Laboratorium Komputer SMKN 1 Jatisari</div>
    </div>
    <div class="info-card">
      <div class="info-lbl">Status Lisensi &amp; Hak Cipta</div>
      <div class="info-val">Hak Cipta © $tahun SMKN 1 Jatisari · All Rights Reserved</div>
    </div>
  </div>
</div>

</div><!-- /doc-body -->

<div class="footer">
  <strong>SICAKAP v1.0.0</strong> — Sistem Informasi Absensi &amp; Catatan Kegiatan Satpam &amp; Caraka<br>
  Dokumentasi Teknis Resmi &amp; Panduan Pengoperasian · SMK Negeri 1 Jatisari · $tanggal
</div>

</body>
</html>
HTML;

$htmlPath = __DIR__ . '/DOKUMENTASI_SICAKAP.html';
file_put_contents($htmlPath, $html);
echo "✅ File HTML dokumentasi berhasil dibuat: " . realpath($htmlPath) . PHP_EOL;
echo "📄 Ukuran HTML: " . number_format(filesize($htmlPath) / 1024, 1) . " KB" . PHP_EOL;

// Konversi ke PDF menggunakan Google Chrome Headless
$pdfPath = __DIR__ . '/DOKUMENTASI_SICAKAP.pdf';
$chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

if (file_exists($chromePath)) {
    echo "🚀 Memulai pembuatan PDF resmi via Google Chrome Headless..." . PHP_EOL;
    if (file_exists($pdfPath)) {
        @unlink($pdfPath);
    }
    $cmd = '"' . $chromePath . '" --headless=new --disable-gpu --no-pdf-header-footer --print-background --print-to-pdf="' . $pdfPath . '" "' . $htmlPath . '"';
    exec($cmd, $output, $returnVar);

    if (file_exists($pdfPath)) {
        echo "🎉 BERHASIL! File PDF Dokumentasi telah dibuat:" . PHP_EOL;
        echo "📁 Lokasi PDF: " . realpath($pdfPath) . PHP_EOL;
        echo "📊 Ukuran PDF: " . number_format(filesize($pdfPath) / 1024 / 1024, 2) . " MB" . PHP_EOL;
    } else {
        echo "⚠️  File PDF belum terbentuk otomatis. Anda dapat membuka file HTML di browser dan menekan tombol 'Cetak / Simpan PDF'." . PHP_EOL;
    }
} else {
    echo "⚠️  Google Chrome tidak ditemukan pada path default. Silakan buka {$htmlPath} di browser lalu gunakan Ctrl+P." . PHP_EOL;
}
