-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_sicakap
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_requests`
--

DROP TABLE IF EXISTS `leave_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_requests`
--

LOCK TABLES `leave_requests` WRITE;
/*!40000 ALTER TABLE `leave_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `leave_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_26_000001_create_shifts_table',1),(5,'2026_10_26_000002_create_attendances_table',1),(6,'2026_10_26_000003_create_leave_requests_table',1),(7,'2026_10_26_000004_create_activity_logs_table',1),(8,'2026_10_26_000005_create_user_schedules_table',1),(9,'2026_10_28_000001_create_settings_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('jZBeig9P0E82wtCfg1bFM9QoX20BT4yi6Cc2usNF',NULL,'127.0.0.1','curl/8.21.0','eyJfdG9rZW4iOiJJeDRGN2FrR2tsZ1dRbkV6TGRQQ05lZFRYMVB6c0ZLdXpLTEZsMldLIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9sb2NhdGlvbi1zZXR0aW5nIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYWRtaW5cL2xvY2F0aW9uLXNldHRpbmciLCJyb3V0ZSI6ImFkbWluLmxvY2F0aW9uLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1793177656),('pjOMk1ZfBRYy9pWJ5coNNPVnjSDuImNdmqOcNBEw',8,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0','eyJfdG9rZW4iOiIxZmN2Q1BQQVVqUTJaRmxjcEY5Zk0wUDNnV1pJQUNOd25JdnlaMmVwIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6OCwicGFzc3dvcmRfaGFzaF93ZWIiOiJiYjk2YWM4M2JjMjU5ZjExNTdjY2Q0N2E4NDRjNzJkYzZiZjQ4YTg2MzhjNzBiOTk2OTcwODFhMjhkZjUwYjcxIiwiYWN0aXZlX3VzZXJfaWQiOjgsIm9yaWdpbmFsX2FkbWluX2lkIjo2fQ==',1793177828),('qPaomlERGb3Aqyi1jgaBl1d0dQAUVAWtkDoHpSE5',NULL,'127.0.0.1','Symfony','eyJfdG9rZW4iOiJycXBsemNtSzE1WHNzYjFGN2NZZnU0bjFMc3hRUVNBWjhtSVBYREdNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1793145536),('ZarvTZcFOyJS77wk51HaLLNBOTrzIyjvQnOuSEys',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0','eyJfdG9rZW4iOiJZYTJjMm96Y1hIMWdrdE10MFlBVXRCV09RbTVwT3Q1RkVLTlNCeklzIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9LCJ1cmwiOnsiaW50ZW5kZWQiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMCJ9fQ==',1793145087),('zPvvlFznmKQeKTVh0IXSKZrxECdGynlCEgCn8jfg',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9711','eyJfdG9rZW4iOiI3VXpZTk1rVUFWd1RtWU5ZYk1Lb3VQczJoZjNxdUgyb1k2cElnYVU5IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1793177190);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'location_office_name','SMKN 1 Jatisari','2026-10-28 08:35:45','2026-10-28 08:55:50'),(2,'location_latitude','-6.365815','2026-10-28 08:35:45','2026-10-28 08:48:14'),(3,'location_longitude','107.530951','2026-10-28 08:35:45','2026-10-28 08:48:14'),(4,'location_radius_meters','200','2026-10-28 08:35:45','2026-10-28 08:55:50'),(5,'location_restriction_enabled','1','2026-10-28 08:35:45','2026-10-28 08:35:45');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shifts`
--

