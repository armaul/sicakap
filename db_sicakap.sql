-- SICAKAP SQL DUMP
-- SMKN 1 Jatisari
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'satpam',
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('6', 'Administrator Utama', 'ADM-001', 'admin@admin.com', 'admin', 'Super Administrator & Pengelola Sistem', '0838152461518', 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$D5segbjYKc.UPXid7Mg8VeG5QAkzrnDmhrLGTyKb.1KPjJI1GtGJ2', 'vkcnP8lDJlE8ujvSVDu3dydDoW7j4hQnz9MB9rmfgT5LPjxyjS6j28yxAORU', '2026-10-26 10:15:41', '2026-10-26 19:26:23');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('7', 'ADE', 'STP001', 'ade@satpam.com', 'satpam', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$XqI5b/jeFGMSoNqvajwY/uz/EmSYAYvIQPWG2x6Hby6IUpBWIhQBi', NULL, '2026-10-26 10:20:42', '2026-10-26 10:20:42');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('8', 'DEDE IRFAN ARDIANSYAH', 'STP-002', 'dede@gmail.com', 'satpam', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$pUWN9SociuZFBSSyPG9hkuXkCt16auBtYf/ERdBnYNLNYMEvzoIyS', NULL, '2026-10-26 10:21:55', '2026-10-26 10:21:55');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('9', 'GITO ANTONI', 'STP-003', 'gito@satpam.com', 'satpam', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$RvfQpTCrXUPAw9xdsd97n.Gu/zCsJRaNA407JIwERlgHJ6PR3xFDG', NULL, '2026-10-26 10:23:12', '2026-10-26 10:23:12');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('10', 'JUMADI', 'STP-004', 'jumadi@satpam.com', 'satpam', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$l22CnXd0N/nMYWFitPua4u0GNi2cR9Bo8wCmG3mf.JzTJWFsgHjIy', NULL, '2026-10-26 10:23:55', '2026-10-26 10:23:55');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('11', 'RAIS SUTISNA', 'STP-005', 'rais@satpam.com', 'satpam', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$yDBUgYVPVMwXhVwDTitW.eMiXe1TRiSlACxvVdHkRnmVDIFrJN/Ri', NULL, '2026-10-26 10:25:09', '2026-10-26 10:25:09');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('12', 'HARTON A RAUF', 'STP-006', 'harton@gmail.com', 'satpam', 'ANGGOTA', '0838152461518', 'http://127.0.0.1:8000/storage/avatars/vS2gio5KvlBCuqS1kyCarr17BFoXWqr7wFkI18eE.jpg', NULL, '$2y$12$RRqAMEGlWzeLPSz0N/ynJekvezu0MVDBCYwM4wK4ruxDMoJzKoAvq', NULL, '2026-10-26 10:25:50', '2026-10-27 11:34:23');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('13', 'JUNAEDI', 'CRK-001', 'junaedi@caraka.com', 'caraka', 'ANGGOTA', '0838152461518', 'http://127.0.0.1:8000/storage/avatars/MmnPLSlbCEVtRzrBX2miJegjB5wF8NMUzlN1Hc2U.jpg', NULL, '$2y$12$MSTmnay/UT/bd/DrWnwXMe8gRzi.dzYz8CPMAVJ2MOSSQxR0fVzrS', NULL, '2026-10-26 10:26:48', '2026-10-26 19:24:11');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('14', 'RADI SOETISNA', 'CRK-002', 'radi@gmail.com', 'caraka', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$uCXW6hy4F0HhIec.DAILfuxDTRXC0C7X9w2rbfT3l0oysmYqmKqGW', NULL, '2026-10-26 10:27:31', '2026-10-26 10:27:31');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('15', 'RAHMAN', 'CRK-003', 'rahman@caraka.com', 'caraka', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$ASi5vjIRRTBucB5WFpk/s.1waNO4rLZc6w4xEN5sV4sb2D1zgwY8W', NULL, '2026-10-26 10:28:16', '2026-10-26 10:28:16');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('16', 'MAHPUDIN', 'CRK-004', 'mahpudin@caraka.com', 'caraka', 'ANGGOTA', '0838152461518', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', NULL, '$2y$12$T5GpOwRJIm8rUKALSbPW8ORioFWHt9TNDJMF6RIfX.OLvZrTuRlom', NULL, '2026-10-26 10:29:02', '2026-10-26 10:29:02');
INSERT INTO `users` (`id`, `name`, `nip`, `email`, `role`, `position`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('17', 'DIAH GUSTANTI', '197608242006042007', 'diahgustanti@kepsek.com', 'admin', 'KEPALA SEKOLAH', '0812-9988-1122', 'http://127.0.0.1:8000/storage/avatars/2eXFsl164taTiClZJ8UL3p65imQQFChsxdaaiCFk.jpg', NULL, '$2y$12$AZbPyKNA0l.tBUuZ2iTOFOYtdl6wrsM4y8O6cax46U1oA1jfg96ee', NULL, '2026-10-27 14:04:04', '2026-10-27 14:04:56');

DROP TABLE IF EXISTS `shifts`;
CREATE TABLE `shifts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_night_shift` tinyint(1) NOT NULL DEFAULT '0',
  `grace_period_minutes` int NOT NULL DEFAULT '15',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shifts_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `shifts` (`id`, `name`, `code`, `role`, `start_time`, `end_time`, `is_night_shift`, `grace_period_minutes`, `description`, `created_at`, `updated_at`) VALUES ('1', 'Shift Pagi Satpam', 'STP_PAGI', 'satpam', '06:00:00', '18:00:00', '0', '15', 'Jaga pos depan, kontrol lalu lintas masuk, monitoring tamu, patroli gedung pagi.', '2026-10-26 10:15:41', '2026-10-26 10:30:57');
INSERT INTO `shifts` (`id`, `name`, `code`, `role`, `start_time`, `end_time`, `is_night_shift`, `grace_period_minutes`, `description`, `created_at`, `updated_at`) VALUES ('3', 'Shift Malam Satpam', 'STP_MALAM', 'satpam', '18:00:00', '06:00:00', '1', '15', 'Patroli berkala area perimeter & gudang, penguncian gerbang utama, penguncian gerbang belakang.', '2026-10-26 10:15:41', '2026-10-26 10:31:52');
INSERT INTO `shifts` (`id`, `name`, `code`, `role`, `start_time`, `end_time`, `is_night_shift`, `grace_period_minutes`, `description`, `created_at`, `updated_at`) VALUES ('4', 'Shift Reguler Caraka', 'CRK_REGULER', 'caraka', '06:00:00', '16:30:00', '0', '15', 'Persiapan kebersihan kantor / koridor kelas pagi hari, sanitasi toilet, perawatan taman, dan pengelolaan sampah.', '2026-10-26 10:15:41', '2026-10-26 10:33:35');

DROP TABLE IF EXISTS `user_schedules`;
CREATE TABLE `user_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `shift_id` bigint unsigned DEFAULT NULL,
  `is_off` tinyint(1) NOT NULL DEFAULT '0',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_schedules_user_id_date_unique` (`user_id`,`date`),
  KEY `user_schedules_shift_id_foreign` (`shift_id`),
  KEY `user_schedules_created_by_foreign` (`created_by`),
  KEY `user_schedules_date_is_off_index` (`date`,`is_off`),
  CONSTRAINT `user_schedules_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `user_schedules_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `user_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('1', '13', '2026-10-26', '4', '0', NULL, '6', '2026-10-26 10:34:01', '2026-10-26 10:40:57');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('2', '7', '2026-10-26', '3', '0', NULL, '6', '2026-10-26 10:34:39', '2026-10-26 10:34:39');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('3', '8', '2026-10-26', '1', '0', NULL, '6', '2026-10-26 10:34:50', '2026-10-26 10:34:50');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('4', '9', '2026-10-26', '3', '0', NULL, '6', '2026-10-26 10:35:00', '2026-10-26 10:35:00');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('5', '12', '2026-10-26', '1', '0', NULL, '6', '2026-10-26 10:35:06', '2026-10-26 10:35:06');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('6', '10', '2026-10-26', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:35:15', '2026-10-26 10:35:15');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('7', '11', '2026-10-26', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:35:20', '2026-10-26 10:35:20');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('8', '7', '2026-10-27', '3', '0', NULL, '6', '2026-10-26 10:35:28', '2026-10-26 10:35:28');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('9', '8', '2026-10-27', '1', '0', NULL, '6', '2026-10-26 10:35:34', '2026-10-26 10:35:47');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('10', '7', '2026-10-28', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:35:56', '2026-10-26 10:35:56');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('11', '7', '2026-10-29', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:36:05', '2026-10-26 10:36:05');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('12', '7', '2026-10-30', '1', '0', NULL, '6', '2026-10-26 10:36:15', '2026-10-26 10:36:15');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('13', '7', '2026-10-31', '1', '0', NULL, '6', '2026-10-26 10:36:22', '2026-10-26 10:36:22');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('14', '8', '2026-10-28', '3', '0', NULL, '6', '2026-10-26 10:36:33', '2026-10-26 10:36:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('15', '8', '2026-10-29', '3', '0', NULL, '6', '2026-10-26 10:36:46', '2026-10-26 10:36:46');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('16', '8', '2026-10-30', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:36:55', '2026-10-26 10:36:55');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('17', '8', '2026-10-31', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:37:01', '2026-10-26 10:37:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('18', '9', '2026-10-27', '3', '0', NULL, '6', '2026-10-26 10:37:08', '2026-10-26 10:37:08');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('19', '9', '2026-10-28', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:37:14', '2026-10-26 10:37:14');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('20', '9', '2026-10-29', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:37:21', '2026-10-26 10:37:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('21', '9', '2026-10-30', '1', '0', NULL, '6', '2026-10-26 10:37:28', '2026-10-26 10:37:28');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('22', '9', '2026-10-31', '1', '0', NULL, '6', '2026-10-26 10:37:34', '2026-10-26 10:37:34');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('23', '12', '2026-10-27', '1', '0', NULL, '6', '2026-10-26 10:37:41', '2026-10-26 10:37:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('24', '12', '2026-10-28', '3', '0', 'Libur / Off Tugas', '6', '2026-10-26 10:37:49', '2026-10-26 10:38:02');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('25', '12', '2026-10-29', '3', '0', NULL, '6', '2026-10-26 10:37:55', '2026-10-26 10:37:55');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('26', '12', '2026-10-30', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:38:08', '2026-10-26 10:38:08');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('27', '12', '2026-10-31', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:38:14', '2026-10-26 10:38:14');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('28', '10', '2026-10-27', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:38:21', '2026-10-26 10:38:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('29', '11', '2026-10-27', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:38:26', '2026-10-26 10:38:46');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('30', '10', '2026-10-28', '1', '0', NULL, '6', '2026-10-26 10:38:34', '2026-10-26 10:38:34');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('31', '11', '2026-10-28', '1', '0', NULL, '6', '2026-10-26 10:38:53', '2026-10-26 10:38:53');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('32', '10', '2026-10-29', '1', '0', NULL, '6', '2026-10-26 10:38:59', '2026-10-26 10:38:59');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('33', '11', '2026-10-29', '1', '0', NULL, '6', '2026-10-26 10:39:06', '2026-10-26 10:39:06');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('34', '10', '2026-10-30', '3', '0', NULL, '6', '2026-10-26 10:39:14', '2026-10-26 10:39:14');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('35', '11', '2026-10-30', '3', '0', NULL, '6', '2026-10-26 10:39:21', '2026-10-26 10:39:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('36', '10', '2026-10-31', '3', '0', NULL, '6', '2026-10-26 10:39:27', '2026-10-26 10:39:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('37', '11', '2026-10-31', '3', '0', NULL, '6', '2026-10-26 10:39:33', '2026-10-26 10:39:33');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('38', '16', '2026-10-26', '4', '0', NULL, '6', '2026-10-26 10:40:06', '2026-10-26 10:41:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('39', '14', '2026-10-26', '4', '0', NULL, '6', '2026-10-26 10:40:13', '2026-10-26 10:41:57');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('40', '15', '2026-10-26', '4', '0', NULL, '6', '2026-10-26 10:40:19', '2026-10-26 10:42:17');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('41', '13', '2026-10-27', '4', '0', NULL, '6', '2026-10-26 10:40:25', '2026-10-26 10:41:03');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('42', '16', '2026-10-27', '4', '0', NULL, '6', '2026-10-26 10:40:30', '2026-10-26 10:41:45');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('43', '14', '2026-10-27', '4', '0', NULL, '6', '2026-10-26 10:40:34', '2026-10-26 10:42:04');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('44', '15', '2026-10-27', '4', '0', NULL, '6', '2026-10-26 10:40:39', '2026-10-26 10:42:30');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('45', '13', '2026-10-28', '4', '0', NULL, '6', '2026-10-26 10:40:43', '2026-10-26 10:41:11');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('46', '13', '2026-10-29', '4', '0', NULL, '6', '2026-10-26 10:40:47', '2026-10-26 10:41:19');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('47', '13', '2026-10-30', '4', '0', NULL, '6', '2026-10-26 10:40:51', '2026-10-26 10:41:26');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('48', '13', '2026-10-31', '4', '0', NULL, '6', '2026-10-26 10:41:33', '2026-10-26 10:41:33');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('49', '16', '2026-10-28', '4', '0', NULL, '6', '2026-10-26 10:41:51', '2026-10-26 10:41:51');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('50', '14', '2026-10-28', '4', '0', NULL, '6', '2026-10-26 10:42:10', '2026-10-26 10:42:10');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('51', '16', '2026-10-29', '4', '0', NULL, '6', '2026-10-26 10:42:36', '2026-10-26 10:42:36');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('52', '14', '2026-10-29', '4', '0', NULL, '6', '2026-10-26 10:42:41', '2026-10-26 10:42:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('53', '16', '2026-10-30', '4', '0', NULL, '6', '2026-10-26 10:42:47', '2026-10-26 10:42:47');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('54', '16', '2026-10-31', '4', '0', NULL, '6', '2026-10-26 10:42:53', '2026-10-26 10:42:53');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('55', '14', '2026-10-30', '4', '0', NULL, '6', '2026-10-26 10:43:00', '2026-10-26 10:43:00');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('56', '14', '2026-10-31', '4', '0', NULL, '6', '2026-10-26 10:43:05', '2026-10-26 10:43:05');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('57', '15', '2026-10-28', '4', '0', NULL, '6', '2026-10-26 10:43:10', '2026-10-26 10:43:10');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('58', '15', '2026-10-29', '4', '0', NULL, '6', '2026-10-26 10:43:18', '2026-10-26 10:43:18');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('59', '15', '2026-10-30', '4', '0', NULL, '6', '2026-10-26 10:43:23', '2026-10-26 10:43:23');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('60', '15', '2026-10-31', '4', '0', NULL, '6', '2026-10-26 10:43:27', '2026-10-26 10:43:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('61', '13', '2026-11-01', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:43:45', '2026-10-26 10:56:46');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('62', '13', '2026-11-10', '4', '0', NULL, '6', '2026-10-26 10:49:59', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('63', '13', '2026-11-11', '4', '0', NULL, '6', '2026-10-26 10:49:59', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('64', '9', '2026-11-10', NULL, '1', 'Libur (Import)', '6', '2026-10-26 10:49:59', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('65', '13', '2026-11-02', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('66', '14', '2026-11-02', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('67', '15', '2026-11-02', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('68', '16', '2026-11-02', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('69', '13', '2026-11-03', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('70', '14', '2026-11-03', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('71', '15', '2026-11-03', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('72', '16', '2026-11-03', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('73', '13', '2026-11-04', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('74', '14', '2026-11-04', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('75', '15', '2026-11-04', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('76', '16', '2026-11-04', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('77', '13', '2026-11-05', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('78', '14', '2026-11-05', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('79', '15', '2026-11-05', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('80', '16', '2026-11-05', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('81', '13', '2026-11-06', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('82', '14', '2026-11-06', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('83', '15', '2026-11-06', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('84', '16', '2026-11-06', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('85', '13', '2026-11-09', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('86', '14', '2026-11-09', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('87', '15', '2026-11-09', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('88', '16', '2026-11-09', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('89', '14', '2026-11-10', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('90', '15', '2026-11-10', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('91', '16', '2026-11-10', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('92', '14', '2026-11-11', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('93', '15', '2026-11-11', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('94', '16', '2026-11-11', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('95', '13', '2026-11-12', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('96', '14', '2026-11-12', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('97', '15', '2026-11-12', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('98', '16', '2026-11-12', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('99', '13', '2026-11-13', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('100', '14', '2026-11-13', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('101', '15', '2026-11-13', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('102', '16', '2026-11-13', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('103', '13', '2026-11-16', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('104', '14', '2026-11-16', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('105', '15', '2026-11-16', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('106', '16', '2026-11-16', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('107', '13', '2026-11-17', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('108', '14', '2026-11-17', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('109', '15', '2026-11-17', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('110', '16', '2026-11-17', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('111', '13', '2026-11-18', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('112', '14', '2026-11-18', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('113', '15', '2026-11-18', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('114', '16', '2026-11-18', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('115', '13', '2026-11-19', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('116', '14', '2026-11-19', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('117', '15', '2026-11-19', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('118', '16', '2026-11-19', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('119', '13', '2026-11-20', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('120', '14', '2026-11-20', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('121', '15', '2026-11-20', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('122', '16', '2026-11-20', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('123', '13', '2026-11-23', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('124', '14', '2026-11-23', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('125', '15', '2026-11-23', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('126', '16', '2026-11-23', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('127', '13', '2026-11-24', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('128', '14', '2026-11-24', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('129', '15', '2026-11-24', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('130', '16', '2026-11-24', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('131', '13', '2026-11-25', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('132', '14', '2026-11-25', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('133', '15', '2026-11-25', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('134', '16', '2026-11-25', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('135', '13', '2026-11-26', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('136', '14', '2026-11-26', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('137', '15', '2026-11-26', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('138', '16', '2026-11-26', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('139', '13', '2026-11-27', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('140', '14', '2026-11-27', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('141', '15', '2026-11-27', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('142', '16', '2026-11-27', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('143', '13', '2026-11-30', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('144', '14', '2026-11-30', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('145', '15', '2026-11-30', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('146', '16', '2026-11-30', '4', '0', NULL, '6', '2026-10-26 10:56:27', '2026-10-26 10:56:27');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('147', '14', '2026-11-01', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('148', '15', '2026-11-01', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('149', '16', '2026-11-01', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('150', '13', '2026-11-07', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('151', '14', '2026-11-07', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('152', '15', '2026-11-07', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('153', '16', '2026-11-07', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('154', '13', '2026-11-08', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('155', '14', '2026-11-08', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('156', '15', '2026-11-08', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('157', '16', '2026-11-08', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('158', '13', '2026-11-14', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('159', '14', '2026-11-14', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('160', '15', '2026-11-14', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('161', '16', '2026-11-14', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('162', '13', '2026-11-15', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('163', '14', '2026-11-15', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('164', '15', '2026-11-15', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('165', '16', '2026-11-15', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('166', '13', '2026-11-21', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('167', '14', '2026-11-21', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('168', '15', '2026-11-21', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('169', '16', '2026-11-21', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('170', '13', '2026-11-22', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('171', '14', '2026-11-22', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('172', '15', '2026-11-22', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('173', '16', '2026-11-22', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('174', '13', '2026-11-28', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('175', '14', '2026-11-28', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('176', '15', '2026-11-28', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('177', '16', '2026-11-28', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('178', '13', '2026-11-29', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('179', '14', '2026-11-29', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('180', '15', '2026-11-29', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('181', '16', '2026-11-29', NULL, '1', 'Libur / Off Tugas', '6', '2026-10-26 10:57:21', '2026-10-26 10:57:21');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('182', '7', '2026-11-03', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:02:44', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('183', '7', '2026-11-01', '3', '0', 'Shift Malam Satpam', '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('184', '7', '2026-11-02', '3', '0', 'Shift Malam Satpam', '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('185', '7', '2026-11-04', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('186', '7', '2026-11-05', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('187', '7', '2026-11-06', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('188', '7', '2026-11-07', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('189', '7', '2026-11-08', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('190', '7', '2026-11-09', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('191', '7', '2026-11-10', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('192', '7', '2026-11-11', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('193', '7', '2026-11-12', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('194', '7', '2026-11-13', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('195', '7', '2026-11-14', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('196', '7', '2026-11-15', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('197', '7', '2026-11-16', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('198', '7', '2026-11-17', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('199', '7', '2026-11-18', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('200', '7', '2026-11-19', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('201', '7', '2026-11-20', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('202', '7', '2026-11-21', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('203', '7', '2026-11-22', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('204', '7', '2026-11-23', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('205', '7', '2026-11-24', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('206', '7', '2026-11-25', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('207', '7', '2026-11-26', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('208', '7', '2026-11-27', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('209', '7', '2026-11-28', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('210', '7', '2026-11-29', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('211', '7', '2026-11-30', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('212', '8', '2026-11-01', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('213', '8', '2026-11-02', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('214', '8', '2026-11-03', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('215', '8', '2026-11-04', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('216', '8', '2026-11-05', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('217', '8', '2026-11-06', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('218', '8', '2026-11-07', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('219', '8', '2026-11-08', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('220', '8', '2026-11-09', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('221', '8', '2026-11-10', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('222', '8', '2026-11-11', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('223', '8', '2026-11-12', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('224', '8', '2026-11-13', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('225', '8', '2026-11-14', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('226', '8', '2026-11-15', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('227', '8', '2026-11-16', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('228', '8', '2026-11-17', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('229', '8', '2026-11-18', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('230', '8', '2026-11-19', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('231', '8', '2026-11-20', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('232', '8', '2026-11-21', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('233', '8', '2026-11-22', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('234', '8', '2026-11-23', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('235', '8', '2026-11-24', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('236', '8', '2026-11-25', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('237', '8', '2026-11-26', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('238', '8', '2026-11-27', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('239', '8', '2026-11-28', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('240', '8', '2026-11-29', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('241', '8', '2026-11-30', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('242', '9', '2026-11-01', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('243', '9', '2026-11-02', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('244', '9', '2026-11-03', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('245', '9', '2026-11-04', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('246', '9', '2026-11-05', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('247', '9', '2026-11-06', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('248', '9', '2026-11-07', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('249', '9', '2026-11-08', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('250', '9', '2026-11-09', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('251', '9', '2026-11-11', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('252', '9', '2026-11-12', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('253', '9', '2026-11-13', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('254', '9', '2026-11-14', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('255', '9', '2026-11-15', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('256', '9', '2026-11-16', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('257', '9', '2026-11-17', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('258', '9', '2026-11-18', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('259', '9', '2026-11-19', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('260', '9', '2026-11-20', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('261', '9', '2026-11-21', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('262', '9', '2026-11-22', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('263', '9', '2026-11-23', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('264', '9', '2026-11-24', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('265', '9', '2026-11-25', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('266', '9', '2026-11-26', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('267', '9', '2026-11-27', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('268', '9', '2026-11-28', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('269', '9', '2026-11-29', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('270', '9', '2026-11-30', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('271', '12', '2026-11-01', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('272', '12', '2026-11-02', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('273', '12', '2026-11-03', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('274', '12', '2026-11-04', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('275', '12', '2026-11-05', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('276', '12', '2026-11-06', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('277', '12', '2026-11-07', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('278', '12', '2026-11-08', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('279', '12', '2026-11-09', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('280', '12', '2026-11-10', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('281', '12', '2026-11-11', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('282', '12', '2026-11-12', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('283', '12', '2026-11-13', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('284', '12', '2026-11-14', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('285', '12', '2026-11-15', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('286', '12', '2026-11-16', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('287', '12', '2026-11-17', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('288', '12', '2026-11-18', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('289', '12', '2026-11-19', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('290', '12', '2026-11-20', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('291', '12', '2026-11-21', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('292', '12', '2026-11-22', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('293', '12', '2026-11-23', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('294', '12', '2026-11-24', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('295', '12', '2026-11-25', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('296', '12', '2026-11-26', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('297', '12', '2026-11-27', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('298', '12', '2026-11-28', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('299', '12', '2026-11-29', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('300', '12', '2026-11-30', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('301', '10', '2026-11-01', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('302', '10', '2026-11-02', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('303', '10', '2026-11-03', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('304', '10', '2026-11-04', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('305', '10', '2026-11-05', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('306', '10', '2026-11-06', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('307', '10', '2026-11-07', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('308', '10', '2026-11-08', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('309', '10', '2026-11-09', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('310', '10', '2026-11-10', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('311', '10', '2026-11-11', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('312', '10', '2026-11-12', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('313', '10', '2026-11-13', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('314', '10', '2026-11-14', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('315', '10', '2026-11-15', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('316', '10', '2026-11-16', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('317', '10', '2026-11-17', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('318', '10', '2026-11-18', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('319', '10', '2026-11-19', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('320', '10', '2026-11-20', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('321', '10', '2026-11-21', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('322', '10', '2026-11-22', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('323', '10', '2026-11-23', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('324', '10', '2026-11-24', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('325', '10', '2026-11-25', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('326', '10', '2026-11-26', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('327', '10', '2026-11-27', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('328', '10', '2026-11-28', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('329', '10', '2026-11-29', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('330', '10', '2026-11-30', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('331', '11', '2026-11-01', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('332', '11', '2026-11-02', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('333', '11', '2026-11-03', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('334', '11', '2026-11-04', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('335', '11', '2026-11-05', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('336', '11', '2026-11-06', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('337', '11', '2026-11-07', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('338', '11', '2026-11-08', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('339', '11', '2026-11-09', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('340', '11', '2026-11-10', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('341', '11', '2026-11-11', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('342', '11', '2026-11-12', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('343', '11', '2026-11-13', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('344', '11', '2026-11-14', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('345', '11', '2026-11-15', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('346', '11', '2026-11-16', '1', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('347', '11', '2026-11-17', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('348', '11', '2026-11-18', '3', '0', NULL, '6', '2026-10-26 11:06:40', '2026-10-26 11:06:40');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('349', '11', '2026-11-19', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:40', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('350', '11', '2026-11-20', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:41', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('351', '11', '2026-11-21', '1', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('352', '11', '2026-11-22', '1', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('353', '11', '2026-11-23', '3', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('354', '11', '2026-11-24', '3', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('355', '11', '2026-11-25', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:41', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('356', '11', '2026-11-26', NULL, '1', 'Libur (Import)', '6', '2026-10-26 11:06:41', '2026-10-26 11:10:01');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('357', '11', '2026-11-27', '1', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('358', '11', '2026-11-28', '1', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('359', '11', '2026-11-29', '3', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');
INSERT INTO `user_schedules` (`id`, `user_id`, `date`, `shift_id`, `is_off`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES ('360', '11', '2026-11-30', '3', '0', NULL, '6', '2026-10-26 11:06:41', '2026-10-26 11:06:41');

DROP TABLE IF EXISTS `attendances`;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `shift_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `jam_masuk` datetime DEFAULT NULL,
  `foto_masuk` text COLLATE utf8mb4_unicode_ci,
  `lokasi_masuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_pulang` datetime DEFAULT NULL,
  `foto_pulang` text COLLATE utf8mb4_unicode_ci,
  `lokasi_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `durasi_menit` int DEFAULT NULL,
  `durasi_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hadir',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_user_id_date_unique` (`user_id`,`date`),
  KEY `attendances_shift_id_foreign` (`shift_id`),
  CONSTRAINT `attendances_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `attendance_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Selesai',
  `photo` text COLLATE utf8mb4_unicode_ci,
  `time_recorded` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_attendance_id_foreign` (`attendance_id`),
  CONSTRAINT `activity_logs_attendance_id_foreign` FOREIGN KEY (`attendance_id`) REFERENCES `attendances` (`id`) ON DELETE SET NULL,
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `leave_requests`;
CREATE TABLE `leave_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `catatan_atasan` text COLLATE utf8mb4_unicode_ci,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leave_requests_user_id_foreign` (`user_id`),
  KEY `leave_requests_approved_by_foreign` (`approved_by`),
  CONSTRAINT `leave_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `leave_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('1', 'location_office_name', 'SMKN 1 Jatisari (Kampus Utama)', '2026-10-28 15:35:45', '2026-10-28 15:35:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('2', 'location_latitude', '-6.3655', '2026-10-28 15:35:45', '2026-10-28 15:35:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('3', 'location_longitude', '107.5312', '2026-10-28 15:35:45', '2026-10-28 15:35:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('4', 'location_radius_meters', '100', '2026-10-28 15:35:45', '2026-10-28 15:35:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('5', 'location_restriction_enabled', '1', '2026-10-28 15:35:45', '2026-10-28 15:35:45');

SET FOREIGN_KEY_CHECKS=1;