DROP TABLE IF EXISTS `shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shifts`
--

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;
INSERT INTO `shifts` VALUES (1,'Shift Pagi Satpam','STP_PAGI','satpam','06:00:00','18:00:00',0,15,'Jaga pos depan, kontrol lalu lintas masuk, monitoring tamu, patroli gedung pagi.','2026-10-26 03:15:41','2026-10-26 03:30:57'),(3,'Shift Malam Satpam','STP_MALAM','satpam','18:00:00','06:00:00',1,15,'Patroli berkala area perimeter & gudang, penguncian gerbang utama, penguncian gerbang belakang.','2026-10-26 03:15:41','2026-10-26 03:31:52'),(4,'Shift Reguler Caraka','CRK_REGULER','caraka','06:00:00','16:30:00',0,15,'Persiapan kebersihan kantor / koridor kelas pagi hari, sanitasi toilet, perawatan taman, dan pengelolaan sampah.','2026-10-26 03:15:41','2026-10-26 03:33:35');
/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_schedules`
--

DROP TABLE IF EXISTS `user_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_schedules`
--

LOCK TABLES `user_schedules` WRITE;
/*!40000 ALTER TABLE `user_schedules` DISABLE KEYS */;
INSERT INTO `user_schedules` VALUES (1,13,'2026-10-26',4,0,NULL,6,'2026-10-26 03:34:01','2026-10-26 03:40:57'),(2,7,'2026-10-26',3,0,NULL,6,'2026-10-26 03:34:39','2026-10-26 03:34:39'),(3,8,'2026-10-26',1,0,NULL,6,'2026-10-26 03:34:50','2026-10-26 03:34:50'),(4,9,'2026-10-26',3,0,NULL,6,'2026-10-26 03:35:00','2026-10-26 03:35:00'),(5,12,'2026-10-26',1,0,NULL,6,'2026-10-26 03:35:06','2026-10-26 03:35:06'),(6,10,'2026-10-26',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:35:15','2026-10-26 03:35:15'),(7,11,'2026-10-26',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:35:20','2026-10-26 03:35:20'),(8,7,'2026-10-27',3,0,NULL,6,'2026-10-26 03:35:28','2026-10-26 03:35:28'),(9,8,'2026-10-27',1,0,NULL,6,'2026-10-26 03:35:34','2026-10-26 03:35:47'),(10,7,'2026-10-28',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:35:56','2026-10-26 03:35:56'),(11,7,'2026-10-29',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:36:05','2026-10-26 03:36:05'),(12,7,'2026-10-30',1,0,NULL,6,'2026-10-26 03:36:15','2026-10-26 03:36:15'),(13,7,'2026-10-31',1,0,NULL,6,'2026-10-26 03:36:22','2026-10-26 03:36:22'),(14,8,'2026-10-28',3,0,NULL,6,'2026-10-26 03:36:33','2026-10-26 03:36:40'),(15,8,'2026-10-29',3,0,NULL,6,'2026-10-26 03:36:46','2026-10-26 03:36:46'),(16,8,'2026-10-30',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:36:55','2026-10-26 03:36:55'),(17,8,'2026-10-31',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:37:01','2026-10-26 03:37:01'),(18,9,'2026-10-27',3,0,NULL,6,'2026-10-26 03:37:08','2026-10-26 03:37:08'),(19,9,'2026-10-28',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:37:14','2026-10-26 03:37:14'),(20,9,'2026-10-29',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:37:21','2026-10-26 03:37:21'),(21,9,'2026-10-30',1,0,NULL,6,'2026-10-26 03:37:28','2026-10-26 03:37:28'),(22,9,'2026-10-31',1,0,NULL,6,'2026-10-26 03:37:34','2026-10-26 03:37:34'),(23,12,'2026-10-27',1,0,NULL,6,'2026-10-26 03:37:41','2026-10-26 03:37:41'),(24,12,'2026-10-28',3,0,'Libur / Off Tugas',6,'2026-10-26 03:37:49','2026-10-26 03:38:02'),(25,12,'2026-10-29',3,0,NULL,6,'2026-10-26 03:37:55','2026-10-26 03:37:55'),(26,12,'2026-10-30',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:38:08','2026-10-26 03:38:08'),(27,12,'2026-10-31',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:38:14','2026-10-26 03:38:14'),(28,10,'2026-10-27',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:38:21','2026-10-26 03:38:40'),(29,11,'2026-10-27',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:38:26','2026-10-26 03:38:46'),(30,10,'2026-10-28',1,0,NULL,6,'2026-10-26 03:38:34','2026-10-26 03:38:34'),(31,11,'2026-10-28',1,0,NULL,6,'2026-10-26 03:38:53','2026-10-26 03:38:53'),(32,10,'2026-10-29',1,0,NULL,6,'2026-10-26 03:38:59','2026-10-26 03:38:59'),(33,11,'2026-10-29',1,0,NULL,6,'2026-10-26 03:39:06','2026-10-26 03:39:06'),(34,10,'2026-10-30',3,0,NULL,6,'2026-10-26 03:39:14','2026-10-26 03:39:14'),(35,11,'2026-10-30',3,0,NULL,6,'2026-10-26 03:39:21','2026-10-26 03:39:21'),(36,10,'2026-10-31',3,0,NULL,6,'2026-10-26 03:39:27','2026-10-26 03:39:27'),(37,11,'2026-10-31',3,0,NULL,6,'2026-10-26 03:39:33','2026-10-26 03:39:33'),(38,16,'2026-10-26',4,0,NULL,6,'2026-10-26 03:40:06','2026-10-26 03:41:40'),(39,14,'2026-10-26',4,0,NULL,6,'2026-10-26 03:40:13','2026-10-26 03:41:57'),(40,15,'2026-10-26',4,0,NULL,6,'2026-10-26 03:40:19','2026-10-26 03:42:17'),(41,13,'2026-10-27',4,0,NULL,6,'2026-10-26 03:40:25','2026-10-26 03:41:03'),(42,16,'2026-10-27',4,0,NULL,6,'2026-10-26 03:40:30','2026-10-26 03:41:45'),(43,14,'2026-10-27',4,0,NULL,6,'2026-10-26 03:40:34','2026-10-26 03:42:04'),(44,15,'2026-10-27',4,0,NULL,6,'2026-10-26 03:40:39','2026-10-26 03:42:30'),(45,13,'2026-10-28',4,0,NULL,6,'2026-10-26 03:40:43','2026-10-26 03:41:11'),(46,13,'2026-10-29',4,0,NULL,6,'2026-10-26 03:40:47','2026-10-26 03:41:19'),(47,13,'2026-10-30',4,0,NULL,6,'2026-10-26 03:40:51','2026-10-26 03:41:26'),(48,13,'2026-10-31',4,0,NULL,6,'2026-10-26 03:41:33','2026-10-26 03:41:33'),(49,16,'2026-10-28',4,0,NULL,6,'2026-10-26 03:41:51','2026-10-26 03:41:51'),(50,14,'2026-10-28',4,0,NULL,6,'2026-10-26 03:42:10','2026-10-26 03:42:10'),(51,16,'2026-10-29',4,0,NULL,6,'2026-10-26 03:42:36','2026-10-26 03:42:36'),(52,14,'2026-10-29',4,0,NULL,6,'2026-10-26 03:42:41','2026-10-26 03:42:41'),(53,16,'2026-10-30',4,0,NULL,6,'2026-10-26 03:42:47','2026-10-26 03:42:47'),(54,16,'2026-10-31',4,0,NULL,6,'2026-10-26 03:42:53','2026-10-26 03:42:53'),(55,14,'2026-10-30',4,0,NULL,6,'2026-10-26 03:43:00','2026-10-26 03:43:00'),(56,14,'2026-10-31',4,0,NULL,6,'2026-10-26 03:43:05','2026-10-26 03:43:05'),(57,15,'2026-10-28',4,0,NULL,6,'2026-10-26 03:43:10','2026-10-26 03:43:10'),(58,15,'2026-10-29',4,0,NULL,6,'2026-10-26 03:43:18','2026-10-26 03:43:18'),(59,15,'2026-10-30',4,0,NULL,6,'2026-10-26 03:43:23','2026-10-26 03:43:23'),(60,15,'2026-10-31',4,0,NULL,6,'2026-10-26 03:43:27','2026-10-26 03:43:27'),(61,13,'2026-11-01',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:43:45','2026-10-26 03:56:46'),(62,13,'2026-11-10',4,0,NULL,6,'2026-10-26 03:49:59','2026-10-26 03:56:27'),(63,13,'2026-11-11',4,0,NULL,6,'2026-10-26 03:49:59','2026-10-26 03:56:27'),(64,9,'2026-11-10',NULL,1,'Libur (Import)',6,'2026-10-26 03:49:59','2026-10-26 04:10:01'),(65,13,'2026-11-02',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(66,14,'2026-11-02',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(67,15,'2026-11-02',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(68,16,'2026-11-02',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(69,13,'2026-11-03',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(70,14,'2026-11-03',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(71,15,'2026-11-03',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(72,16,'2026-11-03',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(73,13,'2026-11-04',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(74,14,'2026-11-04',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(75,15,'2026-11-04',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(76,16,'2026-11-04',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(77,13,'2026-11-05',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(78,14,'2026-11-05',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(79,15,'2026-11-05',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(80,16,'2026-11-05',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(81,13,'2026-11-06',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(82,14,'2026-11-06',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(83,15,'2026-11-06',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(84,16,'2026-11-06',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(85,13,'2026-11-09',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(86,14,'2026-11-09',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(87,15,'2026-11-09',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(88,16,'2026-11-09',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(89,14,'2026-11-10',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(90,15,'2026-11-10',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(91,16,'2026-11-10',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(92,14,'2026-11-11',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(93,15,'2026-11-11',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(94,16,'2026-11-11',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(95,13,'2026-11-12',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(96,14,'2026-11-12',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(97,15,'2026-11-12',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(98,16,'2026-11-12',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(99,13,'2026-11-13',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(100,14,'2026-11-13',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(101,15,'2026-11-13',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(102,16,'2026-11-13',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(103,13,'2026-11-16',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(104,14,'2026-11-16',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(105,15,'2026-11-16',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(106,16,'2026-11-16',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(107,13,'2026-11-17',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(108,14,'2026-11-17',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(109,15,'2026-11-17',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(110,16,'2026-11-17',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(111,13,'2026-11-18',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(112,14,'2026-11-18',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(113,15,'2026-11-18',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(114,16,'2026-11-18',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(115,13,'2026-11-19',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(116,14,'2026-11-19',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(117,15,'2026-11-19',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(118,16,'2026-11-19',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(119,13,'2026-11-20',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(120,14,'2026-11-20',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(121,15,'2026-11-20',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(122,16,'2026-11-20',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(123,13,'2026-11-23',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(124,14,'2026-11-23',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(125,15,'2026-11-23',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(126,16,'2026-11-23',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(127,13,'2026-11-24',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(128,14,'2026-11-24',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(129,15,'2026-11-24',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(130,16,'2026-11-24',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(131,13,'2026-11-25',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(132,14,'2026-11-25',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(133,15,'2026-11-25',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(134,16,'2026-11-25',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(135,13,'2026-11-26',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(136,14,'2026-11-26',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(137,15,'2026-11-26',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(138,16,'2026-11-26',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(139,13,'2026-11-27',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(140,14,'2026-11-27',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(141,15,'2026-11-27',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(142,16,'2026-11-27',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(143,13,'2026-11-30',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(144,14,'2026-11-30',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(145,15,'2026-11-30',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(146,16,'2026-11-30',4,0,NULL,6,'2026-10-26 03:56:27','2026-10-26 03:56:27'),(147,14,'2026-11-01',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(148,15,'2026-11-01',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(149,16,'2026-11-01',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(150,13,'2026-11-07',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(151,14,'2026-11-07',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(152,15,'2026-11-07',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(153,16,'2026-11-07',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(154,13,'2026-11-08',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(155,14,'2026-11-08',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(156,15,'2026-11-08',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(157,16,'2026-11-08',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(158,13,'2026-11-14',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(159,14,'2026-11-14',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(160,15,'2026-11-14',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(161,16,'2026-11-14',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(162,13,'2026-11-15',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(163,14,'2026-11-15',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(164,15,'2026-11-15',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(165,16,'2026-11-15',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(166,13,'2026-11-21',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(167,14,'2026-11-21',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(168,15,'2026-11-21',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(169,16,'2026-11-21',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(170,13,'2026-11-22',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(171,14,'2026-11-22',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(172,15,'2026-11-22',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(173,16,'2026-11-22',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(174,13,'2026-11-28',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(175,14,'2026-11-28',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(176,15,'2026-11-28',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(177,16,'2026-11-28',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(178,13,'2026-11-29',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(179,14,'2026-11-29',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(180,15,'2026-11-29',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(181,16,'2026-11-29',NULL,1,'Libur / Off Tugas',6,'2026-10-26 03:57:21','2026-10-26 03:57:21'),(182,7,'2026-11-03',NULL,1,'Libur (Import)',6,'2026-10-26 04:02:44','2026-10-26 04:10:01'),(183,7,'2026-11-01',3,0,'Shift Malam Satpam',6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(184,7,'2026-11-02',3,0,'Shift Malam Satpam',6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(185,7,'2026-11-04',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(186,7,'2026-11-05',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(187,7,'2026-11-06',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(188,7,'2026-11-07',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(189,7,'2026-11-08',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(190,7,'2026-11-09',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(191,7,'2026-11-10',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(192,7,'2026-11-11',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(193,7,'2026-11-12',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(194,7,'2026-11-13',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(195,7,'2026-11-14',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(196,7,'2026-11-15',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(197,7,'2026-11-16',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(198,7,'2026-11-17',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(199,7,'2026-11-18',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(200,7,'2026-11-19',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(201,7,'2026-11-20',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(202,7,'2026-11-21',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(203,7,'2026-11-22',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(204,7,'2026-11-23',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(205,7,'2026-11-24',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(206,7,'2026-11-25',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(207,7,'2026-11-26',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(208,7,'2026-11-27',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(209,7,'2026-11-28',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(210,7,'2026-11-29',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(211,7,'2026-11-30',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(212,8,'2026-11-01',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(213,8,'2026-11-02',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(214,8,'2026-11-03',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(215,8,'2026-11-04',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(216,8,'2026-11-05',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(217,8,'2026-11-06',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(218,8,'2026-11-07',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(219,8,'2026-11-08',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(220,8,'2026-11-09',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(221,8,'2026-11-10',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(222,8,'2026-11-11',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(223,8,'2026-11-12',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(224,8,'2026-11-13',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(225,8,'2026-11-14',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(226,8,'2026-11-15',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(227,8,'2026-11-16',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(228,8,'2026-11-17',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(229,8,'2026-11-18',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(230,8,'2026-11-19',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(231,8,'2026-11-20',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(232,8,'2026-11-21',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(233,8,'2026-11-22',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(234,8,'2026-11-23',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(235,8,'2026-11-24',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(236,8,'2026-11-25',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(237,8,'2026-11-26',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(238,8,'2026-11-27',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(239,8,'2026-11-28',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(240,8,'2026-11-29',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(241,8,'2026-11-30',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(242,9,'2026-11-01',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(243,9,'2026-11-02',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(244,9,'2026-11-03',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(245,9,'2026-11-04',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(246,9,'2026-11-05',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(247,9,'2026-11-06',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(248,9,'2026-11-07',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(249,9,'2026-11-08',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(250,9,'2026-11-09',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(251,9,'2026-11-11',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(252,9,'2026-11-12',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(253,9,'2026-11-13',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(254,9,'2026-11-14',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(255,9,'2026-11-15',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(256,9,'2026-11-16',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(257,9,'2026-11-17',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(258,9,'2026-11-18',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(259,9,'2026-11-19',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(260,9,'2026-11-20',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(261,9,'2026-11-21',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(262,9,'2026-11-22',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(263,9,'2026-11-23',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(264,9,'2026-11-24',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(265,9,'2026-11-25',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(266,9,'2026-11-26',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(267,9,'2026-11-27',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(268,9,'2026-11-28',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(269,9,'2026-11-29',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(270,9,'2026-11-30',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(271,12,'2026-11-01',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(272,12,'2026-11-02',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(273,12,'2026-11-03',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(274,12,'2026-11-04',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(275,12,'2026-11-05',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(276,12,'2026-11-06',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(277,12,'2026-11-07',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(278,12,'2026-11-08',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(279,12,'2026-11-09',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(280,12,'2026-11-10',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(281,12,'2026-11-11',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(282,12,'2026-11-12',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(283,12,'2026-11-13',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(284,12,'2026-11-14',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(285,12,'2026-11-15',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(286,12,'2026-11-16',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(287,12,'2026-11-17',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(288,12,'2026-11-18',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(289,12,'2026-11-19',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(290,12,'2026-11-20',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(291,12,'2026-11-21',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(292,12,'2026-11-22',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(293,12,'2026-11-23',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(294,12,'2026-11-24',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(295,12,'2026-11-25',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(296,12,'2026-11-26',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(297,12,'2026-11-27',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(298,12,'2026-11-28',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(299,12,'2026-11-29',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(300,12,'2026-11-30',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(301,10,'2026-11-01',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(302,10,'2026-11-02',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(303,10,'2026-11-03',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(304,10,'2026-11-04',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(305,10,'2026-11-05',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(306,10,'2026-11-06',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(307,10,'2026-11-07',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(308,10,'2026-11-08',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(309,10,'2026-11-09',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(310,10,'2026-11-10',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(311,10,'2026-11-11',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(312,10,'2026-11-12',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(313,10,'2026-11-13',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(314,10,'2026-11-14',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(315,10,'2026-11-15',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(316,10,'2026-11-16',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(317,10,'2026-11-17',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(318,10,'2026-11-18',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(319,10,'2026-11-19',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(320,10,'2026-11-20',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(321,10,'2026-11-21',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(322,10,'2026-11-22',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(323,10,'2026-11-23',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(324,10,'2026-11-24',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(325,10,'2026-11-25',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(326,10,'2026-11-26',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(327,10,'2026-11-27',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(328,10,'2026-11-28',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(329,10,'2026-11-29',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(330,10,'2026-11-30',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(331,11,'2026-11-01',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(332,11,'2026-11-02',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(333,11,'2026-11-03',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(334,11,'2026-11-04',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(335,11,'2026-11-05',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(336,11,'2026-11-06',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(337,11,'2026-11-07',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(338,11,'2026-11-08',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(339,11,'2026-11-09',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(340,11,'2026-11-10',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(341,11,'2026-11-11',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(342,11,'2026-11-12',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(343,11,'2026-11-13',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(344,11,'2026-11-14',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(345,11,'2026-11-15',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(346,11,'2026-11-16',1,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(347,11,'2026-11-17',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(348,11,'2026-11-18',3,0,NULL,6,'2026-10-26 04:06:40','2026-10-26 04:06:40'),(349,11,'2026-11-19',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:40','2026-10-26 04:10:01'),(350,11,'2026-11-20',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:41','2026-10-26 04:10:01'),(351,11,'2026-11-21',1,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41'),(352,11,'2026-11-22',1,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41'),(353,11,'2026-11-23',3,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41'),(354,11,'2026-11-24',3,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41'),(355,11,'2026-11-25',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:41','2026-10-26 04:10:01'),(356,11,'2026-11-26',NULL,1,'Libur (Import)',6,'2026-10-26 04:06:41','2026-10-26 04:10:01'),(357,11,'2026-11-27',1,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41'),(358,11,'2026-11-28',1,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41'),(359,11,'2026-11-29',3,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41'),(360,11,'2026-11-30',3,0,NULL,6,'2026-10-26 04:06:41','2026-10-26 04:06:41');
/*!40000 ALTER TABLE `user_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'Administrator Utama','ADM-001','admin@admin.com','admin','Super Administrator & Pengelola Sistem','0838152461518','https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$D5segbjYKc.UPXid7Mg8VeG5QAkzrnDmhrLGTyKb.1KPjJI1GtGJ2','vkcnP8lDJlE8ujvSVDu3dydDoW7j4hQnz9MB9rmfgT5LPjxyjS6j28yxAORU','2026-10-26 03:15:41','2026-10-26 12:26:23'),(7,'ADE','STP001','ade@satpam.com','satpam','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$XqI5b/jeFGMSoNqvajwY/uz/EmSYAYvIQPWG2x6Hby6IUpBWIhQBi',NULL,'2026-10-26 03:20:42','2026-10-26 03:20:42'),(8,'DEDE IRFAN ARDIANSYAH','STP-002','dede@gmail.com','satpam','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$pUWN9SociuZFBSSyPG9hkuXkCt16auBtYf/ERdBnYNLNYMEvzoIyS',NULL,'2026-10-26 03:21:55','2026-10-26 03:21:55'),(9,'GITO ANTONI','STP-003','gito@satpam.com','satpam','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$RvfQpTCrXUPAw9xdsd97n.Gu/zCsJRaNA407JIwERlgHJ6PR3xFDG',NULL,'2026-10-26 03:23:12','2026-10-26 03:23:12'),(10,'JUMADI','STP-004','jumadi@satpam.com','satpam','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$l22CnXd0N/nMYWFitPua4u0GNi2cR9Bo8wCmG3mf.JzTJWFsgHjIy',NULL,'2026-10-26 03:23:55','2026-10-26 03:23:55'),(11,'RAIS SUTISNA','STP-005','rais@satpam.com','satpam','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$yDBUgYVPVMwXhVwDTitW.eMiXe1TRiSlACxvVdHkRnmVDIFrJN/Ri',NULL,'2026-10-26 03:25:09','2026-10-26 03:25:09'),(12,'HARTON A RAUF','STP-006','harton@gmail.com','satpam','ANGGOTA','0838152461518','http://127.0.0.1:8000/storage/avatars/vS2gio5KvlBCuqS1kyCarr17BFoXWqr7wFkI18eE.jpg',NULL,'$2y$12$RRqAMEGlWzeLPSz0N/ynJekvezu0MVDBCYwM4wK4ruxDMoJzKoAvq',NULL,'2026-10-26 03:25:50','2026-10-27 04:34:23'),(13,'JUNAEDI','CRK-001','junaedi@caraka.com','caraka','ANGGOTA','0838152461518','http://127.0.0.1:8000/storage/avatars/MmnPLSlbCEVtRzrBX2miJegjB5wF8NMUzlN1Hc2U.jpg',NULL,'$2y$12$MSTmnay/UT/bd/DrWnwXMe8gRzi.dzYz8CPMAVJ2MOSSQxR0fVzrS',NULL,'2026-10-26 03:26:48','2026-10-26 12:24:11'),(14,'RADI SOETISNA','CRK-002','radi@gmail.com','caraka','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$uCXW6hy4F0HhIec.DAILfuxDTRXC0C7X9w2rbfT3l0oysmYqmKqGW',NULL,'2026-10-26 03:27:31','2026-10-26 03:27:31'),(15,'RAHMAN','CRK-003','rahman@caraka.com','caraka','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$ASi5vjIRRTBucB5WFpk/s.1waNO4rLZc6w4xEN5sV4sb2D1zgwY8W',NULL,'2026-10-26 03:28:16','2026-10-26 03:28:16'),(16,'MAHPUDIN','CRK-004','mahpudin@caraka.com','caraka','ANGGOTA','0838152461518','https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',NULL,'$2y$12$T5GpOwRJIm8rUKALSbPW8ORioFWHt9TNDJMF6RIfX.OLvZrTuRlom',NULL,'2026-10-26 03:29:02','2026-10-26 03:29:02'),(17,'DIAH GUSTANTI','197608242006042007','diahgustanti@kepsek.com','admin','KEPALA SEKOLAH','0812-9988-1122','http://127.0.0.1:8000/storage/avatars/2eXFsl164taTiClZJ8UL3p65imQQFChsxdaaiCFk.jpg',NULL,'$2y$12$AZbPyKNA0l.tBUuZ2iTOFOYtdl6wrsM4y8O6cax46U1oA1jfg96ee',NULL,'2026-10-27 07:04:04','2026-10-27 07:04:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-28 16:03:22
